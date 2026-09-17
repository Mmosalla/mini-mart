<?php

namespace Modules\Product\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
use Modules\Product\Enums\ProductEnum;
use Modules\Product\Models\Product;

class ProductList extends Component
{
    use WithFileUploads, WithPagination;
    public $create_mode = false;
    public $update_mode = false;

    public $form_mode = true;

    public $product_id;

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

    public $search;

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
        $this->form_mode = true;
        $this->dispatch('cancelCreateProduct');
    }

    public function CreateMode(): void
    {
        $this->create_mode = true;
        $this->form_mode = false;
    }

    #[Computed]
    public function Products()
    {
        return Product::query()
            ->with('categories')
            ->paginate(10);
    }

    public function EditProduct($id): void
    {
        $this->update_mode = true;
        $this->form_mode = false;
        $this->product_id = $id;
        $product = Product::query()->find($this->product_id);
        $this->name = $product->name;
        $this->categoryIds = $product->categories->pluck('id')->toArray();
        $this->image = $product->image;
        $this->short_description = $product->short_description;
        $this->price = $product->price;
        $this->discount = $product->discount;
        $this->brand = $product->brand;
    }

    public function cancelUpdateProduct()
    {
        $this->update_mode = false;
        $this->form_mode = true;
        $this->dispatch('UpdateProductCanceled');
    }

    public function UpdateProduct(): void
    {
        $this->validate(['name' => 'required|unique:products,name,'.$this->product_id]);
        $product = Product::query()->find($this->product_id);
        $image_name = $product->image;
        if ($this->image instanceof UploadedFile) {
            if ($product->image && Storage::disk('public')->exists('Images/Products/' . $product->image)) {
                Storage::disk('public')->delete('Images/Products/' . $product->image);
            }
            $image_name = $this->image->hashName();
            $this->image->storeAs('Images/Products', $image_name, 'public'
            );
        }
        $product->update([
            'name' => $this->name,
            'slug' => make_slug($this->name),
            'price' => $this->price,
            'discount' => $this->discount,
            'short_description' => $this->short_description,
            'image' => $this->image ? $image_name : $product->image,
            'brand' => $this->brand,
        ]);
        $this->update_mode = false;
        $this->form_mode = true;
        $product->categories()->sync($this->categoryIds);
        $this->reset('categoryIds' , 'name' , 'price' , 'discount' , 'short_description' , 'image' , 'brand' );
        $this->dispatch('productUpdated');
    }

    public function searchData(): void
    {
        $this->Products = Product::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->with('categories')
            ->paginate(10);
    }

    #[On('destroyProduct')]
    public function destroyRow($product_id): void
    {
        $product = Product::query()->findOrFail($product_id);
        if ($product->image && Storage::disk('public')->exists('Images/Products/' . $product->image)) {
            Storage::disk('public')->delete('Images/Products/' . $product->image);
        }
        $product->delete();
        $this->dispatch('productDeleted');
    }


    public function changeStatus($id, string $status): void
    {
        $product = Product::query()->findOrFail($id);
        $product->update([
            'status' => ProductEnum::from($status)->value,
        ]);
        $this->dispatch('statusChanged');
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
