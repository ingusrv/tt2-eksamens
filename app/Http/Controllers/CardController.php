<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Card;
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

    public function destroy(int $boardId, int $columnId, int $cardId, Request $request)
    {
        $user = $request->user();

        $board = Board::find($boardId);
        if (!$board) {
            return redirect()->route("dashboard");
        }
        if ($board->user_id !== $user->id) {
            // TODO: if board is not owned by user AND isnt shared with edit permissions
            return redirect()->route("dashboard");
        }

        $column = Column::find($columnId);
        if (!$column) {
            return redirect()->route("board.show", $boardId);
        }
        if ($column->board_id !== $board->id) {
            return redirect()->route("dashboard");
        }

        $card = Card::find($cardId);
        if (!$card) {
            return redirect()->route("board.show", $boardId);
        }
        if ($card->column_id !== $column->id) {
            return redirect()->route("dashboard");
        }

        $card->delete();

        return redirect()->route("board.show", $boardId);
    }
}
