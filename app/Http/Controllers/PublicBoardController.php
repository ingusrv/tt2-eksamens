<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class PublicBoardController extends Controller
{
    public function show(int $id, Request $request)
    {
        $board = Board::find($id);
        if (!$board) {
            return redirect()->route("index");
        }

        $canEdit = false;

        if ($board->privacy === 0) {
            return redirect()->route("index");
        }

        $columns = $board->columns()->orderBy("order", "asc")->get();

        return view("board.public", compact("board", "columns", "canEdit"));
    }
}
