// var manageBrandTable;

// $(document).ready(function() {
// 	// top bar active
// 	$('#navBrand').addClass('active');
	
// 	// manage brand table
// 	manageBrandTable = $("#manageBrandTable").DataTable({
// 		'ajax': 'php_action/fetchBrand.php',
// 		'order': []		
// 	});

// 	// submit brand form function
// 	$("#submitBrandForm").unbind('submit').bind('submit', function() {
// 		// remove the error text
// 		$(".text-danger").remove();
// 		// remove the form error
// 		$('.form-group').removeClass('has-error').removeClass('has-success');			

// 		var brandName = $("#brandName").val();
// 		var brandStatus = $("#brandStatus").val();

// 		if(brandName == "") {
// 			$("#brandName").after('<p class="text-danger">Brand Name field is required</p>');
// 			$('#brandName').closest('.form-group').addClass('has-error');
// 		} else {
// 			// remov error text field
// 			$("#brandName").find('.text-danger').remove();
// 			// success out for form 
// 			$("#brandName").closest('.form-group').addClass('has-success');	  	
// 		}

// 		if(brandStatus == "") {
// 			$("#brandStatus").after('<p class="text-danger">Brand Name field is required</p>');

// 			$('#brandStatus').closest('.form-group').addClass('has-error');
// 		} else {
// 			// remov error text field
// 			$("#brandStatus").find('.text-danger').remove();
// 			// success out for form 
// 			$("#brandStatus").closest('.form-group').addClass('has-success');	  	
// 		}

// 		if(brandName && brandStatus) {
// 			var form = $(this);
// 			// button loading
// 			$("#createBrandBtn").button('loading');

// 			$.ajax({
// 				url : form.attr('action'),
// 				type: form.attr('method'),
// 				data: form.serialize(),
// 				dataType: 'json',
// 				success:function(response) {
// 					// button loading
// 					$("#createBrandBtn").button('reset');

// 					if(response.success == true) {
// 						// reload the manage member table 
// 						manageBrandTable.ajax.reload(null, false);						

//   	  			// reset the form text
// 						$("#submitBrandForm")[0].reset();
// 						// remove the error text
// 						$(".text-danger").remove();
// 						// remove the form error
// 						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
//   	  			$('#add-brand-messages').html('<div class="alert alert-success">'+
//             '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
//             '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
//           '</div>');

//   	  			$(".alert-success").delay(500).show(10, function() {
// 							$(this).delay(3000).hide(10, function() {
// 								$(this).remove();
// 							});
// 						}); // /.alert
// 					}  // if

// 				} // /success
// 			}); // /ajax	
// 		} // if

// 		return false;
// 	}); // /submit brand form function

// });

// function editBrands(brandId = null) {
// 	if(brandId) {
// 		// remove hidden brand id text
// 		$('#brandId').remove();

// 		// remove the error 
// 		$('.text-danger').remove();
// 		// remove the form-error
// 		$('.form-group').removeClass('has-error').removeClass('has-success');

// 		// modal loading
// 		$('.modal-loading').removeClass('div-hide');
// 		// modal result
// 		$('.edit-brand-result').addClass('div-hide');
// 		// modal footer
// 		$('.editBrandFooter').addClass('div-hide');

// 		$.ajax({
// 			url: 'php_action/fetchSelectedBrand.php',
// 			type: 'post',
// 			data: {brandId : brandId},
// 			dataType: 'json',
// 			success:function(response) {
// 				// modal loading
// 				$('.modal-loading').addClass('div-hide');
// 				// modal result
// 				$('.edit-brand-result').removeClass('div-hide');
// 				// modal footer
// 				$('.editBrandFooter').removeClass('div-hide');

// 				// setting the brand name value 
// 				$('#editBrandName').val(response.brand_name);
// 				// setting the brand status value
// 				$('#editBrandStatus').val(response.brand_active);
// 				// brand id 
// 				$(".editBrandFooter").after('<input type="hidden" name="brandId" id="brandId" value="'+response.brand_id+'" />');

// 				// update brand form 
// 				$('#editBrandForm').unbind('submit').bind('submit', function() {

// 					// remove the error text
// 					$(".text-danger").remove();
// 					// remove the form error
// 					$('.form-group').removeClass('has-error').removeClass('has-success');			

// 					var brandName = $('#editBrandName').val();
// 					var brandStatus = $('#editBrandStatus').val();

// 					if(brandName == "") {
// 						$("#editBrandName").after('<p class="text-danger">Brand Name field is required</p>');
// 						$('#editBrandName').closest('.form-group').addClass('has-error');
// 					} else {
// 						// remov error text field
// 						$("#editBrandName").find('.text-danger').remove();
// 						// success out for form 
// 						$("#editBrandName").closest('.form-group').addClass('has-success');	  	
// 					}

// 					if(brandStatus == "") {
// 						$("#editBrandStatus").after('<p class="text-danger">Brand Name field is required</p>');

// 						$('#editBrandStatus').closest('.form-group').addClass('has-error');
// 					} else {
// 						// remove error text field
// 						$("#editBrandStatus").find('.text-danger').remove();
// 						// success out for form 
// 						$("#editBrandStatus").closest('.form-group').addClass('has-success');	  	
// 					}

// 					if(brandName && brandStatus) {
// 						var form = $(this);

// 						// submit btn
// 						$('#editBrandBtn').button('loading');

// 						$.ajax({
// 							url: form.attr('action'),
// 							type: form.attr('method'),
// 							data: form.serialize(),
// 							dataType: 'json',
// 							success:function(response) {

// 								if(response.success == true) {
// 									console.log(response);
// 									// submit btn
// 									$('#editBrandBtn').button('reset');

// 									// reload the manage member table 
// 									manageBrandTable.ajax.reload(null, false);								  	  										
// 									// remove the error text
// 									$(".text-danger").remove();
// 									// remove the form error
// 									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
// 			  	  			$('#edit-brand-messages').html('<div class="alert alert-success">'+
// 			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 			          '</div>');

// 			  	  			$(".alert-success").delay(500).show(10, function() {
// 										$(this).delay(3000).hide(10, function() {
// 											$(this).remove();
// 										});
// 									}); // /.alert
// 								} // /if
									
// 							}// /success
// 						});	 // /ajax												
// 					} // /if

// 					return false;
// 				}); // /update brand form

// 			} // /success
// 		}); // ajax function

// 	} else {
// 		alert('error!! Refresh the page again');
// 	}
// } // /edit brands function

// function removeBrands(brandId = null) {
// 	if(brandId) {
// 		$('#removeBrandId').remove();
// 		$.ajax({
// 			url: 'php_action/fetchSelectedBrand.php',
// 			type: 'post',
// 			data: {brandId : brandId},
// 			dataType: 'json',
// 			success:function(response) {
// 				$('.removeBrandFooter').after('<input type="hidden" name="removeBrandId" id="removeBrandId" value="'+response.brand_id+'" /> ');

// 				// click on remove button to remove the brand
// 				$("#removeBrandBtn").unbind('click').bind('click', function() {
// 					// button loading
// 					$("#removeBrandBtn").button('loading');

// 					$.ajax({
// 						url: 'php_action/removeBrand.php',
// 						type: 'post',
// 						data: {brandId : brandId},
// 						dataType: 'json',
// 						success:function(response) {
// 							console.log(response);
// 							// button loading
// 							$("#removeBrandBtn").button('reset');
// 							if(response.success == true) {

// 								// hide the remove modal 
// 								$('#removeMemberModal').modal('hide');

// 								// reload the brand table 
// 								manageBrandTable.ajax.reload(null, false);
								
// 								$('.remove-messages').html('<div class="alert alert-success">'+
// 			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
// 			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
// 			          '</div>');

// 			  	  			$(".alert-success").delay(500).show(10, function() {
// 										$(this).delay(3000).hide(10, function() {
// 											$(this).remove();
// 										});
// 									}); // /.alert
// 							} else {

// 							} // /else
// 						} // /response messages
// 					}); // /ajax function to remove the brand

// 				}); // /click on remove button to remove the brand

// 			} // /success
// 		}); // /ajax

// 		$('.removeBrandFooter').after();
// 	} else {
// 		alert('error!! Refresh the page again');
// 	}
// } // /remove brands function

$(document).ready(function() {
    // active top navbar brands
    $('#navBrands').addClass('active');

    // DataTable initialization
    var manageBrandsTable = $('#manageBrandsTable').DataTable({
        'ajax': {
            'url': '/get-brands',
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
                        '<li><a type="button" data-toggle="modal" id="editBrandModalBtn" data-target="#editBrandModal" onclick="showEditBrand(' + row.id + ')"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>' +
                        '<li><a type="button" data-toggle="modal" data-target="#removeBrandModal" id="removeBrandModalBtn" onclick="removeBrand(' + row.id + ')"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>' +
                        '</ul>' +
                        '</div>';
                }
            }
        ]
    });

    // Add brand modal button click event
    $('#addBrandModalBtn').click(function() {
        $('#add-brands-messages').html('');
        $('#submitBrandForm')[0].reset();
        $('#submitBrandForm').unbind('submit').bind('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            console.log("Form Data:", formData); // Log form data to verify it
            $.ajax({
                url: '/create-brand',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("Response:", response); // Log response data
                    if (response.message === 'Brand created successfully.') {
                        $('#addBrandModal').modal('hide');
                        manageBrandsTable.ajax.reload(null, false);
                    }
                    $('#add-brands-messages').html('<div class="alert alert-' + (response.message === 'Brand created successfully.' ? 'success' : 'danger') + '">' +
                        response.message +
                        '</div>');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error); // Log AJAX error
                }
            });
        });
    });

    // Edit brand modal button click event
    $('#editBrandModalBtn').click(function() {
        $('#edit-brands-messages').html('');
        $('#editBrandForm')[0].reset();
        var brandId = $(this).data('id');
        $.ajax({
            url: '/get-brands/' + brandId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.message === 'Brand retrieved successfully.') {
                    $('#editBrandName').val(response.data.name);
                    $('#editBrandStatus').val(response.data.status);
                    $('#editBrandForm').unbind('submit').bind('submit', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        $.ajax({
                            url: '/edit-brands/' + brandId,
                            type: 'POST',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.message === 'Brand updated successfully.') {
                                    $('#editBrandModal').modal('hide');
                                    manageBrandsTable.ajax.reload(null, false);
                                }
                                $('#edit-brands-messages').html('<div class="alert alert-' + (response.message === 'Brand updated successfully.' ? 'success' : 'danger') + '">' +
                                    response.message +
                                    '</div>');
                            }
                        });
                    });
                }
            }
        });
    });

    // Remove brand modal button click event
    $('#removeBrandModalBtn').click(function() {
        var brandId = $(this).data('id');
        $('#removeBrandBtn').unbind('click').bind('click', function() {
            $.ajax({
                url: '/delete-brands/' + brandId,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.message === 'Brand deleted successfully.') {
                        $('#removeBrandModal').modal('hide');
                        manageBrandsTable.ajax.reload(null, false);
                    }
                    $('.remove-messages').html('<div class="alert alert-' + (response.message === 'Brand deleted successfully.' ? 'success' : 'danger') + '">' +
                        response.message +
                        '</div>');
                }
            });
        });
    });
});
