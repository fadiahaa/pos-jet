<div>
    <div class="container">
        {{-- Form Create --}}
            @if ($updateProduct)
            <h1 class="h3 p-3 mb-3 border-bottom"><b>Form Edit Produk</b></h1>
                @if (session()->has('message'))
                    <script>
                        Swal.fire(
                            'Good job!',
                            '{!!session('message')!!}',
                            'success'
                            )
                    </script>
                @endif
                @livewire('product.update')     
            @else
            <h1 class="h3 p-3 mb-3 border-bottom"><b>Form Tambah Produk</b></h1>
                @if (session()->has('message'))
                    <script>
                        Swal.fire(
                            'Good job!',
                            '{!!session('message')!!}',
                            'success'
                            )
                    </script>
                @endif
                @livewire('product.create')
            @endif

        </div>

        {{-- Show Data --}}
        <div class="card-body border pb-5">
            <nav class="navbar navbar-light">
                <div class="container-fluid p-0">
                  <div class="navbar-brand">
                    <select class="form-select" wire:model="paginate" aria-label="Default select example">
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                      </select>
                    </div>
                  <div class="d-flex">
                    <input class="form-control me-2" wire:model="search" type="search" placeholder="Cari" aria-label="Search">
                  </div>
                </div>
              </nav>
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ $product->nama_produk }}</td>
                            <td>{{ $product->kode_produk }}</td>
                            <td>Rp. {{ number_format($product->harga_produk) }}</td>
                            <td>
                                <button wire:click="getProduct({{$product->id}})" class="btn btn-warning btn-sm">Edit</button>
                                <button wire:click="$emit('deleteProduct',{{$product->id}})" class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
            {{$products->links()}}
        </div>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('livewire:load', function () {
        @this.on('deleteProduct', idProduct => {
            Swal.fire({
            title: 'Apakah Anda Yakin??',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak, Batal!',
            reverseButtons: true
            }).then((result) => {
                //Call Method Delete in Livewire Component
            if (result.isConfirmed) {
                @this.call('deleteProduct', idProduct)
                Swal.fire(
                'Terhapus!',
                'Data Anda Sudah Terhapus.',
                'success'
                )
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                'Cancelled',
                'Data Tidak Jadi Dihapus',
                'error'
                )
            }
            })
        })
    })
</script>
@endpush