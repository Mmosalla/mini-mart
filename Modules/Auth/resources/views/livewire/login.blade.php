<div class="form-wrapper">

    <!-- logo -->
    <div class="logo">
        <img src={{url("panel/assets/media/image/logo-sm.png")}} alt="image">
    </div>
    <!-- ./ logo -->

    <h5>ورود</h5>

    <!-- form -->
    <form>
        <div class="form-group">
            <input type="text" wire:model="username" class="form-control text-left" placeholder="نام کاربری" dir="ltr"  autofocus>
            @error('username')
            <span class="alert alert-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" wire:model="password" class="form-control text-left" placeholder="رمز عبور" dir="ltr" >
            @error('password')
            <span class="alert alert-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group d-sm-flex justify-content-between text-left mb-4">
            <a class="d-block mt-2 mt-sm-0 line-height-28" href="{{route('reset_password')}}">بازنشانی رمز عبور</a>
        </div>
        <buttonn wire:click.prevent="login" class="btn btn-primary btn-block">ورود</buttonn>
        <hr>
        <p class="text-muted">حسابی ندارید؟</p>
        <a href="{{route('register')}}" class="btn btn-outline-light btn-sm">هم اکنون ثبت نام کنید!</a>
    </form>
    <!-- ./ form -->

</div>
