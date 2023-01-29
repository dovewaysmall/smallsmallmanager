@extends('appcx')
@section('content')
@section('title', 'All Stay Bookings')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Stay Bookings</h4>
                    <span>
                    {{-- <a href="{{url('/inspections-last-month')}}" class="btn btn-warning btn-xxs shadow">Last Month</a> --}}
                    {{-- <a href="{{url('/inspections-this-month')}}" class="btn btn-success btn-xxs shadow">This Month</a> --}}
                    </span>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table shadow-hover display responsive nowrap" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Number of Guests</th>
                                    <th>Apartment</th>
                                    <th>Check in</th>
                                    <th>Check out</th>
                                    <th>View More</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($staySmallSmallAllBookings as $staySmallSmallAllBooking)
                                <tr>
                                    <td><span style="display:none;">{{strtotime($staySmallSmallAllBooking['date_of_booking'])}}</span>{{date('d-m-Y',strtotime($staySmallSmallAllBooking['date_of_booking']))}}</td>
                                    <td>{{$staySmallSmallAllBooking['lastname'].' '.$staySmallSmallAllBooking['firstname']}}</td>
                                    <td>{{$staySmallSmallAllBooking['phone']}}</td>
                                    <td>{{$staySmallSmallAllBooking['email']}}</td>
                                     <td align="center">{{$staySmallSmallAllBooking['guests']}}</td>                 
                                     <td align="center">{{$staySmallSmallAllBooking['apartmentName']}}</td>                 
                                     <td>{{date('d-m-Y',strtotime($staySmallSmallAllBooking['checkin']))}}</td>                 
                                     <td>{{date('d-m-Y',strtotime($staySmallSmallAllBooking['checkout']))}}</td> 
                                     <td><a href="{{ URL::to('single-staysmallsmall-booking/'.$staySmallSmallAllBooking['id']) }}" class="btn btn-primary btn-xxs shadow">View More</a></td>
                
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#datatable').dataTable( {
        // responsive: true
        "scrollX": true,
        order: [],
} );
</script>
@endsection