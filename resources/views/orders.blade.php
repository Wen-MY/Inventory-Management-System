@include('php_action.db_connect')
<x-header />

@if(request()->has('o') && request()->o == 'add')
    <div class="div-request div-hide">add</div>
@elseif(request()->has('o') && request()->o == 'manord')
    <div class="div-request div-hide">manord</div>
@elseif(request()->has('o') && request()->o == 'editOrd')
    <div class="div-request div-hide">editOrd</div>
@endif

<ol class="breadcrumb">
    <li><a href="{{ url('dashboard') }}">Home</a></li>
    <li>Order</li>
    <li class="active">
        @if(request()->has('o') && request()->o == 'add')
            Add Order
        @elseif(request()->has('o') && request()->o == 'manord')
            Manage Order
        @endif
    </li>
</ol>

<h4>
    <i class='glyphicon glyphicon-circle-arrow-right'></i>
    @if(request()->has('o') && request()->o == 'add')
        Add Order
    @elseif(request()->has('o') && request()->o == 'manord')
        Manage Order
    @elseif(request()->has('o') && request()->o == 'editOrd')
        Edit Order
    @endif
</h4>

<div class="panel panel-default">
    <div class="panel-heading">
        @if(request()->has('o') && request()->o == 'add')
            <i class="glyphicon glyphicon-plus-sign"></i> Add Order
        @elseif(request()->has('o') && request()->o == 'manord')
            <i class="glyphicon glyphicon-edit"></i> Manage Order
        @elseif(request()->has('o') && request()->o == 'editOrd')
            <i class="glyphicon glyphicon-edit"></i> Edit Order
        @endif
    </div>

    <div class="panel-body">
        @if(request()->has('o') && request()->o == 'add')
            <div class="success-messages"></div>

            <form class="form-horizontal" method="POST" action="{{ url('php_action/createOrder.php') }}" id="createOrderForm">
                @csrf
                <div class="form-group">
                    <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="clientName" class="col-sm-2 control-label">Client Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" />
                    </div>
                </div>

                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th style="width:40%;">Product</th>
                            <th style="width:20%;">Rate</th>
                            <th style="width:10%;">Available Quantity</th>
                            <th style="width:15%;">Quantity</th>
                            <th style="width:25%;">Total</th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productData as $product)
                            <tr id="row{{ $loop->iteration }}">
                                <td style="margin-left:20px;">
                                    <div class="form-group">
                                        <select class="form-control" name="productName[]" id="productName{{ $loop->iteration }}" onchange="getProductData({{ $loop->iteration }})">
                                            <option value="">~~SELECT~~</option>
                                            @foreach($productData as $row)
                                                <option value="{{ $row->product_id }}" id="changeProduct{{ $row->product_id }}">{{ $row->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td style="padding-left:20px;">
                                    <input type="text" name="rate[]" id="rate{{ $loop->iteration }}" autocomplete="off" disabled="true" class="form-control" />
                                    <input type="hidden" name="rateValue[]" id="rateValue{{ $loop->iteration }}" autocomplete="off" class="form-control" />
                                </td>
                                <td style="padding-left:20px;">
                                    <div class="form-group">
                                        <p id="available_quantity{{ $loop->iteration }}"></p>
                                    </div>
                                </td>
                                <td style="padding-left:20px;">
                                    <div class="form-group">
                                        <input type="number" name="quantity[]" id="quantity{{ $loop->iteration }}" onkeyup="getTotal({{ $loop->iteration }})" autocomplete="off" class="form-control" min="1" />
                                    </div>
                                </td>
                                <td style="padding-left:20px;">
                                    <input type="text" name="total[]" id="total{{ $loop->iteration }}" autocomplete="off" class="form-control" disabled="true" />
                                    <input type="hidden" name="totalValue[]" id="totalValue{{ $loop->iteration }}" autocomplete="off" class="form-control" />
                                </td>
                                <td>
                                    <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow({{ $loop->iteration }})"><i class="glyphicon glyphicon-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-6">
            <div class="form-group">
                <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
                    <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                </div>
            </div>

            <div class="form-group">
                <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" />
                    <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
                </div>
            </div>

            <div class="form-group">
                <label for="discount" class="col-sm-3 control-label">Discount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
                </div>
            </div>

            <div class="form-group">
                <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
                    <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
                </div>
            </div>

            <div class="form-group">
                <label for="vat" class="col-sm-3 control-label gst">GST 18%</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="vat" name="gstn" readonly="true" />
                    <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" />
                </div>
            </div>

            <div class="form-group">
                <label for="due" class="col-sm-3 control-label">Due Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="due" name="due" disabled="true" />
                    <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
                </div>
            </div>

            <div class="form-group">
                <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
                <div class="col-sm-9">
                    <select class="form-control" name="paymentType" id="paymentType">
                        <option value="">~~SELECT~~</option>
                        <option value="1">Cheque</option>
                        <option value="2">Cash</option>
                        <option value="3">Credit Card</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
                <div class="col-sm-9">
                    <select class="form-control" name="paymentStatus" id="paymentStatus">
                        <option value="">~~SELECT~~</option>
                        <option value="1">Full Payment</option>
                        <option value="2">Advance Payment</option>
                        <option value="3">No Payment</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
                <div class="col-sm-9">
                    <select class="form-control" name="paymentPlace" id="paymentPlace">
                        <option value="">~~SELECT~~</option>
                        <option value="1">In Gujarat</option>
                        <option value="2">Out Of Gujarat</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group submitButtonFooter">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                <button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Reset</button>
            </div>
        </div>
        </form>
        @if ($_GET['o'] == 'manord')
    {{-- manage order --}}
    <div id="success-messages"></div>
    
    <table class="table" id="manageOrderTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Order Date</th>
                <th>Client Name</th>
                <th>Contact</th>
                <th>Total Order Item</th>
                <th>Payment Status</th>
                <th>Option</th>
            </tr>
        </thead>
    </table>
@elseif ($_GET['o'] == 'editOrd')
    {{-- edit order --}}
    <div class="success-messages"></div>

    <form class="form-horizontal" method="POST" action="{{ route('editOrder') }}" id="editOrderForm">
        @php
            $orderId = $_GET['i'];
            $sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status, orders.payment_place, orders.gstn FROM orders WHERE orders.order_id = {$orderId}";
            $result = $connect->query($sql);
            $data = $result->fetch_row();
        @endphp

        <div class="form-group">
            <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="{{ $data[1] }}" />
            </div>
        </div>

        <div class="form-group">
            <label for="clientName" class="col-sm-2 control-label">Client Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" value="{{ $data[2] }}" />
            </div>
        </div>

        <div class="form-group">
            <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" value="{{ $data[3] }}" />
            </div>
        </div>

        <table class="table" id="productTable">
            <thead>
                <tr>
                    <th style="width:40%;">Product</th>
                    <th style="width:20%;">Rate</th>
                    <th style="width:15%;">Available Quantity</th>
                    <th style="width:15%;">Quantity</th>
                    <th style="width:15%;">Total</th>
                    <th style="width:10%;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
                    $orderItemResult = $connect->query($orderItemSql);
                    $arrayNumber = 0;
                    $x = 1;
                @endphp
                @while ($orderItemData = $orderItemResult->fetch_array())
                    <tr id="row{{ $x }}" class="{{ $arrayNumber }}">
                        <td style="margin-left:20px;">
                            <div class="form-group">
                                <select class="form-control" name="productName[]" id="productName{{ $x }}" onchange="getProductData({{ $x }})">
                                    <option value="">~~SELECT~~</option>
                                    @php
                                        $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
                                        $productData = $connect->query($productSql);
                                    @endphp
                                    @while ($row = $productData->fetch_array())
                                        @php
                                            $selected = ($row['product_id'] == $orderItemData['product_id']) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $row['product_id'] }}" id="changeProduct{{ $row['product_id'] }}" {{ $selected }}>{{ $row['product_name'] }}</option>
                                    @endwhile
                                </select>
                            </div>
                        </td>
                        <!-- Add other table cells and PHP logic here -->
                    </tr>
                    @php
                        $arrayNumber++;
                        $x++;
                    @endphp
                @endwhile
            </tbody>
        </table>
        <div class="col-md-6">
            <div class="form-group">
                <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="{{ $data[4] }}" />
                    <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="{{ $data[4] }}" />
                </div>
            </div> <!--/form-group-->			  
            <div class="form-group">
                <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="{{ $data[6] }}" />
                    <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="{{ $data[6] }}" />
                </div>
            </div> <!--/form-group-->			  
            <div class="form-group">
                <label for="discount" class="col-sm-3 control-label">Discount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="{{ $data[7] }}" />
                </div>
            </div> <!--/form-group-->	
            <div class="form-group">
                <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="{{ $data[8] }}" />
                    <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="{{ $data[8] }}" />
                </div>
            </div> <!--/form-group-->	
            <div class="form-group">
                <label for="vat" class="col-sm-3 control-label gst">{{ ($data[13] == 2) ? "IGST 18%" : "GST 18%" }}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="{{ $data[5] }}" />
                    <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="{{ $data[5] }}" />
                </div>
            </div> 
            <div class="form-group">
                <label for="gstn" class="col-sm-3 control-label gst">G.S.T.IN</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="gstn" name="gstn" value="{{ $data[14] }}" />
                </div>
            </div><!--/form-group-->		  		  
        </div> <!--/col-md-6-->

        <div class="col-md-6">
            <div class="form-group">
                <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="{{ $data[9] }}" />
                </div>
            </div> <!--/form-group-->			  
            <div class="form-group">
                <label for="due" class="col-sm-3 control-label">Due Amount</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="due" name="due" disabled="true" value="{{ $data[10] }}" />
                    <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="{{ $data[10] }}" />
                </div>
            </div> <!--/form-group-->		
            <div class="form-group">
    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
    <div class="col-sm-9">
        <select class="form-control" name="paymentType" id="paymentType">
            <option value="">~~SELECT~~</option>
            @if ($data[11] == 1)
                <option value="1" selected>Cheque</option>
            @else
                <option value="1">Cheque</option>
            @endif
            @if ($data[11] == 2)
                <option value="2" selected>Cash</option>
            @else
                <option value="2">Cash</option>
            @endif
            @if ($data[11] == 3)
                <option value="3" selected>Credit Card</option>
            @else
                <option value="3">Credit Card</option>
            @endif
        </select>
    </div>
</div> <!--/form-group-->

        <div class="form-group">
            <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
            <div class="col-sm-9">
                <select class="form-control" name="paymentStatus" id="paymentStatus">
                    <option value="">~~SELECT~~</option>
                    @if ($data[12] == 1)
                        <option value="1" selected>Full Payment</option>
                    @else
                        <option value="1">Full Payment</option>
                    @endif
                    @if ($data[12] == 2)
                        <option value="2" selected>Advance Payment</option>
                    @else
                        <option value="2">Advance Payment</option>
                    @endif
                    @if ($data[12] == 3)
                        <option value="3" selected>No Payment</option>
                    @else
                        <option value="3">No Payment</option>
                    @endif
                </select>
            </div>
        </div> <!--/form-group-->

        <div class="form-group">
            <label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
            <div class="col-sm-9">
                <select class="form-control" name="paymentPlace" id="paymentPlace">
                    <option value="">~~SELECT~~</option>
                    @if ($data[13] == 1)
                        <option value="1" selected>In Gujarat</option>
                    @else
                        <option value="1">In Gujarat</option>
                    @endif
                    @if ($data[13] == 2)
                        <option value="2" selected>Out Gujarat</option>
                    @else
                        <option value="2">Out Gujarat</option>
                    @endif
                </select>
            </div>
        </div>
        </div> <!--/col-md-6-->

        <div class="form-group editButtonFooter">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
                <input type="hidden" name="orderId" id="orderId" value="{{ $_GET['i'] }}" />
                <button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;">

      	<div class="paymentOrderMessages"></div>
      	     				 				 
		<div class="form-group">
			<label for="due" class="col-sm-3 control-label">Due Amount</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="due" name="due" disabled="true" />					
			</div>
		</div> <!--/form-group-->		
		<div class="form-group">
			<label for="payAmount" class="col-sm-3 control-label">Pay Amount</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="payAmount" name="payAmount"/>					      
			</div>
		</div> <!--/form-group-->		
		<div class="form-group">
			<label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
			<div class="col-sm-9">
				<select class="form-control" name="paymentType" id="paymentType">
					<option value="">~~SELECT~~</option>
					<option value="1">Cheque</option>
					<option value="2">Cash</option>
					<option value="3">Credit Card</option>
				</select>
			</div>
		</div> <!--/form-group-->							  
		<div class="form-group">
			<label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
			<div class="col-sm-9">
				<select class="form-control" name="paymentStatus" id="paymentStatus">
					<option value="">~~SELECT~~</option>
					<option value="1">Full Payment</option>
					<option value="2">Advance Payment</option>
					<option value="3">No Payment</option>
				</select>
			</div>
		</div> <!--/form-group-->							  				  
      	        
      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>	
      </div>           
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Order</h4>
      </div>
      <div class="modal-body">
      	<div class="removeOrderMessages"></div>
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->

<script src="{{ asset('custom/js/order.js') }}"></script>

<x-footer />



