<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function store(int $boardId, Request $request)
    {
        if (!$request->name) {
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

        $lastColumn = $board->columns()->orderBy("order", "asc")->get()->last();
        $order = $lastColumn ? $lastColumn->order + 1 : 0;
        $board->columns()->create([
            "name" => $request->name,
            "order" => $order,
        ]);

        return redirect()->route("board.show", $boardId);
    }

    public function swap(int $boardId, int $columnId, int $targetColumnId, Request $request)
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

        $targetColumn = Column::find($targetColumnId);
        if (!$targetColumn) {
            return redirect()->route("board.show", $boardId);
        }
        if ($targetColumn->board_id !== $board->id) {
            return redirect()->route("dashboard");
        }

        $currentOrder = $column->order;
        $column->order = $targetColumn->order;
        $targetColumn->order = $currentOrder;

        $column->save();
        $targetColumn->save();

        return redirect()->route("board.show", $boardId);
    }

    public function destroy(int $boardId, int $columnId, Request $request)
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

        $column->delete();

        return redirect()->route("board.show", $boardId);
    }
}
