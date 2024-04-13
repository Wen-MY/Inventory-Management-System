// var manageCategoriesTable;

// $(document).ready(function() {
// 	// active top navbar categories
// 	$('#navCategories').addClass('active');	

// 	manageCategoriesTable = $('#manageCategoriesTable').DataTable({
// 		'ajax' : 'php_action/fetchCategories.php',
// 		'order': []
// 	}); // manage categories Data Table

// 	// on click on submit categories form modal
// 	$('#addCategoriesModalBtn').unbind('click').bind('click', function() {
// 		// reset the form text
// 		$("#submitCategoriesForm")[0].reset();
// 		// remove the error text
// 		$(".text-danger").remove();
// 		// remove the form error
// 		$('.form-group').removeClass('has-error').removeClass('has-success');

// 		// submit categories form function
// 		$("#submitCategoriesForm").unbind('submit').bind('submit', function() {

// 			var categoriesName = $("#categoriesName").val();
// 			var categoriesStatus = $("#categoriesStatus").val();

// 			if(categoriesName == "") {
// 				$("#categoriesName").after('<p class="text-danger">Brand Name field is required</p>');
// 				$('#categoriesName').closest('.form-group').addClass('has-error');
// 			} else {
// 				// remov error text field
// 				$("#categoriesName").find('.text-danger').remove();
// 				// success out for form 
// 				$("#categoriesName").closest('.form-group').addClass('has-success');	  	
// 			}

// 			if(categoriesStatus == "") {
// 				$("#categoriesStatus").after('<p class="text-danger">Brand Name field is required</p>');
// 				$('#categoriesStatus').closest('.form-group').addClass('has-error');
// 			} else {
// 				// remov error text field
// 				$("#categoriesStatus").find('.text-danger').remove();
// 				// success out for form 
// 				$("#categoriesStatus").closest('.form-group').addClass('has-success');	  	
// 			}

// 			if(categoriesName && categoriesStatus) {
// 				var form = $(this);
// 				// button loading
// 				$("#createCategoriesBtn").button('loading');

// 				$.ajax({
// 					url : form.attr('action'),
// 					type: form.attr('method'),
// 					data: form.serialize(),
// 					dataType: 'json',
// 					success:function(response) {
// 						// button loading
// 						$("#createCategoriesBtn").button('reset');

// 						if(response.success == true) {
// 							// reload the manage member table 
// 							manageCategoriesTable.ajax.reload(null, false);						

// 	  	  			// reset the form text
// 							$("#submitCategoriesForm")[0].reset();
// 							// remove the error text
// 							$(".text-danger").remove();
// 							// remove the form error
// 							$('.form-group').removeClass('has-error').removeClass('has-success');
	  	  			
// 	  	  			$('#add-categories-messages').html('<div class="alert alert-success">'+
// 	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 		          '</div>');

// 	  	  			$(".alert-success").delay(500).show(10, function() {
// 								$(this).delay(3000).hide(10, function() {
// 									$(this).remove();
// 								});
// 							}); // /.alert
// 						}  // if

// 					} // /success
// 				}); // /ajax	
// 			} // if

// 			return false;
// 		}); // submit categories form function
// 	}); // /on click on submit categories form modal	

// }); // /document

// // edit categories function
// function editCategories(categoriesId = null) {
// 	if(categoriesId) {
// 		// remove the added categories id 
// 		$('#editCategoriesId').remove();
// 		// reset the form text
// 		$("#editCategoriesForm")[0].reset();
// 		// reset the form text-error
// 		$(".text-danger").remove();
// 		// reset the form group errro		
// 		$('.form-group').removeClass('has-error').removeClass('has-success');

// 		// edit categories messages
// 		$("#edit-categories-messages").html("");
// 		// modal spinner
// 		$('.modal-loading').removeClass('div-hide');
// 		// modal result
// 		$('.edit-categories-result').addClass('div-hide');
// 		//modal footer
// 		$(".editCategoriesFooter").addClass('div-hide');		

// 		$.ajax({
// 			url: 'php_action/fetchSelectedCategories.php',
// 			type: 'post',
// 			data: {categoriesId: categoriesId},
// 			dataType: 'json',
// 			success:function(response) {

// 				// modal spinner
// 				$('.modal-loading').addClass('div-hide');
// 				// modal result
// 				$('.edit-categories-result').removeClass('div-hide');
// 				//modal footer
// 				$(".editCategoriesFooter").removeClass('div-hide');	

// 				// set the categories name
// 				$("#editCategoriesName").val(response.categories_name);
// 				// set the categories status
// 				$("#editCategoriesStatus").val(response.categories_active);
// 				// add the categories id 
// 				$(".editCategoriesFooter").after('<input type="hidden" name="editCategoriesId" id="editCategoriesId" value="'+response.categories_id+'" />');


// 				// submit of edit categories form
// 				$("#editCategoriesForm").unbind('submit').bind('submit', function() {
// 					var categoriesName = $("#editCategoriesName").val();
// 					var categoriesStatus = $("#editCategoriesStatus").val();

// 					if(categoriesName == "") {
// 						$("#editCategoriesName").after('<p class="text-danger">Brand Name field is required</p>');
// 						$('#editCategoriesName').closest('.form-group').addClass('has-error');
// 					} else {
// 						// remov error text field
// 						$("#editCategoriesName").find('.text-danger').remove();
// 						// success out for form 
// 						$("#editCategoriesName").closest('.form-group').addClass('has-success');	  	
// 					}

// 					if(categoriesStatus == "") {
// 						$("#editCategoriesStatus").after('<p class="text-danger">Brand Name field is required</p>');
// 						$('#editCategoriesStatus').closest('.form-group').addClass('has-error');
// 					} else {
// 						// remov error text field
// 						$("#editCategoriesStatus").find('.text-danger').remove();
// 						// success out for form 
// 						$("#editCategoriesStatus").closest('.form-group').addClass('has-success');	  	
// 					}

// 					if(categoriesName && categoriesStatus) {
// 						var form = $(this);
// 						// button loading
// 						$("#editCategoriesBtn").button('loading');

// 						$.ajax({
// 							url : form.attr('action'),
// 							type: form.attr('method'),
// 							data: form.serialize(),
// 							dataType: 'json',
// 							success:function(response) {
// 								// button loading
// 								$("#editCategoriesBtn").button('reset');

// 								if(response.success == true) {
// 									// reload the manage member table 
// 									manageCategoriesTable.ajax.reload(null, false);									  	  			
									
// 									// remove the error text
// 									$(".text-danger").remove();
// 									// remove the form error
// 									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
// 			  	  			$('#edit-categories-messages').html('<div class="alert alert-success">'+
// 			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 				          '</div>');

// 			  	  			$(".alert-success").delay(500).show(10, function() {
// 										$(this).delay(3000).hide(10, function() {
// 											$(this).remove();
// 										});
// 									}); // /.alert
// 								}  // if

// 							} // /success
// 						}); // /ajax	
// 					} // if


// 					return false;
// 				}); // /submit of edit categories form

// 			} // /success
// 		}); // /fetch the selected categories data

// 	} else {
// 		alert('Oops!! Refresh the page');
// 	}
// } // /edit categories function

// // remove categories function
// function removeCategories(categoriesId = null) {
		
// 	$.ajax({
// 		url: 'php_action/fetchSelectedCategories.php',
// 		type: 'post',
// 		data: {categoriesId: categoriesId},
// 		dataType: 'json',
// 		success:function(response) {			

// 			// remove categories btn clicked to remove the categories function
// 			$("#removeCategoriesBtn").unbind('click').bind('click', function() {
// 				// remove categories btn
// 				$("#removeCategoriesBtn").button('loading');

// 				$.ajax({
// 					url: 'php_action/removeCategories.php',
// 					type: 'post',
// 					data: {categoriesId: categoriesId},
// 					dataType: 'json',
// 					success:function(response) {
// 						if(response.success == true) {
//  							// remove categories btn
// 							$("#removeCategoriesBtn").button('reset');
// 							// close the modal 
// 							$("#removeCategoriesModal").modal('hide');
// 							// update the manage categories table
// 							manageCategoriesTable.ajax.reload(null, false);
// 							// udpate the messages
// 							$('.remove-messages').html('<div class="alert alert-success">'+
// 	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 		          '</div>');

// 	  	  			$(".alert-success").delay(500).show(10, function() {
// 								$(this).delay(3000).hide(10, function() {
// 									$(this).remove();
// 								});
// 							}); // /.alert
//  						} else {
//  							// close the modal 
// 							$("#removeCategoriesModal").modal('hide');

//  							// udpate the messages
// 							$('.remove-messages').html('<div class="alert alert-success">'+
// 	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 		          '</div>');

// 	  	  			$(".alert-success").delay(500).show(10, function() {
// 								$(this).delay(3000).hide(10, function() {
// 									$(this).remove();
// 								});
// 							}); // /.alert
//  						} // /else
						
						
// 					} // /success function
// 				}); // /ajax function request server to remove the categories data
// 			}); // /remove categories btn clicked to remove the categories function

// 		} // /response
// 	}); // /ajax function to fetch the categories data
// } // remove categories function

$(document).ready(function() {
    // active top navbar categories
    $('#navCategories').addClass('active');

    // DataTable initialization
    var manageCategoriesTable = $('#manageCategoriesTable').DataTable({
        'ajax': {
            'url': '/get-categories',
            'type': 'GET',
        },
        'columns': [
            { 'data': 'name' },
            { 'data': 'status' },
            {
                'data': null,
                'render': function(data, type, row) {
                    return '<div class="btn-group">' +
                        '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                        'Action <span class="caret"></span>' +
                        '</button>' +
                        '<ul class="dropdown-menu">' +
                        '<li><a type="button" data-toggle="modal" id="editCategoryModalBtn" data-target="#editCategoriesModal" onclick="showEditCategory(' + row.id + ')"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>' +
                        '<li><a type="button" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoryModalBtn" onclick="removeCategory(' + row.id + ')"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>' +
                        '</ul>' +
                        '</div>';
                }
            }
        ]
    });

    // Add category modal button click event
    $('#addCategoryModalBtn').click(function() {
        $('#add-categories-messages').html('');
        $('#submitCategoriesForm')[0].reset();
        $('#submitCategoriesForm').unbind('submit').bind('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            console.log("Form Data:", formData); // Log form data to verify it
            $.ajax({
                url: '/create-categories',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("Response:", response); // Log response data
                    if (response.message === 'Category created successfully.') {
                        $('#addCategoriesModal').modal('hide');
                        manageCategoriesTable.ajax.reload(null, false);
                    }
                    $('#add-categories-messages').html('<div class="alert alert-' + (response.message === 'Category created successfully.' ? 'success' : 'danger') + '">' +
                        response.message +
                        '</div>');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error); // Log AJAX error
                }
            });
        });
    });

    // Edit category modal button click event
    $('#editCategoryModalBtn').click(function() {
        $('#edit-categories-messages').html('');
        $('#editCategoriesForm')[0].reset();
        var categoryId = $(this).data('id');
        $.ajax({
            url: '/get-categories/' + categoryId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.message === 'Category retrieved successfully.') {
                    $('#editCategoriesName').val(response.data.name);
                    $('#editCategoriesStatus').val(response.data.status);
                    $('#editCategoriesForm').unbind('submit').bind('submit', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        $.ajax({
                            url: '/edit-categories/' + categoryId,
                            type: 'POST',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.message === 'Category updated successfully.') {
                                    $('#editCategoriesModal').modal('hide');
                                    manageCategoriesTable.ajax.reload(null, false);
                                }
                                $('#edit-categories-messages').html('<div class="alert alert-' + (response.message === 'Category updated successfully.' ? 'success' : 'danger') + '">' +
                                    response.message +
                                    '</div>');
                            }
                        });
                    });
                }
            }
        });
    });

    // Remove category modal button click event
    $('#removeCategoryModalBtn').click(function() {
        var categoryId = $(this).data('id');
        $('#removeCategoriesBtn').unbind('click').bind('click', function() {
            $.ajax({
                url: '/delete-categories/' + categoryId,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.message === 'Category deleted successfully.') {
                        $('#removeCategoriesModal').modal('hide');
                        manageCategoriesTable.ajax.reload(null, false);
                    }
                    $('.remove-messages').html('<div class="alert alert-' + (response.message === 'Category deleted successfully.' ? 'success' : 'danger') + '">' +
                        response.message +
                        '</div>');
                }
            });
        });
    });
});
