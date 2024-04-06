<div class="card-body">
    Welcome to JM's Web Application.
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @can('isAdmin')
        <div class="btn btn-success btn-lg">
            You have Admin Access
        </div>
    @elsecan('isAuthor')
        <div class="btn btn-primary btn-lg">
            You have Author Access
        </div>
    @else
        <div class="btn btn-info btn-lg">
            You have User Access
        </div>
    @endcan
</div>
