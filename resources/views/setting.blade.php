<x-header />

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="active">Setting</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"><i class="glyphicon glyphicon-wrench"></i> Setting</div>
            </div> <!-- /panel-heading -->

            <div class="panel-body">
            <form action="#" method="post" class="form-horizontal" id="changeUsernameForm">
                @csrf    
                <fieldset>
                    <legend>Change Username</legend>

                    <div class="changeUsernameMessages"></div>
                    
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{ $user->username }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" data-loading-text="Loading..." id="changeUsernameBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
                        </div>
                    </div>
                </fieldset>
            </form>

            <form action="#" method="post" class="form-horizontal" id="changePasswordForm">
                <fieldset>
                    <legend>Change Password</legend>

                    <div class="changePasswordMessages"></div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Current Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="npassword" class="col-sm-2 control-label">New password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="npassword" name="npassword" placeholder="New Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cpassword" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes </button>
                        </div>
                    </div>
                </fieldset>
            </form>
            </div> <!-- /panel-body -->
        </div> <!-- /panel -->
    </div> <!-- /col-md-12 -->
</div> <!-- /row-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Function to retrieve the bearer token from local storage
    function getToken() {
        return localStorage.getItem('token');
    }

    // Function to handle form submissions
    function handleFormSubmit(formId, apiUrl) {
        document.getElementById(formId).addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            const formData = new FormData(this);

            // Fetch API call
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + getToken(), // Include bearer token
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                // Handle API response
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Call handleFormSubmit for each form
    handleFormSubmit('changeUsernameForm', '/api/changeUsername');
    handleFormSubmit('changePasswordForm', '/api/changePassword');
});
</script>
<x-footer />
