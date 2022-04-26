<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'contact_number',
        'address',
        'sold_date',
        'created_by',
        'payment_mode',
        'sales_note',
        'discount',
        'payment_status',
    ];
}
