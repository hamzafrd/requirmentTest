@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('todo.update', $todo->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">JUDUL</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name', $todo->name) }}" placeholder="Masukkan Judul todo">

                                <!-- error message untuk name -->
                                @error('name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <label class="font-weight-bold">Apakah Sudah Selesai ?</label>
                                @if ($todo->is_done)
                                    <input type="checkbox" class="form-check-input @error('is_done') is-invalid @enderror"
                                        name="is_done" value="{{ old('is_done', $todo->is_done) }}" checked>
                                @else
                                    <input type="checkbox" class="form-check-input @error('is_done') is-invalid @enderror"
                                        name="is_done" value="{{ old('is_done', $todo->is_done) }}">
                                @endif

                                <!-- error message untuk content -->
                                @error('content')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
