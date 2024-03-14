@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">TODO APPS</h3>
                    <h5 class="text-center">Requirement Test</h5>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('todo.create') }}" class="btn btn-md btn-success mb-3">TAMBAH todo</a>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">IS_DONE</th>
                                    <th scope="col">TODO</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="todoBody">
                                @forelse ($todos as $todo)
                                    <tr>
                                        <td>
                                            @if ($todo->is_done == 0)
                                                <div class="btn btn-sm btn-danger">Belum Selesai</div>
                                            @else
                                                <div class="btn btn-sm btn-success">Selesai</div>
                                            @endif
                                        </td>
                                        <td>{{ $todo->name }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('todo.destroy', $todo->id) }}" method="POST">

                                                <a href="{{ route('todo.show', $todo->id) }}"
                                                    class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('todo.edit', $todo->id) }}"
                                                    class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf

                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data todo belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $todos->links() }}
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h2 class="">History</h2>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">IS_DONE</th>
                                    <th scope="col">TODO</th>
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="todoTrashedBody">
                                @forelse ($todos_trashed as $todo)
                                    <tr>
                                        <td>
                                            @if ($todo->is_done == 0)
                                                <p class="">Belum Selesai</p>
                                            @else
                                                <p class="btn btn-sm btn-success">Selesai</p>
                                            @endif
                                        </td>
                                        <td>{{ $todo->name }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('todo.destroyPermanent', $todo->id) }}" method="POST">

                                                <a href="{{ route('todo.recover', $todo->id) }}"
                                                    class="btn btn-sm btn-success">Recover</a>

                                                @method('GET')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Hapus dari history
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data History belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $todos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#todoBody tr')[0]
            const trashedTable = $('#todoTrashedBody tr')[0]
            console.log(table, trashedTable)

            const todosURL = "{{ route('todo.getTodos') }}"
            const todosTrashedURL = "{{ route('todo.getTodosTrashed') }}"

            postData(todosURL);
            postData(todosTrashedURL);

            function postData(baseURL) {
                $.ajax({
                    url: baseURL,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.map(res => {
                            var html = '<tr>' +
                                '<td>' +
                                (res.is_done == 0 ? '<p class="">Belum Selesai</p>' :
                                    '<p class="btn btn-sm btn-success">Selesai</p>') +
                                '</td>' +
                                '<td>' + res.name + '</td>' +
                                '<td class="text-center">' +
                                '<form action="{{ route('todo.destroyPermanent', $todo->id) }}" method="POST">' +
                                '<a href="{{ route('todo.recover', $todo->id) }}" class="btn btn-sm btn-success">Recover</a>' +
                                '@method('GET')' +
                                '<button type="submit" class="btn btn-sm btn-danger">Hapus dari history</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>';
                        })
                        table.append(table)
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(error);
                    }
                })
            }

        })
    </script>
@endpush
