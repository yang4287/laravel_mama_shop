<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Http\Services\ProductImageService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductPostRequest;
use App\Models\Account;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\ProductClass;

class OrderProductController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    protected $productService;
    protected $productServiceImage;


    // public function __construct(ProductService $productService, ProductImageService $productImageService)
    // {
    //     $this->productService = $productService;
    //     $this->productServiceImage = $productImageService;
    // }



    public function index() #所有商品資訊及相片
    {

       
    }


   
    
}
