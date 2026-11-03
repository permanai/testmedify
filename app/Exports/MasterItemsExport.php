<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MasterItemsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected int $rowNumber = 0;

    public function query()
    {
        return MasterItem::with('kategoris')->orderBy('id');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Item',
            'Nama Supplier',
            'Harga Beli',
            'Laba (%)',
            'Harga Jual',
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;

        $kategori  = $item->kategoris->pluck('nama')->join(', ') ?: '-';
        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

        return [
            $this->rowNumber,
            $kategori,
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            round($hargaJual),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row: bold + background
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF343A40']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 30,  // Nama Kategori
            'C' => 35,  // Nama Item
            'D' => 20,  // Nama Supplier
            'E' => 15,  // Harga Beli
            'F' => 10,  // Laba
            'G' => 15,  // Harga Jual
        ];
    }
}
