<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function store(int $BoardId, Request $request)
    {
        if (!$request->name) {
            return redirect()->route("board.show", $BoardId);
        }

        $board = Board::find($BoardId);
        $lastColumn = $board->columns()->get()->sortBy("order")->last();
        $order = $lastColumn ? $lastColumn->order + 1 : 0;
        $board->columns()->create([
            "name" => $request->name,
            "order" => $order,
        ]);

        return redirect()->route("board.show", $BoardId);
    }
}
