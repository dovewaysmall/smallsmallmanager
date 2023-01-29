@extends('layouts.app')
@section('content')
@section('title', 'All Landlord')

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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Profile</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($convertedTenants as $ctenant)
                                <tr>
                                    
                                    <td>{{$ctenant['userID']}}</td>
                                    <td>{{$ctenant['firstName'].' '.$ctenant['lastName'] }}</td>
                                    <td>{{$ctenant['email']}}</td>
                                    <td>{{$ctenant['phone']}}</td>
                                    <td><a href="#">View</a></td>
                                    
                                    
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