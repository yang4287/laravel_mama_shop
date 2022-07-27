@include('admin.head')
@include('admin.sidebar')


<div class="right_container">
    <div class="head ">
        <div>Hi，{{session('account')}} </div>
        <div class="mx-2"><a href="/admin/logout" class="waves-effect waves-primary"><span> 登出 </span></a></div>
        
        
         
    </div>

    <div class="content">
        @yield('content')

    </div>

</div>