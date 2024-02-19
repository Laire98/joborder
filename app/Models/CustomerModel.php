<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;
}
