@extends('appcx')
@section('content')
@section('title', 'All Landlord')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Landlords</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allLandlord as $landlord)
                                <tr>
                                    
                                    <td>{{$landlord['userID']}}</td>
                                    <td>{{$landlord['firstName'].' '.$landlord['lastName'] }}</td>
                                    <td>{{$landlord['email']}}</td>
                                    <td>*********</td>
                                    
                                    
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