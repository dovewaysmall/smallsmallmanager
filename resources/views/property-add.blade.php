@extends('layouts.app')

@section('title', 'Add New Property')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Add New Property</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('properties') }}">Properties</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Add New
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <!-- Property Add Content -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-7">
                    <h4 class="card-title">Property Information</h4>
                    <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                      <i class="ti ti-menu fs-5 d-flex"></i>
                    </button>
                  </div>
                  
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif

                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif

                  @if(session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                  @endif

                  @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                  @endif

                  <form action="{{ route('properties.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="mb-4">
                      <label class="form-label">Property Title <span class="text-danger">*</span></label>
                      <input type="text" name="propertyTitle" class="form-control" placeholder="Property Title" value="{{ old('propertyTitle') }}" required>

                      <label class="form-label mt-3">Description</label>
                      <textarea name="propertyDescription" class="form-control" rows="6" placeholder="Description">{{ old('propertyDescription') }}</textarea>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Address</label>
                          <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">City</label>
                          <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city') }}">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Property Type <span class="text-danger">*</span></label>
                          <select name="propertyType" class="form-select" required>
                            <option value="">Select Property Type</option>
                            <option value="apartment" {{ old('propertyType') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="house" {{ old('propertyType') === 'house' ? 'selected' : '' }}>House</option>
                            <option value="studio" {{ old('propertyType') === 'studio' ? 'selected' : '' }}>Studio</option>
                            <option value="duplex" {{ old('propertyType') === 'duplex' ? 'selected' : '' }}>Duplex</option>
                            <option value="bungalow" {{ old('propertyType') === 'bungalow' ? 'selected' : '' }}>Bungalow</option>
                            <option value="flat" {{ old('propertyType') === 'flat' ? 'selected' : '' }}>Flat</option>
                            <option value="room" {{ old('propertyType') === 'room' ? 'selected' : '' }}>Room</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Status</label>
                          <select name="status" class="form-select">
                            <option value="yes" {{ old('status') === 'yes' ? 'selected' : '' }}>Active</option>
                            <option value="no" {{ old('status') === 'no' ? 'selected' : '' }}>Inactive</option>
                          </select>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">State <span class="text-danger">*</span></label>
                          <input type="text" name="state" class="form-control" placeholder="e.g. Lagos State" value="{{ old('state', 'Lagos State') }}" required>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Country <span class="text-danger">*</span></label>
                          <input type="text" name="country" class="form-control" placeholder="e.g. Nigeria" value="{{ old('country', 'Nigeria') }}" required>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Property Owner <span class="text-danger">*</span></label>
                          <select name="landlordID" class="form-select" required>
                            <option value="">Select Property Owner</option>
                            @if(isset($landlords) && count($landlords) > 0)
                              @foreach($landlords as $landlord)
                                <option value="{{ $landlord['userID'] ?? $landlord['id'] }}" {{ old('landlordID') === ($landlord['userID'] ?? $landlord['id']) ? 'selected' : '' }}>
                                  {{ $landlord['firstName'] ?? $landlord['name'] ?? 'Unknown' }} {{ $landlord['lastName'] ?? '' }} ({{ $landlord['userID'] ?? $landlord['id'] }})
                                </option>
                              @endforeach
                            @else
                              <option value="962654077517" {{ old('landlordID') === '962654077517' ? 'selected' : '' }}>Default Owner (962654077517)</option>
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Price (₦)</label>
                          <input type="number" name="price" class="form-control" placeholder="Price" value="{{ old('price') }}" step="0.01">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Service Charge (₦)</label>
                          <input type="number" name="serviceCharge" class="form-control" placeholder="Service Charge" value="{{ old('serviceCharge') }}" step="0.01">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Security Deposit (₦)</label>
                          <input type="number" name="securityDeposit" class="form-control" placeholder="Security Deposit" value="{{ old('securityDeposit') }}" step="0.01">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Payment Plan</label>
                          <select name="paymentPlan" class="form-select">
                            <option value="flexible" {{ old('paymentPlan') === 'flexible' ? 'selected' : '' }}>Flexible</option>
                            <option value="fixed" {{ old('paymentPlan') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="installment" {{ old('paymentPlan') === 'installment' ? 'selected' : '' }}>Installment</option>
                          </select>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-4">
                          <label class="form-label">Bedrooms</label>
                          <input type="number" name="bed" class="form-control" placeholder="Bedrooms" value="{{ old('bed', 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Bathrooms</label>
                          <input type="number" name="bath" class="form-control" placeholder="Bathrooms" value="{{ old('bath', 0) }}" min="0">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Toilets</label>
                          <input type="number" name="toilet" class="form-control" placeholder="Toilets" value="{{ old('toilet', 0) }}" min="0">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Furnishing</label>
                          <select name="furnishing" class="form-select">
                            <option value="1" {{ old('furnishing') === '1' ? 'selected' : '' }}>Furnished</option>
                            <option value="0" {{ old('furnishing') === '0' ? 'selected' : '' }}>Unfurnished</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Available Date</label>
                          <input type="date" name="available_date" class="form-control" value="{{ old('available_date') }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-success">
                        <i class="ti ti-device-floppy me-1"></i> Create Property
                      </button>
                      <a href="{{ route('properties') }}" class="btn btn-secondary ms-2">
                        <i class="ti ti-arrow-left me-1"></i> Cancel
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4">
              <div class="offcanvas-lg offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <!-- Sidebar content can be added here in future -->
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection