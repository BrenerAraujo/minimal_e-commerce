<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $currentUrl;
    public $product_details;
    public $product_name = '';
    public $product_price = '';
    public $photo = '';
    public string $product_description = '';
    public $category_id;
    public $all_categories;

    public function mount($id)
    {
        $this->product_details = Product::find($id);
        $this->product_name = $this->product_details->name;
        $this->product_price = $this->product_details->price;
        $this->product_description = $this->product_details->description;
        $this->category_id = $this->product_details->category_id;
        $this->photo = $this->product_details->image;
        $this->all_categories = Category::all();
    }

    public function update()
    {
        $this->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        if($this->photo && !is_string($this->photo)){
            $photoPath = $this->photo->store('photos', 'public');
        } else {
            $photoPath = $this->photo;
        }

        $this->product_details->update([
            'name' => $this->product_name,
            'price' => $this->product_price,
            'description' => $this->product_description,
            'category_id' => $this->category_id,
            'image' => $photoPath,
        ]);

        return $this->redirect('/products', navigate: true);
    }

    public function render()
    {
//        $current_url = url()->current();
//        $explode_url = explode('/', $current_url);
//
//        $this->currentUrl = $explode_url[3].' '.$explode_url[5];

        return view('livewire.edit-product')->layout('admin-layout');
    }
}
