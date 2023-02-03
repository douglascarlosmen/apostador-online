<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PrintController extends Controller
{
    protected $games;
    protected $tickets;
    protected $count;
    public function __construct(){
        $this->games = [];
        $this->tickets = [];
        $this->count = 0;
    }


    public function index(){
        return view('application.front.printer');
    }

    public function print(Request $request){
        $splittedGames = explode("\r\n", $request->dozens_text);

        foreach($splittedGames as $index => $game){
            if ($index == 0){
                $quantity = $this->getDozensCount($game);
            }

            $this->games[] = view('application.tickets.'.$request->loto.'.game', ['game' => $game, 'type' => $request->type])->render();
            $this->count++;
            if ($this->count % 3 == 0){
                $this->tickets[] = view('application.tickets.'.$request->loto.'.ticket', ['games' => $this->games, 'quantity' => $quantity, 'type' => $request->type])->render();
                $this->games = [];
            }else if ($index == count($splittedGames) - 1){
                $left = 3 - count($this->games);
                for ($i = 0; $i < $left; $i++){
                    $this->games[] = view('application.tickets.'.$request->loto.'.game', ['game' => ""])->render();
                }
                $this->tickets[] = view('application.tickets.'.$request->loto.'.ticket', ['games' => $this->games, 'quantity' => $quantity, 'type' => $request->type])->render();
            }
        }
        return view('application.tickets.'.$request->loto.'.layout', ['tickets' => $this->tickets]);
    }

    private function getDozensCount($game){
        if (str_contains($game, ','))
            $dozens = explode(',', $game);
        else if (str_contains($game, ' '))
            $dozens = explode(',', $game);

        return count($dozens);
    }
}
