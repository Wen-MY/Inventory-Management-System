<x-header />

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="active">Category</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Categories</div>
            </div>
            <!-- /panel-heading -->

            <div class="panel-body">
                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" data-toggle="modal" id="addCategoryModalBtn" data-target="#addCategoriesModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Category </button>
                </div>
                <!-- /div-action -->

                <table class="table" id="manageCategoriesTable">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th style="width:15%;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if ($category->status == 1)
                                        <span class="label label-success">Available</span>
                                    @else
                                        <span class="label label-danger">Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a type="button" data-toggle="modal" id="editCategoryModalBtn" data-target="#editCategoriesModal" onclick="showEditCategory({{ $category->id }})"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                                            <li><a type="button" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoryModalBtn" onclick="setCategoryId({{ $category->id }})"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
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

<!-- add categories -->
<div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="submitCategoriesForm" action="/api/create-categories" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Categories</h4>
                </div>
                <div class="modal-body">
                    <div id="add-categories-messages"></div>
                    <div class="form-group">
                        <label for="categoriesName" class="col-sm-4 control-label">Categories Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="categoriesName" placeholder="Categories Name" name="categoriesName" autocomplete="off">
                        </div>
                    </div>
                    <!-- /form-group-->
                    <div class="form-group">
                        <label for="categoriesStatus" class="col-sm-4 control-label">Status: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-7">
                            <select class="form-control" id="categoriesStatus" name="categoriesStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1">Available</option>
                                <option value="2">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <!-- /form-group-->
                </div>
                <!-- /modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="createCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- /add categories -->

<!-- edit categories brand -->
<div class="modal fade" id="editCategoriesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="editCategoriesForm" action="/api/edit-categories/" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Categories</h4>
                </div>
                <div class="modal-body">
                    <div id="edit-categories-messages"></div>
                    <div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="edit-categories-result">
                        <!-- Hidden input field for category ID -->
                        <input type="hidden" name="editCategoriesId" id="editCategoriesId" value="">
                        <div class="form-group">
                            <label for="editCategoriesName" class="col-sm-4 control-label">Categories Name: </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editCategoriesName" placeholder="Categories Name" name="editCategoriesName" autocomplete="off">
                            </div>
                        </div>
                        <!-- /form-group-->
                        <div class="form-group">
                            <label for="editCategoriesStatus" class="col-sm-4 control-label">Status: </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-7">
                                <select class="form-control" id="editCategoriesStatus" name="editCategoriesStatus">
                                    <option value="">~~SELECT~~</option>
                                    <option value="1">Available</option>
                                    <option value="2">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <!-- /form-group-->
                    </div>
                    <!-- /edit brand result -->
                </div>
                <!-- /modal-body -->
                <div class="modal-footer editCategoriesFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                    <button type="submit" class="btn btn-success" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- /edit categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCategoriesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Category</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="categoryIdToDelete" name="categoryIdToDelete">
                <p>Do you really want to remove this category?</p>
            </div>
            <div class="modal-footer removeCategoriesFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancel</button>
                <!-- Use data-category-id to store the category ID -->
                <button type="button" class="btn btn-primary" id="removeCategoriesBtn" onclick="removeCategory(document.getElementById('categoryIdToDelete').value)"> <i class="glyphicon glyphicon-ok-sign"></i> Confirm</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /categories brand -->

<script src="{{ asset('js/categories.js') }}"></script>

<script>
    function setCategoryId(categoryId) {
        document.getElementById('categoryIdToDelete').value = categoryId;
    }

    function showEditCategory(id) {
        event.preventDefault();

        fetch('/api/get-categories/' + id)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch category details');
                }
            })
            .then(data => {
                var category = data.data;
                document.getElementById('editCategoriesId').value = category.id;
                document.getElementById('editCategoriesName').value = category.name;
                document.getElementById('editCategoriesStatus').value = category.status;

                // Dynamically update the action attribute of the form
                var editForm = document.getElementById('editCategoriesForm');
                editForm.action = '/api/edit-categories/' + category.id;

                $('#editCategoriesModal').modal('show');
            })
            .catch(error => {
                console.error('Failed to fetch category details:', error);
                // Optionally, display an error message to the user
            });
    }

    function removeCategory(categoryId) {
        if (!categoryId) {
            console.error('Invalid category ID');
            return;
        }

        // Make a DELETE request to the specified route with the category ID
        fetch(`/api/delete-categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                // Add any additional headers if needed
            },
        })
        .then(response => {
            if (response.ok) {
                // If the deletion is successful, reload the page or perform any other action
                window.location.reload();
            } else {
                // If there is an error, display a message or handle it accordingly
                console.error('Failed to delete category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Attach click event listener to the "Confirm" button in the removeCategoriesModal
    $('#removeCategoriesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var categoryId = button.data('category-id'); // Extract category ID from data-* attributes
        var modal = $(this);
        modal.find('#removeCategoriesBtn').attr('data-category-id', categoryId); // Set the data-category-id attribute of the Confirm button
    });

    // Handle click event of the "Confirm" button
    $('#removeCategoriesBtn').click(function() {
        var categoryId = $(this).data('category-id'); // Retrieve category ID from data-category-id attribute
        console.log('Category ID from button click:', categoryId); // Debugging statement
        removeCategory(categoryId);
    });
</script>

<x-footer />
