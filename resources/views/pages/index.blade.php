@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Uangku') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success btn-sm" id="btn-add-money">+ Add</button>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Keterangan</td>
                                <td>Jumlah</td>
                                <td>Jenis</td>
                                <td>Tanggal</td>
                                <td>Opsi</td>
                            </tr>
                        </thead>
                        <tbody id="table-moneys">

                            @foreach ($moneys as $money)
                            <tr id="index_{{$money->id}}">
                                <td>{{ $money->keterangan }}</td>
                                <td>{{ $money->jumlah }}</td>
                                <td>{{ $money->jenis }}</td>
                                <td>{{ $money->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="javascript:void(0)" id="btn-edit-money" data-id="{{ $money->id }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="javascript:void(0)" id="btn-delete-money" data-id="{{ $money->id }}"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
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