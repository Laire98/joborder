<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderModel extends Model
{
    use HasFactory;

    protected $table = 'workorder';

    protected $fillable = [
        'workorder_desc',
        'customer_id',
        'device',
        'model',
        'serial',
        'access',
        'issue',
        'inspection',
        'software',
        'interview',
        'replacement',
        'patch',
        'backup',
        'other',
        'other_desc',
        'completion_time',
        'start_date',
        'completion_date',
        'labor_charges',
        'software_cost',
        'miscellaneous_expense',
        'total_cost',
        'status_id',
        'status_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;
    protected $dates = ['completion_time', 'start_date',  'completion_date'];
}
