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
<div id="register" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">註冊會員</div>

                <div class="card-body">
                    <b-form @submit="registerSubmit" id="form1">
                        @csrf

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">手機號碼</label>

                            
                            <div class="col-md-6">
                                {{cache()->get('checked_phone')}}
                            </div>


                           
                        </div>
                        
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">姓名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" v-model="name" class="form-control " :class="isInvalid.name" name="name" value="name" required autocomplete autofocus>




                                <span v-if="isInvalid.name" class="invalid-feedback" role="alert">
                                    <span v-for="e in errorMessage.name">
                                        <strong>@{{ e }}</strong>
                                        <br>
                                    </span>
                                </span>

                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">密碼</label>

                            <div class="col-md-6">
                                <input id="password" type="password" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" v-model="password" class="form-control" :class="isInvalid.password" name="password" required autocomplete="current-password">

                                


                                <span v-if="isInvalid.password" class="invalid-feedback" role="alert">
                                    <span v-for="e in errorMessage.password">
                                        <strong>@{{ e }}</strong>
                                        <br>
                                    </span>
                                </span>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">再次輸入密碼</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" v-model="password_confirmation" class="form-control" :class="isInvalid.password_confirmation" name="password_confirmation" required>




                                <span v-if="isInvalid.password_confirmation" class="invalid-feedback" role="alert">
                                    <span v-for="e in errorMessage.password_confirmation">
                                        <strong>@{{ e }}</strong>
                                        <br>
                                    </span>
                                </span>

                            </div>
                        </div>




                        <div class="row mb-0">
                            <div v-if="name && password && password_confirmation" class="col col-md-6 offset-md-4">
                                <button type="submit" form="form1" class="btn btn-primary">
                                    註冊
                                </button>


                            </div>
                            <div v-else class="col col-md-6 offset-md-4">
                                <button disabled type="button" class="btn btn-primary">
                                    註冊
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
                
                   
                password: null,
                password_confirmation: null,
                name:null,
                   
                
                
                errorMessage: null,
                isInvalid: {
                   
                    
                    password: null,
                    password_confirmation: null,
                    name:null,
                }


            }
        },



        methods: {





            

            registerSubmit(event) {
                event.preventDefault();
                this.axios.post('/member/auth/register', { password: this.password,
                password_confirmation: this.password_confirmation,
                name:this.name})
                    .then(response => {
                        

                        this.$bvModal.msgBoxOk('註冊成功', {
                            title: '訊息',
                            size: 'sm',
                            buttonSize: 'sm',
                            okVariant: 'success',
                            okTitleHtml:'<span><a style="color:white;text-decoration:none" href="/member/login">返回登入頁</a></span>',
                           
                            headerClass: 'p-2 border-bottom-0',
                            footerClass: 'p-2 border-top-0',
                            centered: true
                        })
                        this.errorMessage = null
                        this.isInvalid.name = null
                     
                        this.isInvalid.password = null
                        this.isInvalid.password_confirmation = null
                     
                    })
                  
                    .catch(error => {
                        
                        this.errorMessage = error.response.data.errors
                        if (this.errorMessage) {


                            if (this.errorMessage.name) {
                                this.isInvalid.name = 'is-invalid'
                            } else {
                                this.isInvalid.name = null
                            }

                            if (this.errorMessage.password) {
                                this.isInvalid.password = 'is-invalid'
                            } else {
                                this.isInvalid.password = null
                            }

                            if (this.errorMessage.password_confirmation) {
                                this.isInvalid.password_confirmation = 'is-invalid'
                            } else {
                                this.isInvalid.password_confirmation = null
                            }

                        }


                    })
                   
            },

        }
    }
    const register = new Vue(register_post)
    register.$mount('#register')
</script>
@endsection