<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class Inventory extends Component
{
    public $name, $description, $quantity, $price, $product_id, $date_stock;
    public $updateM = false;
    public $products;

    private function resetInputFields(){
        $this->name = '';
        $this->description = '';
        $this->quantity = '';
        $this->price = '';
    }

    public function store(){
        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        Product::create($validatedData);
        $this->resetInputFields();
    }

    public function update(){

        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);
        
        if ($this->product_id) {
            $product = Product::find($this->product_id);
            $product->update([
                'name' => $this->name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'price' => $this->price,
            ]);
            $this->updateM = false;
            $this->resetInputFields();
        }
    }
    public function edit($id){

        $this->updateM = true;
        $product = Product::where('id',$id)->first();
        $this->product_id = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->quantity = $product->quantity;
        $this->price = $product->price;

    }
    public function delete($id){
        if($id){
            Product::where('id',$id)->delete();
        }
    }


    public function render()
    {
        $this->products = Product::all();
        // dd($this->products);
        return view('livewire.inventory');
    }
}
