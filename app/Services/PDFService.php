<?php

namespace App\Services;

use Spatie\LaravelPdf\Facades\Pdf;

class PDFService
{
    public static function PDFGenerate(array $data, string $view, string $path, bool $download = false)
    {
        $pdf = Pdf::view($view, $data)->disk('public')->save($path);

        if ($download) {
            return response()->file(storage_path("app/public/{$path}"), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
            ]);
        }
    }
}
