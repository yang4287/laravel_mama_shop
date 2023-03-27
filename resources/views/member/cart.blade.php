@extends('layouts.shop')
@section('content')

<div id="cart">
    <b-container fluid="sm">
        <h3>
            <strong>購物車內容</strong>
        </h3>
        <div v-if="cartAmountSum > 0 ">
            <table class="table align-middle">

                <thead class="table-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">商品名稱</th>
                        <th scope="col">價錢</th>
                        <th scope="col">數量</th>
                    </tr>
                </thead>

                <tbody>
                    <b-form>

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



        </div>

        <p v-else>購物車沒有商品哦</p>
        <label>提醒: 本店家所有商品皆冷凍宅配:17顆以下，運費160，超過17顆，運費225!!</label>
        <hr>
        <div align="right">
            <p v-if="cartAmountSum > 0"><strong>運費@{{shipPrice}}</strong></p>
            <p><strong>小計@{{carttotalPrice}}</strong></p>
            <p><strong>總計@{{totalPrice}}</strong></p>

        </div>
        <div v-if="cartAmountSum > 0">
            <h3>
                <strong>填寫訂購資訊</strong>
            </h3>
            <div>

                <b-form method="POST" action="/order">
                    @csrf

                    <b-form-group class="py-2" id="input-group-1" label="收貨人姓名" label-for="input-1">
                        <b-form-input id="input-1" name="consignee_name" placeholder="收貨人姓名" required></b-form-input>
                    </b-form-group>
                    <b-form-group class="py-2" id="input-group-2" label="收貨人聯絡電話" label-for="input-2">
                        <b-form-input id="input-2" name="consignee_phone" type="tel" pattern="^(09)\d{8}$" placeholder="收貨人聯絡電話" required></b-form-input>
                    </b-form-group>
                    <b-form-group class="py-2" id="input-group-3" label="收貨人地址" label-for="input-3">
                        <b-form-input id="input-3" name="consignee_address" placeholder="收貨人地址" required></b-form-input>

                    </b-form-group>
                    <b-form-group class="py-2" id="input-group-4" label="指定到貨日(無指定日期請空白)" label-for="input-4">
                        <b-form-input id="input-4" name="except_date" placeholder="指定到貨日"></b-form-input>
                    </b-form-group>





                    <div align="center">
                        <b-button type="submit" variant="primary" size="lg">立即結帳</b-button>
                    </div>


                </b-form>

            </div>
        </div>
    </b-container>
</div>


@endsection