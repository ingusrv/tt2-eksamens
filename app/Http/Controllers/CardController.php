<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(int $boardId, int $columnId, Request $request)
    {
        if (!$request->text) {
            return redirect()->route("board.show", $boardId);
        }

        $column = Column::find($columnId);
        $lastCard = $column->cards()->get()->sortBy("order")->last();
        $order = $lastCard ? $lastCard->order + 1 : 0;
        $column->cards()->create([
            "text" => $request->text,
            "order" => $order,
        ]);

        return redirect()->route("board.show", $boardId);
    }
}
