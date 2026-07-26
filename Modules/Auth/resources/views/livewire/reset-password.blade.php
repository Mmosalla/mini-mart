<div class="form-wrapper">

    <div class="logo">
        <img src={{url("panel/assets/media/image/logo-sm.png")}} alt="image">
    </div>
    <h5>بازنشانی رمز عبور</h5>
    @if($step ==1)
        <form>
            <div class="form-group">
                <input type="text" wire:model="mobile" class="form-control text-left" placeholder="موبایل" dir="ltr" autofocus>
                @error('mobile')
                <span class="alert alert-danger">{{$message}}</span>
                @enderror
            </div>
            <button wire:click.prevent="sendOtpCode" class="btn btn-primary btn-block">

                <span wire:loading.remove>
                    ارسال کد تایید
                </span>

                <span wire:loading>
                    در حال ارسال...
                </span>
            </button>
            <hr>
            <a href="{{route('register')}}" class="btn btn-sm btn-outline-light mr-1 my-1">هم اکنون ثبت نام کنید!</a>
            یا
            <a href="{{route('login')}}" class="btn btn-sm btn-outline-light ml-1 my-1">وارد شوید!</a>
        </form>
    @endif

@if($step == 2)
        <form>
            <div class="form-group">
                <input type="text" wire:model="code" class="form-control text-left" placeholder="کد" dir="ltr" autofocus>
                @error('code')
                <span class="alert alert-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" wire:model="password" class="form-control text-left" placeholder="رمزعبور" dir="ltr" >
                @error('password')
                <span class="alert alert-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" wire:model="password_confirmation" class="form-control text-left" placeholder="تکرار رمزعبور" dir="ltr" >
                @error('password_confirmation')
                <span class="alert alert-danger">{{$message}}</span>
                @enderror
            </div>
            <button wire:click.prevent="resetPassword" class="btn btn-primary btn-block">تغییر رمز عبور</button>
            <div wire:poll.1s="decrementTimer" class="text-center mt-3">
                @if($canResend)
                    <button wire:click.prevent="resendOtp" class="btn btn-outline-success btn-sm">
                        ارسال مجدد کد
                    </button>
                @else
                    <button disabled class="btn btn-outline-secondary btn-sm">
                        ارسال مجدد تا
                        {{ $resendSeconds }}
                        ثانیه دیگر
                    </button>
                @endif


            </div>
            <hr>
            <a href="{{route('register')}}" class="btn btn-sm btn-outline-light mr-1 my-1">هم اکنون ثبت نام کنید!</a>
            یا
            <a href="{{route('login')}}" class="btn btn-sm btn-outline-light ml-1 my-1">وارد شوید!</a>
        </form>
@endif

</div>
