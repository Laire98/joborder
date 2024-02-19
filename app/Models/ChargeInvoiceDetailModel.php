<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeInvoiceDetailModel extends Model
{
    use HasFactory;
    protected $table = 'charge_invoice_detail';

    protected $fillable = [
        'charge_id',
        'quantity',
        'unit',
        'articles',
        'price',
        'total',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
