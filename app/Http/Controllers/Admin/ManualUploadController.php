<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManualUploadController extends Controller
{
    public function create()
    {
        return view('admin.manuals.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:25600', // max 25MB
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:50',
        ]);

        $file = $request->file('pdf_file');
        
        // Verifica MIME type rigoroso
        if ($file->getMimeType() !== 'application/pdf') {
            return back()->withErrors(['pdf_file' => 'Il file deve essere un PDF valido.']);
        }

        // Salvataggio in storage protetto (fuori dalla web root pubblica)
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.pdf';
        $path = $file->storeAs('private/manuals', $filename, 'local');

        // Estrazione testo dal PDF (Pure PHP Parser con zlib)
        $fullPath = storage_path('app/' . $path);
        $extractedText = $this->extractTextFromPdf($fullPath);

        $title = $request->input('title') ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $category = $request->input('category') ?: 'Documentazione';
        $level = $request->input('level') ?: 'Intermedio';
        $summary = Str::limit(strip_tags($extractedText), 300, '...');

        // Creazione bozza manuale (is_published = false)
        $manual = Manual::create([
            'title' => $title,
            'slug' => Str::slug($title . '-' . Str::random(5)),
            'category' => $category,
            'level' => $level,
            'summary' => $summary ?: 'Contenuto estratto da PDF in attesa di revisione.',
            'content' => $extractedText ?: 'Nessun testo estratto automaticamente.',
            'is_published' => false, // Bozza / non pubblicato
        ]);

        return redirect()->route('admin.manuals.upload')->with('success', 'PDF caricato e bozza manuale creata con successo! (Testo estratto e salvato in bozza).');
    }

    protected function extractTextFromPdf(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $content = file_get_contents($filePath);
        $extractedText = '';

        // Estrazione stream compressi con zlib (FlateDecode)
        if (preg_match_all('/stream(.*?)endstream/s', $content, $matches)) {
            foreach ($matches[1] as $stream) {
                $stream = ltrim($stream, "\r\n");
                $decoded = @gzuncompress($stream);
                if ($decoded !== false) {
                    // Cerca stringhe di testo tra parentesi tonde (...) o operatori Tj/TJ
                    if (preg_match_all('/\((.*?)\)\s*T[jJ]/s', $decoded, $textMatches)) {
                        foreach ($textMatches[1] as $txt) {
                            $extractedText .= ' ' . $this->cleanPdfString($txt);
                        }
                    } else {
                        // Estrazione generica di stringhe leggibili
                        preg_match_all('/\(([^()\r\n]{3,})\)/', $decoded, $strMatches);
                        if (!empty($strMatches[1])) {
                            $extractedText .= ' ' . implode(' ', $strMatches[1]);
                        }
                    }
                }
            }
        }

        // Fallback: ricerca stringhe tra parentesi nel documento intero se lo stream non ha prodotto testo
        if (trim($extractedText) === '') {
            if (preg_match_all('/\(([^\r\n]{4,})\)/', $content, $matches)) {
                $extractedText = implode(' ', $matches[1]);
            }
        }

        return trim(preg_replace('/\s+/', ' ', $extractedText)) ?: 'Documento PDF acquisito. Testo non decodificato automaticamente.';
    }

    protected function cleanPdfString(string $str): string
    {
        // Rimuovi caratteri di escape PDF
        $str = str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $str);
        return $str;
    }
}
