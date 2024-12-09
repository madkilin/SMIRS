<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemCheck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'location_id', 'inventory_id', 'status', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getQuantityAttribute()
    {
        return DB::table('location_inventory')
            ->where('location_id', $this->location_id)
            ->where('inventory_id', $this->inventory_id)
            ->value('quantity');
    }
}
