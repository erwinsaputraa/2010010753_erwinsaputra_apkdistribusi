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
                    <h1 class="m-0">Laporan Harian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Harian Sales</li>
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
                <form action="laporanharian" method="GET">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search">
                </form>
            </div>

            {{-- Button Export PDF --}}
            @if (Auth::user()->hakakses('sales')||Auth::user()->hakakses('admin'))
            <div class="col-auto">
                <a href="{{ route('laporanharian.create')}}" class="btn btn-success">
                    Tambah Data
                </a>
                {{-- <a href="{{ route('laporanharianpdf')}}" class="btn btn-danger">
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
                        <th class="px-6 py-6">Nama Sales</th>
                        <th class="px-6 py-6">Area Kunjungan</th>
                        <th class="px-6 py-6">Chanel</th>
                        <th class="px-6 py-6">Call</th>
                        <th class="px-6 py-6">Akumulasi EC</th>
                        <th class="px-6 py-6">Target Harian</th>
                        <th class="px-6 py-6">Akumulasi Penjualan</th>
                        {{-- <th class="px-6 py-6">EC</th> --}}
                        @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin'))
                        <th class="px-6 py-6">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=1;
                    @endphp
                    @foreach ($laporanharian as $index => $item)
                    <tr>
                        <th class="px-6 py-6">{{ $index + $laporanharian->firstItem() }}</th>
                        <td class="px-6 py-6">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}
                        </td>
                        <td class="px-6 py-6">{{ $item->masteruser->name }}</td>
                        <td class="px-6 py-10">{{ $item->area }}</td>
                        <td class="px-6 py-6">{{ $item->chanel }}</td>
                        <td class="px-6 py-6">{{ $item->call }}</td>
                        <td class="px-6 py-6">{{ $item->akumulasiec }}</td>
                        <td class="px-6 py-6">Rp. {{ number_format($item->targetharian) }}</td>
                        <td class="px-6 py-6">Rp. {{ number_format($item->aktualharian) }}</td>
                        @if (Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin'))
                        <td>
                            <a href="{{ route('laporanharian.edit', $item->id)}}" class="btn btn-primary btn-block">
                                Edit
                            </a>
                            <form action="{{ route('laporanharian.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-block mt-2">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $laporanharian->links() }}
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
