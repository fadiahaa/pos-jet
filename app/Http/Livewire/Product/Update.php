<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Update extends Component
{
    public $productId;
    public $nama_produk;
    public $kode_produk;
    public $harga_produk;

    protected $rules = [
        'nama_produk' => 'required|min:6',
        'kode_produk' => 'required',
        'harga_produk' => 'required'
    ];

    protected $listeners = ['updateProduct'];

    public function updateProduct($product)
    {
        $this->productId=$product['id'];
        $this->nama_produk=$product['nama_produk'];
        $this->kode_produk=$product['kode_produk'];
        $this->harga_produk=$product['harga_produk'];
    }

    public function update()
    {
        $this->validate();
        if($this->productId){
            $product=Product::where('id', $this->productId)->first();
            $product->update([
                'nama_produk'=>$this->nama_produk,
                'kode_produk'=>$this->kode_produk,
                'harga_produk'=>$this->harga_produk
            ]);
        }
            $this->emit('newUpdateProduct', $product);
            $this->deleteInput();
    }

    public function deleteInput(){
        $this->nama_produk=null;
        $this->kode_produk=null;
        $this->harga_produk=null;
    }

    public function render()
    {
        return view('livewire.product.update');
    }
}