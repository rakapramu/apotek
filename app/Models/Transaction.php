<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'user_id', 'obat_id', 'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
