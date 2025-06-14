<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Validator};
use App\Models\{Order, Status, Product, Role, Transaction, User};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function makeOrderGet($productId)
    {
        $product = Product::findOrFail($productId);
        return view('order.make_order', [
            'title' => 'Make Order',
            'product' => $product
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
        ]);

        Order::create([
            'product_id' => $validatedData['product_id'],
            'user_id' => $validatedData['user_id'],
            'quantity' => $validatedData['quantity'],
            'address' => $validatedData['address'],
            'shipping_address' => 'NULL',
            'total_price' => $validatedData['total_price'],
            'payment_id' => 2,
            'bank_id' => 1,
            'note_id' => 1,
            'status_id' => 2,
            'transaction_doc' => null,
            'is_done' => 0,
        ]);

        return redirect()->back()->with('success', 'Order created successfully!');
    }


    // Hiển thị đơn hàng chưa duyệt
    public function orderData()
    {
        $title = "Dữ Liệu Đơn Hàng";
        $currentUser = Auth::user();

        if (!$currentUser) {
            return redirect()->route('login');
        }

        $orders = Order::with(['bank', 'note', 'payment', 'user', 'status', 'product'])
            ->where('is_done', 0)
            ->when($currentUser->role_id != Role::ADMIN_ID, function($query) use ($currentUser) {
                return $query->where('user_id', $currentUser->id);
            })
            ->orderBy('id', 'ASC')
            ->get();

        $status = Status::all();
        return view('order.order_data', compact('title', 'orders', 'status'));
    }

    public function orderDataFilter(Request $request, $status_id)
    {
        $title = "Dữ Liệu Đơn Hàng";
        $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where("status_id", $status_id)->orderBy("id", "ASC")->get();
        $status = Status::all();

        return view("/order/order_data", compact("title", "orders", "status"));
    }

    public function getOrderData(Order $order)
    {
        $order->load("product", "user", "note", "status", "bank", "payment");
        return $order;
    }

    // Hiển thị lịch sử đơn đã duyệt
    public function orderHistory()
    {
        $title = "Lịch Sử Đơn Hàng";
        $currentUser = Auth::user();

        if (!$currentUser) {
            return redirect()->route('login');
        }

        $orders = Order::with(['bank', 'note', 'payment', 'user', 'status', 'product', 'approver'])
            ->where('is_done', 1)
            ->when($currentUser->role_id != Role::ADMIN_ID, function($query) use ($currentUser) {
                return $query->where('user_id', $currentUser->id);
            })
            ->orderBy('id', 'DESC') // Changed from approved_at to id as temporary fix
            ->get();

        $status = Status::all();
        return view('order.order_data', compact('title', 'orders', 'status'));
    }
    public function approveOrder(Order $order)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser || $currentUser->role_id != Role::ADMIN_ID) {
                throw new \Exception('Unauthorized action');
            }

            $order->update([
                'is_done' => 1,
                'status_id' => 5,
                'approved_by' => $currentUser->id,
                'approved_at' => now()
            ]);

            $message = "Đơn hàng đã được duyệt thành công!";
            myFlasherBuilder(message: $message, success: true);

            return redirect()->back();

        } catch (\Exception $e) {
            $message = "Có lỗi xảy ra khi duyệt đơn hàng!";
            myFlasherBuilder(message: $message, failed: true);
            return redirect()->back();
        }
    }
}
