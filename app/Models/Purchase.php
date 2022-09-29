<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier',
        'invoice_number',
        'order_date',
        'delivery_date',
        'payment_mode',
        'purchase_note',
        'purchase_total',
        'payment_status',
        'other_expense',
        'created_by',
    ];
}
