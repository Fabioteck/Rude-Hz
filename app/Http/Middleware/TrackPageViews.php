<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Analytic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && !$request->expectsJson() && !$request->is('admin*')) {
            try {
                $userAgent = $request->userAgent();
                $deviceType = 'Desktop';
                if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $userAgent)) {
                    $deviceType = 'Tablet';
                } elseif (preg_match('/(blackberry|configuration\/cldc|hp |hppro|itunes|maemo|midi|mini|mmp|netfront|opera m(ob|in)i|palm|phone|pie|plucker|pocket|psp|symbian|symbianos|teashark|teleca|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino)/i', $userAgent)) {
                    $deviceType = 'Mobile';
                }

                // Prepariamo i dati teorici di tracciamento
                $rawPayload = [
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'session_id' => session()->getId(),
                    'ip_address' => $request->ip(),
                    'url_path' => $request->getPathInfo(),
                    'referrer_url' => $request->headers->get('referer'),
                    'operation_system' => substr(PHP_OS_FAMILY, 0, 50), 
                    'browser' => substr($userAgent, 0, 100), 
                    'device' => $deviceType,
                    'country_name' => $request->header('cf-ipcountry') ?? 'XX', 
                    'duration' => 0,
                ];

                // Recuperiamo al volo le colonne reali presenti fisicamente sulla tabella 'analytics'
                $realColumns = Schema::getColumnListing('analytics');

                // Filtriamo il payload tenendo ESCLUSIVAMENTE i campi esistenti sul database
                $filteredPayload = array_intersect_key($rawPayload, array_flip($realColumns));

                // Eseguiamo il salvataggio sicuro dei soli campi compatibili
                if (!empty($filteredPayload)) {
                    $record = Analytic::create($filteredPayload);
                    session(['last_analytics_id' => $record->id]);
                }

            } catch (\Exception $e) {
                // Se succede qualcosa, registriamo l'errore nei log di Laravel senza bloccare la navigazione dell'utente
                Log::error('Errore Tracciamento Analytics: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
