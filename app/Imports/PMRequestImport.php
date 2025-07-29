<?php

namespace App\Imports;

use App\Models\PMRequest;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PMRequestImport implements OnEachRow, WithHeadingRow, WithEvents
{
    private $projectName;

    public function headingRow(): int
    {
        return 15;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->getReader()->getActiveSheet();
                $this->projectName = $sheet->getCell('D8')->getValue();
            },
        ];
    }

    public function onRow(Row $row)
    {
        $rowData = $row->toArray();

        if (!isset($rowData['qty']) || !is_numeric($rowData['qty'])) {
            return;
        }

        $deliveryDate = null;
        if (!empty($rowData['required_delivery_date'])) {
            try {
                $deliveryDate = Date::excelToDateTimeObject($rowData['required_delivery_date']);
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
            'project_name' => $this->projectName ?? '',
        ]);
    }
}