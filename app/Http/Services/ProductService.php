<?php


namespace App\Http\Services;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ProductService {
    

    public function add($input) {
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
        Product::destroy($id);
        
        
        Storage::deleteDirectory('/public/image/commodity/'.$id);
        
        
    }
   
}