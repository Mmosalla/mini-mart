<?php

namespace Modules\Dashboard\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Panel extends Component
{
    #[Layout('dashboard::components.layouts.master')]
    public function render(): view
    {
        return view('dashboard::livewire.panel');
    }
}
