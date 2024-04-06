@extends('layouts.auth')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    @foreach ($posts as $post)
                        @can('viewAny', $post)
                            <div class="card-header">
                                <div class="float-right"> {{ $post['title'] }}</div>
                                @can('delete', $post)
                                    <form method='POST' action="/posts/{{ $post['id'] }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger float-right">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                                <div class="alert alert-success" role="alert">
                                    {{ $post['content'] }}
                                    User_id={{ $post['user_id'] }}
                                </div>
                            </div>
                        @endcan
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
