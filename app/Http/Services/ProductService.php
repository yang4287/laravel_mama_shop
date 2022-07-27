<?php


namespace App\Http\Services;
use App\Models\Product;
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
            'id' => $input['id'],
            'name' =>$input['name'],
            'class' => $input['class'],
            'content' => $input['content'],
            'price' => $input['price'],
            'number' => $input['number'],
            'status' => $input['status'],
            ]);
        $product->save();
    }

    public function update($input) {
        $product = Product::find($input['id']);
        $product->name = $input['name'];
        $product->class = $input['class'];
        $product->content = $input['content'];
        $product->price = $input['price'];
        $product->number =$input['number'];
        $product->status = $input['status'];
        
        return $product->save();
    }

    public function delete($id) { //此刪除連Image資料表一起刪除
        if (str_contains($id, '../') || str_contains(urlencode($id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        Product::destroy($id);
        
        
        Storage::deleteDirectory('/public/image/product/'.$id);
        
        
    }
   
}