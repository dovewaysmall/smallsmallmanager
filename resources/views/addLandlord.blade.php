@extends('layouts.app')
@section('content')
@section('title', 'Add Landlord')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Landlord</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.rentsmallsmall.com/api/add-landlord-api" enctype="multipart/form-data">
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text" name="firstName" class="form-control input-rounded" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastName" class="form-control input-rounded" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control input-rounded" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control input-rounded" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control input-rounded" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="text" name="income" class="form-control input-rounded" placeholder="Income" required>
                            </div>
                            <div class="form-group">
                                <label>Referral</label>
                                <select class="form-control default-select" id="sel1" name="referral">
                                    <option value="twitter">Twitter</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="wom">WOM</option>
                                    <option value="television">Television</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Verified</label>
                                <select class="form-control default-select" id="sel1" name="verified">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Profile Pic</label>
                                <input type="file" name="profile_picture" class="form-control input-rounded">
                            </div>
                            <div class="form-group">
                                <input type="text" name="interest" class="form-control input-rounded" placeholder="Interest" required>
                            </div>
                            {{-- <div class="form-group">
                                <input type="text" name="frequency" class="form-control input-rounded" placeholder="Frequency">
                            </div> --}}
                            {{-- <div class="form-group">
                                <input type="date" name="regDate" class="form-control input-rounded">
                            </div> --}}
                            <button type="submit" class="btn btn-primary">Add Landlord</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection