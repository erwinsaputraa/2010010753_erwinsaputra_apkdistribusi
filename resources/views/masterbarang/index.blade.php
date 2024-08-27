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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Data Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Data Barang</li>
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
            {{-- <div class="col-auto">
                <form action="masterbarang" method="GET">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search">
                </form>
            </div> --}}

            {{-- Button Export PDF --}}
            {{-- <div class="col-auto">
                <a href="{{ route('masterbarang.create')}}" class="btn btn-success">
                    Tambah Data
                </a>
                <a href="{{ route('masterbarangpdf')}}" class="btn btn-danger">
                    Export PDF
                </a>
            </div> --}}
        </div>

        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="px-6 py-2">No</th>
                        <th class="px-6 py-2">Kode Barang</th>
                        <th class="px-6 py-2">Nama Barang</th>
                        <th class="px-6 py-2">Harga</th>
                        <th class="px-6 py-2">Qty</th>
                        <th class="px-6 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=1;
                    @endphp
                    @foreach ($brgmasuk as $index => $item)
                    <tr>
                        <th class="px-6 py-2">{{ $index + $brgmasuk->firstItem() }}</th>
                        <td class="px-6 py-2">{{ $item->kodebarang }}</td>
                        <td class="px-6 py-2">{{ $item->namabarang }}</td>
                        <td class="px-6 py-2">Rp. {{ number_format($item->hargabarang )}}</td>
                        <td class="px-6 py-2">{{ $item->qty }}</td>
                        <td class="px-6 py-2">
                            <button type="submit" class="btn btn-success" {{ $item->status === 'approve' ? 'disabled' : '' }}>
                                {{ $item->status === 'approve' ? 'Approved' : 'Setujui' }}
                            </button>
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
