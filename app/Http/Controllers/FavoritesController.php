<?php

namespace App\Http\Controllers;

use Auth;
use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function store (Reply $reply)
    {
        $reply->favourite();

        return back();
    }
}
