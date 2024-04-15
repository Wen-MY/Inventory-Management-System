<x-header />

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="active">Product</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"><i class="glyphicon glyphicon-edit"></i> Manage Product</div>
            </div>
            <div class="panel-body">
                <div class="remove-messages"></div>
                @can('create', \App\Models\Product::class)
                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn"
                        data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Product
                    </button>
                </div>
                @endcan
                <table class="table" id="manageProductTable">
                    <thead>
                        <tr>
                            <th style="width:10%;">Photo</th>
                            <th>Product Name</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Status</th>
                            @can('update', $products)
                                <th style="width:15%;">Options</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><img src="{{ asset($product->image) }}" alt="Product Image"
                                        style="width: 80px; height: 50px;"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->rate }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->brand->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    @if ($product->status == 1)
                                        <label class="label label-success">Available</label>
                                    @elseif($product->status == 2)
                                        <label class="label label-danger">Not Available</label>
                                    @endif
                                </td>
                                @can('update', $product)
                                <td>
                                    <!-- Single button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a type="button" data-toggle="modal" id="editProductModalBtn"
                                                    data-target="#editProductModal"
                                                    onclick="showEditProduct({{ $product->id }})"> <i
                                                        class="glyphicon glyphicon-edit"></i> Edit</a></li>
                                            <li><a type="button" data-toggle="modal" data-target="#removeProductModal"
                                                    onclick="setProductId({{ $product->id }})">
                                                    <i class="glyphicon glyphicon-trash"></i> Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- add product -->
@can('create', \App\Models\Product::class)
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="submitProductForm" action="/api/create-product" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
                </div>

                <div class="modal-body" style="max-height:450px; overflow:auto;">
                    <div class="form-group">
                        <label for="productImage" class="col-sm-3 control-label">Product Image: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                            <div class="kv-avatar center-block">
                                <img id="addProductImagePreview" alt="Product Image"
                                    style="width: 150px; height: 150px;">
                                <input type="file" class="form-control" id="productImage" placeholder="Product Name"
                                    name="productImage" class="file-loading" style="width:auto;"
                                    onchange="previewAddProductImage(event)" />
                            </div>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="productName" class="col-sm-3 control-label">Product Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="productName" placeholder="Product Name"
                                name="productName" autocomplete="off">
                            @if ($errors->has('productName'))
                                <span class="text-danger">{{ $errors->first('productName') }}</span>
                            @endif
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="quantity" placeholder="Quantity"
                                name="quantity" autocomplete="off">
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="rate" class="col-sm-3 control-label">Rate: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="rate" placeholder="Rate"
                                name="rate" autocomplete="off">
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="brandName" name="brandName">
                                <option value="">~~SELECT~~</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select type="text" class="form-control" id="categoryName" placeholder="Product Name"
                                name="categoryName">
                                <option value="">~~SELECT~~</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="productStatus" class="col-sm-3 control-label">Status: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="productStatus" name="productStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1">Available</option>
                                <option value="2">Not Available</option>
                            </select>
                        </div>
                    </div> <!-- /form-group-->
                </div> <!-- /modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                            class="glyphicon glyphicon-remove-sign"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="createProductBtn"
                        data-loading-text="Loading..." autocomplete="off"> <i
                            class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div> <!-- /modal-footer -->
            </form> <!-- /.form -->
        </div> <!-- /modal-content -->
    </div> <!-- /modal-dailog -->
</div>
@endcan
<!-- /add product -->

<!-- edit product -->
<div class="modal fade" tabindex="-1" role="dialog" id="editProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product</h4>
            </div>
            <div class="modal-body" style="max-height:450px; overflow:auto;">
                <div class="div-result">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#photo" aria-controls="home"
                                role="tab" data-toggle="tab">Photo</a></li>
                        <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab"
                                data-toggle="tab">Product Info</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="photo">
                            <form id="updateProductImageForm" onsubmit="updateProductImage(event)"
                                class="form-horizontal" enctype="multipart/form-data">
                                <br />
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="editProductId"
                                        placeholder="Product Name" name="editProductId">
                                    <label for="editProductImage" class="col-sm-3 control-label">Product Image:
                                    </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <img id="editProductImagePreview" alt="Product Image"
                                            style="width: 150px; height: 150px;">
                                    </div>
                                </div> <!-- /form-group-->
                                <div class="form-group">
                                    <label for="editProductImage" class="col-sm-3 control-label">Select Photo:
                                    </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <!-- the avatar markup -->
                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none;">
                                        </div>
                                        <div class="kv-avatar center-block">
                                            <input type="file" class="form-control" id="editProductImage"
                                                placeholder="Product Name" name="editProductImage"
                                                class="file-loading" style="width:auto;"
                                                onchange="previewEditProductImage(event)" />
                                        </div>
                                    </div>
                                </div> <!-- /form-group-->
                                <div class="modal-footer editProductPhotoFooter">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                                            class="glyphicon glyphicon-remove-sign"></i> Close</button>
                                    <button type="submit" class="btn btn-success" id="editProductImageBtn"
                                        data-loading-text="Loading...">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                                    </button>
                                </div>
                                <!-- /modal-footer -->
                            </form>
                            <!-- /form -->
                        </div>
                        <!-- product image -->
                        <div role="tabpanel" class="tab-pane" id="productInfo">
                            <form class="form-horizontal" id="editProductForm" onsubmit="updateProduct(event)"
                                method="POST">
                                <br />
                                <div id="edit-product-messages"></div>
                                <div class="form-group">
                                    <label for="editProductName" class="col-sm-3 control-label">Product Name: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editProductName"
                                            placeholder="Product Name" name="editProductName" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editQuantity" class="col-sm-3 control-label">Quantity: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editQuantity"
                                            placeholder="Quantity" name="editQuantity" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editRate" class="col-sm-3 control-label">Rate: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editRate" placeholder="Rate"
                                            name="editRate" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="editBrandName" name="editBrandName">
                                            <option value="">~~SELECT~~</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    @if ($brand->id == $product->brand_id) selected @endif>
                                                    {{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->


                                <div class="form-group">
                                    <label for="editCategoryName" class="col-sm-3 control-label">Category Name:
                                    </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control" id="editCategoryName"
                                            name="editCategoryName">
                                            <option value="">~~SELECT~~</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" selected="{{$category->id == $product->category_id}}">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="editProductStatus" name="editProductStatus">
                                            <option value="">~~SELECT~~</option>
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>
                                                Available
                                            </option>

                                            <option value="2" {{ $product->status == 2 ? 'selected' : '' }}>
                                                Not Available
                                            </option>
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="modal-footer editProductFooter">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                                            class="glyphicon glyphicon-remove-sign"></i> Close</button>
                                    <button type="submit" class="btn btn-success" id="editProductBtn"
                                        data-loading-text="Loading...">
                                        <i class="glyphicon glyphicon-ok-sign"></i> Save Changes
                                    </button>
                                </div> <!-- /modal-footer -->
                            </form> <!-- /.form -->
                        </div>
                        <!-- /product info -->
                    </div>
                </div>
            </div> <!-- /modal-body -->
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- /edit product -->

<!-- remove product -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Product</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="productIdToDelete" name="productIdToDelete">
                <p>Do you really want to remove ?</p>
            </div>
            <div class="modal-footer removeProductFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> Close</button>
                <button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."
                    onclick="removeProduct(document.getElementById('productIdToDelete').value)">
                    <i class="glyphicon glyphicon-ok-sign"></i> Save changes
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- remove product -->

<script>
    function previewAddProductImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var img = document.getElementById('addProductImagePreview');
            img.src = reader.result;
        };

        reader.readAsDataURL(input.files[0]);
    }

    function previewEditProductImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var img = document.getElementById('editProductImagePreview');
            img.src = reader.result;
        };

        reader.readAsDataURL(input.files[0]);
    }

    function updateProductImage(event) {
        event.preventDefault();
        var formData = new FormData(event.target);

        fetch('api/update-product-image/' + document.getElementById('editProductId').value, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to update product image');
                }
            })
            .then(data => {
                window.location.href = '/product';
            })
            .catch(error => {
                console.error('Failed to update product image:', error);
            });
    }

    function updateProduct(event) {
        event.preventDefault();
        var formData = new FormData(event.target);

        fetch('api/update-product/' + document.getElementById('editProductId').value, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to update product');
                }
            })
            .then(data => {
                window.location.href = '/product';
            })
            .catch(error => {
                console.error('Failed to update product:', error);
            });
    }

    function setProductId(productId) {
        document.getElementById('productIdToDelete').value = productId;
    }

    function removeProduct(id) {
        event.preventDefault();

        fetch('api/delete-product/' + id, {
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
                window.location.href = '/product';
            })
            .catch(error => {
                console.error('Failed to delete product:', error);
            });
    }

    function showEditProduct(id) {
        event.preventDefault();

        fetch('api/get-product/' + id, {
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
                var product = data.product;
                var productImageSrc = product.image;

                document.getElementById('editProductId').value = product.id;
                document.getElementById('editProductImagePreview').src = productImageSrc;
                document.getElementById('editProductName').value = product.name;
                document.getElementById('editQuantity').value = product.quantity;
                document.getElementById('editRate').value = product.rate;
                document.getElementById('editBrandName').value = product.brand.name;
                document.getElementById('editCategoryName').value = product.category.name;
                document.getElementById('editProductStatus').value = product.status;
                $('#editProductModal').modal('show');
            })
            .catch(error => {
                console.error('Failed to fetch product details:', error);
            });
    }
</script>

<x-footer />
