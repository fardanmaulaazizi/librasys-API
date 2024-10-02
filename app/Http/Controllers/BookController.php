<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'book retrieval successful',
            'data' => $books
        ]);
    }

    public function store(Request $request)
    {
        $data = new Book();
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'quantity' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'massage' => 'book addition failed',
                'data' => $validator->errors()
            ], 401);
        }

        $data->title = $request->title;
        $data->author = $request->author;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->save();
        return response()->json([
            'status' => true,
            'massage' => 'book addition successful',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, Book $book)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'book data update failed',
                'data' => $validator->errors()
            ], 401);
        }

        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->quantity = $request->quantity;
        $book->save();

        return response()->json([
            'status' => true,
            'message' => 'book data update successful',
            'data' => $book
        ], 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'status' => true,
            'message' => 'user data deletion successful',
            'data' => $book
        ], 200);
    }
}
