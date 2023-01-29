@extends('appcx')
@section('content')
@section('title', 'All Verifications')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Verifications</h4>
                </div>

                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table shadow-hover display responsive nowrap" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Verification ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gross Annual Income</th>
                                    <th>Employment Status</th>
                                    <th>Status</th>
                                    <th>Profile</th>
                                    {{-- <th>Birth Place</th>
                                    <th>DOB</th>
                                    <th>Marital Status</th>
                                    <th>Present Address</th>
                                    <th>Duration at Present Address</th>
                                    <th>Current Renting Status</th>
                                    <th>Disability</th>
                                    <th>Pets</th>
                                    <th>Present Landlord</th>
                                    <th>Landlord's Email</th>
                                    <th>Landlord's Phone</th>
                                    <th>Landlord's Address</th>
                                    <th>Reason for Leaving</th>
                                    
                                    <th>Occupation</th>
                                    <th>Company Name</th>
                                    <th>Company Address</th>
                                    <th>HR Manager's Name</th>
                                    <th>HR Manager's Email</th>
                                    <th>Office Phone</th>
                                    <th>Guarantor's Name</th>
                                    <th>Guarantor's Email</th>
                                    <th>Guarantor's Phone</th>
                                    <th>Guarantor's Occupation</th>
                                    <th>Guarantor's Address</th> --}}
                                    {{-- <th>Profile</th> --}}
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allVerifications as $verification)
                                <tr>
                                    
                                    <td>{{date('d-m-Y',strtotime($verification['verifications_date']))}}</td>
                                    <td>{{$verification['verification_id']}}</td>
                                    <td>{{$verification['firstName']}}</td>
                                    <td>{{$verification['lastName']}}</td>
                                    <td>&#x20A6;{{$verification['gross_annual_income']}}</td>
                                    @if($verification['employment_status'] == 'Employed')
                                    <td><a href="#nogo" class="btn btn-success btn-xxs shadow">{{$verification['employment_status']}}</a></td>
                                    @else
                                    <td><a href="#nogo" class="btn btn-warning btn-xxs shadow">Unemployed</a></td>
                                    @endif

                                    @php 
                                        $role = Auth::user()->role;
                                    @endphp 
                                    @if($role == '6')
                                        @if($verification['verified'] == 'yes')
                                        <td><a href="{{ URL::to('tenant-verification/'.$verification['veriID']) }}" class="btn btn-success btn-xxs shadow">Verified</a></td>
                                        @elseif($verification['verified'] == 'no')
                                        <td><a href="{{ URL::to('tenant-verification/'.$verification['veriID']) }}" class="btn btn-danger btn-xxs shadow">Not Verified</a></td>
                                        @elseif($verification['verified'] == 'processing')
                                        <td><a href="{{ URL::to('tenant-verification/'.$verification['veriID']) }}" class="btn btn-warning btn-xxs shadow">Processing</a></td>
                                        @elseif($verification['verified'] == 'received')
                                        <td><a href="{{ URL::to('tenant-verification/'.$verification['veriID']) }}" class="btn btn-primary btn-xxs shadow">Received</a></td>
                                        @else 
                                        @endif
                                    @else
                                        @if($verification['verified'] == 'yes')
                                        <td><a href="#nogo" class="btn btn-success btn-xxs shadow">Verified</a></td>
                                        @elseif($verification['verified'] == 'no')
                                        <td><a href="#nogo" class="btn btn-danger btn-xxs shadow">Not Verified</a></td>
                                        @elseif($verification['verified'] == 'processing')
                                        <td><a href="#nogo" class="btn btn-warning btn-xxs shadow">Processing</a></td>
                                        @elseif($verification['verified'] == 'received')
                                        <td><a href="#nogo" class="btn btn-primary btn-xxs shadow">Received</a></td>
                                        @else 
                                        @endif
                                    @endif
                                    <td><a href="{{ URL::to('verification-profile/'.$verification['veriID']) }}" class="btn btn-primary btn-xxs shadow">View More</a></td>
                                    {{-- <td>{{date('d-m-Y',strtotime($verification['dob']))}}</td> --}}
                                    {{-- <td>{{$verification['marital_status']}}</td> --}}
                                    {{-- <td>{{$verification['present_address']}}</td> --}}
                                    {{-- <td>{{$verification['duration_present_address']}}</td> --}}
                                    {{-- <td>{{$verification['current_renting_status']}}</td> --}}
                                    {{-- <td>{{$verification['disability']}}</td> --}}
                                    {{-- <td>{{$verification['pets']}}</td> --}}
                                    {{-- <td>{{$verification['present_landlord']}}</td> --}}
                                    {{-- <td>{{$verification['landlord_email']}}</td> --}}
                                    {{-- <td>{{$verification['landlord_phone']}}</td> --}}
                                    {{-- <td>{{$verification['landlord_address']}}</td> --}}
                                    {{-- <td>{{$verification['reason_for_living']}}</td> --}}
                                    {{-- <td>{{$verification['employment_status']}}</td> --}}
                                    {{-- <td>{{$verification['occupation']}}</td> --}}
                                    {{-- <td>{{$verification['company_name']}}</td> --}}
                                    {{-- <td>{{$verification['company_address']}}</td> --}}
                                    {{-- <td>{{$verification['hr_manager_name']}}</td> --}}
                                    {{-- <td>{{$verification['hr_manager_email']}}</td> --}}
                                    {{-- <td>{{$verification['office_phone']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_name']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_email']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_phone']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_occupation']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_address']}}</td> --}}
                                    {{-- <td>{{$verification['guarantor_occupation']}}</td>
                                    <td>{{$verification['guarantor_occupation']}}</td>
                                    <td>{{$verification['guarantor_occupation']}}</td> --}}
                                    {{-- <td><a href="#">View</a></td> --}}
                                    
                                    
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