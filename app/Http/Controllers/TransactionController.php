<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $title = "Danh sách giao dịch";
        $transactions = Transaction::with("category")->get();

        return view("/transaction/index", compact("title", "transactions"));
    }

    public function addOutcomeGet()
    {
        $title = "Thêm giao dịch";
        $categories = Category::where("id", "!=", 1)->get();

        return view("/transaction/add_outcome", compact("title", "categories"));
    }

    public function addOutcomePost(Request $request)
    {
        $validatedData = $request->validate(
            [
                "category_id" => "required|numeric|gt:0",
                "outcome" => "required|numeric|gt:0",
                "description" => "required"
            ],
            [
                "category_id.gt" => "Vui lòng chọn danh mục hợp lệ."
            ]
        );

        Transaction::create($validatedData);

        $message = "Giao dịch đã được tạo thành công!";

        myFlasherBuilder(message: $message, success: true);

        return redirect("/transaction");
    }

    public function editOutcomeGet(Transaction $transaction)
    {
        $title = "Chỉnh sửa giao dịch";
        $transaction->load("category");
        $categories = Category::where("id", "!=", 1)->get();

        return view("/transaction/edit_outcome", compact("title", "transaction", "categories"));
    }

    public function editOutcomePost(Request $request, Transaction $transaction)
    {
        $validatedData = $request->validate(
            [
                "category_id" => "required|numeric|gt:0",
                "outcome" => "required|numeric|gt:0",
                "description" => "required"
            ],
            [
                "category_id.gt" => "Vui lòng chọn danh mục hợp lệ."
            ]
        );

        $transaction->fill($validatedData);

        if ($transaction->isDirty()) {
            $transaction->save();

            $message = "Giao dịch đã được cập nhật thành công!";

            myFlasherBuilder(message: $message, success: true);

            return redirect("/transaction");
        } else {
            $message = "Thao tác thất bại, không có thay đổi nào!";

            myFlasherBuilder(message: $message, failed: true);

            return back();
        }
    }
}
