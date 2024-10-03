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

    public function borrow(Request $request)
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
                'message' => 'cannot add borrowing data because the book quantity is not enough',
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

    public function return(Request $request, Borrowing $borrowing)
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

        if ($borrowing->status == 'returned') {
            return response()->json([
                'status' => false,
                'message' => 'the book has already been returned',
                'data' => $borrowing
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

    public function update(Request $request, Borrowing $borrowing)
    {
        $rules = [
            'user_id' => 'required',
            'book_id' => 'required',
            'quantity' => 'required',
            'status' => 'required',
            'loan_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'borrrowing data update failed',
                'data' => $validator->errors()
            ]);
        }

        if ($borrowing->loan_date > $request->loan_date) {
            return response()->json([
                'status' => false,
                'message' => 'cannot update borrowing data because the return date before the date the book was borrowed',
            ]);
        }

        if ($borrowing->status == 'loaned') {
            $oldBook = Book::find($borrowing->book_id);
            $oldBookQuantity = $oldBook->quantity;
            $oldBook->quantity += $borrowing->quantity;
            $oldBook->save();
        }

        $newBook = Book::find($request->book_id);
        if ($request->quantity > $newBook->quantity) {
            $oldBook->quantity = $oldBookQuantity;
            $oldBook->save();
            return response()->json([
                'status' => false,
                'message' => 'cannot update borrowing data because the book quantity is not enough',
            ]);
        }
        if ($request->status == 'loaned') {
            $newBook->quantity -= $request->quantity;
            $newBook->save();
        }

        $borrowing->user_id = $request->user_id;
        $borrowing->book_id = $request->book_id;
        $borrowing->quantity = $request->quantity;
        $borrowing->status = $request->status;
        $borrowing->loan_date = $request->loan_date;
        $borrowing->return_date = $request->return_date;
        $borrowing->save();
        return response()->json([
            'status' => true,
            'message' => 'borrowing data update successful',
            'data' => $borrowing
        ]);
    }
    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status == 'loaned') {
            $book = $borrowing->book;
            $book->quantity += $borrowing->quantity;
            $book->save();
        }
        $borrowing->delete();
        return response()->json([
            'status' => true,
            'message' => 'borrowing data deletion successful',
            'data' => $borrowing
        ]);
    }

    public function user(User $user)
    {
        if (auth()->user()->role_id == 3 && auth()->user()->role_id != $user->role_id) {
            return response()->json([
                'status' => false,
                'message' => 'members cannot view borrowing data of other members.',
            ]);
        }
        $borrowings = Borrowing::with(['user.role', 'book'])->where('user_id', $user->id)->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'borrowing retrieval successful',
            'data' => $borrowings
        ]);
    }
}
