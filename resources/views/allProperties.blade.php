@extends('appcx')
@section('content')
@section('title', 'All Properties')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Properties</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Property ID</th>
                                    <th>Title</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Rental Condition</th>
                                    <th>Furnishing</th>
                                    <th>Price</th>
                                    <th>Service Charge</th>
                                    <th>Security Deposit</th>
                                    <th>Security Deposit Term</th>
                                    <th>Verification</th>
                                    <th>Property Type</th>
                                    {{-- <th>Renting As</th> --}}
                                    <th>Payment Plan</th>
                                    {{-- <th>Frequency</th>     --}}
                                    {{-- <th>Intervals</th>     --}}
                                    {{-- <th>Amenities</th>     --}}
                                    <th>Services</th>    
                                    <th>Bed</th>    
                                    <th>Bath</th>    
                                    <th>Toilet</th>    
                                    <th>Address</th>    
                                    <th>City</th>    
                                    <th>State</th>    
                                    <th>Country</th>    
                                    <th>Zip</th>    
                                    <th>Status</th>    
                                    <th>Poster</th>    
                                    <th>Views</th>    
                                    <th>Featured Property</th>        
                                    <th>Managed By</th>    
                                    <th>Property Owner</th>    
                                    <th>Available Date</th>    
                                    <th>Date of Entry</th>    
                                </tr>
                            </thead>
                            <tbody>  
                                @foreach ($allProperties as $property)
                                <tr>
                                    <td>{{$property['propertyID']}}</td>
                                    <td>{{$property['propertyTitle']}}</td>
                                    {{-- <td>{!!html_entity_decode($property['propertyDescription'])!!}</td> --}}
                                    <td>{{$property['rentalCondition']}}</td>
                                    <td>{{$property['furnishing']}}</td>
                                    <td>{{$property['price']}}</td>
                                    <td>{{$property['serviceCharge']}}</td>
                                    <td>{{$property['securityDeposit']}}</td>
                                    <td>{{$property['securityDepositTerm']}}</td>
                                    <td>{{$property['verification']}}</td>
                                    <td>{{$property['propertyType']}}</td>
                                    {{-- <td>{{$property['renting_as']}}</td> --}}
                                    <td>{{$property['paymentPlan']}}</td>
                                    {{-- <td>{{$property['frequency']}}</td> --}}
                                    {{-- <td>{{$property['intervals']}}</td> --}}
                                    {{-- <td>{{$property['amenities']}}</td> --}}
                                    <td>{{$property['services']}}</td>
                                    <td>{{$property['bed']}}</td>
                                    <td>{{$property['bath']}}</td>
                                    <td>{{$property['toilet']}}</td>
                                    <td>{{$property['address']}}</td>
                                    <td>{{$property['city']}}</td>
                                    <td>{{$property['state']}}</td>
                                    <td>{{$property['country']}}</td>
                                    <td>{{$property['zip']}}</td>
                                    <td>{{$property['status']}}</td>
                                    <td>{{$property['poster']}}</td>
                                    <td>{{$property['views']}}</td>
                                    <td>{{$property['featured_property']}}</td>
                                    <td>{{$property['managed_by']}}</td>
                                    <td>{{$property['property_owner']}}</td>
                                    <td>{{$property['available_date']}}</td>
                                    <td>{{$property['dateOfEntry']}}</td>
                                    
                                    
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