<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class ManageCategories extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $currentUrl;

    public function setSortBy($sorColumn)
    {
        if($this->sortBy == $sorColumn) {
            $this->sortDir = $this->sortDir == 'ASC' ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sorColumn;
        $this->sortDir = 'ASC';
    }

    public function render()
    {
        $current_url = url()->current();
        $explode_url = explode('/', $current_url);

        $this->currentUrl = $explode_url[3];

        return view('livewire.manage-categories', [
            'categories' => Category::search($this->search)
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage)
        ])->layout('admin-layout');
    }
}
