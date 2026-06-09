<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $fillable = ['email', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
