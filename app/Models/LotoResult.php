<?php

namespace App\Models;

use Carbon\Carbon;
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
        "lucky_month",
        "cycle"
    ];

    protected $dates = ['contest_date', 'date_next_contest'];


    // Relations
    public function loto()
    {
        return $this->belongsTo(Loto::class, "loto_id");
    }

    // Acessors
    public function getFormattedAccumulatedNextContestAttribute(){
        return number_format($this->accumulated_next_contest, 2, ",", ".");
    }

    public function getFormattedNameAttribute(){
        switch($this->name){
            case "megasena": return "Mega Sena";
            case "lotofacil": return "Lotofácil";
            case "quina": return "Quina";
            case "duplasena": return "Dupla-Sena";
            case "lotomania": return "Lotomania";
            case "diadesorte": return "Dia de Sorte";
            case "timemania": return "Timemania";
        }
    }

    public function getStyleClassByName(){
        switch($this->name){
            case "megasena": return "megasena-number";
            case "lotofacil": return "lotofacil-number";
            case "lotomania": return "lotomania-number";
            case "duplasena": return "dupla-number";
            case "quina": return "quina-number";
            case "diadesorte": return "dia-number";
            case "timemania": return "time-number";
        }
    }

    // Functions
    public function nextContestInDays()
    {
        if($diff = $this->date_next_contest->diffInDays(Carbon::now()) < 1) {
            $diff = $this->date_next_contest->diffInHours(Carbon::now()) . ' horas';
        } else {
            $diff = $diff . ' dias';
        }

        return $diff;
    }
}
