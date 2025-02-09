<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
    @if(count($products) > 0)
        @foreach($products as $product)
            <livewire:item-card :product_details="$product" wire:key="{{ $product->id }}"/>
        @endforeach
    @else
        <h2 class="text-2xl text-gray-300">No Product Available</h2>
    @endif
</div>
