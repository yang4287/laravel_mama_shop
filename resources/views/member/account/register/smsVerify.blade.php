@extends('layouts.shop')
@section('title')
MaMa好閒
@endsection

@section('title_href')
<a class="navbar-brand" href="{{ url('/') }}">
    MaMa好閒
</a>
@endsection


@section('content')
<div id="smsVerify" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">註冊會員</div>

                <div class="card-body">
                    <b-form  @submit="verifySms" id="form1">
                        @csrf

                        <div class="row mb-3">

                            <label for="phone" class="col-md-4 col-form-label text-md-end">手機號碼</label>


                            <div v-if="!send_phone" class="col-md-6">
                                <input id="phone" type="tel" v-model="phone" pattern="^(09)\d{8}$" class="form-control" :class="isInvalid.phone" name="phone" required autocomplete autofocus>




                                <span v-if="isInvalid.phone" class="invalid-feedback" role="alert">
                                    <span v-for="e in errorMessage.phone">
                                        <strong>@{{ e }}</strong>
                                        <br>
                                    </span>
                                </span>

                            </div>
                            <div v-if="!send_phone" class="col-md-2">



                                <b-button type="button" variant="secondary" @click="sendSms(phone)">
                                    發送驗證碼
                                </b-button>

                            </div>

                            <div v-else class="col-md-6">
                                @{{phone}}
                            </div>
                            <div v-else class="col-md-2">




                                <b-button disabled type="button" variant="secondary">
                                    已發送驗證碼
                                </b-button>

                            </div>



                        </div>

                        <div v-if="send_phone" class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">驗證碼</label>

                            <div class="col-md-6">
                                <input id="code" type="text" length="4" v-model="code" class="form-control" :class="isInvalid.code"  name="code" required autocomplete autofocus>



                                <span v-if="isInvalid.code" class="invalid-feedback" role="alert">
                                    <span v-for="e in errorMessage.code">
                                        <strong>@{{ e }}</strong>
                                        <br>
                                    </span>
                                </span>


                            </div>
                        </div>









                        <div class="row mb-0">

                            <div v-if="code" class="col col-md-6 offset-md-4">
                                <button type="submit"  form="form1" class="btn btn-primary">
                                    下一步
                                </button>


                            </div>

                            <div v-else class="col col-md-6 offset-md-4">
                                <button disabled type="button" class="btn btn-primary">
                                    下一步
                                </button>


                            </div>

                            <div class="col col-md-3 offset-md-4">
                                <a href="/member/login">已有會員</a>

                            </div>
                            <div class="col col-md-3 offset-md-4">

                                <a href="/member/forget">忘記密碼</a>
                            </div>
                        </div>

                    </b-form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const register_post = {
        created() {

        },

        data() {
            return {


                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                phone: null,
                send_phone: null,
                code: null,
                errorMessage: null,
                isInvalid: {


                    phone: null,
                    code:null

                }


            }
        },



        methods: {





            sendSms(p) {

                this.axios.post('/api/sendSms', {
                        phone: p
                    }).then(response => {
                        console.log(response)



                        this.$bvModal.msgBoxOk(response.data.message, {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })

                        this.errorMessage = null

                        this.send_phone = p





                    })
                    .catch(error => {
                        this.$bvModal.msgBoxOk('驗證碼取得失敗，' + error.response.data.message, {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })
                        this.errorMessage = error.response.data.errors;
                        if (this.errorMessage) {
                            if (this.errorMessage.phone) {
                                this.isInvalid.phone = 'is-invalid'
                            }
                        }
                    })
            },

            verifySms(event) {
                event.preventDefault()
                this.axios.post('/auth/verifySms', {
                        code: this.code,phone:this.send_phone
                    }).then(response => {
                        console.log(response)



                        window.location.href='/member/register/step2';

                        




                    })
                    .catch(error => {
                        this.$bvModal.msgBoxOk(error.response.data.message, {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })
                        this.errorMessage = error.response.data.errors;
                        if (this.errorMessage) {
                            if (this.errorMessage.code) {
                                this.isInvalid.code = 'is-invalid'
                            }
                        }
                    })
            },


        }
    }
    const register = new Vue(register_post)
    register.$mount('#smsVerify')
</script>
@endsection