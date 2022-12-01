<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loto extends Model
{
    use HasFactory;

    protected $table = "lotos";

    protected $fillable = ["name"];

    public function results()
    {
        return $this->hasMany(LotoResult::class, 'loto_id');
    }
}
