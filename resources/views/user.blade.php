<x-header />

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="active">User</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"><i class="glyphicon glyphicon-edit"></i> Manage User</div>
            </div>

            <div class="panel-body">
                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" data-toggle="modal" id="addUserModalBtn" data-target="#addUserModal"><i class="glyphicon glyphicon-plus-sign"></i> Add User</button>
                </div>

                <table class="table" id="manageUserTable">
                    <thead>
                        <tr>
                            <th style="width:10%;">User Name</th>
                            <th style="width:15%;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    @if($user->id !== session("user.id"))
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>
                                <!-- Dropdown button for actions -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- Edit user option -->
                                        <li><a type="button" data-toggle="modal" id="editUserModalBtn"
                                                data-target="#editUserModal"
                                                onclick="showEditUser({{ $user->id }})">
                                                <i class="glyphicon glyphicon-edit"></i> Edit
                                            </a>
                                        </li>
                                        <!-- Remove user option -->
                                        <li><a type="button" data-toggle="modal" data-target="#removeUserModal"
                                                id="removeUserModalBtn"
                                                onclick="setUserId({{ $user->id }})">
                                                <i class="glyphicon glyphicon-trash"></i> Remove
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
                <!-- /table -->
            </div>
            <!-- /panel-body -->
        </div>
        <!-- /panel -->
    </div>
    <!-- /col-md-12 -->
</div>
<!-- /row -->

<!-- add user -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="submitUserForm" action="{{ route('createUser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
                </div>

                <div class="modal-body" style="max-height:450px; overflow:auto;">
                    <div id="add-user-messages"></div>
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">User Name: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" placeholder="User Name" name="username" autocomplete="off">
                        </div>
                    </div>
                    <!-- /form-group-->

                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password: </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" autocomplete="off">
                        </div>
                    </div>
                    <!-- /form-group-->

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email: </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" autocomplete="off">
                        </div>
                    </div>
                    <!-- /form-group-->
                    <div class="form-group">
                        <label for="role" class="col-sm-3 control-label">Role: </label>
                        <div class="col-sm-8">
                        <select class="form-control" id="role" name="role">
                            <option value="">~~SELECT~~</option>
                            <option value="staff" >Staff</option>
                            <option value="admin" >Admin</option>
                            <option value="audit" >Audit</option>
                        </select>
                        </div>
                    </div>
                </div>
                <!-- /modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="createUserBtn" data-loading-text="Loading..." autocomplete="off"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dailog -->
</div>
<!-- /add categories -->


<!-- edit user -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit User</h4>
            </div>
            <div class="modal-body" style="max-height:450px; overflow:auto;">
                <div class="div-loading">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="div-result">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#userInfo" aria-controls="profile" role="tab" data-toggle="tab">User Info</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- product image -->
                        <div role="tabpanel" class="tab-pane active" id="userInfo">
                            <form class="form-horizontal" id="editUserForm" onsubmit="updateUser(event)">
                                @csrf
                                <br />
                                <input type="hidden" class="form-control" id="editUserId"
                                        placeholder="User Name" name="editUserId">
                                <div class="form-group">
                                    <label for="edituserName" class="col-sm-3 control-label">User Name: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editUsername" placeholder="User Name" name="username" autocomplete="off">
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="form-group">
                                    <label for="editPassword" class="col-sm-3 control-label">Password: </label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="editPassword" placeholder="Password" name="password" autocomplete="off">
                                    </div>
                                </div>
                                <!-- /form-group-->
                                <div class="modal-footer editUserFooter">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                                    <button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                                </div>
                                <!-- /modal-footer -->
                            </form>
                            <!-- /.form -->
                        </div>
                        <!-- /product info -->
                    </div>
                </div>
            </div>
            <!-- /modal-body -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userIdToDelete" name="userIdToDelete">
                <p>Do you really want to remove ?</p>
            </div>
            <div class="modal-footer removeProductFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                <button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..." onclick="removeUser(document.getElementById('userIdToDelete').value)"> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->
<script>
    function showEditUser(id) {
        event.preventDefault();

        fetch('api/get-user/' + id, {
                method: 'GET',
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch product details');
                }
            })
            .then(data => {
                var user = data.user;
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUsername').value = user.username;
                document.getElementById('editPassword').value = user.password;
                $('#editUserModal').modal('show');
            })
            .catch(error => {
                console.error('Failed to fetch user details:', error);
            });
    }

    function updateUser(event) {
        event.preventDefault();
        var formData = new FormData(event.target);

        fetch('api/update-user/' + document.getElementById('editUserId').value, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to update user');
                }
            })
            .then(data => {
                window.location.href = '/user';
            })
            .catch(error => {
                console.error('Failed to update user:', error);
            });
    }
    function setUserId(userId) {
        document.getElementById('userIdToDelete').value = userId;
    }
    function removeUser(id) {
        event.preventDefault();

        fetch('api/delete-user/' + id, {
                method: 'POST',
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to delete product');
                }
            })
            .then(data => {
                window.location.href = '/user';
            })
            .catch(error => {
                console.error('Failed to delete user:', error);
            });
    }
    </script>

<x-footer />