@extends('layouts.shop')
@section('content')

<div id="cart">
    <b-container fluid="sm">
        <h3>
            <strong>購物車內容</strong>
        </h3>
        
        <table v-if="cartAmountSum > 0 " class="table align-middle">

            <thead class="table-dark">
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">價錢</th>
                    <th scope="col">數量</th>
                </tr>
            </thead>
            
            <tbody >
                <b-form >
                    
                    <tr v-for="i in cartItems" :key="i.product_id">
                        <th scope="row">
                            <b-button type="button" variant="danger" @click="deleteCart(i.product_id)">x</b-button>
                        </th>
                        <th scope="row">
                            <b-img height="100px" width="100px" :src="i.product.product_image[0].path"></b-img>
                        </th>
                        <td>@{{i.product.name}}<span v-if="i.product.product_class.class">-@{{i.product.product_class.class}}</span></td>
                        <td>@{{i.product.price}}</td>
                        <td>



                            <b-form-input type="number" id="input-amount" v-model="i.number" min=0 :max="i.product.amount" value="i.number" required @change="updateCart(i)"></b-form-input>


                        </td>



                    </tr>
                </b-form>

            </tbody>
            
        </table>
        <p v-else>購物車沒有商品哦</p>
        <hr>
        <div align="right" >
        <p><strong>小計@{{carttotalPrice}}</strong></p>
        
    </b-container>
</div>


@endsection