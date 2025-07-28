<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index(): JsonResponse {
        $todos = Todo::all();
        return response()->json([
            "message" => "Todos fetched succesfully",
            "data" => $todos
        ]);
    }

    public function store(Request $request):JsonResponse {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "is_completed" => "sometimes|boolean"
        ]);

        if($validator->fails()) {
            return response()->json(["message" => "Validation failed", "errors" => $validator->errors()], 422);
        }

        $todo = Todo::create([
            "title" => $request->title,
            "is_completed" => $request->input('is_completed', false),
        ]);

        return response()->json([
            "message" => "Todo created succesfully",
            "data" => $todo
        ], 201);
    }

    public function complete(Todo $todo):JsonResponse {
        $todo->update([
            'is_completed' => true
        ]);

        return response()->json([
            "message" => "Todo completed succesfully",
            "data" => $todo
        ], 200);
    }

    public function destroy(Todo $toDo):JsonResponse {
        $toDo->delete();

        return response()->json([
            "message" => "Todo deleted succesfully",
            "data" => $toDo
        ], 200);
    }

    public function getDeletedTodos():JsonResponse {
        $todos = Todo::onlyTrashed()->get();

        return response()->json([
            "message" => "Deleted todos fetched succesfully",
            "data" => $todos
        ], 200);
    }

    public function getAllTodos():JsonResponse {
        $todos = Todo::withTrashed()->get();

        return response()->json([
            "message" => "All todos fetched succesfully",
            "data" => $todos
        ], 200);
    }

    public function restore(int $id):JsonResponse {
        $todo = Todo::withTrashed()->find($id);

        if(!$todo) {
            return response()->json(["message" => "Todo not found"], 404);
        }

        $todo->restore();

        return response()->json([
            "message" => "Todo restored succesfully",
            "data" => $todo
        ], 200);
    }

    public function forceDelete(int $id):JsonResponse {
        $todo = Todo::withTrashed()->find($id);

        if(!$todo) {
            return response()->json(["message" => "Todo not found"], 404);
        }

        $todo->forceDelete();

        return response()->json([
            "message" => "Todo succesfully deleted permanently",
            "data" => $todo
        ], 200);
    }
}
