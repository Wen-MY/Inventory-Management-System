@extends('layouts.app')

<script>
    function fetchUserProfile(event) {
        event.preventDefault(); // Prevent the default form submission

        var token = localStorage.getItem('token'); // Assuming you stored the token as 'token'

        fetch('/api/user-profile', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                var username = data.username; // Accessing the username from the data object
                document.getElementById('username').innerText = username;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Welcome to Your Application
            </div>
            <div class="card-body">
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

                <form id="logout-form" action="{{ url('api/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">Logout</button>
                </form>
                <form id="fetch-user-form" onsubmit="fetchUserProfile(event)" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">Fetch User Profile</button>
                </form>

                <div class="container">
                    <div class="card mt-3">
                        <div class="card-header">
                            Welcome to Your Application
                        </div>
                        <div class="card-body">
                            <p id="welcome-message">Welcome, <span id="username"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
