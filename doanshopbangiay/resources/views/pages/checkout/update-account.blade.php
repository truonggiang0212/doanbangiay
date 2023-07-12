@extends('welcome')
@section('content')
<section id="form"><!--form-->
    <div class="signup-form" style="position: absolute; margin-top: -195px;margin-left: 50px;"><!--sign up forsm-->
        <h2>Thông tin tài khoản</h2>
        <form action="{{URL::to('/update-account-save')}}" method="POST">
            {{ @csrf_field() }}
            @foreach ($user as $key => $user_cus )
            <p style="font-size: 20px;margin-bottom: 10px;">{{ $user_cus->customer_email }}</p>
            <input type="text" style="width: 300px" value="{{ $user_cus->customer_name }}" name="customer_name" placeholder="Họ & tên"/>
            {{-- <input type="email" value="" name="customer_email" placeholder="Email"/> --}}
            {{-- <input type="password" value="{{ $user_cus->customer_password }}" name="customer_password" placeholder="Password"/> --}}
            <input type="text" style="width: 300px" value="{{ $user_cus->customer_phone }}"  name="customer_phone" placeholder="Phone"/>
            <button type="submit" class="btn btn-default">Cập nhật tài khoản</button>
            @endforeach
        </form>
        <div style="margin-top: 10px">
            <a href="{{URL::to('/update-password')}}">
                <button type="submit" class="btn btn-default">Thay đổi mật khẩu</button>
            </a>
        </div>
    </div><!--/sign up form-->
</section><!--/form-->

@endsection
