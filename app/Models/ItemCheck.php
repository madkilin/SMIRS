<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'inventory_id',
        'status',
        'description',
        'location_item_id'
    ];

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
    public function locationItem()
    {
        return $this->belongsTo(LocationItem::class)->withTrashed(); // Menambahkan withTrashed pada relasi
    }
}
