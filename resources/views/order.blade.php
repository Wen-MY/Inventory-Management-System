<x-header />
<script src="{{ asset('/js/order.js') }}"></script>
<script>
    function getToken() {
        return localStorage.getItem('token');
    }

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    function fetchOrderToUpdate(id) {
        fetch('api/get-order/' + id, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + getToken(), // Include bearer token
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'include'
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch order details');
                }
            })
            .then(data => {
                var order = data.order;

                document.getElementById('orderDate').value = order.date;
                document.getElementById('clientName').value = order.client_name;
                document.getElementById('clientContact').value = order.client_contact;
                document.getElementById('subTotal').value = order.sub_total;
                document.getElementById('subTotalValue').value = order.sub_total;
                document.getElementById('totalAmount').value = order.total_amount;
                document.getElementById('totalAmountValue').value = order.total_amount;
                document.getElementById('discount').value = order.discount;
                document.getElementById('grandTotal').value = order.grand_total;
                document.getElementById('grandTotalValue').value = order.grand_total;
                document.getElementById('vat').value = order.vat;
                document.getElementById('vatValue').value = order.vat;
                document.getElementById('gstn').value = order.gstn;
                document.getElementById('paid').value = order.paid;
                document.getElementById('due').value = order.due;
                document.getElementById('dueValue').value = order.due;
                document.getElementById('hiddenPaymentType').value = order.payment_type;
                document.getElementById('hiddenPaymentStatus').value = order.payment_status;
                document.getElementById('hiddenPaymentPlace').value = order.payment_place;

                var hiddenPaymentType = document.getElementById('hiddenPaymentType').value;
                var paymentTypeSelect = document.getElementById('paymentTypeSelect');
                var hiddenPaymentStatus = document.getElementById('hiddenPaymentStatus').value;
                var paymentPaymentSelect = document.getElementById('paymentPaymentSelect');
                var hiddenPaymentPlace = document.getElementById('hiddenPaymentPlace').value;
                var paymentPlaceSelect = document.getElementById('paymentPlaceSelect');

                for (var i = 0; i < paymentTypeSelect.options.length; i++) {
                    if (paymentTypeSelect.options[i].value == hiddenPaymentType) {
                        paymentTypeSelect.options[i].selected = true;
                        break;
                    }
                }

                for (var i = 0; i < paymentStatusSelect.options.length; i++) {
                    if (paymentStatusSelect.options[i].value == hiddenPaymentStatus) {
                        paymentStatusSelect.options[i].selected = true;
                        break;
                    }
                }

                for (var i = 0; i < paymentPlaceSelect.options.length; i++) {
                    if (paymentPlaceSelect.options[i].value == hiddenPaymentPlace) {
                        paymentPlaceSelect.options[i].selected = true;
                        break;
                    }
                }

                var products = @json($products);
                console.log(products);

            })
            .catch(error => {
                console.error('Failed to fetch order details:', error);
            });
    }

    function updateOrder(event) {
        event.preventDefault();
        var formData = new FormData(event.target);

        var orderId = getUrlParameter('i');

        fetch('api/update-order/' + orderId, {
                method: 'POST',
                body: formData,
                headers: {
                    'Authorization': 'Bearer ' + getToken(), // Include bearer token
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'include'
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to update order');
                }
            })
            .then(data => {
                window.location.href = '/orders?o=manord'; // Redirect to the orders page after successful update
            })
            .catch(error => {
                console.error('Failed to update order:', error);
            });
    }

    function getTotal(input) {
        var row = input.parentNode.parentNode.parentNode; // Get the parent <tr> element
        var rate = row.querySelector("[name='rate[]']").value; // Get the rate value
        var quantity = input.value; // Get the quantity value

        var total = rate * quantity;

        row.querySelector("[name='total[]']").value = total;
        row.querySelector("[name='totalValue[]']").value = total;

        var subTotal = 0;
        document.querySelectorAll("[name='total[]']").forEach(function(totalInput) {
            subTotal += parseFloat(totalInput.value || 0);
        });

        document.getElementById("subTotal").value = subTotal.toFixed(2);
        document.getElementById("subTotalValue").value = subTotal.toFixed(2);

        var discount = parseFloat(document.getElementById("discount").value || 0);
        var totalAmount = subTotal - discount;
        var gst = totalAmount * 0.18;
        var grandTotal = totalAmount + gst;
        var paid = parseFloat(document.getElementById("paid").value || 0);
        var due = grandTotal - paid;

        document.getElementById("totalAmount").value = totalAmount.toFixed(2);
        document.getElementById("totalAmountValue").value = totalAmount.toFixed(2);

        document.getElementById("grandTotal").value = grandTotal.toFixed(2);
        document.getElementById("grandTotalValue").value = grandTotal.toFixed(2);

        // Update the GST input field
        document.getElementById("vat").value = gst.toFixed(2);
        document.getElementById("vatValue").value = gst.toFixed(2);

        // Update the due amount input field
        document.getElementById("due").value = due.toFixed(2);
        document.getElementById("dueValue").value = due.toFixed(2);
    }

    function updateRate(select) {
        var selectedOption = select.options[select.selectedIndex];
        var rateField = select.closest('tr').querySelector("input[name='rate[]']");
        var hiddenRateField = select.closest('tr').querySelector("input[name='rateValue[]']");
        var availableQuantityField = select.closest('tr').querySelector("input[name='availableQuantity[]']");

        if (selectedOption.value !== '') {
            var rate = selectedOption.getAttribute('data-rate');
            var availableQuantity = selectedOption.getAttribute('data-availableQuantity');
            rateField.value = rate;
            hiddenRateField.value = rate;
            availableQuantityField.value = availableQuantity;
        } else {
            rateField.value = '';
            hiddenRateField.value = '';
            availableQuantityField.value = '';
        }
    }

    function setOrderId(orderId) {
        document.getElementById('orderIdToDelete').value = orderId;
    }

    function removeOrder(id) {
        event.preventDefault();

        fetch('api/delete-order/' + id, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + getToken(), // Include bearer token
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'include'
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to delete order');
                }
            })
            .then(data => {
                window.location.href = '/orders?o=manord';
            })
            .catch(error => {
                console.error('Failed to delete order:', error);
            });
    }

    var orderId = getUrlParameter('i');
    fetchOrderToUpdate(orderId);

    function addRow() {
        var table = document.getElementById("productTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);

        cell1.innerHTML = `<div class="form-group">
                            <select class="form-control" name="productName[]" onchange="updateRate(this)">
                                <option value="">~~SELECT~~</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-rate="{{ $product->rate }}" data-availableQuantity="{{ $product->quantity }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>`;
        cell1.style.paddingLeft = "22px"; // Apply padding-left style
        cell1.style.paddingRight = "20px";
        cell2.innerHTML =
            `<input type="text" name="rate[]" id="rate[]" autocomplete="off" disabled="true" class="form-control" />
                        <input type="hidden" name="rateValue[]" id="rateValue[]" autocomplete="off" class="form-control" />`;

        cell3.innerHTML = ` <td style="padding-left:22px; padding-right:22px;">
                            <input type="text" name="availableQuantity[]" id="availableQuantity[]" autocomplete="off" disabled="true" class="form-control" />
                            <input type="hidden" name="availableQuantityValue[]" id="availableQuantityValue[]" autocomplete="off" class="form-control" />
                        </td>`;

        cell4.innerHTML = `<div class="form-group">
                            <input type="number" name="quantity[]" id="quantity[]" onkeyup="getTotal(this)" autocomplete="off" class="form-control" min="1" />
                        </div>`;
        cell4.style.paddingLeft = "20px"; // Apply padding-left style
        cell4.style.paddingRight = "25px"; // Apply padding-right style

        cell5.innerHTML = `<div class="form-group">
                            <input type="text" name="total[]" id="total[]" autocomplete="off" class="form-control" disabled="true" />
                            <input type="hidden" name="totalValue[]" id="totalValue[]" autocomplete="off" class="form-control" />
                        </div>`;
        cell5.style.paddingLeft = "20px"; // Apply padding-left style
    }

    function createOrder(event) {
        event.preventDefault();
        var userId = {{ auth()->user()->id }};
        var form = document.getElementById('createOrderForm');

        var formData = new FormData(form);
        formData.append('user_id', userId);

        fetch('api/create-order', {
                method: 'POST',
                body: formData,
                headers: {
                    'Authorization': 'Bearer ' + getToken(), // Include bearer token
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'include'

            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to submit form');
                }
            })
            .then(data => {
                window.location.href = '/orders?o=add';
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    }
</script>

@if (request()->has('o') && request()->o == 'add')
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
        @if (request()->has('o') && request()->o == 'add')
            Add Order
        @elseif(request()->has('o') && request()->o == 'manord')
            Manage Order
        @endif
    </li>
</ol>

<h4>
    <i class='glyphicon glyphicon-circle-arrow-right'></i>
    @if (request()->has('o') && request()->o == 'add')
        Add Order
    @elseif(request()->has('o') && request()->o == 'manord')
        Manage Order
        @can('update', $orders)
        @elseif(request()->has('o') && request()->o == 'editOrd')
            Edit Order
        @endcan
    @endif
</h4>

<div class="panel panel-default">
    <div class="panel-heading">
        @if (request()->has('o') && request()->o == 'add')
            <i class="glyphicon glyphicon-plus-sign"></i> Add Order
        @elseif(request()->has('o') && request()->o == 'manord')
            <i class="glyphicon glyphicon-edit"></i> Manage Order
            @can('update', $orders)
            @elseif(request()->has('o') && request()->o == 'editOrd')
                <i class="glyphicon glyphicon-edit"></i> Edit Order
            @endcan
        @endif

    </div>

    @if (request()->has('o') && request()->o == 'add')
        <div class="success-messages"></div>

        <form class="form-horizontal" method="POST" onsubmit=createOrder(event) id="createOrderForm">
            @csrf
            <div class="form-group">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
                <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="orderDate" name="orderDate" placeholder="Order Date"
                        autocomplete="off" />
                </div>
            </div>

            <div class="form-group">
                <label for="clientName" class="col-sm-2 control-label">Client Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="clientName" name="clientName"
                        placeholder="Client Name" autocomplete="off" />
                </div>
            </div>

            <div class="form-group">
                <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="clientContact" name="clientContact"
                        placeholder="Contact Number" autocomplete="off" />
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
                    <tr>
                        <td style="padding-left:22px; padding-right:20px;">
                            <div class="form-group">
                                <select class="form-control" name="productName[]" onchange="updateRate(this)">
                                    <option value="">~~SELECT~~</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-rate="{{ $product->rate }}"
                                            data-availableQuantity="{{ $product->quantity }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="rate[]" id="rate[]" autocomplete="off" disabled="true"
                                class="form-control" />
                            <input type="hidden" name="rateValue[]" id="rateValue[]" autocomplete="off"
                                class="form-control" />
                        </td>
                        <td>
                            <input type="text" name="availableQuantity[]" id="availableQuantity[]" autocomplete="off"
                                disabled="true" class="form-control" />
                            <input type="hidden" name="availableQuantityValue[]" id="availableQuantityValue[]"
                                autocomplete="off" class="form-control" />
                        </td>
                        <td style="padding-left:20px; padding-right:25px;">
                            <div class="form-group">
                                <input type="number" name="quantity[]" id="quantity[]" onkeyup="getTotal(this)"
                                    autocomplete="off" class="form-control" min="1" />
                            </div>
                        </td>
                        <td style="padding-left:20px;">
                            <div class="form-group">
                                <input type="text" name="total[]" id="total[]" autocomplete="off"
                                    class="form-control" disabled="true" />
                                <input type="hidden" name="totalValue[]" id="totalValue[]" autocomplete="off"
                                    class="form-control" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subTotal" name="subTotal"
                            disabled="true" />
                        <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="totalAmount" name="totalAmount"
                            disabled="true" />
                        <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="discount" class="col-sm-3 control-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="discount" name="discount"
                            onkeyup="discountFunc()" autocomplete="off" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="grandTotal" name="grandTotal"
                            disabled="true" />
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
                        <input type="text" class="form-control" id="paid" name="paid" autocomplete="off"
                            onkeyup="paidAmount()" />
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
                    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn"
                        data-loading-text="Loading...">
                        <i class="glyphicon glyphicon-plus-sign"></i> Add Row
                    </button>
                    <button type="submit" id="createOrderBtn" data-loading-text="Loading..."
                        class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                    <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i
                            class="glyphicon glyphicon-erase"></i> Reset</button>
                </div>
            </div>
        </form>
    @elseif (request()->has('o') && request()->o == 'manord')
        <table class="table" id="manageOrderTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Date</th>
                    <th>Client Name</th>
                    <th>Contact</th>
                    <th>Total Order Item</th>
                    <th>Payment Status</th>
                    @can('update', $orders)
                        <!-- Pass the $order instance -->
                        <th id="option">Option</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->client_contact }}</td>
                        <td>{{ $itemCounts[$order->id] ?? 0 }}</td>
                        <td>
                            @if ($order->payment_status == 1)
                                <label class="label label-success">Full Payment</label>
                            @elseif($order->payment_status == 2)
                                <label class="label label-info">Advanced Payment</label>
                            @elseif($order->payment_status == 3)
                                <label class="label label-danger">No Payment</label>
                            @endif
                        </td>
                        <td>
                            @can('update', $order)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li><a href="orders?o=editOrd&i={{ $order->id }}" id="editOrderModalBtn"><i
                                                    class="glyphicon glyphicon-edit"></i>
                                                Edit</a></li>

                                        <li><a type="button" data-toggle="modal" data-target="#removeOrderModal"
                                                id="removeOrderModalBtn" onclick="setOrderId({{ $order->id }})">
                                                <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                                    </ul>
                                </div>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- @can('update', $orders) --}}
    @elseif (request()->has('o') && request()->o == 'editOrd')
        <form class="form-horizontal" method="POST" onsubmit="updateOrder(event)" id="editOrderForm">
            <div class="form-group">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
                <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="orderDate" name="orderDate"
                        autocomplete="off" />
                </div>
            </div>

            <div class="form-group">
                <label for="clientName" class="col-sm-2 control-label">Client Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="clientName" name="clientName"
                        placeholder="Client Name" autocomplete="off" />
                </div>
            </div>

            <div class="form-group">
                <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="clientContact" name="clientContact"
                        placeholder="Contact Number" autocomplete="off" />
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
                    @foreach ($orderItems as $orderItem)
                        <tr>
                            <td style="padding-left:22px; padding-right:20px;">
                                <div class="form-group">
                                    <input type="hidden" name="orderItemId[]" value="{{ $orderItem->id }}">
                                    <select class="form-control" name="productName[]" onchange="updateRate(this)">
                                        <option value="">~~SELECT~~</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-rate="{{ $product->rate }}"
                                                {{ $product->id == $orderItem->product_id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="rate[]" id="rate[]" autocomplete="off"
                                    disabled="true" class="form-control" value="{{ $orderItem->product->rate }}" />
                                <input type="hidden" name="rateValue[]" id="rateValue[]" autocomplete="off"
                                    class="form-control" value="{{ $orderItem->product->rate }}" />
                            </td>
                            <td style="padding-left:22px;">
                                <div class="form-group">
                                    {{ $orderItem->product->quantity - $orderItem->quantity }}
                                </div>
                            </td>
                            <td style="padding-left:20px; padding-right:25px;">
                                <div class="form-group">
                                    <input type="number" name="quantity[]" id="quantity[]" onkeyup="getTotal(this)"
                                        autocomplete="off" class="form-control" min="1"
                                        value="{{ $orderItem->quantity }}" />
                                </div>
                            </td>
                            <td style="padding-left:20px;">
                                <div class="form-group">
                                    <input type="text" name="total[]" id="total[]" autocomplete="off"
                                        class="form-control" disabled="true" value="{{ $orderItem->total }}" />
                                    <input type="hidden" name="totalValue[]" id="totalValue[]" autocomplete="off"
                                        class="form-control" value="{{ $orderItem->total }}" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subTotal" name="subTotal"
                            disabled="true" />
                        <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="totalAmount" name="totalAmount"
                            disabled="true" />
                        <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="discount" class="col-sm-3 control-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="discount" name="discount"
                            onkeyup="discountFunc()" autocomplete="off" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="grandTotal" name="grandTotal"
                            disabled="true" />
                        <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="vat" class="col-sm-3 control-label gst">
                        GST 18%
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="vat" name="vat" disabled="true" />
                        <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="gstn" class="col-sm-3 control-label gst">G.S.T.IN</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="gstn" name="gstn" />
                    </div>
                </div><!--/form-group-->
            </div> <!--/col-md-6-->

            <div class="col-md-6">
                <div class="form-group">
                    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="paid" name="paid" autocomplete="off"
                            onkeyup="paidAmount()" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="due" class="col-sm-3 control-label">Due Amount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="due" name="due" disabled="true" />
                        <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
                    <input type="hidden" class="form-control" id="hiddenPaymentType" name="hiddenPaymentType" />
                    <div class="col-sm-9">
                        <select class="form-control" name="paymentTypeSelect" id="paymentTypeSelect">
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
                        <input type="hidden" class="form-control" id="hiddenPaymentStatus"
                            name="hiddenPaymentStatus" />
                        <select class="form-control" name="paymentStatusSelect" id="paymentStatusSelect">
                            <option value="">~~SELECT~~</option>
                            <option value="1">Full Payment</option>
                            <option value="2">Advanced Payment</option>
                            <option value="3">No Payment</option>
                        </select>
                    </div>
                </div> <!--/form-group-->

                <div class="form-group">
                    <label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
                    <div class="col-sm-9">
                        <input type="hidden" class="form-control" id="hiddenPaymentPlace"
                            name="hiddenPaymentPlace" />
                        <select class="form-control" name="paymentPlaceSelect" id="paymentPlaceSelect">
                            <option value="">~~SELECT~~</option>
                            <option value="1">In Gujarat</option>
                            <option value="2">Out Gujarat</option>
                        </select>
                    </div>
                </div>
            </div> <!--/col-md-6-->

            <div class="form-group editButtonFooter">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" id="editOrderBtn" data-loading-text="Loading..."
                        class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save
                        Changes</button>
                </div>
            </div>
        </form>
        {{-- @endcan --}}
</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
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
                        <input type="text" class="form-control" id="payAmount" name="payAmount" />
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
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> Close</button>
                <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn"
                    data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->
@endif

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Order</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="orderIdToDelete" name="orderIdToDelete">
                <p>Do you really want to remove ?</p>
            </div>
            <div class="modal-footer removeOrderFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> Close</button>
                <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."
                    onclick="removeOrder(document.getElementById('orderIdToDelete').value)">
                    <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<x-footer />
