<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class SaleManagement extends Component
{

    public $search = '';
    public $products = [];
    public $lineItems = [];
    public $total = 0;
    public $net = 0;


    public $showCompleteSaleModal = false;
    public $cashGiven = 0;
    public $change = 0;

    public $discountCode = '';
    public $discountAmount = 0;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function calculateChange()
    {
        $this->change = $this->cashGiven - $this->total;
    }

    public function applyDiscount()
    {
     

        if ($this->discountCode == 'gago') {
            $this->discountAmount = 10;
            $this->total -= $this->discountAmount;
        }

        $this->discountCode = ''; 
    }

    public function completeSale()
    {
        $this->change = $this->cashGiven - $this->total;

        // Reset the discount amount
        $this->discountAmount = 0;
        $this->lineItems = [];
        $this->total = 0;
        $this->net = 0;
        $this->cashGiven = 0;
        $this->search = '';
        
        $this->showCompleteSaleModal = false;
    }
    public function addProduct($productId)
    {
        $productsCollection = collect($this->products);
        $product = $productsCollection->firstWhere('id', $productId);
    
        if ($product) {
    
            $key = array_search($productId, array_column($this->lineItems, 'product_id'));
    
            if ($key === false) {
            
                $this->lineItems[] = [
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1,
                ];
            } else {
            
                $this->lineItems[$key]['quantity'] += 1;
            }
    
            $this->total += $product['price'];
            $this->net += $product['price'];
        }
    }

    public function addQuantity($productId)
    {

        $key = array_search($productId, array_column($this->lineItems, 'product_id'));

        if ($key !== false) {
   
            $this->lineItems[$key]['quantity'] += 1;
            $this->total += $this->lineItems[$key]['price'];
            $this->net += $this->lineItems[$key]['price'];
        }
    }

    public function subtractQuantity($productId)
    {
   
        $key = array_search($productId, array_column($this->lineItems, 'product_id'));

        if ($key !== false && $this->lineItems[$key]['quantity'] > 1) {
    
            $this->lineItems[$key]['quantity'] -= 1;
            $this->total -= $this->lineItems[$key]['price'];
            $this->net -= $this->lineItems[$key]['price'];
        }
    }
    public function removeProduct($productId)
    {

        $key = array_search($productId, array_column($this->lineItems, 'product_id'));

        if ($key !== false) {
        
            $this->total -= $this->lineItems[$key]['price'] * $this->lineItems[$key]['quantity'];
            $this->net -= $this->lineItems[$key]['price'] * $this->lineItems[$key]['quantity'];

       
            unset($this->lineItems[$key]);

            $this->lineItems = array_values($this->lineItems);
        }
    }

    public function clearCart()
    {
        // Remove all items
        $this->lineItems = [];
        $this->total = 0;
        $this->discountAmount = 0;
        $this->net = 0;
    }

    public function render()
    {
        $searchResults = [];

        if (!empty($this->search)) {
            $searchResults = Product::where('name', 'like', '%' . $this->search . '%')->orWhere('id', 'like', '%' . $this->search . '%')->get();
            // ->where('id', 'like', '%' . $this->search . '%')->get();
           // $searchResults = Product::where('id', 'like', '%' . $this->search . '%')->get();
        }

        return view('livewire.sale-management', [
            'searchResults' => $searchResults,
        ]);
    }
}
