<div>
    <style>
        .qty {
            width: 20%;
            display: inline;
        }
    </style>
    <div class="card-body">
        <div class="form-group row pb-5">
            <form class="row g-3 mt-3" wire:submit.prevent="submit">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Product</label>
                <div class="col-sm-8">
                    <select class="form-control @error('product_id') is-invalid @enderror" wire:model="product_id" required>
                            <option>-- Pilih Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"> {{ $product->nama_produk }} </option>
                        @endforeach
                    </select>
                    @error('product_id') 
                    {{-- <span class="error"></span>  --}}
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="card-body border-top pb-5 p-0 mt-3">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Harga/Qty</th>
                        <th scope="col" style="width: 200px;">Total</th>
                        <th scope="col" style="width: 10px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($transactions as $transaction)
                    <tr>    
                        <td>{{$loop->iteration}}</td>
                        <td>{{$transaction->product->nama_produk}}</td>
                        <td>
                            <div>
                                @if ($transaction->qty > 1)
                                    <span class="btn btn-danger btn-sm" wire:click="decrement({{$transaction->id}})">-</span>  
                                @endif
                                <input type="text" class="form-control qty" value="{{$transaction->qty}}" readonly>
                                <span class="btn btn-success btn-sm" wire:click="increment({{$transaction->id}})">+</span>
                            </div>
                        </td>
                        <td>Rp. {{number_format($transaction->product->harga_produk)}}</td>
                        <td>Rp. {{number_format($transaction->product->harga_produk*$transaction->qty)}}</td>
                        <td>
                            <button type="button" wire:click="deleteTransaction({{$transaction->id}})" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                              </svg></button>
                        </td>
                    </tr>
                    @endforeach 

                </tbody>
                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:right;">Total Pembelian</td>
                    <td>
                       Rp. {{number_format($transactions->sum('total'))}}
                    </td>
                    <tr>
                        <td style="border:none;"></td>
                        <td style="border:none;"></td>
                        <td style="border:none;"></td>
                        <td style="text-align:right;">Pembayaran</td>
                        <td style="text-align:right;">
                            <input type="number" value="0" wire:model="pembayaran">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;"></td>
                        <td style="border:none;"></td>
                        <td style="border:none;"></td>
                        <td style="text-align:right;">Kembalian</td>
                        <td style="text-align:left;">
                            Rp. {{number_format($pembayaran - $transactions->sum('total'))}}
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-right:55px;">
                <button type="button" wire:click="save" class="btn btn-success btn-sm float-right">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
