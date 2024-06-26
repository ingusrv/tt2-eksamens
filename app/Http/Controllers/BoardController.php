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
        $columns = $board->columns()->get()->sortBy("order");

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

        return view("board.edit", compact("board", "users"));
    }
}
