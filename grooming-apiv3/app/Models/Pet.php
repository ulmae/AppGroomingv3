<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Pet extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'customer_id', 'name', 'species', 'breed', 'birth_date', 'weight_kg', 'notes'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'weight_kg' => 'decimal:2',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

public function getAgeAttribute()
{
    if (!$this->birth_date) {
        return null;
    }
    
    return $this->birth_date->diffInYears(now());
}


public function getAgeTextAttribute()
{
    if (!$this->birth_date) {
        return 'Edad no registrada';
    }
    
    $years = $this->birth_date->diffInYears(now());
    $months = $this->birth_date->diffInMonths(now()) % 12;
    
    if ($years > 0) {
        return $years === 1 ? '1 año' : "{$years} años";
    } elseif ($months > 0) {
        return $months === 1 ? '1 mes' : "{$months} meses";
    } else {
        $days = $this->birth_date->diffInDays(now());
        return $days === 1 ? '1 día' : "{$days} días";
    }
}
}