<?php


namespace App\Http\Services;

use App\Models\ProductClass;



class ProductClassService
{


    public function index($product_id)
    {

        return ProductClass::where('product_id', $product_id)->get();
    }
    public function add($product_id, $class)
    {

        $productClass = new ProductClass([
            'product_id' => $product_id,
            'class' => $class,
            
            ]);
        return $productClass->save();
    }

    public function update($product_id, $class)
    {
        $productClass = ProductClass::where('product_id', $product_id)->first();
       
        $productClass->class = $class;
    
        
        return $productClass->save();
    }

    public function delete($product_id) #刪除產品
    {
       
       
        ProductClass::where('product_id', $product_id)->delete();


        
    }
   
}
