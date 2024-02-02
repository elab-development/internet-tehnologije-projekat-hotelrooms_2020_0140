<?php

namespace App\Exports;

use App\Models\Hotel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(Hotel::getAllHotels());
    }

    public function headings(): array
    {
        return ['id', 'name', 'type', 'description', 'city', 'address', 'rating'];
    }
}
