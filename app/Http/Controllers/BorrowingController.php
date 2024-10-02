<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{

    public function index()
    {
        $borrowings = Borrowing::with(['user.role', 'book'])->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'borrowing retrieval successful',
            'data' => $borrowings
        ]);
    }

    public function store(Request $request)
    {
        $data = new Borrowing();
        $rules = [
            'book_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
            'loan_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'book loan failed',
                'data' => $validator->errors()
            ]);
        }

        $book = Book::find($request->book_id);
        if ($book->quantity < $request->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'book quantity not enough',
                'data' => $book
            ]);
        }

        $book->quantity -= $request->quantity;
        $book->save();

        $data->book_id = $request->book_id;
        $data->user_id = $request->user_id;
        $data->quantity = $request->quantity;
        $data->loan_date = $request->loan_date;
        $data->status = 'loaned';
        $data->save();
        return response()->json([
            'status' => true,
            'message' => 'book loan successful',
            'data' => $data
        ]);
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $rules = [
            'borrowing_id' => 'required',
            'return_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'book return failed',
                'data' => $validator->errors()
            ]);
        }

        if ($borrowing->loan_date > $request->return_date) {
            return response()->json([
                'status' => false,
                'message' => 'cannot return the book before the date the book was borrowed',
            ]);
        }

        $book = Book::find($borrowing->book_id);
        $book->quantity += $borrowing->quantity;
        $book->save();
        $borrowing->return_date = $request->return_date;
        $borrowing->status = 'returned';
        $borrowing->save();
        return response()->json([
            'status' => true,
            'message' => 'book return successful',
            'data' => $borrowing
        ]);
    }

    public function destroy(Borrowing $borrowing)
    {
        $book = $borrowing->book;
        $book->quantity += $borrowing->quantity;
        $book->save();
        $borrowing->delete();
        return response()->json([
            'status' => true,
            'message' => 'borrowing data deletion successful',
            'data' => $borrowing
        ]);
    }

    public function user(User $user)
    {
        $borrowings = Borrowing::with(['user.role', 'book'])->where('user_id', $user->id)->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'borrowing retrieval successful',
            'data' => $borrowings
        ]);
    }
}
