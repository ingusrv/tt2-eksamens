<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showBoard(int $id, Request $request)
    {
        $user = $request->user();
        $board = Board::find($id);
        if (!$board) {
            return redirect()->route("dashboard");
        }

        $canEdit = false;
        $columns = $board->columns()->orderBy("order", "asc")->get();

        return view("board.show", compact("board", "columns", "canEdit"));
    }

    public function destroyUser(int $userId, Request $request)
    {
        $user = $request->user();
        if ($user->role !== 1) {
            return redirect()->route("dashboard");
        }

        if ($user->id === $userId) {
            return redirect()->route("dashboard");
        }

        User::findOrFail($userId)->delete();

        return redirect()->route("dashboard");
    }
}
