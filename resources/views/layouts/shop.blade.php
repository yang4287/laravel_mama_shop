<!doctype html>
<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MaMa好閒</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
   
 


    <!-- Styles -->
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">
</head>

<body>


    <div id="shop">
        <div style="width: 100%;height:180px"></div>

        <div class="logo_head">


            <div>

                <b-nav style="display: flex;padding-left: 0;margin-right: 5%;list-style: none;flex-direction: row;flex-wrap: nowrap;justify-content: flex-end;color:black;text-decoration:none">


                    <b-nav-item href="/member/cart">
                        <b-icon scale="1.5" icon="cart4">

                        </b-icon>
                        @if(session()->has('name'))
                        <span class="badge rounded-pill bg-danger">@{{cartAmountSum}}</span>
                        @else
                        <span class="badge rounded-pill bg-danger">0</span>
                        @endif
                    </b-nav-item>



                    <b-nav-item-dropdown variant="link" toggle-class="text-decoration-none" no-caret>
                        <template #button-content>
                            <b-icon scale="1.5" icon='person-circle'></b-icon>
                        </template>
                        @if(session()->has('name'))

                        <b-dropdown-item href="/member/order">訂單查詢</b-dropdown-item>
                        <b-dropdown-item href="/member/profile">會員資訊</b-dropdown-item>
                        <b-dropdown-item href="/member/logout">登出</b-dropdown-item>
                        @else
                        <b-dropdown-item href="/member/login">登入</b-dropdown-item>
                        @endif
                    </b-nav-item-dropdown>









                </b-nav>
                <div style="text-align:center">
                    <a href="{{ url('/') }}" style="width:250px;height:auto">
                        <img src="/storage/image/logo.png" alt="Center image" style="width:200px;height:auto"></img>
                    </a>
                </div>
            </div>
            <div id="nav-select">
                <b-nav align="center">
                    <b-nav-item>關於我們</b-nav-item>
                    <b-nav-item-dropdown id="my-nav-dropdown" text="商品列表" toggle-class="nav-link-custom" right>
                        <b-dropdown-item href="/product/all"> 全部商品</b-dropdown-item>
                        <b-dropdown-item href="/product/一般款">一般款</b-dropdown-item>
                        <b-dropdown-item href="/product/刈包款">刈包款</b-dropdown-item>
                        <b-dropdown-item href="/product/甜甜圈款">甜甜圈款</b-dropdown-item>
                        <b-dropdown-item href="/product/其他">其他</b-dropdown-item>
                    </b-nav-item-dropdown>


                    <b-nav-item>訂購須知

                    </b-nav-item>


                </b-nav>


            </div>

        </div>
        <div>

            @yield('banner')

        </div>
        <div class="py-4">



            @yield('content')
        </div>

    </div>


</body>

</html>
@if(session()->has('name'))
<script type="application/javascript">
    var shop = {

        created() {


            this.cartData();
        },

        data() {
            return {


                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),


                cartAmountSum: 0,
                totalPrice: 0,
                carttotalPrice: 0,
                cartItems: null,
                shipPrice: 0,
                orderInfo: {
                    consignee_name:'',
                    consignee_phone:null,
                    consignee_address:'',
                    except_date:0

                }

            }
        },
        computed: {




        },
        mounted() {},
        methods: {

            cartData() {

                this.axios.get('/member/api/cart/list').then(response => {
                    console.log(response.data);
                    this.cartItems = response.data
                    this.cartAmountSum = 0
                    this.carttotalPrice = 0
                    this.totalPrice = 0
                    this.shipPrice = 0

                    for (let x = 0; x < this.cartItems.length; x++) {
                        this.cartAmountSum = this.cartItems[x].number + this.cartAmountSum
                        this.carttotalPrice = this.cartItems[x].product.price * this.cartItems[x].number + this.carttotalPrice

                    }
                    if (this.cartAmountSum <= 17 && this.cartAmountSum > 0) {
                        this.shipPrice = 160
                    } else if (this.cartAmountSum > 17) {
                        this.shipPrice = 225
                    }

                    this.totalPrice = this.carttotalPrice + this.shipPrice

                });


            },




            addCart(i) {



                this.axios.post('/member/api/cart/add', {
                        'product_id': i,
                        'number': 1
                    }).then(response => {
                        console.log(response.data);

                        // alert(response.data);


                        this.$bvModal.msgBoxOk('加入成功', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })


                        this.cartData();





                    })
                    .catch(error => {
                        this.$bvModal.msgBoxOk('加入失敗' + error.response.data.message, {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })
                    })




            },
            updateCart(i) {
                //document.forms["cartForm"].submit().preventDefault;
                if (i.number > i.product.amount) {

                    this.$bvModal.msgBoxOk('庫存不足，請少於' + i.product.amount, {
                        title: '訊息',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'success',
                        headerClass: 'p-2 border-bottom-0',
                        footerClass: 'p-2 border-top-0',
                        centered: true
                    })
                    this.cartData();
                    return
                }
                if (i.number <= 0) {

                    this.$bvModal.msgBoxConfirm('確定移除 " ' + i.product.name + ' " ?', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'danger',
                            okTitle: '確定',
                            cancelTitle: '取消',
                            footerClass: 'p-2',

                            centered: true
                        })
                        .then(value => {
                            if (value) {
                                this.deleteCart(i.product_id)
                                return
                            }

                        })
                    this.cartData();

                    return

                }


                this.axios.patch('/member/api/cart/update', {
                    'product_id': i.product_id,
                    'number': i.number
                }).then(response => {



                    this.cartData();





                })





            },

            deleteCart(product_id) {
                this.axios.delete('/member/api/cart/delete', {
                    'product_id': product_id,

                }).then(response => {



                    this.cartData();





                })
            },
            checkLogin() {

                this.$bvModal.msgBoxOk('請先登入!', {
                    title: '訊息',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'success',
                    okTitleHtml: '<span><a style="color:white;text-decoration:none" href="/member/login">登入</a></span>',
                    headerClass: 'p-2 border-bottom-0',
                    footerClass: 'p-2 border-top-0',
                    centered: true
                })


            },
           


        },
    }
</script>
@else
<script type="application/javascript">
    var shop = {
        data() {
            return {


                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),


                cartAmountSum: 0,
                cartItems: null,

            }
        },

        methods: {

            checkLogin() {

                this.$bvModal.msgBoxOk('請先登入!', {
                    title: '訊息',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'success',
                    okTitleHtml: '<span><a style="color:white;text-decoration:none" href="/member/login">登入</a></span>',
                    headerClass: 'p-2 border-bottom-0',
                    footerClass: 'p-2 border-top-0',
                    centered: true
                })

            },

        },
    }
</script>
@endif
<script type="application/javascript">
    const shopApp = new Vue(shop)
    shopApp.$mount('#shop')
</script>