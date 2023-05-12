<div class="mt-5">
    <div class="container">
        <!-- Search bar -->
        <input type="text" class="form-control" wire:model.debounce.100ms="search" placeholder="Search for products..." />
        <ul class="list-group mt-2">
            @foreach ($searchResults as $result)
                <li class="list-group-item list-group-item-action" wire:click="addProduct({{ $result->id }})">{{ $result->name }} - ${{ $result->price }}</li>
            @endforeach
        </ul>
    
        <!-- Selected items table -->
        <table class="table mt-2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lineItems as $index => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <!-- Add Quantity -->
                            @if ($item['quantity'] < $products->firstWhere('id', $item['product_id'])->quantity)
                                <button class="btn btn-success"
                                    wire:click="addQuantity({{ $item['product_id'] }})">+</button>
                            @else
                                <button class="btn btn-success" disabled>+</button>
                            @endif
                           {{ $item['quantity'] }}
                            <!-- Subtract Quantity -->
                            <button class="btn btn-warning" wire:click="subtractQuantity({{ $item['product_id'] }})"
                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                           
                            
                        </td>
                        <td>
                            {{ $item['price'] }}
                        </td>
                      
                        </td>
                      
                        <td><button class="btn btn-sm btn-primary"
                                wire:click="removeProduct({{ $item['product_id'] }})">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    

        <div class="mt-2">
            <input type="text" class="form-control" wire:model="discountCode" placeholder="Enter discount code" />
            <button class="btn btn-primary mt-2" wire:click="applyDiscount">Apply Discount</button>
        </div>
        <!-- Total -->
        <div class="mt-3">
            <h5>Net: ${{ $net }}</h5>   
            @if ($discountAmount > 0)
           
                <h5>Discount:  -${{ $discountAmount }}</h5>
            @endif
            <h2>Total: ${{ $total }}</h2>
            <button class="btn btn-primary" wire:click="$set('showCompleteSaleModal', true)">Complete Sale</button>
            <button class="btn btn-warning" wire:click="clearCart">Clear Cart</button>
        </div>

                <!-- Complete Sale Modal -->
        @if ($showCompleteSaleModal)
        <div class="modal d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Complete Sale</h5>
                        <button type="button" class="close" wire:click="$set('showCompleteSaleModal', false)">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" wire:model="cashGiven" wire:keyup="calculateChange" placeholder="Enter cash amount given by customer" />
                        <h5 class="mt-3 text-center">Change: ${{ number_format($change, 2) }}</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showCompleteSaleModal', false)">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="completeSale">Complete Sale</button>
                    </div>
                </div>
            </div>
        </div>
        @endif



    </div>
    
</div>
