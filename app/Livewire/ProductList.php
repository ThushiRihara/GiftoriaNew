<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
// use App\Models\Gift;

class ProductList extends Component
{
    public $categories;

    public function mount()
    {
        // Get all categories with gifts
        $this->categories = Category::with('gifts')->get();
    }

    public function render()
    {
        return view('livewire.product-list', [
            'categories' => $this->categories
        ]);
    }
}
