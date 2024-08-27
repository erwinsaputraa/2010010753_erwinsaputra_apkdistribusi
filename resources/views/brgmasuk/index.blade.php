@extends('layout.admin')
@push('css')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
    integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang Masuk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Barang Masuk</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    {{-- CRUD --}}
    <!-- Required meta tags -->
    {{--
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> --}}



    <div class="container">
        {{-- search --}}
        <div class="row g-3 align-items-center mb-4">
            <div class="col-auto">
                <form action="brgmasuk" method="GET">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search">
                </form>
            </div>

            {{-- Button Export PDF --}}
            @if (Auth::user()->hakakses('sales')||Auth::user()->hakakses('admin'))
            <div class="col-auto">
                <a href="{{ route('brgmasuk.create')}}" class="btn btn-success">
                    Tambah Data
                </a>
                {{-- <a href="{{ route('brgmasukpdf')}}" class="btn btn-danger">
                    Export PDF
                </a> --}}
            </div>
            @endif
        </div>

        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="px-6 py-6">No</th>
                        <th class="px-6 py-6">Tanggal</th>
                        <th class="px-6 py-6">Kode Barang</th>
                        <th class="px-6 py-6">Nama barang</th>
                        <th class="px-6 py-6">Harga barang</th>
                        <th class="px-6 py-6">Qty</th>
                        <th class="px-6 py-6">Dari Supplier</th>
                        <th class="px-6 py-6">Status</th>
                        <th class="px-6 py-6">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($brgmasuk as $index => $item)
                    <tr>
                        <th class="px-6 py-6">{{ $index + $brgmasuk->firstItem() }}</th>
                        <td class="px-10 py-10">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}
                        </td>
                        <td class="px-6 py-6">{{ $item->kodebarang }}</td>
                        <td class="px-6 py-6">{{ $item->namabarang }}</td>
                        <td class="px-6 py-6">Rp. {{number_format ( $item->hargabarang) }}</td>
                        <td class="px-6 py-6">{{ $item->qty }}</td>
                        <td class="px-6 py-6">{{ $item->mastersupplier->namapt }}</td>
                        <td class="px-6 py-6">
                            {{ $item->status ?? 'Belum Disetujui' }}
                        </td>

                        <td>
                            @if ($item->status !== 'approve')
                            @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin'))
                                <a href="{{ route('brgmasuk.edit', $item->id) }}" class="btn btn-primary">
                                    Edit
                                </a>
                            @endif
                            @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin'))
                                <form action="{{ route('brgmasuk.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            @endif
                            @endif
                            <!-- Form untuk update status -->
                            <form action="{{ route('brgmasuk.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" {{ $item->status === 'approve' ? 'disabled' : '' }}>
                                    {{ $item->status === 'approve' ? 'Approved' : 'Setujui' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $brgmasuk->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Optional JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script>
    @if(Session::has('success'))
toastr.success("{{ Session::get('success')}}")
@endif
</script>
@endpush
