<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Http\Services\ProductImageService;
use App\Http\Services\ProductClassService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductPostRequest;

use Illuminate\Support\Facades\DB;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

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
    protected $productServiceClass;


    public function __construct(ProductService $productService, ProductImageService $productImageService, ProductClassService $productClassService)
    {
        $this->productService = $productService;
        $this->productServiceImage = $productImageService;
        $this->productServiceClass = $productClassService;
    }



    public function index() #所有商品資訊及相片及賣出數量
    {

        $product = $this->productService->index();
        $product = $product->get();





        return response()->json($product);
    }

    public function shop_index(Request $request) #所有商品資訊及相片及賣出數量
    {

        $product = $this->productService->index();
        $product = $product->where('status', 1);





        if (!is_null($request->class)) {
            if ($request->class == 'all') {
                $class='全部商品';
                $product = $product->get()->toArray();
                
                $data = array ("class" => $class, "product" => $product);
                
                
                return view('product',compact('data'));
            } else {
               
                $class = $request->class;
                $product = $product->whereHas('productClass', function (Builder $query) use ($request) {
                    $query->where('class', $request->class);
                })->get()->toArray();
                
                $data = array ("class" => $class, "product" => $product);
                
                
                return view('product',compact('data'));
            }
        } elseif (!is_null($request->product_id)) {
            $product =  $product->where('product_id', $request->product_id)->get();
            return view('productOne', $product);
        }
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        try {
            DB::transaction(function ()  use ($product_id) {
                $this->productService->delete($product_id);

                $this->productServiceClass->delete($product_id);
                $this->productServiceImage->deleteAll($product_id);
            });
            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {

            return response()->json(['error' => $e], 422);
        }
    }
    public function update(ProductPostRequest $request)
    {
        $input = $request->all();
        $oldImage = $this->productServiceImage->index($input['product_id']);
        try {
            DB::transaction(function ()  use ($input, $oldImage) {

                if (count($input['image']) > $oldImage->count()) { #新相片數量>原相片數量
                    $i = 0;
                    for ($i; $i < count($oldImage); $i++) {
                        $this->productServiceImage->update($input['product_id'], $input['image'][$i], $i + 1);
                    };

                    for ($i; $i < count($input['image']); $i++) {
                        $this->productServiceImage->add($input['product_id'], $input['image'][$i], $i + 1);
                    };
                } elseif (count($input['image']) < $oldImage->count()) {
                    $i = 0;
                    for ($i; $i < count($input['image']); $i++) {
                        $this->productServiceImage->update($input['product_id'], $input['image'][$i], $i + 1);
                    };

                    for ($i; $i <  count($oldImage); $i++) {
                        $this->productServiceImage->deleteOne($input['product_id'], $i + 1);
                    };
                } else {
                    for ($i = 0; $i < count($input['image']); $i++) {
                        $this->productServiceImage->update($input['product_id'], $input['image'][$i], $i + 1);
                    };
                }
                $this->productService->update($input);
                $this->productServiceClass->update($input['product_id'], $input['class']);
                return response()->json([
                    'status' => 'success',
                ], 200);
            });
        } catch (Exception $e) {
            return response()->json(['error' => $e], 422);
        }
    }

    public function add(ProductPostRequest $request)
    {
        $input = $request;

        try {
            DB::transaction(function ()  use ($input) {
                $this->productService->add($input);
                $this->productServiceClass->add($input['product_id'], $input['class']);
                for ($i = 0; $i < count($input['image']); $i++) {
                    $this->productServiceImage->add($input['product_id'], $input['image'][$i], $i + 1);
                };

                return response()->json([
                    'status' => 'success',
                ], 200);
            });
        } catch (Exception $e) {
            return response()->json(['error' => $e], 422);
        }
    }
}
