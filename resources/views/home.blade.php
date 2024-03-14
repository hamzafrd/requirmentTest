@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- {{ __('You are logged in!') }} --}}
                        <form>
                            <div class="row mb-3">
                                <label for="user_id">User : </label>
                                <select name="user_id" id="user_id" class="form-control">
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach --}}
                                </select>
                                <p id="select2_value">Value : - </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                minimumInputLength: 2,
                placeholder: 'Select User',
                ajax: {
                    url: route('users.index'),
                    dataType: 'json',
                    data: (params) => {
                        let query = {
                            search: params.term,
                            page: params.page || 1,
                        };
                        return query;
                    },
                    processResults: data => {
                        console.log(data.data);
                        return {
                            results: data.data.map(res => {
                                return {
                                    text: res.name,
                                    id: res.id
                                }
                            }),
                            pagination: {
                                more: data.current_page < data.last_page,
                            },
                        }
                    }
                },

            })

            let test = $('#select2_value')[0].innerHTML;

        })
    </script>
@endpush
