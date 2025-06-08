<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkOrder extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'pet_id', 'created_by_id', 'assigned_to_id', 'status', 
        'estimated_ready', 'ready_at', 'customer_notified', 'comments'
    ];

    protected $casts = [
        'estimated_ready' => 'datetime',
        'ready_at' => 'datetime',
        'customer_notified' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function services()
    {
        return $this->belongsToMany(GroomingService::class, 'work_order_services', 'work_order_id', 'service_id')
                    ->withPivot('order_index')
                    ->orderBy('work_order_services.order_index');
    }

    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'in_progress' => 'En Proceso',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            default => 'Desconocido'
        };
    }

    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getServicesListAttribute()
    {
        return $this->services->pluck('name')->join(', ');
    }
}