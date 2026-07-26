<div class="form-wrapper">

    <div class="logo">
        <img src="{{ url('panel/assets/media/image/logo-sm.png') }}" alt="image">
    </div>


    <h5>ایجاد حساب</h5>


    @if($step == 1)

        <form>

            <div class="form-group">

                <input
                    type="text"
                    name="username"
                    wire:model="username"
                    class="form-control"
                    placeholder="نام کاربری"
                    autofocus
                >

                @error('username')
                <span class="alert alert-danger">
                    {{ $message }}
                </span>
                @enderror

            </div>


            <div class="form-group">

                <input
                    type="text"
                    name="mobile"
                    wire:model="mobile"
                    class="form-control text-left"
                    placeholder="موبایل"
                    dir="ltr"
                >

                @error('mobile')
                <span class="alert alert-danger">
                    {{ $message }}
                </span>
                @enderror

            </div>


            <div class="form-group">

                <input
                    type="password"
                    name="password"
                    wire:model="password"
                    class="form-control text-left"
                    placeholder="رمز عبور"
                    dir="ltr"
                >

                @error('password')
                <span class="alert alert-danger">
                    {{ $message }}
                </span>
                @enderror

            </div>

            <button
                wire:click.prevent="sendOtpCode"
                wire:loading.attr="disabled"
                class="btn btn-primary btn-block"
            >
                <span wire:loading.remove>
                    ارسال کد تایید
                </span>

                <span wire:loading>
                    در حال ارسال...
                </span>
            </button>

            <hr>

            <p class="text-muted">
                حساب کاربری دارید؟
            </p>

            <a href="login.html" class="btn btn-outline-light btn-sm">
                وارد شوید!
            </a>
        </form>

    @endif
    @if($step == 2)
        <form>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">
                    موبایل
                </label>
                <div class="col-sm-10">
                    <input
                        class="form-control"
                        value="{{ $mobile }}"
                        type="text"
                        readonly
                    >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">
                    کد تایید
                </label>
                <div class="col-sm-10">
                    <input
                        type="text"
                        wire:model="code"
                        class="form-control text-left"
                        placeholder="کد تایید"
                        dir="ltr"
                    >
                    @error('code')
                    <span class="alert alert-danger">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <button wire:click.prevent="CreatUser" wire:loading.attr="disabled" class="btn btn-primary btn-block">
                تایید
            </button>

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


        </form>

    @endif
    <!-- ./ مرحله دوم -->


</div>
