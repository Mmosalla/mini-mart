<?php

namespace Modules\Category\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\Category\Enums\CategoryStatus;
use Modules\Category\Models\Category;

class CategoryList extends Component
{
    use WithPagination, WithFileUploads;

    #[Validate('required|unique:categories,name')]
    public $name;
    public $parent_category;
    public $editIndex = null;

    public $search;




    #[Computed]
    public function Categories()
    {
        return Category::query()
            ->with(['parentCategory'])
            ->paginate(10);
    }

    public function creatCategory(): void
    {
        $this->validate();
        Category::query()->create([
            'name' => $this->name,
            'parent_id' => $this->parent_category,
            'slug' => make_slug($this->name),
        ]);
        $this->dispatch('CategoryCreated');
        $this->reset('name', 'parent_category', 'editIndex');
    }

    public function editCategory($id)
    {
        $this->editIndex = $id ;
        $category = Category::query()->findOrFail($id);
        $this->name = $category->name;
        $this->parent_category = $category->parent_id;
    }

    public function cancelEdit()
    {
        $this->editIndex = null;
        $this->reset('name', 'parent_category', 'editIndex');
        $this->dispatch('CategoryCanceled');

    }

    public function UpdateCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories,name,'.$this->editIndex,
        ]);
        Category::query()->findOrFail($this->editIndex)->update([
            'name' => $this->name,
            'parent_id' => $this->parent_category,
            'slug' => make_slug($this->name),
        ]);
        $this->dispatch('CategoryUpdated');
        $this->reset('name', 'parent_category', 'editIndex');
    }

    public function searchData(): void
    {
        $this->Categories = Category::query()
            ->with('parentCategory')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function changeToInActive($id): void
    {
        $category = Category::query()->findOrFail($id);
        $category->update([
            'status' => CategoryStatus::Inactive->value,
        ]);
        $this->dispatch('CategoryStatusChanged');
    }
    public function changeToActive($id): void
    {
        $category = Category::query()->findOrFail($id);
        $category->update([
            'status' => CategoryStatus::Active->value,
        ]);
        $this->dispatch('CategoryStatusChanged');
    }

    #[On('destroy-category')]
    public function destroycategory($category_id): void
    {
        Category::destroy($category_id);
    }

    #[Layout('dashboard::components.layouts.master'), Title('دسته بندی ها')]
    public function render(): view
    {
        $parent_categories = Category::query()
            ->where('parent_id', null)
            ->pluck('name', 'id');
        return view('category::livewire.category-list', compact('parent_categories'));
    }
}
