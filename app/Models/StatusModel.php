<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $fillable = [
        'status_desc',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = false;
}
