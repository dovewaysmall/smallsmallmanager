@extends('appcx')
@section('content')
@section('title', 'All Inspections')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Inspections(BuySmallSmall)</h4>
                    <span>
                    <a href="{{url('/inspections-last-month')}}" class="btn btn-warning btn-xxs shadow">Last Month</a>
                    <a href="{{url('/inspections-this-month')}}" class="btn btn-success btn-xxs shadow">This Month</a>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    {{-- <th>Email</th> --}}
                                    {{-- <th>Phone</th> --}}
                                    {{-- <th>Inspection ID</th> --}}
                                    <th>Property Name</th>
                                    <th>Status</th>
                                    {{-- <th>Remarks</th> --}}
                                    <th>View More</th>
                                                              
                                    {{-- <th>Customer Inspection Feedback</th>
                                    <th>CX Feedback Details</th> --}}
                                    
                                 
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allBuyInspections as $allBuyInspection)
                                <tr>
                                    <td><span style="display:none;">{{strtotime($allBuyInspection['date_of_entry'])}}</span>{{date('d-m-Y',strtotime($allBuyInspection['date_of_entry']))}}</td>
                                    
                                    <td>{{$allBuyInspection['firstName']}}</td>
                                    <td>{{$allBuyInspection['lastName']}}</td>
                                    <td><a href="{{url('https://buy.smallsmall.com/property/'.$allBuyInspection['propertyID'])}}" target="_blank" style="color: black !important">{{$allBuyInspection['property_name']}}</a></td>
                                    {{-- <td>{{$inspection['inspection_status']}}</td> --}}
                                    <td>@if($allBuyInspection['status'] == 'New')
                                        <a href="#" class="btn btn-primary btn-xxs shadow">New</a>
                                        @elseif($allBuyInspection['status'] == '')
                                        <a href="#" class="btn btn-danger btn-xxs shadow">Nil</a>
                                        @else
                                        @endif
                                    </td>
                                    <td><a href="{{ URL::to('single-buy-inspection/'.$allBuyInspection['id']) }}" class="btn btn-warning btn-xxs shadow">View More</a></td>

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