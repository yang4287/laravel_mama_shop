<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Http\Services\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Product;

class ProductController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    protected $productService;
    protected $productServiceImage;


    public function __construct(ProductService $productService, ProductImageService $productImageService)
    {
        $this->productService = $productService;
        $this->productServiceImage = $productImageService;
    }



    public function index() #所有商品資訊及相片
    {

        $product = Product::with('product_image')->get();


        return response()->json($product);
    }

    public function delete(Request $request)
    {
    }
    public function update(Request $request)
    {
        $input = $request->all();
        $oldImage = $this->productServiceImage->index($input['id']);
        DB::transaction(function ()  use ($input, $oldImage) {

            if (count($input['image']) > $oldImage->count()) { #新相片數量>原相片數量
                $i = 0;
                for ($i; $i < count($oldImage); $i++) {
                    $this->productServiceImage->update($input['id'], $input['image'][$i], $i + 1);
                };

                for ($i; $i < count($input['image']); $i++) {
                    $this->productServiceImage->add($input['id'], $input['image'][$i], $i + 1);
                };
            } elseif (count($input['image']) < $oldImage->count()) {
                $i = 0;
                for ($i; $i < count($input['image']); $i++) {
                    $this->productServiceImage->update($input['id'], $input['image'][$i], $i + 1);
                };

                for ($i; $i <  count($oldImage); $i++) {
                    $this->productServiceImage->delete($input['id'], $i + 1);
                };
            } else {
                for ($i = 0; $i < count($input['image']); $i++) {
                    $this->productServiceImage->update($input['id'], $input['image'][$i], $i + 1);
                };
            }
            $this->productService->update($input);
        });

        return response()->json([
            'status' => 'success',



        ], 200);
    }
    public function add(Request $request)
    {
    }
}
