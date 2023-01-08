@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <button class="btn btn-success btn-sm" id="btn-add-money">+ Add</button>
                        </div>

                    </div>
                    <h4>Laporan</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Tanggal</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="table-moneys">

                            @foreach ($moneys as $money)
                            <tr id="index_{{$money->id}}">
                                <td>{{ $money->keterangan }}</td>
                                @if ($money->jenis == 'masuk')
                                <td class="bg-success text-white"><span>Rp. {{ $money->jumlah }}</span></td>
                                <td>-</td>
                                @else
                                <td>-</td>
                                <td class="bg-warning text-white"><span>Rp.{{ $money->jumlah }}</span></td>
                                @endif

                                <td>{{ $money->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="javascript:void(0)" id="btn-edit-money" data-id="{{ $money->id }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="javascript:void(0)" id="btn-delete-money" data-id="{{ $money->id }}"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            <tr id='row-sum-moneys'>
                                <th>Jumlah</th>
                                <td class=""><span>Rp. {{ $masuk }}</span></td>
                                <td class=""><span>Rp.{{ $keluar }}</span></td>
                                <td>Sisa</td>
                                <td>{{ $masuk - $keluar }}</td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $moneys->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.add-modal')
@include('components.edit-modal')
@include('components.delete-modal')
@endsection