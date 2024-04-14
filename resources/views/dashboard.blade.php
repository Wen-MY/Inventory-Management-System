<x-header />
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>

<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.print.css') }}" media="print">

<div class="row">
    @if(session('user'))
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <a href="{{ url('product') }}" style="text-decoration:none;color:black;">
                        Total Product
                        <span class="badge pull pull-right" id="countProduct">{{ $countProduct }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <a href="{{ url('product') }}" style="text-decoration:none;color:black;">
                        Low Stock
                        <span class="badge pull pull-right" id="countLowStock">{{ $countLowStock }}</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{ url('orders?o=manord') }}" style="text-decoration:none;color:black;">
                    Total Orders
                    <span class="badge pull pull-right" id="countOrder">{{ $countOrder }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="cardHeader">
                <h1>{{ date('d') }}</h1>
            </div>

            <div class="cardContainer">
                <p>{{ date('l') .' '. date('d') .', '. date('Y') }}</p>
            </div>
        </div>
        <br/>

        <div class="card">
            <div class="cardHeader" style="background-color:#245580;">
                <h1 id="totalRevenue">{{ $totalRevenue ? $totalRevenue : '0' }}</h1>
            </div>

            <div class="cardContainer">
                <p>INR Total Revenue</p>
            </div>
        </div>
    </div>

    @if(session('user'))
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-calendar"></i> User Wise Order
                </div>
                <div class="panel-body">
                    <table class="table" id="productTable">
                        <thead>
                            <tr>
                                <th style="width:40%;">Name</th>
                                <th style="width:20%;">Orders in Rupees</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userwiseQuery as $orderResult)
                                <tr>
                                    <td>{{ $orderResult->username }}</td>
                                    <td>{{ $orderResult->totalorder }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        $('#navDashboard').addClass('active');

        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: '',
                center: 'title'
            },
            buttonText: {
                today: 'today',
                month: 'month'
            }
        });
    });
</script>

<x-footer />
