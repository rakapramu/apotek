<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = ['obat_id', 'jumlah', 'total'];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
