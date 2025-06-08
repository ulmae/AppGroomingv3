<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroomingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'duration_min'
    ];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'work_order_services', 'service_id', 'work_order_id')
                    ->withPivot('order_index');
    }
}
