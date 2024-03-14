@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h4>TODO : {{ $todo->name }}</h4>
                        @if ($todo->is_done == 0)
                            Status :
                            <div class="btn btn-sm btn-danger">Belum Selesai</div>
                        @else
                            Status :
                            <div class="btn btn-sm btn-success">Selesai</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
