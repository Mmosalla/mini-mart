<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Auth\Jobs\SendOtpJob;
use Modules\Auth\Models\Otp;
use Modules\Auth\Services\OtpService;
use Modules\User\Models\User;

class Register extends Component
{
    public $username;
    public $mobile;
    public $password;
    public $code;
    public $canResend = false;
    public $resendSeconds = 120;
    public $step = 1;

    public function sendOtpCode(OtpService $otpService): void
    {
        $this->validate([
            'mobile' => ['required', 'regex:/^09[0-9]{9}$/'],
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        $check = User::query()
            ->where('mobile', $this->mobile)
            ->exists();
        if ($check) {
            $this->dispatch('user_exist');
        } else {
            $code = $otpService->generate($this->mobile);
            SendOtpJob::dispatch(
                $this->mobile,
                $code
            );
            $this->step = 2;
            $this->canResend = false;
            $this->resendSeconds = 120;
        }
    }

    public function CreatUser()
    {
        $this->validate([
            'code' => [
                'required',
            ],
        ]);
        $otp = Otp::query()
            ->where('mobile', $this->mobile)
            ->where('otp', $this->code)
            ->where('expired_at', '>', now())
            ->first();
        if (!$otp) {
            $this->dispatch('wrong_code');
            return;
        }
        $user = User::query()->create([
            'mobile' => $this->mobile,
            'name' => $this->username,
            'password' => Hash::make($this->password),
            'mobile_verified_at' => now(),
        ]);
        $otp->delete();
        Auth::login($user);
        $this->redirect(route('admin.dashboard'));
    }

    public function resendOtp(OtpService $otpService): void
    {
        if (!$this->canResend) {
            $this->dispatch('wait_resend');
            return;
        }

        $lastOtp = Otp::query()
            ->where('mobile', $this->mobile)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at->gt(now()->subSeconds(120))) {
            $this->dispatch('wait_resend');
            return;
        }


        Otp::query()
            ->where('mobile', $this->mobile)
            ->update([
                'expired_at' => now(),
            ]);

        $code = $otpService->generate($this->mobile);
        SendOtpJob::dispatch(
            $this->mobile,
            $code
        );
        $this->canResend = false;
        $this->resendSeconds = 120;

    }

    public function decrementTimer(): void
    {

        if ($this->resendSeconds > 0) {
            $this->resendSeconds--;
        }
        if ($this->resendSeconds <= 0) {
            $this->canResend = true;
        }

    }


    #[Layout('auth::components.layouts.master'), Title('ثبت نام')]
    public function render(): view
    {
        return view('auth::livewire.register');
    }
}
