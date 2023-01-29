@extends('appcx')
@section('content')
@section('title', 'Canceled Inspections Last Month')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Canceled Inspections Last Month</h4>
                    <span>
                        <a href="{{url('/all-inspections')}}" class="btn btn-warning btn-xxs shadow">All Inspections</a>
                        <a href="{{url('/canceled-inspections-this-month')}}" class="btn btn-success btn-xxs shadow">This Month</a>
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
                                    {{-- <th>Email</th> --}}
                                    {{-- <th>Phone</th> --}}
                                    {{-- <th>Inspection ID</th> --}}
                                    <th>Property Name</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>View More</th>
                                    @php 
                                        $role = Auth::user()->role;
                                        if($role == '1' || Auth::user()->id == '6'){
                                            echo '<th>Edit</th>';
                                        }
                                    // CX Dashboard
                                    @endphp
                                                                     
                                 
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($canceledInspectionsLastMonth as $inspection)
                                @if($inspection['inspection_status'] == 'canceled')
                                <tr>
                                    
                                        <td><span style="display:none;">{{strtotime($inspection['dateOfEntry'])}}</span>{{date('d-m-Y',strtotime($inspection['dateOfEntry']))}}</td>
                                        <td>{{$inspection['lastName'].' '.$inspection['firstName']}}</td>
                                                        
                                        <td>{{$inspection['propertyTitle']}}</td>
                                        {{-- <td>{{$inspection['inspection_status']}}</td> --}}
                                        <td><a href="#" class="btn btn-danger btn-xxs shadow">Canceled</a></td>

                                        <td>
                                            @if($inspection['inspection_remarks'] == 'interested')
                                            <a href="#" class="btn btn-success btn-xxs shadow">Interested</a>
                                            @elseif($inspection['inspection_remarks'] == 'uninterested')
                                            <a href="#" class="btn btn-danger btn-xxs shadow">Uninterested</a>
                                            @elseif($inspection['inspection_remarks'] == 'indecisive')
                                            <a href="#" class="btn btn-warning btn-xxs shadow">Indecisive</a>
                                            @elseif($inspection['inspection_remarks'] == '')
                                            <a href="#" class="btn btn-primary btn-xxs shadow">Not Updated</a>
                                            @endif
                                        </td>
                                        <td><a href="{{ URL::to('single-inspection/'.$inspection['id']) }}" class="btn btn-warning btn-xxs shadow">View More</a></td>

                                        @if($role == '1' || Auth::user()->id == '6')
                                        <td><a href="{{ URL::to('inspection/'.$inspection['id']) }}" class="btn btn-primary btn-xxs shadow">Assign</a></td>      
                                        @endif
                                    

                                </tr>
                                @endif
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