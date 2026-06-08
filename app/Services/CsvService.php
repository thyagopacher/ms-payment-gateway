<?php

namespace App\Services;

use App\Contracts\PdfAdapterInterface;

class CsvService
{
    public function __construct()
    {

    }

    public function generate(array $data, string $delimiter = ';'): string
    {
        if (empty($data)) {
            return '';
        }

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, array_keys($data[0]), $delimiter);

        foreach ($data as $row) {
            fputcsv($handle, $row, $delimiter);
        }

        rewind($handle);

        $csv = stream_get_contents($handle);

        fclose($handle);

        return $csv;
    }
}
