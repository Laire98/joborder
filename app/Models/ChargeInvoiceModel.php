<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeInvoiceModel extends Model
{
    use HasFactory;

    protected $table = 'charge_invoice';

    protected $fillable = [
        'charge_desc',
        'customer_id',
        'tin',
        'address',
        'remarks',
        'non_vat',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
