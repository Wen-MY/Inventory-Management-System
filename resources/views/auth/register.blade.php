<!DOCTYPE html>
<html>

<head>
    <title>Stock Management System</title>

    <style>
        .btn-link {
            margin-top: 150px;
        }
    </style>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>

<body>
    <div class="container">
        <div class="row vertical">
            <div class="col-md-5 col-md-offset-4">
                <a href="/login" class="btn btn-link">Login</a>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <div class="messages"></div>
                        <form class="form-horizontal" onsubmit="registerUser(event)" id="registerForm">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Username" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation"
                                        class="col-sm-2 control-label confirm-label">Confirm
                                        Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm Password"
                                            autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default"> <i
                                                class="glyphicon glyphicon-log-in"></i> Register</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <!-- panel-body -->
                </div>
                <!-- /panel -->
            </div>
            <!-- /col-md-4 -->
        </div>
        <!-- /row -->
    </div>
    <!-- container -->
</body>

<script>
    function registerUser(event) {
        event.preventDefault();

        var formData = new FormData(event.target);

        fetch('/register', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/login';
                } else {
                    console.log(response); // Log the response for debugging
                    return response.json(); // Parse response body as JSON
                }
            })
            .then(data => {
                // Display validation errors if any
                if (data) {
                    let errors = '<div class="alert alert-danger" role="alert">';
                    Object.values(data).forEach(message => {
                        errors += `${message}`;
                    });
                    errors += '</div>';
                    document.querySelector('.messages').innerHTML = errors;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

</html>
