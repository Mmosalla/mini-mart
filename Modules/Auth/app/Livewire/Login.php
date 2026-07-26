<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;
    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];

    public function login(): \Illuminate\Http\RedirectResponse
    {
        $this->validate();
        if (!Auth::attempt([
            'name' => $this->username,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'username' => 'نام کاربری یا رمز عبور اشتباه است.',
            ]);
        }
        session()->regenerate();
        $this->redirect(route('admin.dashboard'));
    }
    #[Layout('auth::components.layouts.master'), Title('ورود')]
    public function render(): View
    {
        return view('auth::livewire.login');
    }
}
