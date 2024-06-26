<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class SharedBoardController extends Controller
{
    public function store(int $boardId, Request $request)
    {
        $board = Board::find($boardId);
        if (!$board) {
            return redirect()->route("dashboard");
        }

        if ($request->userId == null) {
            return redirect()->route("board.edit", $boardId);
        }

        if ($request->permissions == null) {
            return redirect()->route("board.edit", $boardId);
        }

        $board->sharedUsers()->attach(
            $request->userId,
            ["permissions" => $request->permissions]
        );

        return redirect()->route("board.edit", $boardId)->with("status", "board-shared");
    }

    public function destroy(int $boardId, int $userId, Request $request)
    {
        $user = $request->user();
        $board = Board::find($boardId);
        if (!$board) {
            return redirect()->route("dashboard");
        }
        if ($board->user_id !== $user->id) {
            return redirect()->route("dashboard");
        }

        $board->sharedUsers()->detach($userId);

        return redirect()->route("board.edit", $boardId);
    }
}
