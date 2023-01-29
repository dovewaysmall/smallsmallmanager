@extends('appcx')
@section('content')
@section('title', 'All Tenants')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Tenants</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Account Manager</th>
                                    <th>Profile</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $role = Auth::user()->role;
                                @endphp

                                @foreach ($allTenants as $tenant)
                                <tr>
                                    
                                    <td>{{$tenant['userID']}}</td>
                                    <td>{{$tenant['firstName'].' '.$tenant['lastName'] }}</td>
                                    <td>
                                        @if($tenant['rent_status'] == 'Vacant')
                                        <a href="#nogo" class="btn btn-danger btn-xxs shadow">{{$tenant['rent_status']}}</a></td>
                                        @else 
                                        <a href="#nogo" class="btn btn-success btn-xxs shadow">{{$tenant['rent_status']}}</a></td>
                                        @endif

                                    @if($role == '1' || Auth::user()->id == 5 || Auth::user()->id == 21)
                                        @if($tenant['account_manager'] == NULL)
                                        <td><a href="{{ URL::to('assign-account-manager/'.$tenant['userID']) }}" class="btn btn-primary btn-xxs shadow">Not Assigned</a></td>
                                        @else
                                        <td><a href="{{ URL::to('assign-account-manager/'.$tenant['userID']) }}" class="btn btn-success btn-xxs shadow">Assigned</a></td>
                                        @endif
                                    @else 
                                        @if($tenant['account_manager'] == NULL)
                                        <td><a href="#" class="btn btn-primary btn-xxs shadow">Not Assigned</a></td>
                                        @else
                                        <td><a href="#" class="btn btn-success btn-xxs shadow">Assigned</a></td>
                                        @endif
                                    @endif

                                    <td><a href="{{ URL::to('tenant/'.$tenant['userID']) }}" class="btn btn-primary btn-xxs shadow">View</a></td>
                                    
                                    
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
@endsection