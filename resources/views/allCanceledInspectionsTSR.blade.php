@extends('appcx')
@section('content')
@section('title', 'Canceled Inspections')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Canceled Inspections TSR</h4>
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
                                    {{-- <th>Inspection ID</th> --}}
                                    <th>Property Name</th>
                                    <th>Inspection Type</th>
                                    {{-- <th>User ID</th> --}}
                                    <th>Client Proposed Date</th>
                                    <th>Updated Inspection Date</th>
                                    <th>Inspection Status</th>
                                    <th>Remarks</th>
                                    <th>Comment</th>
                                    
                                    
                                 
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{Auth::user()->parent_id}} --}}
                                {{-- @php
                                    dd($allInspectionsTSR)
                                @endphp --}}
                                @foreach ($allCanceledInspectionsTSR as $inspection)
                                {{-- @php
                                    dd($inspection)
                                @endphp --}}
                                    @if(($inspection['assigned_tsr'] == (Auth::user()->parent_id)) && ($inspection['inspection_status'] == 'canceled'))
                                        <tr>
                                            <td><span style="display:none;">{{strtotime($inspection['dateOfEntry'])}}</span>{{date('d-m-Y',strtotime($inspection['dateOfEntry']))}}</td>
                                            <td>{{$inspection['lastName'].' '.$inspection['firstName']}}</td>
                                            <td><a href="tel:{{$inspection['phone']}}" style="color: blue">{{$inspection['phone']}}</a></td>
                                            {{-- <td>{{$inspection['inspectionID']}}</td> --}}
                                            <td><a href="{{url('https://rent.smallsmall.com/property/'.$inspection['propertyID'])}}" target="_blank" style="color: black !important">{{$inspection['propertyTitle']}}</a></td>
                                            <td>{{$inspection['inspectionType']}}</td>
                                            {{-- <td>{{$inspection['userID']}}</td> --}}
                                            <td>{{date('d-m-Y',strtotime($inspection['inspectionDate']))}}</td>
                                            <td>
                                                @if($inspection['updated_inspection_date'] == '0000-00-00 00:00:00' || $inspection['updated_inspection_date'] == '')
                                                Not Updated
                                                @else
                                                {{$inspection['updated_inspection_date']}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($inspection['inspection_status'] == 'pending-assigned')
                                                <a href="{{ URL::to('pending-inspection/'.$inspection['id']) }}" class="btn btn-primary btn-xxs shadow">Pending(Assigned)</a>
                                                @elseif($inspection['inspection_status'] == 'completed')
                                                <a href="{{ URL::to('pending-inspection/'.$inspection['id']) }}" class="btn btn-success btn-xxs shadow">Completed</a>
                                                @elseif($inspection['inspection_status'] == 'canceled')
                                                <a href="{{ URL::to('pending-inspection/'.$inspection['id']) }}" class="btn btn-danger btn-xxs shadow">Canceled</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($inspection['inspection_remarks'] == 'interested')
                                                <a href="#" class="btn btn-success btn-xxs shadow">Interested</a>
                                                @elseif($inspection['inspection_remarks'] == 'uninterested')
                                                <a href="#" class="btn btn-danger btn-xxs shadow">Uninterested</a>
                                                @elseif($inspection['inspection_remarks'] == 'indecisive')
                                                <a href="#" class="btn btn-warning btn-xxs shadow">Indecisive</a>
                                                @endif
                                            </td>
                                            <td>{{$inspection['comment']}}</td>
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