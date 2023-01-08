@extends('layouts.shop')
@section('content')

<div>
    <b-container fluid="sm">


        <h3>{{$data['class']}}</h3>


        <div class="row">
            @foreach($data['product'] as $product)
            <div class="col-md-3 my-3 col-6">
                <b-card class=" border-0 text-center">
                    <b-card-img src="{{$product['product_image'][0]['path']}}" alt="Image" top style="border-radius:0%;"></b-card-img>
                    <hr>

                    <b-card-title>{{$product['name']}}</b-card-title>
                    <b-card-text style="color:rgb(181 143 134);font-size:1.2rem;font-weight:400">
                        NT${{$product['price']}}
                    </b-card-text>
                    @if(session()->has('name'))
                    <b-button lg="4" variant="outline-dark" @click="addCart({{$product['product_id']}})">
                        <b-icon scale="1" icon="cart-plus"></b-icon>
                    </b-button>
                    @else
                    <b-button lg="4" variant="outline-dark" @click="checkLogin()">
                        <b-icon scale="1" icon="cart-plus">

                        </b-icon>
                    </b-button> @endif
                </b-card>
            </div>
            @endforeach
        </div>
</div>



@endsection