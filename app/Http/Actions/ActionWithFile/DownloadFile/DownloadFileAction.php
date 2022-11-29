<?php

namespace App\Http\Actions\ActionWithFile\DownloadFile;

use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadFileAction
{
    public const FILENAME = 'test';

    public function __invoke(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo $this->generateFile();
        }, self::FILENAME . '.csv');
    }

    private function generateFile(): string
    {
        $maxMemoryMb = 1024 * 1024 * 3;
        $handle = fopen('php://temp/maxmemory:' . $maxMemoryMb, 'w');
        $fields = [
            'column1' => 'value1',
            'column2' => 'value2',
        ];

        // Header
        fputcsv($handle, array_keys($fields));

        // Body
        fputcsv($handle, $fields);

        rewind($handle);
        $csv = stream_get_contents($handle);

        fclose($handle);

        return $csv;
    }
}
