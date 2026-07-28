<?php

namespace Modules\User\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\User\Enums\UserStatusEnums;
use Modules\User\Models\User;

class UserList extends Component
{
    use WithPagination;
    public $search = '';
    #[Computed]
    public function users()
    {
        return User::query()->paginate(10);
    }

    public function chengToInactive($user_id): void
    {
        $user = User::query()->findOrFail($user_id);
        $user->update([
        'status' => UserStatusEnums::INACTIVE->value
        ]);
        $this->dispatch('status_chengToInactive');
    }
    public function chengToActive($user_id): void
    {
        $user = User::query()->findOrFail($user_id);
        $user->update([
            'status' => UserStatusEnums::ACTIVE->value
        ]);
        $this->dispatch('status_chengToActive');
    }
    public function searchData(): void
    {
        $this->users = User::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('mobile', 'like', '%'.$this->search.'%')
            ->paginate(10);
    }
    #[Layout('dashboard::components.layouts.master'), Title('کاربران')]
    public function render(): View
    {
        return view('user::livewire.user-list');
    }
}
