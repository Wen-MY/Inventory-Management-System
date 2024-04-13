<x-header />

<div class="row">
    <div class="col-md-12">

        <ol class="breadcrumb">
            <li><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="active">Brand</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Brands</div>
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">

                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" id="addBrandModalBtn" data-toggle="modal" data-target="#addBrandModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Brand </button>
                </div>
                <!-- /div-action -->

                <table class="table" id="manageBrandTable">
                    <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Status</th>
                            <th style="width:15%;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    @if ($brand->status == 1)
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
                                            <li><a type="button" data-toggle="modal" id="editBrandModalBtn" data-target="#editBrandModal" onclick="showEditBrand({{ $brand->id }})"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                                            <li><a type="button" data-toggle="modal" data-target="#removeBrandModal" id="removeBrandModalBtn" onclick="setBrandId({{ $brand->id }})"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
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

<!-- add brand -->
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="form-horizontal" id="submitBrandForm" action="/api/create-brands" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
                </div>
                <div class="modal-body">

                    <div id="add-brand-messages"></div>

                    <div class="form-group">
                        <label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="brandName" placeholder="Brand Name" name="brandName" autocomplete="off">
                        </div>
                    </div>
                    <!-- /form-group-->
                    <div class="form-group">
                        <label for="brandStatus" class="col-sm-3 control-label">Status: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="brandStatus" name="brandStatus">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Close</button>

                    <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off"><i class="glyphicon glyphicon-ok-sign"></i>Save Changes</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- / add modal -->

<!-- edit brand -->
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="form-horizontal" id="editBrandForm" action="/api/edit-brand/" method="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
                </div>
                <div class="modal-body">

                    <div id="edit-brand-messages"></div>

                    <div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <div class="edit-brand-result">
                    <input type="hidden" name="editBrandId" id="editBrandId" value="">
                        <div class="form-group">
                            <label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editBrandName" placeholder="Brand Name" name="editBrandName" autocomplete="off">
                            </div>
                        </div>
                        <!-- /form-group-->
                        <div class="form-group">
                            <label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
                            <label class="col-sm-1 control-label">: </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="editBrandStatus" name="editBrandStatus">
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

                <div class="modal-footer editBrandFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

                    <button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div>
                <!-- /modal-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeBrandModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="brandIdToDelete" name="brandIdToDelete">
                <p>Do you really want to remove this brand?</p>
            </div>
            <div class="modal-footer removeBrandFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancel</button>
                <!-- Use data-brand-id to store the brand ID -->
                <button type="button" class="btn btn-primary" id="removeBrandBtn" onclick="removeBrand(document.getElementById('brandIdToDelete').value)"> <i class="glyphicon glyphicon-ok-sign"></i> Confirm</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /remove brand -->

<script src="{{ asset('js/brand.js') }}"></script>

<script>
    function setBrandId(brandId) {
        document.getElementById('brandIdToDelete').value = brandId;
    }

    function showEditBrand(id) {
        event.preventDefault();

        fetch('/api/get-brands/' + id)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch brand details');
                }
            })
            .then(data => {
                var brand = data.data;
                document.getElementById('editBrandId').value = brand.id;
                document.getElementById('editBrandName').value = brand.name;
                document.getElementById('editBrandStatus').value = brand.status;

                // Dynamically update the action attribute of the form
                var editForm = document.getElementById('editBrandForm');
                editForm.action = '/api/edit-brand/' + brand.id;

                $('#editBrandModal').modal('show');
            })
            .catch(error => {
                console.error('Failed to fetch brand details:', error);
                // Optionally, display an error message to the user
            });
    }

    function removeBrand(brandId) {
        if (!brandId) {
            console.error('Invalid brand ID');
            return;
        }

        // Make a DELETE request to the specified route with the brand ID
        fetch(`/api/delete-brands/${brandId}`, {
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
                console.error('Failed to delete brand');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Attach click event listener to the "Confirm" button in the removeBrandModal
    $('#removeBrandModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var brandId = button.data('brand-id'); // Extract brand ID from data-* attributes
        var modal = $(this);
        modal.find('#removeBrandBtn').attr('data-brand-id', brandId); // Set the data-brand-id attribute of the Confirm button
    });

    // Handle click event of the "Confirm" button
    $('#removeBrandBtn').click(function() {
        var brandId = $(this).data('brand-id'); // Retrieve brand ID from data-brand-id attribute
        console.log('Brand ID from button click:', brandId); // Debugging statement
        removeBrand(brandId);
    });
</script>

<x-footer />
