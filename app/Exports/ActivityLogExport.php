<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityLogExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * ดึงข้อมูลจาก Model `Credit` พร้อมดึง `user` และ `product`
     */
    public function collection()
    {
        return ActivityLog::with('admin')->orderBy('created_at', 'desc')->get();
    }

    /**
     * กำหนดหัวตารางในไฟล์ Excel
     */
    public function headings(): array
    {
        return [
            'วันที่',
            'Admin',
            'กิจกรรม',
            'รายละเอียด',
        ];
    }

    /**
     * กำหนดค่าที่ต้องการแสดงในแต่ละแถว
     */
    public function map($log): array
    {
        return [
            $log->created_at->format('Y-m-d H:i:s'), // วันที่ทำรายการ
            $log->admin ? $log->admin->name : 'ไม่ทราบชื่อ', // ชื่อ Admin ที่ทำรายการ
            $log->action, // ประเภทกิจกรรม
            $log->details, // รายละเอียดเพิ่มเติม
        ];
    }
}
