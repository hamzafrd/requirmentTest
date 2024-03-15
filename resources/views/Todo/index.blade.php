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
                                    <th scope="col">SORT</th>
                                </tr>
                            </thead>
                            <tbody id="todoBody">
                                @forelse ($todos as $index => $todo)
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
                                        <td>
                                            <form action="{{ route('todos.moveUp', ['todo' => $todo->id]) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    {{ $index == 0 ? 'disabled' : '' }}>Up</button>
                                            </form>
                                            <form action="{{ route('todos.moveDown', ['todo' => $todo->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    {{ $index == count($todos) - 1 ? 'disabled' : '' }}>Down</button>
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
                                                <p>Belum Selesai</p>
                                            @else
                                                <p>Selesai</p>
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
            const table = $('#todoBody')
            const trashedTable = $('#todoTrashedBody')


            const todosURL = "{{ route('todo.getTodos') }}"
            const todosTrashedURL = "{{ route('todo.getTodosTrashed') }}"

            $.ajax({
                url: todosTrashedURL,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let html = ''
                    data.forEach(function(todo, index) {
                        console.log(todo);
                        html += '<tr>'
                        html += '<td>' + (todo.is_done == 0 ?
                                '<div class="">Belum Selesai</div>' :
                                '<div class="">Selesai</div>') +
                            '</td>';
                        html += '<td>' + todo.name + '</td>';
                        html += '<td class="text-center">';
                        html += '<a href="/todo/recover/' + todo.id +
                            '" class="btn btn-sm btn-success">Recover</a>';
                        html += '<form class="delete-form" data-id="' + todo.id +
                            '" action="/todo/destroyPermanent/' + todo.id + '" method="POST">';
                        html +=
                            '<button type="submit" class="btn btn-sm btn-danger delete-btn">Hapus Permanent</button>';
                        html += '@csrf';
                        html += '@method('GET')';
                        html += '</form>';
                        html += '</td>';

                        html += ''

                    })
                    trashedTable.html(html)
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(error);
                },

            })


        })

        const moveUpBtns = document.querySelectorAll('.move-up-btn');
        const moveDownBtns = document.querySelectorAll('.move-down-btn');

        moveUpBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                if (row.previousElementSibling && row.previousElementSibling.querySelector(
                        '.move-up-btn')) {
                    row.parentNode.insertBefore(row, row.previousElementSibling);
                }
            });
        });

        moveDownBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const nextRow = row.nextElementSibling;
                if (nextRow && nextRow.querySelector('.move-down-btn') && nextRow.nextElementSibling) {
                    row.parentNode.insertBefore(nextRow, row);
                }
            });
        });
    </script>
@endpush
