<?php

namespace App\Http\Controllers;

use App\Models\Loto;

class SiteController extends Controller
{
    public function index()
    {
        $recentlyLotosResults = Loto::with(['results' => function ($query) {
            $query->orderBy('contest_number', 'DESC');
        }])->get()->transform(function ($loto) {
            return $loto->results->first();
        });

        return view('application.front.site_index', compact('recentlyLotosResults'));
    }
}
