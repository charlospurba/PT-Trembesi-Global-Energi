<?php

namespace App\Imports;

use App\Models\PMRequest;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PMRequestImport implements OnEachRow, WithHeadingRow
{
    public function headingRow(): int
    {
        return 15; // karena baris 15 adalah header
    }

    public function onRow(Row $row)
    {
        $rowData = $row->toArray();

        // Jika kolom pertama (qty) kosong atau bukan angka, kita berhenti membaca
        if (!isset($rowData['qty']) || !is_numeric($rowData['qty'])) {
            return; // atau bisa `return false;` tergantung kebutuhan
        }

        // Jika tanggal kosong atau tidak valid, atur nilai default
        $deliveryDate = null;
        if (!empty($rowData['required_delivery_date'])) {
            try {
                $deliveryDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rowData['required_delivery_date']);
            } catch (\Exception $e) {
                $deliveryDate = null;
            }
        }

        PMRequest::create([
            'qty' => $rowData['qty'],
            'unit' => $rowData['unit'] ?? '',
            'commcode' => $rowData['commcode'] ?? '',
            'description' => $rowData['description_of_material'] ?? '',
            'specification' => $rowData['specification'] ?? '',
            'required_delivery_date' => $deliveryDate,
            'remarks' => $rowData['remarks'] ?? '',
        ]);
    }

}
