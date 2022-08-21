<?php


namespace App\Http\Services;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class ProductImageService
{


    public function index($id)
    {

        return ProductImage::where('product_id', $id)->get();
    }
    public function add($id, $image, $order)
    {

        if (!is_null($image['path'])) { //判斷是否有上傳照片
            if (str_contains($image['path'], 'image')) { //判斷是否為相片'../storage/image/product/1/1_1.jpg'
                $path = '../storage/image/product/' . $id . '/' . $id . '_' .  strval($order) . '.jpg'; //儲存在資料庫的路徑

                Storage::putFileAs('/public/image/product/' . $id . '/', $image['path'], $id . '_' . strval($order) . '.jpg');
                $product_image = new ProductImage([
                    'product_id' => $id,
                    'path' => $path,
                    'order' => $order,

                ]);
                $product_image->save();
            } else {
                throw ValidationException::withMessages([
                    'field' => '請上傳image的格式',
                ]);
            }
        } else {
            throw ValidationException::withMessages(['field' => '請上傳相片']);
        }
    }

    public function update($id, $image, $order)
    {
        if (str_contains($id, '../') || str_contains(urlencode($id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        if (!str_contains($image['path'], '../storage/image/product/')) { //判斷是否有替換照片

            if (str_contains($image['path'], 'image')) { //判斷是否為相片
                Storage::delete('/public/image/product/' . $id . '/' . $id . '_' .  strval($order) . '.jpg');
                Storage::putFileAs('/public/image/product/' . $id . '/', $image['path'], $id . '_' .  strval($order) . '.jpg');
            } else {
                throw ValidationException::withMessages([
                    'field' => '請上傳image的格式',
                ]);
            }
        }
    }

    public function deleteOne($id, $order)
    {
        if (str_contains($id, '../') || str_contains(urlencode($id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        ProductImage::where('product_id', $id)->where('order', $order)->delete();


        Storage::delete('/public/image/product/' . $id . '/' . $id . '_' .  strval($order) . '.jpg');
    }
    public function deleteAll($id, $order)
    {
        if (str_contains($id, '../') || str_contains(urlencode($id), '..%2F')) {
            throw ValidationException::withMessages([
                'field' => 'id輸入有誤',
            ]);
        }
        ProductImage::destroy($id);

        Storage::deleteDirectory('/public/image/product/'.$id);
    }
}
