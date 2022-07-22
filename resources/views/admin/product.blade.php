@extends('layouts.admin')
@section('content')


<div id="app">

    <input type="hidden" name="_token" :value="csrf">



    <!-- <div  style="z-index: 9999;background:#f7eded;position:absolute;top:50%;left:50%">
        <div class="text-center">
            <b-spinner variant="primary" label="Text Centered"></b-spinner>
        </div>
    </div> -->
    <div class="topList row my-3 ">


        <div class="col-xs-1 col-sm-2 col-md-3">

            <b-card id="soldOut" @click="sorting = -1, type = 'number' ,search = '',wellSellOut = -1 ,soldOut = 1" title="已售完" style="background-color:rgb(223 121 121 / 86%)">
                <b-card-text>
                    @{{soldOut_number}}
                </b-card-text>

            </b-card>
            <b-tooltip target="soldOut" title="點擊補貨"></b-tooltip>
        </div>
        <div class="col-xs-1   col-sm-2 col-md-3">
            <b-card id="wellSellOut" @click="sorting = -1, type = 'number' ,search = '',wellSellOut = 1 ,soldOut = -1" title="即將售完" style="background-color:rgb(223 168 121 / 86%) ">
                <b-card-text>
                    @{{wellSellOut_number}}

                </b-card-text>

            </b-card>
            <b-tooltip target="wellSellOut" title="點擊補貨"></b-tooltip>
        </div>
        <div class="col-xs-1  col-sm-2 col-md-3">
            <b-card id="allitems" @click="sorting = -1, type = 'id' ,search = '', wellSellOut = -1 ,soldOut = -1" title="商品數量" style="background-color:rgb(159 109 157  / 86%)">
                <b-card-text>
                    @{{items_number}}
                </b-card-text>

            </b-card>
            <b-tooltip target="allitems" title="點擊顯示全部商品"></b-tooltip>

        </div>
        <div class="col-xs-1 col-sm-2 col-md-3">
            <b-card @click="add()" title="新增商品" style="background-color:rgb(144 88 88 / 86%)">
                <b-card-text>
                    +
                </b-card-text>
            </b-card>

        </div>

        <b-modal id="add-modal" centered @hide="resetInfoModal" size="lg">
            <template #modal-header="{ close }">
                <h5>新增商品</h5>
                <b-button variant="light" size="sm" class="mb-2" @click="close()">
                    <b-icon icon="x-lg" aria-hidden="true"></b-icon>
                </b-button>



            </template>
            <b-row>
                <b-col v-show="infoModal.currentImageNumber >= 1 " sm="3" class="image_upload" v-for="(item, index) in infoModal.image">

                    <div class="uploader">
                        <input type="file" class="fonts" :name="index" @change="afterRead(index)" :ref="index" accept="image/*" :id="index" />
                    </div>
                    <b-icon scale="2" icon="dash-square-fill" id="delimage" aria-hidden="true" @click="delImage(index)"></b-icon>

                    <label :for="index" class="upload">
                        <div class="laber-up">


                            <b-img thumbnail fluid :src="item.path" alt="" srcset="" />
                            </b-img>
                        </div>
                    </label>
                </b-col>

                <!-- 新增相片 -->
                <b-col sm="3" v-show=" infoModal.currentImageNumber <= 7 ">
                    <div class="uploader">
                        <input type="file" class="fonts" :name="infoModal.currentImageNumber" @change="addImage(infoModal.currentImageNumber)" :ref="infoModal.currentImageNumber" accept="image/*" :id="infoModal.currentImageNumber" />
                    </div>


                    <label :for="infoModal.currentImageNumber" class="upload">
                        <div class="laber-up">


                            <div>
                                <b-img v-bind="mainProps" thumbnail fluid>
                                </b-img>
                                <b-icon style="position:absolute;z-index:2" scale="2" icon="plus-lg" name="plus" />
                                </b-icon>


                            </div>
                        </div>
                    </label>


                </b-col>

            </b-row>
            <b-form @submit="addSubmit" id="form1">
                <b-row class="my-5">
                    <b-col sm="2" class="my-2">
                        <label for="input-id">編號id:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" v-model='infoModal.id' id="input-id" placeholder="輸入商品編號" value="infoModal.id" ref="id" required></b-form-input>
                    </b-col>




                    <b-col sm="2" class="my-2">
                        <label for="input-name">名稱:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" v-model='infoModal.name' id="input-name" placeholder="輸入商品名稱" value="infoModal.name" required></b-form-input>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-class">分類:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" v-model="infoModal.class" id="input-class" placeholder="輸入商品分類" value="infoModal.class"></b-form-input>

                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-content">內容:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-textarea id="input-content" v-model="infoModal.content" max-rows="6" placeholder="輸入商品描述" value="infoModal.content"></b-form-textarea>
                    </b-col>
                    <b-col sm="2" class="my-2 ">
                        <label for="input-price">價錢:</label>

                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="number" min=1 id="input-price" v-model="infoModal.price" placeholder="輸入商品售價" value="infoModal.price" required></b-form-input>

                    </b-col>

                    <b-col sm="2" class="my-2">
                        <label for="input-number">剩餘數量:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">

                        <b-form-input type="number" id="input-number" min=0 v-model="infoModal.number" placeholder="輸入商品剩餘數量" value="infoModal.number" required></b-form-input>


                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-status">商品狀態:</label>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="S">上架</b-form-radio>


                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="D">下架</b-form-radio>

                        </b-form-group>

                    </b-col>



                </b-row>

                <!-- <b-row>

                    <b-col class="image_upload" v-for="(value, key) in infoModal.image" :key="key">
                        <div class="uploader">

                            <input v-if="key == 'path1'" type="file" class="fonts" :name="key" @change="afterRead(key)" :ref="key" accept="image/*" :id="key" />
                            <input v-else type="file" class="fonts" :name="key" @change="afterRead(key)" :ref="key" accept="image/*" :id="key" />
                        </div>
                        <b-icon v-show="value" scale="2" icon="dash-square-fill" id="delimage" aria-hidden="true" @click="delImage(key)"></b-icon>
                        <label :for="key" class="upload">
                            <div class="laber-up">
                                <div v-show="value">
                                    <b-img thumbnail fluid :src="value" alt="" srcset="" />
                                    </b-img>
                                </div>
                                <div v-show="!value">
                                    <b-img v-bind="mainProps" thumbnail fluid>
                                    </b-img>
                                    <b-icon style="position:absolute;z-index:2" scale="2" icon="plus-lg" name="plus" />
                                    </b-icon>


                                </div>
                            </div>
                        </label>
                    </b-col>


                </b-row>


                <b-row class="my-5">
                    <b-col sm="2" class="my-2">
                        <label for="input-id">編號id:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" id="input-id" placeholder="輸入商品編號" :value="infoModal.id" ref="id" required></b-form-input>
                    </b-col>

                    <b-col sm="2" class="my-2">
                        <label for="input-name">名稱:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" id="input-name" placeholder="輸入商品名稱" :value="infoModal.name" ref="name" required></b-form-input>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-class">分類:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" id="input-class" placeholder="輸入商品分類" :value="infoModal.class" ref="class"></b-form-input>

                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-content">內容:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-textarea id="input-content" max-rows="6" placeholder="輸入商品描述" :value="infoModal.content" ref="content"></b-form-textarea>
                    </b-col>
                    <b-col sm="2" class="my-2 ">
                        <label for="input-price">價錢:</label>

                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="number" min=1 id="input-price" placeholder="輸入商品售價" :value="infoModal.price" ref="price" required></b-form-input>

                    </b-col>

                    <b-col sm="2" class="my-2">
                        <label for="input-number">剩餘數量:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">

                        <b-form-input type="number" id="input-number" min=0 max=2147483647 placeholder="輸入商品剩餘數量" :value="infoModal.number" ref="number" required></b-form-input>


                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-status">商品狀態:</label>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="S" required>上架</b-form-radio>
                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="D" required>下架</b-form-radio>
                        </b-form-group>
                    </b-col>



                </b-row> -->





            </b-form>
            <template #modal-footer="{ ok, cancel }">


                <b-button size="sm" variant="secondary" @click="cancel()">
                    取消
                </b-button>
                <b-button type="submit" size="sm" variant="success" form="form1">
                    確認
                </b-button>

            </template>

        </b-modal>
    </div>

    <div class="table__object">


        <div>

            <input v-model="search" placeholder="以名稱來搜尋">
        </div>




        <table>
            <b-card no-body class="my-2 px-2" id="table_th">
                <b-row class=" p-1">
                    <b-col class="col-1" @click="sorting *= -1, type = 'id'"><strong>商品編號&ensp;</strong><i class="fa" :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'id' ? 'displayIt' : '']"></i></b-col>
                    <b-col class="col-3" @click="sorting *= -1, type = 'name'"><strong>商品名稱&ensp;</strong><i class="fa" :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'name' ? 'displayIt' : '']"></i></b-col>
                    <b-col @click="sorting *= -1, type = 'class'"><strong>分類&ensp;</strong><i class="fa" :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'class' ? 'displayIt' : '']"></i>
                    </b-col>
                    <b-col @click="sorting *= -1, type = 'price'"><strong>價錢&ensp;</strong><i class="fa" :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'price' ? 'displayIt' : '']"></i>
                    </b-col>
                    <b-col @click="sorting *= -1, type = 'soldNumber'"><strong>售出數量&ensp;</strong><i class="fa" :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'soldNumber' ? 'displayIt' : '']"></i>
                    </b-col>
                    <b-col @click="sorting *= -1, type = 'number'"><strong>剩餘數量&ensp;</strong><i class="fa " :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'number' ? 'displayIt' : '']"></i>
                    </b-col>
                    <b-col @click="sorting *= -1, type = 'status'"><strong>狀態&ensp;</strong><i class="fa " :class="[sorting == -1 ? 'fa-circle-arrow-up' : 'fa-circle-arrow-down', type === 'status' ? 'displayIt' : '']"></i>
                    </b-col>
                    <b-col><strong>Actions</strong>
                    </b-col>

                </b-row>
            </b-card>

            <div class="list_product">

                <b-card class="p-2" v-for="i in sortItems" :key="i.id">


                    <b-row no-gutters>

                        <b-col class="col-1">
                            @{{ i.id }}

                        </b-col>
                        <b-col class="col-3">@{{ i.name }}</b-col>
                        <b-col>@{{ i.class }}</b-col>
                        <b-col>@{{ i.price }}</b-col>
                        <b-col>@{{ i.soldNumber }}</b-col>
                        <b-col>@{{ i.number }}</b-col>


                        <b-col v-if=" i.status == 'S' " style="color:green">上架中</b-col>
                        <b-col v-if=" i.status == 'D' " style="color:red">已下架</b-col>
                        <b-col>
                            <b-button @click="info(i)" variant="dark" size="sm">編輯</b-button>
                            <!-- <b-button variant="secondary" size="sm">下架</b-button> -->
                            <b-button @click="deleteAlert(i.id,i.name)" variant="danger" size="sm">刪除</b-button>

                        </b-col>
                    </b-row>
                </b-card>
            </div>

        </table>

        <div class="pager mt-5">
            <b-button variant="outline-dark" @click="previousPage" :class="{'inactive' : currentPage == 1}">previous</b-button>
            <strong>page @{{currentPage}} of @{{totalPage}} </strong>
            <b-button variant="outline-dark" @click="nextPage" :class="{'inactive' : currentPage == totalPage}">next</b-button>
        </div>

        <b-modal id="edit-modal" centered @hide="resetInfoModal" size="lg">
            <template #modal-header="{ close }">
                <h5>編輯商品</h5>
                <b-button variant="light" size="sm" class="mb-2" @click="close()">
                    <b-icon icon="x-lg" aria-hidden="true"></b-icon>
                </b-button>



            </template>

            <b-row>
                <b-col sm="3" class="image_upload" v-for="(item, index) in infoModal.image">

                    <div class="uploader">
                        <input type="file" class="fonts" :name="index" @change="afterRead(index)" :ref="index" accept="image/*" :id="index" />
                    </div>
                    <b-icon scale="2" icon="dash-square-fill" id="delimage" aria-hidden="true" @click="delImage(index)"></b-icon>

                    <label :for="index" class="upload">
                        <div class="laber-up">


                            <b-img thumbnail fluid :src="item.path" alt="" srcset="" />
                            </b-img>
                        </div>
                    </label>
                </b-col>

                <!-- 新增相片 -->
                <b-col sm="3" v-show=" infoModal.currentImageNumber <= 7 ">
                    <div class="uploader">
                        <input type="file" class="fonts" :name="infoModal.currentImageNumber" @change="addImage(infoModal.currentImageNumber)" :ref="infoModal.currentImageNumber" accept="image/*" :id="infoModal.currentImageNumber" />
                    </div>


                    <label :for="infoModal.currentImageNumber" class="upload">
                        <div class="laber-up">


                            <div>
                                <b-img v-bind="mainProps" thumbnail fluid>
                                </b-img>
                                <b-icon style="position:absolute;z-index:2" scale="2" icon="plus-lg" name="plus" />
                                </b-icon>


                            </div>
                        </div>
                    </label>


                </b-col>

            </b-row>
            <b-form @submit="onSubmit" id="form1">

                <b-row class="my-5">




                    <b-col sm="2" class="my-2">
                        <label for="input-name">名稱:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" v-model='infoModal.name' id="input-name" placeholder="輸入商品名稱" value="infoModal.name" required></b-form-input>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-class">分類:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="text" v-model="infoModal.class" id="input-class" placeholder="輸入商品分類" value="infoModal.class"></b-form-input>

                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-content">內容:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-textarea id="input-content" v-model="infoModal.content" max-rows="6" placeholder="輸入商品描述" value="infoModal.content"></b-form-textarea>
                    </b-col>
                    <b-col sm="2" class="my-2 ">
                        <label for="input-price">價錢:</label>

                    </b-col>
                    <b-col sm="10" class="my-2">
                        <b-form-input type="number" min=1 id="input-price" v-model="infoModal.price" placeholder="輸入商品售價" value="infoModal.price" required></b-form-input>

                    </b-col>

                    <b-col sm="2" class="my-2">
                        <label for="input-number">剩餘數量:</label>
                    </b-col>
                    <b-col sm="10" class="my-2">

                        <b-form-input type="number" id="input-number" min=0 v-model="infoModal.number" placeholder="輸入商品剩餘數量" value="infoModal.number" required></b-form-input>


                    </b-col>
                    <b-col sm="2" class="my-2">
                        <label for="input-status">商品狀態:</label>
                    </b-col>
                    <b-col sm="2" class="my-2">
                        <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="S">上架</b-form-radio>


                            <b-form-radio v-model="infoModal.status" :aria-describedby="ariaDescribedby" value="D">下架</b-form-radio>

                        </b-form-group>

                    </b-col>



                </b-row>





            </b-form>
            <template #modal-footer="{ ok, cancel }">

                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button size="sm" variant="secondary" @click="cancel()">
                    取消
                </b-button>
                <b-button type="submit" size="sm" variant="success" form="form1">
                    確認
                </b-button>

            </template>

        </b-modal>
    </div>

</div>


<script>
    const table_product = {
        created() {
            this.allData();
        },

        data() {
            return {


                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                mainProps: {
                    blank: true,
                    blankColor: '#ffffff00',
                    width: 300,
                    height: 300,
                    class: 'm1',

                },

                loading: true,

                search: '',
                sorting: -1,
                type: 'id',
                soldOut: -1,
                soldOut_number: null,

                wellSellOut: -1,
                wellSellOut_number: null,
                items: [],
                items_number: null,
                pageSize: 8,
                currentPage: 1,
                totalPage: 0,
                showUpto: 8,
                showFromto: 0,

                infoModal: {

                    id: null,
                    name: '',
                    class: '',
                    content: '',
                    price: null,


                    number: null,
                    status: '',
                    image: [],
                    currentImageNumber: 0


                }


            }
        },
        computed: {




            sortItems: function() {
                this.soldOut_number = this.items.filter(i => i.number == 0).length;
                this.wellSellOut_number = this.items.filter(i => i.number < 10 && i.number > 0).length;
                this.items_number = this.items.length;
                var focus = this.type;
                if (this.search == '') {
                    if (this.wellSellOut == 1) {
                        var sort = this.items.slice(0).sort((a, b) => a[focus] < b[focus] ? this.sorting : -this.sorting);
                        var wellSellOut_sort = sort.filter(i => i.number < 10 && i.number > 0);
                        var list = wellSellOut_sort.slice(this.showFromto, this.showUpto);
                        this.totalPage = Math.ceil(this.items.length / this.pageSize);
                        return list;

                    } else if (this.soldOut == 1) {

                        var sort = this.items.slice(0).sort((a, b) => a[focus] < b[focus] ? this.sorting : -this.sorting);
                        var soldOut_sort = sort.filter(i => i.number == 0);
                        var list = soldOut_sort.slice(this.showFromto, this.showUpto);
                        this.totalPage = Math.ceil(this.items.length / this.pageSize);
                        return list;

                    } else {
                        var sort = this.items.slice(0).sort((a, b) => a[focus] < b[focus] ? this.sorting : -this.sorting);
                        this.totalPage = Math.ceil(this.items.length / this.pageSize);
                        return sort.slice(this.showFromto, this.showUpto);
                    };
                }

                var sort = this.items.slice(0).sort((a, b) => a[focus] < b[focus] ? this.sorting : -this.sorting);
                var research = this.search.trim();



                var research_sort = sort.filter(i => i.name.indexOf(research) > -1);
                var list = research_sort.slice(this.showFromto, this.showUpto);
                this.totalPage = Math.ceil(list.length / this.pageSize);
                return list;


            }
        },
        methods: {


            onSubmit(event) {
                event.preventDefault()
                if (this.infoModal.image.length == 0) {
                    this.$bvModal.msgBoxOk('修改失敗，至少上傳一張相片', {
                        title: '訊息',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'success',
                        headerClass: 'p-2 border-bottom-0',
                        footerClass: 'p-2 border-top-0',
                        centered: true
                    })
                    return

                }





                console.log(this.infoModal);
                this.axios.post('/product/update', this.infoModal).then(response => {
                        console.log(response.data);
                        this.$bvModal.msgBoxOk('修改成功', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })
                        this.allData();



                    })
                    .catch(error => {
                        console.log(error.response);
                        this.$bvModal.msgBoxOk('修改失敗，' + error.response.data.message, {
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


            allData() {

                this.axios.get('/product').then(response => {
                    this.items = response.data;

                });


            },


            info(item) {
                this.infoModal.id = item.id
                this.infoModal.name = item.name
                this.infoModal.class = item.class
                this.infoModal.content = item.content
                this.infoModal.price = item.price
                this.infoModal.number = item.number
                this.infoModal.status = item.status
                this.infoModal.image = []
                if (item.product_image == null) {
                    this.infoModal.currentImageNumber = 0
                } else {
                    for (let x = 0; x < item.product_image.length; x++) {
                        this.infoModal.image.push({
                            path: item.product_image[x].path
                        })

                    }
                    this.infoModal.currentImageNumber = this.infoModal.image.length
                }






                this.$emit('bv::show::modal', 'edit-modal')
            },
            resetInfoModal() {
                this.infoModal.id = null
                this.infoModal.name = null
                this.infoModal.class = null
                this.infoModal.content = null
                this.infoModal.price = null
                this.infoModal.content = null
                this.infoModal.number = null
                this.infoModal.status = null
                this.infoModal.image = []
                this.infoModal.currentImageNumber = null

                // this.allData();
            },
            add() {


                this.$emit('bv::show::modal', 'add-modal')
            },
            deleteAlert(id, name) {


                this.$bvModal.msgBoxConfirm('確定刪除 " ' + name + ' " ?', {
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
                            this.deleteProduct(id)
                        }

                    })
                    .catch(err => {
                        // An error occurred
                    })


            },
            deleteProduct(i) {


                console.log(i);
                this.axios.post('/product/delete', 'id=' + i).then(response => {
                        console.log(response.data);

                        // alert(response.data);


                        this.$bvModal.msgBoxOk('刪除成功', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })


                        this.allData();





                    })
                    .catch(error => {
                        this.$bvModal.msgBoxOk('刪除失敗' + error.response.data.message, {
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
            addSubmit(event) {
                event.preventDefault()
                if (this.infoModal.image.length == 0) {
                    this.$bvModal.msgBoxOk('新增失敗，至少上傳一張相片', {
                        title: '訊息',
                        size: 'sm',
                        buttonSize: 'sm',
                        okVariant: 'success',
                        headerClass: 'p-2 border-bottom-0',
                        footerClass: 'p-2 border-top-0',
                        centered: true
                    })
                    return

                }

                console.log(this.infoModal);
                this.axios.post('/product/add', this.infoModal).then(response => {
                        console.log(response.data);

                        // alert(response.data);


                        this.$bvModal.msgBoxOk('新增成功', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })


                        this.allData();





                    })
                    .catch(error => {
                        this.$bvModal.msgBoxOk('新增失敗' + error.response.data.message, {
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
            nextPage: function() {
                if (this.currentPage != this.totalPage) {
                    this.showFromto = (this.currentPage * this.pageSize);
                    this.currentPage = this.currentPage + 1;
                    this.showUpto = (this.currentPage * this.pageSize);
                }
            },
            previousPage: function() {
                if (this.currentPage != 1) {
                    this.showFromto = ((this.currentPage - 2) * this.pageSize);
                    this.currentPage = this.currentPage - 1;
                    this.showUpto = (this.currentPage * this.pageSize);
                }
            },
            afterRead(index) {

                let that = this;


                let file = this.$refs[index][0].files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    console.log(that.infoModal.image);
                    that.infoModal.image[index].path = this.result; //顯示縮圖

                };

            },
            addImage(index) {

                let that = this;
                console.log(this.$refs);


                let file = this.$refs[index].files[0];

                //that.infoModal.image.push({path:file,})

                var reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = function(e) {

                    that.infoModal.image.push({
                        path: this.result
                    }); //顯示縮圖


                }
                this.infoModal.currentImageNumber += 1;
            },
            delImage(index) {

                this.infoModal.image.splice(index, 1)
                this.infoModal.currentImageNumber -= 1


            },
            // ok(){
            //     this.updateProduct();
            // }
        },
    }
    const app = new Vue(table_product)
    app.$mount('#app')
</script>
@endsection