<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $boards = $user->boards()->get();
        $sharedBoards = $user->sharedBoards()->get();

        $panelOrder = ["myboards", "sharedboards", "allboards", "allusers"];
        // ja ir lietotāja definēts order
        if ($user->panel_order) {
            $panelOrder = explode(",", $user->panel_order);
        }

        if ($user->role === 1) {
            $allBoards = Board::all();
            $allUsers = User::all();

            return view("board.index", compact("boards", "user", "sharedBoards", "allBoards", "allUsers", "panelOrder"));
        }

        return view("board.index", compact("boards", "user", "sharedBoards", "panelOrder"));
    }

    public function show(int $id, Request $request)
    {
        $user = $request->user();
        $board = Board::find($id);
        if (!$board) {
            return redirect()->route("dashboard");
        }

        $sharedUser = $board->sharedUsers()->find($user->id);
        $canEdit = false;

        if ($board->user_id !== $user->id) {
            if (!$sharedUser) {
                return redirect()->route("dashboard");
            } else {
                $canEdit = $sharedUser->pivot->permissions === 1;
            }
        } else {
            $canEdit = true;
        }

        $columns = $board->columns()->orderBy("order", "asc")->get();

        return view("board.show", compact("board", "columns", "canEdit"));
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

    public function import(Request $request)
    {
        $user = $request->user();

        if (!$request->hasFile("board")) {
            throw ValidationException::withMessages(["board" => __("Import failed: ") . __("No file")]);
        }

        $contents = $request->file("board")->get();
        if (!$contents) {
            throw ValidationException::withMessages(["board" => __("Import failed: ") . __("File is empty")]);
        }

        $json = json_decode($contents);

        if (!isset($json->name)) {
            throw ValidationException::withMessages(["board" => __("Import failed: ") . __("Board name is invalid")]);
        }
        if (!isset($json->privacy)) {
            throw ValidationException::withMessages(["board" => __("Import failed: ") . __("Board privacy is invalid")]);
        }

        $board = new Board();
        $board->user_id = $user->id;
        $board->name = $json->name;
        $board->privacy = $json->privacy;
        $board->save();

        foreach ($json->columns as $col) {
            if (!isset($col->name)) {
                throw ValidationException::withMessages(["board" => __("Import stopped at error: ") . __("Column name is invalid")]);
            }
            if (!isset($col->order)) {
                throw ValidationException::withMessages(["board" => __("Import stopped at error: ") . __("Column order is invalid")]);
            }

            $column = new Column();
            $column->name = $col->name;
            $column->board_id = $board->id;
            $column->order = $col->order;
            $column->save();

            foreach ($col->cards as $card) {
                if (!isset($card->text)) {
                    throw ValidationException::withMessages(["board" => __("Import stopped at error: ") . __("Card text is invalid")]);
                }
                if (!isset($card->order)) {
                    throw ValidationException::withMessages(["board" => __("Import stopped at error: ") . __("Card order is invalid")]);
                }

                $column->cards()->create(["text" => $card->text, "order" => $card->order]);
            }
        }

        return redirect()->route("profile.edit")->with("status", "board-imported");
    }

    public function edit(int $id, Request $request)
    {
        $user = $request->user();
        $board = Board::find($id);
        if (!$board) {
            return redirect()->route("dashboard");
        }

        if ($board->user_id !== $user->id) {
            return redirect()->route("dashboard");
        }

        $users = User::all();
        $privacyOptions = [
            ["value" => 0, "name" => __("Private")],
            ["value" => 1, "name" => __("Unlisted")],
            ["value" => 2, "name" => __("Public")],
        ];
        $sharedUsers = $board->sharedUsers()->get();

        return view("board.edit", compact("board", "users", "privacyOptions", "sharedUsers"));
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
