<?php

namespace App\Imports;

use App\Models\PMRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PMRequestImport implements ToCollection
{
    private $projectName;
    private $userId;

    public function __construct(string $projectName, $userId)
    {
        $this->projectName = $projectName;
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        // Skip header sampai baris ke-3 (mulai dari baris 4)
        foreach ($rows->slice(3) as $row) {
            if (!isset($row[1]) || !is_numeric($row[4])) {
                continue;
            }

            $eta = null;
            if (!empty($row[5])) {
                try {
                    $eta = is_numeric($row[5])
                        ? Date::excelToDateTimeObject($row[5])->format('Y-m-d')
                        : date('Y-m-d', strtotime($row[5]));
                } catch (\Exception $e) {
                    $eta = null;
                }
            }

            PMRequest::create([
                'user_id' => $this->userId,
                'project_name' => $this->projectName,
                'item' => $row[1],
                'specification' => $row[2] ?? '',
                'unit' => $row[3] ?? '',
                'qty' => (int) $row[4],
                'eta' => $eta,
                'remark' => $row[6] ?? '',
                'price' => $this->convertPriceFormat($row[7] ?? ''),
            ]);
        }
    }

    private function convertPriceFormat($price)
    {
        if (is_string($price)) {
            $cleaned = str_replace(['Rp', '.', ' '], '', $price);
            $cleaned = str_replace(',', '.', $cleaned);
            return is_numeric($cleaned) ? (float) $cleaned : 0;
        }
        return is_numeric($price) ? (float) $price : 0;
    }

}
