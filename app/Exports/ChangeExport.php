<?php

namespace App\Exports;

use App\Models\Credit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChangeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * ดึงข้อมูลจาก Model `Credit` พร้อมดึง `user` และ `product`
     */
    public function collection()
    {
        return Credit::with(['product', 'user'])->get();
    }

    /**
     * กำหนดหัวตารางในไฟล์ Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'วันที่ทำรายการ',
            'ชื่อสินค้า',
            'ชื่อผู้ใช้',
            'Point ที่ใช้',
            'Credit ได้รับ',
            'Point คงเหลือ',
            'สถานะ'
        ];
    }

    /**
     * กำหนดค่าที่ต้องการแสดงในแต่ละแถว
     */
    public function map($credit): array
    {
        return [
            $credit->id,
            $credit->created_at->format('Y-m-d H:i:s'), // วันที่
            $credit->product ? $credit->product->name : 'ไม่มีสินค้า', // ชื่อสินค้า
            $credit->user ? $credit->user->name : 'ไม่มีข้อมูลผู้ใช้', // ชื่อผู้ใช้
            $credit->point,
            $credit->credit,
            $credit->lastPoint,
            $credit->status == 1 ? 'สำเร็จ' : 'รออนุมัติ', // สถานะ
        ];
    }
}
