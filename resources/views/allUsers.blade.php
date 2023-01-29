@extends('appcx')
@section('content')
@section('title', 'All Users')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    {{-- <th>Email</th> --}}
                                    {{-- <th>Phone</th> --}}
                                    {{-- <th>Profile</th> --}}
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allUsers as $user)
                                <tr>
                                    
                                    <td>{{$user['userID']}}</td>
                                    <td>{{$user['firstName'].' '.$user['lastName'] }}</td>
                                    {{-- <td>{{$tenant['email']}}</td> --}}
                                    {{-- <td>{{$tenant['phone']}}</td> --}}
                                    {{-- <td><a href="{{ URL::to('tenant/'.$user['userID']) }}" class="btn btn-primary btn-xxs shadow">View</a></td> --}}
                                    
                                    
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