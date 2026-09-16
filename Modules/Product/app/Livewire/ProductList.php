<?php

namespace Modules\Product\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\Category\Enums\CategoryStatus;
use Modules\Category\Models\Category;
use Modules\Product\Enums\ProductEnum;
use Modules\Product\Models\Product;

class ProductList extends Component
{
    use WithFileUploads, WithPagination;
    public $create_mode = false;
    public $update_mode = false;

    #[Validate('required|unique:products,name')]
    public $name;
    #[Validate('nullable')]
    public $categoryIds = [];
    #[Validate('required')]
    public $price;
    #[Validate('nullable|min:0|max:100')]
    public $discount;
    #[Validate('nullable')]
    public $short_description;
    #[Validate('nullable')]
    public $image;
    #[Validate('nullable')]
    public $brand;

    public function CreateProduct(): void
    {
        $this->validate();
        $image_name = $this->image->hashName();
        $this->image->storeAs('Images/Products', $image_name , 'public');

       $product =  Product::query()->
        create([
            'name' => $this->name,
            'slug' => make_slug($this->name),
            'price' => $this->price,
            'discount' => $this->discount,
            'short_description' => $this->short_description,
            'image' => $image_name,
            'brand' => $this->brand,
        ]);
        $product->categories()->sync($this->categoryIds);
        $this->create_mode = false;
        $this->reset('categoryIds' , 'name' , 'price' , 'discount' , 'short_description' , 'image' , 'brand' );
        $this->dispatch('productCreated');

    }

    public function cancelCreateProduct(): void
    {
        $this->create_mode = false;
        $this->dispatch('productCreated');
    }

    public function CreateMode(): void
    {
        $this->create_mode = true;
    }


    #[Layout('dashboard::components.layouts.master'), Title('مدیریت محصولات')]
    public function render(): view
    {
        $categories = Category::query()
            ->where('parent_id', '!=', 0)
            ->where('status', CategoryStatus::Active->value)
            ->pluck('name', 'id');
        return view('product::livewire.product-list', compact('categories'));
    }
}
