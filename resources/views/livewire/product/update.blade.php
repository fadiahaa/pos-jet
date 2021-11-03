<div>
    <input type="hidden" wire:model="productId">
        <form class="row g-3 mt-3" wire:submit.prevent="update">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nama Produk</label>
                <input type="text" class="form-control  @error ('nama_produk') is-invalid @enderror" wire:model="nama_produk" id="inputEmail4" placeholder="Contoh : Baju Lengan Panjang"  required >
                @error('nama_produk') <div class="invalid-feedback">{{$message}}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Kode Produk</label>
                <input type="text" class="form-control"  wire:model="kode_produk" id="inputPassword4" placeholder="Contoh : AB0001" required>
                @error('kode_produk') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Harga Produk</label>
                <input type="number" class="form-control"  wire:model="harga_produk" id="inputAddress" min="1" required>
                @error('harga_produk') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Edit</button>
            </div>
        </form>
</div>
