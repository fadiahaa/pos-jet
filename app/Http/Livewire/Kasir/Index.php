<?php

namespace App\Http\Livewire\Kasir;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderProduct;


class Index extends Component
{   

    public $product_id;
    public $pembayaran;


    protected $rules = [
        'product_id' => 'required|unique:transactions'
    ];

    public function submit()
    {

        $this->validate();
        $transaction = Transaction::create([
            'product_id' => $this->product_id,
            'qty' => 1,
        ]);
        $transaction->total = $transaction->product->harga_produk;
        $transaction->save();

        session()->flash('message', 'Product berhasil di tambahkan');
    }

    public function increment($id)
    {
        // dd($id);
        $transaction = Transaction::find($id);
        $transaction->update([
            'qty' => $transaction->qty+1,
            'total' => $transaction->product->harga_produk*($transaction->qty+1),
        ]);
        session()->flash('message', 'Qty product berhasil di tambahkan');

        // return redirect()->to('/kasir');
    }
    public function decrement($id)
    {
        // dd($id);
        $transaction = Transaction::find($id);
        $transaction->update([
            'qty' => $transaction->qty-1,
            'total' => $transaction->product->harga_produk*($transaction->qty-1),
        ]);
        session()->flash('message', 'Qty product berhasil di kurang');

        // return redirect()->to('/kasir');
    }

    public function deleteTransaction($id){
        $transaction = Transaction::find($id);
        $transaction->delete();
        session()->flash('message', 'Qty product berhasil di hapus');
    }

    public function save(){
        $order = Order::create([
            'order_id' => 'OD-'.date('Ymd').rand(1111,9999),
            'nama_kasir' => auth()->user()->name
        ]);

        $transaction=Transaction::get();
        foreach ($transaction as $key => $value) {
            $product=array(
                'order_id'=>$order->id,
                'product_id'=>$value->product_id,
                'qty'=>$value->qty,
                'total'=>$value->total,
                'created_at'=>\Carbon\carbon::now(),
            );

            $orderProduct=OrderProduct::insert($product);
            $deleteTransaction=Transaction::where('id', $value->id)->delete();
        }

        // session()->flash('message', 'Transaksi Berhasil Ditambah');
        return redirect()->to('/invoice');
    }

    public function render()
    {
        return view('livewire.kasir.index', [
            'products'=>Product::orderBY('nama_produk', 'asc')->get(),
            'transactions' => Transaction::get()
        ]);
    }
}
