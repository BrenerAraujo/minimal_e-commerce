<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddProductForm extends Component
{
    use WithFileUploads;

    public $currentUrl;
    public $product_name = '';
    public $product_price = '';
    public $photo = '';
    public string $product_description = '';
    public $category_id;
    public $all_categories;

    public function mount()
    {
        $this->all_categories = Category::all();
    }

    public function save()
    {
        $this->validate([
            'product_name' => 'required',
            'product_price' => 'required|numeric',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'product_description' => 'required',
            'category_id' => 'required',
        ]);

        $path = $this->photo->store('public/photos');

        $product = new Product();
        $product->name = $this->product_name;
        $product->price = $this->product_price;
        $product->image = $path;
        $product->description = $this->product_description;
        $product->category_id = $this->category_id;
        $product->save();

        return $this->redirect('/products', navigate: true);
    }

    public function render()
    {
        $current_url = url()->current();
        $explode_url = explode('/', $current_url);

        $this->currentUrl = $explode_url[3].' '.$explode_url[4];

        return view('livewire.add-product-form')->layout('admin-layout');
    }
}
