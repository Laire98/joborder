<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'workorder_desc',
        'voucher',
        'debit',
        'credit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
