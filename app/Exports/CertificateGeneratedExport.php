<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CertificateGeneratedExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell, ShouldAutoSize, WithStyles, WithMapping, WithDrawings
{
    protected $query;

    /**
     * Constructor to accept query parameters.
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query;
    }
    public function headings(): array
    {
        return [
            'Reg. No.',
            'Name of Applicant',
            "Father's/Husband's Name",
            'Address',
            'Course',
            'Name of Institute',
            'Mobile No. / Cert. No.',
            'Renewal Date',
            'Photo',
            'Signature'
        ];
    }
    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * Apply styles to the sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Style the header
        return [
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 18,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF00BFFF'], // Light blue header color
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
            ],
            // Set wrapping for all cells
            'A1:J1' => [
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
        ];
    }


    public function map($row): array
    {
        return [
            $row->alloted_regn_no,
            $row->name,
            $row->father_name,
            $row->address . ', ' . $row->city . ', ' . $row->state,
            $row->course,
            $row->inst,
            $row->mobile_no . ' / ' . $row->allotted_certificate_no,
            // \Carbon\Carbon::parse($row->certficate_valid_from_date)->addYears(5)->subDay()->format('d-m-Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set page setup for landscape orientation and A4 paper size
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToPage(true);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);

                // Style array for borders
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];

                // Total rows for data range
                $totalRows = $sheet->getHighestRow();

                // Set ranges for header and data
                $headerRange = 'A1:J1'; // Adjust this range if needed
                $dataRange = 'A2:J' . $totalRows;

                // Apply border styles to the data range
                $sheet->getStyle($dataRange)->applyFromArray($styleArray);

                foreach ($event->sheet->getDelegate()->getRowIterator(2) as $row) { // Starting from row 2
                    $sheet->getRowDimension($row->getRowIndex())->setRowHeight(100);
                }

                $sheet->getHeaderFooter()->setOddHeader('&C&"Calibri,Bold"&30 Jharkhand State of Paramedical Council, Ranchi'); // Centered with font size 20
               
                // Apply header styling: Bold, larger font, centered
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFont()->setSize(14); // Increase font size as needed
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($headerRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Apply data styling: Larger font and wrap text
                $sheet->getStyle($dataRange)->getFont()->setSize(16); // Increase font size for data
                $sheet->getStyle($dataRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($dataRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle($dataRange)->getAlignment()->setWrapText(true);

                // Repeat header after every 10 rows with same styling
                // for ($i = 12; $i <= $totalRows; $i += 10) {
                //     $sheet->insertNewRowBefore($i, 1); // Insert a new row for repeated header
                //     $sheet->fromArray($this->headings(), null, 'A' . $i); // Add the repeated header
                //     // Apply bold and centered style to the repeated header
                //     $sheet->getStyle('A' . $i . ':J' . $i)->getFont()->setBold(true);
                //     $sheet->getStyle('A' . $i . ':J' . $i)->getFont()->setSize(14); // Match font size to the main header
                //     $sheet->getStyle('A' . $i . ':J' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                //     $sheet->getStyle('A' . $i . ':J' . $i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                // }
            },
        ];
    }

    /**
     * @inheritDoc
     */
    public function drawings()
    {
        $drawings = [];
        $row = 3; // Assuming you want images starting from row 2 (adjust as necessary)

        foreach ($this->query as $student) {
            $drawing = new Drawing();
            $drawing->setName('Student Image');
            $drawing->setDescription('Student Photo');
            $drawing->setPath(public_path($student->appl_photo)); // Path to the image file
            $drawing->setHeight(90); // Set the height of the image
            $drawing->setCoordinates('I' . $row); // Place the image in the correct cell, e.g., 'B2', 'B3', etc.
            $drawings[] = $drawing;
            $row++;
        }

        return $drawings;
    }
}
