<?php


namespace App\Http\Services;

use App\Models\Product_image;
use Illuminate\Support\Facades\Storage;



class ProductImageService {
    

    public function index($id) {
        
        return Product_image::where('product_id', $id)->get();;
    }
    public function add($id,$image,$order) {
        
        if (!is_null($image['path'])) { //判斷是否有上傳照片

        $path = '../storage/image/commodity/' .$id . '/' .$id . '_' .  strval($order) . '.jpg'; //儲存在資料庫的路徑

        Storage::putFileAs('/public/image/commodity/' . $id . '/',$image['path'], $id . '_' . strval($order) . '.jpg');
        $product_image = new Product_image([
            'product_id' => $id,
            'path' => $path,
            'order' => $order,
            
            ]);
        $product_image->save();
        }
        
    }

    public function update($id,$image,$order) {
        if (!str_contains($image['path'],'../storage/image/commodity/') ) { //判斷是否有上傳照片

          
            Storage::delete('/public/image/commodity/' . $id . '/' . $id . '_' .  strval($order) . '.jpg');
            Storage::putFileAs('/public/image/commodity/' . $id . '/', $image['path'], $id. '_' .  strval($order) . '.jpg');
           }
           
           
    }

    public function delete($id,$order) {
         Product_image::where('product_id', $id)->where('order', $order)->delete();
 
       
        Storage::delete('/public/image/commodity/' . $id . '/' . $id . '_' .  strval($order) . '.jpg');
        
     }
    
}