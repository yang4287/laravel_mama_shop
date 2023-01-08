<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;


use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CartController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    protected $cartService;



    public function __construct(cartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function index() #該會員購物車商品
    {

        $cart = $this->cartService->index()->get();





        return response()->json($cart);
    }
    public function amountSum() #該會員購物車商品數量
    {
        if (Session::has('account_id')) {
            $cart = $this->cartService->index();

            $sum = $cart->sum('number');
        } else {
            $sum  = 0;
        }



        return response()->json(['sum' => $sum]);
    }
    public function add(Request $request)
    {
        try {


            $cart_product = $this->cartService->index()->pluck('product_id')->toArray();
            if (in_array($request->product_id, $cart_product)) {
                $this->cartService->update($request, True);
            } else {
                $this->cartService->add($request);
            }

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e], 422);
        }
    }
    public function update(Request $request)
    {
        try {
            $this->cartService->update($request);


            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e], 422);
        }
    }
    public function delete(Request $request)
    {
        try {
            $this->cartService->delete($request);


            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e], 422);
        }
    }
}
