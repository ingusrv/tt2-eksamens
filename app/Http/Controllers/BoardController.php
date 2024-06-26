<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $boards = Board::where("user_id", $user->id)->get();
        //$boards = Board::all();

        // TODO: shared boards

        return view("board.index", compact("boards", "user"));
    }

    public function show(int $id)
    {
        $board = Board::find($id);
        $columns = $board->columns()->orderBy("order", "asc")->get();

        return view("board.show", compact("board", "columns"));
    }

    public function store(Request $request)
    {
        if (!$request->name) {
            return redirect()->route("dashboard");
        }

        $request->user()->boards()->create([
            "name" => $request->name,
            "privacy" => 0
        ]);

        return redirect()->route("dashboard");
    }

    public function edit(int $id)
    {
        $board = Board::find($id);
        $users = User::all();
        $privacyOptions = [
            ["value" => 0, "name" => "Private"],
            ["value" => 1, "name" => "Unlisted"],
            ["value" => 2, "name" => "Public"],
        ];

        return view("board.edit", compact("board", "users", "privacyOptions"));
    }

    public function update(int $id, Request $request)
    {
        $user = $request->user();
        $board = Board::find($id);

        if (!$board) {
            return redirect()->route("dashboard");
        }

        if ($board->user_id !== $user->id) {
            return redirect()->route("dashboard");
        }

        if ($request->name == null || $request->privacy == null) {
            return redirect()->route("board.edit", $id);
        }

        $board->name = $request->name;
        $board->privacy = $request->privacy >= 0 && $request->privacy <= 2 ? $request->privacy : 0;
        $board->save();

        return redirect()->route("board.edit", $id)->with("status", "board-data-updated");
    }

    public function destroy(int $id, Request $request)
    {
        $request->validateWithBag('boardDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $board = Board::find($id);

        if (!$board) {
            return redirect()->route("dashboard");
        }

        if ($board->user_id !== $user->id) {
            return redirect()->route("dashboard");
        }

        $board->delete();

        return redirect()->route("dashboard");
    }
}
