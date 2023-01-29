@extends('layouts.app')
@section('content')
@section('title', 'Add Property')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Property</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.rentsmallsmall.com/api/add-property-api">
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text" name="propertyTitle" class="form-control input-rounded" placeholder="Property Title" required>
                            </div>
                            <div class="form-group">
                                <textarea name="propertyDescription" rows="5" class="form-control" placeholder="Property Description"></textarea>
                                {{-- <input type="text" name="lastName" class="form-control input-rounded" placeholder="Last Name" required> --}}
                            </div>
                            <div class="form-group">
                                <input type="text" name="rentalCondition" class="form-control input-rounded" placeholder="Rental Condition">
                            </div>
                            <div class="form-group">
                                <input type="text" name="furnishing" class="form-control input-rounded" placeholder="Furnishing" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="price" class="form-control input-rounded" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <input type="text" name="serviceCharge" class="form-control input-rounded" placeholder="Service Charge" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="securityDeposit" class="form-control input-rounded" placeholder="Security Deposit" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="securityDepositTerm" class="form-control input-rounded" placeholder="Security Deposit Term" required>
                            </div>
                            <div class="form-group">
                                <label>Verification</label>
                                <select class="form-control default-select" id="sel1" name="verification">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="propertyType" class="form-control input-rounded" placeholder="Property Type" required>
                            </div>
                            <div class="form-group">
                                <textarea name="renting_as" rows="5" class="form-control" placeholder="Renting As"></textarea>
                                {{-- <input type="text" name="lastName" class="form-control input-rounded" placeholder="Last Name" required> --}}
                            </div>
                            <div class="form-group">
                                <input type="text" name="paymentPlan" class="form-control input-rounded" placeholder="Payment Plan" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="frequency" class="form-control input-rounded" placeholder="Frequency" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="intervals" class="form-control input-rounded" placeholder="Intervals" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="amenities" class="form-control input-rounded" placeholder="Amenities" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="services" class="form-control input-rounded" placeholder="Services" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="bed" class="form-control input-rounded" placeholder="Bed" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="bath" class="form-control input-rounded" placeholder="Bath" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="toilet" class="form-control input-rounded" placeholder="Toilet" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control input-rounded" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="city" class="form-control input-rounded" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="state" class="form-control input-rounded" placeholder="State" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="country" class="form-control input-rounded" placeholder="Country" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="zip" class="form-control input-rounded" placeholder="Zip" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="status" class="form-control input-rounded" placeholder="Status" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="poster" class="form-control input-rounded" placeholder="Poster" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="featured_property" class="form-control input-rounded" placeholder="Featured Property" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="managed_by" class="form-control input-rounded" placeholder="Managed By" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="property_owner" class="form-control input-rounded" placeholder="Property Owner" required>
                            </div>
                            <div class="form-group">
                                <label>Available Date</label>
                                <input type="date" name="available_date" class="form-control input-rounded">
                                {{-- <input type="text" name="featured_property" class="form-control input-rounded" placeholder="Featured Property" required> --}}
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Add Property</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection