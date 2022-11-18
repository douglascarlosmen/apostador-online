<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LotoResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "lotos_results";

    protected $fillable = [
        "loto_id",
        "name",
        "contest_number",
        "contest_date",
        "place",
        "dozens",
        "awards",
        "awarded_states",
        "accumulated",
        "accumulated_next_contest",
        "date_next_contest",
        "next_context_number",
        "heart_team",
        "lucky_month"
    ];

    public function loto()
    {
        return $this->belongsTo(Loto::class, "loto_id");
    }
}
