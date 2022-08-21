<?php


namespace App\Http\Services;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductService {
    

    public function add($input) {
        $input->validate([
            'id' => 'required|unique:product',
          
        ]);
        if ( str_contains($input['id'],'../') || str_contains(urlencode ($input['id']),'..%2F')){
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        $product = new Product([
            'product_id' => $input['id'],
            'name' =>$input['name'],
            'class' => $input['class'],
            'content' => $input['content'],
            'price' => $input['price'],
            'amount' => $input['amount'],
            'status' => $input['status'],
            ]);
        $product->save();
    }

    public function update($input) {
        $product = Product::find($input['product_id']);
        $product->name = $input['name'];
        $product->class = $input['class'];
        $product->content = $input['content'];
        $product->price = $input['price'];
        $product->number =$input['amount'];
        $product->status = $input['status'];
        
        return $product->save();
    }

    public function delete($id) { 
        if (str_contains($id, '../') || str_contains(urlencode($id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
      
        Product::destroy($id);
        
        
        Storage::deleteDirectory('/public/image/product/'.$id);
        
        
    }
   
}