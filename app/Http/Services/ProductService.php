<?php


namespace App\Http\Services;

use App\Models\Product;

use Illuminate\Validation\ValidationException;

class ProductService
{

    public function index()
    {
        $product = Product::with('productImage:product_id,path')->with(['orderProduct'  => function ($query) {
            $query->with(['order' => function ($query) {
                $query->where('status', 5);
            }])->groupby('product_id')->selectRaw('product_id, sum(amount) as soldSum');
        }]);
        return $product;
    }

    public function add($input)
    {
        $input->validate([
            'product_id' => 'required|unique:product',

        ]);
        if (str_contains($input['product_id'], '../') || str_contains(urlencode($input['product_id']), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        $product = new Product([

            'product_id' => $input['product_id'],
            'name' => $input['name'],
            'content' => $input['content'],
            'price' => $input['price'],
            'amount' => $input['amount'],
            'status' => $input['status'],
        ]);
        return $product->save();
    }

    public function update($input)
    {
        $product = Product::where('product_id', $input['product_id'])->first();
        if (isset($input['name'])) {
            $product->name = $input['name'];
        }
        if (isset($input['content'])) {
            $product->content = $input['content'];
        }
        if (isset($input['price'])) {
            $product->price = $input['price'];
        }
        if (isset($input['amount'])) {
            $product->amount = $input['amount'];
        }
        if (isset($input['status'])) {
            $product->status = $input['status'];
        }
        #$product->class = $input['class'];



        return $product->save();
    }

    public function delete($product_id)
    {
        if (str_contains($product_id, '../') || str_contains(urlencode($product_id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }

        Product::where('product_id', $product_id)->delete();
    }
}
