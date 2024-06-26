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

        $user = $request->user();
        $board = Board::find($boardId);
        if (!$board) {
            return redirect()->route("dashboard");
        }
        if ($board->user_id !== $user->id) {
            $sharedUser = $board->sharedUsers()->find($user->id);
            if (!$sharedUser) {
                return redirect()->route("board.show", $boardId);
            }
            if ($sharedUser->pivot->permissions === 0) {
                return redirect()->route("board.show", $boardId);
            }
        }

        $column = Column::find($columnId);
        if (!$column) {
            return redirect()->route("board.show", $boardId);
        }
        if ($column->board_id !== $board->id) {
            return redirect()->route("dashboard");
        }

        $lastCard = $column->cards()->orderBy("order", "asc")->get()->last();
        $order = $lastCard ? $lastCard->order + 1 : 0;
        $column->cards()->create([
            "text" => $request->text,
            "order" => $order,
        ]);

        return redirect()->route("board.show", $boardId);
    }

    public function swap(int $boardId, int $columnId, int $cardId, int $targetCardId, Request $request)
    {
        $user = $request->user();

        $board = Board::find($boardId);
        if (!$board) {
            return redirect()->route("dashboard");
        }
        if ($board->user_id !== $user->id) {
            $sharedUser = $board->sharedUsers()->find($user->id);
            if (!$sharedUser) {
                return redirect()->route("board.show", $boardId);
            }
            if ($sharedUser->pivot->permissions === 0) {
                return redirect()->route("board.show", $boardId);
            }
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

        $targetCard = Card::find($targetCardId);
        if (!$targetCard) {
            return redirect()->route("board.show", $boardId);
        }
        // lai kolonna ar kuru apmainīs vietas arī pieder tam pašam dēlim
        $targetColumn = Column::find($targetCard->column_id);
        if (!$targetColumn) {
            return redirect()->route("board.show", $boardId);
        }
        if ($targetColumn->board_id !== $board->id) {
            return redirect()->route("dashboard");
        }

        $currentOrder = $card->order;
        $card->order = $targetCard->order;
        $targetCard->order = $currentOrder;

        $card->save();
        $targetCard->save();

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
            $sharedUser = $board->sharedUsers()->find($user->id);
            if (!$sharedUser) {
                return redirect()->route("board.show", $boardId);
            }
            if ($sharedUser->pivot->permissions === 0) {
                return redirect()->route("board.show", $boardId);
            }
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
