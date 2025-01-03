<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationItem extends Model
{
    use HasFactory;

    protected $table = 'location_inventory';

    protected $fillable = ['location_id', 'inventory_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function itemChecks()
    {
        return $this->hasMany(ItemCheck::class);
    }
}
