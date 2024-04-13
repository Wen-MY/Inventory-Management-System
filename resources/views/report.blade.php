<x-header />
<script>
    function generateReport(event) {
        event.preventDefault();
        var formData = new FormData(event.target);

        fetch('api/generate-report/', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch report details');
                }
            })
            .then(data => {
                openReportWindow(data);
            })
            .catch(error => {
                console.error('Failed to fetch report details:', error);
            });
    }

    function openReportWindow(data) {
        var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');

        mywindow.document.write('<html><head><title>Order Report Slip</title></head><body>');

        mywindow.document.write('<h1>Order Report</h1>');
        mywindow.document.write('<table border="1" cellspacing="0" cellpadding="5">');
        mywindow.document.write('<tr><th>Order Date</th><th>Client Name</th><th>Contact</th><th>Grand Total</th></tr>');

        data.orders.forEach(order => {
            mywindow.document.write(
                `<tr><td>${order.date}</td><td>${order.client_name}</td><td>${order.client_contact}</td><td>${order.grand_total}</td></tr>`
            );
        });

        mywindow.document.write('</table>');

        mywindow.document.write(`<p>Total Amount: ${data.totalAmount}</p>`);

        mywindow.document.write('</body></html>');

        mywindow.document.close();

        mywindow.focus();
        setTimeout(function() {
            mywindow.print();
            mywindow.close();
        }, 2000);
    }
</script>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-check"></i> Order Report
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">
                <form class="form-horizontal" method="POST" onsubmit=generateReport(event) id="getOrderReportForm">
                    @csrf
                    <div class="form-group">
                        <label for="startDate" class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="startDate" name="startDate"
                                placeholder="Start Date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="endDate" class="col-sm-2 control-label">End Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="endDate" name="endDate"
                                placeholder="End Date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="generateReportBtn"> <i
                                    class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /panel-body -->
        </div>
    </div>
    <!-- /col-dm-12 -->
</div>
<!-- /row -->

<x-footer />
