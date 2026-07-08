<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytic; // Assicurati che questo modello punti alla tabella corretta
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminStatisticController extends Controller
{
    public function index(Request $request)
    {
        // Recuperiamo il filtro temporale (default 'month' per gli ultimi 30 giorni)
        $range = $request->input('range', 'month');

        // 1. Visite ultimi 30 giorni (Sintassi pulita compatibile con SQLite)
        $visitsPerDay = Analytic::select(DB::raw("strftime('%Y-%m-%d', created_at) as date"), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 2. Dispositivi
        $devices = Analytic::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->get();

        // 3. Referrer (Top 10)
        $referrers = Analytic::select('referrer_url', DB::raw('count(*) as count'))
            ->whereNotNull('referrer_url')
            ->where('referrer_url', '!=', '')
            ->groupBy('referrer_url')
            ->orderBy('count', 'DESC')
            ->take(10)
            ->get();
        // 4. Browser (Top 5)
        $browsers = Analytic::select('browser_name_version', DB::raw('count(*) as count'))
            ->groupBy('browser_name_version')
            ->orderBy('count', 'DESC')
            ->take(5)
            ->get();

        // 5. NUOVA QUERY AGGREGATA PER IPER-PERFORMANCE (CALCOLO DURATE)
        $statsQuery = Analytic::query();

        // Applichiamo il filtro temporale dinamico basato sul range selezionato
        switch ($range) {
            case 'today':
                $statsQuery->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $statsQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'year':
                $statsQuery->whereYear('created_at', Carbon::now()->year);
                break;
            case 'month':
            default:
                $statsQuery->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
                break;
        }

        // Estrazione record aggregato su SQLite
        $stats = $statsQuery->selectRaw("
            COUNT(id) as total_views,
            MIN(duration) as min_duration,
            MAX(duration) as max_duration,
            AVG(duration) as avg_duration,
            SUM(CASE WHEN user_id IS NOT NULL THEN 1 ELSE 0 END) as authenticated_views,
            SUM(CASE WHEN user_id IS NULL THEN 1 ELSE 0 END) as anonymous_views
        ")->first();

        return view('admin.stats.index', compact(
            'visitsPerDay', 
            'devices', 
            'referrers', 
            'browsers', 
            'stats', 
            'range'
        ));
    }

    /**
     * LOGICA DI SALVATAGGIO TEMPO (PING BEACON/FETCH)
     * Incrementa i secondi reali di permanenza sulla riga corrente
     */
    public function ping(Request $request)
    {
        $analyticsId = $request->input('analytics_id') ?? session('last_analytics_id');
        $seconds = (int) ($request->input('seconds') ?? 15);

        if ($analyticsId) {
            // Incremento atomico sul record corretto della tabella
            Analytic::where('id', $analyticsId)->increment('duration', $seconds);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'no_session'], 400);
    }
}
