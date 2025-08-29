@extends('layouts.app')

@section('title', 'Property Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Property Details</h4>
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
                          Details
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <!-- Property Details Content -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-7">
                    <h4 class="card-title">General Information</h4>
                    <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                      <i class="ti ti-menu fs-5 d-flex"></i>
                    </button>
                  </div>
                  
                  @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                  @endif

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

                  @if(!isset($property) || !isset($property['data']) || !isset($property['data']['property']))
                    <div class="alert alert-warning">
                      <i class="ti ti-info-circle me-2"></i>Property data not available. Please try again later.
                    </div>
                  @endif

                  @if(isset($property) && isset($property['data']) && isset($property['data']['property']))
                  <form class="form-horizontal">
                    <div class="mb-4">
                      <label class="form-label">Property ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Property ID" value="{{ $property['data']['property']['propertyID'] ?? $propertyId ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Property Title</label>
                      <input type="text" class="form-control" placeholder="Property Title" value="{{ $property['data']['property']['propertyTitle'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Description</label>
                      <textarea class="form-control" rows="6" placeholder="Description" readonly>{{ isset($property['data']['property']['propertyDescription']) ? strip_tags(html_entity_decode($property['data']['property']['propertyDescription'])) : 'N/A' }}</textarea>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Address</label>
                          <input type="text" class="form-control" placeholder="Address" value="{{ $property['data']['property']['address'] ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">City</label>
                          <input type="text" class="form-control" placeholder="City" value="{{ $property['data']['property']['city'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Property Type</label>
                          <input type="text" class="form-control" placeholder="Type" value="{{ $property['data']['property']['propertyType'] ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Status</label>
                          <input type="text" class="form-control" placeholder="Status" value="{{ $property['data']['property']['status'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Price</label>
                          <input type="text" class="form-control" placeholder="Price" value="{{ isset($property['data']['property']['price']) && $property['data']['property']['price'] ? '₦' . number_format($property['data']['property']['price'], 2) : 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Service Charge</label>
                          <input type="text" class="form-control" placeholder="Service Charge" value="{{ isset($property['data']['property']['serviceCharge']) && $property['data']['property']['serviceCharge'] ? '₦' . number_format($property['data']['property']['serviceCharge'], 2) : 'N/A' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Security Deposit</label>
                          <input type="text" class="form-control" placeholder="Security Deposit" value="{{ isset($property['data']['property']['securityDeposit']) && $property['data']['property']['securityDeposit'] ? '₦' . number_format($property['data']['property']['securityDeposit'], 2) : 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Payment Plan</label>
                          <input type="text" class="form-control" placeholder="Payment Plan" value="{{ $property['data']['property']['paymentPlan'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-4">
                          <label class="form-label">Bedrooms</label>
                          <input type="text" class="form-control" placeholder="Bedrooms" value="{{ $property['data']['property']['bed'] ?? '0' }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Bathrooms</label>
                          <input type="text" class="form-control" placeholder="Bathrooms" value="{{ $property['data']['property']['bath'] ?? '0' }}" readonly>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Toilets</label>
                          <input type="text" class="form-control" placeholder="Toilets" value="{{ $property['data']['property']['toilet'] ?? '0' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Furnishing</label>
                          <input type="text" class="form-control" placeholder="Furnishing" value="{{ $property['data']['property']['furnishing'] == '1' ? 'Furnished' : 'Unfurnished' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Views</label>
                          <input type="text" class="form-control" placeholder="Views" value="{{ $property['data']['property']['views'] ?? '0' }}" readonly>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Property Owner ID</label>
                          <input type="text" class="form-control" placeholder="Owner ID" value="{{ $property['data']['property']['property_owner'] ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Available Date</label>
                          <input type="text" class="form-control" placeholder="Available Date" value="{{ isset($property['data']['property']['available_date']) && !empty($property['data']['property']['available_date']) && $property['data']['property']['available_date'] !== '0000-00-00' && strtotime($property['data']['property']['available_date']) !== false ? date('Y-m-d', strtotime($property['data']['property']['available_date'])) : 'N/A' }}" readonly>
                        </div>
                      </div>

                      <label class="form-label mt-3">Date Added</label>
                      <input type="text" class="form-control" placeholder="Date Added" value="{{ isset($property['data']['property']['dateOfEntry']) && !empty($property['data']['property']['dateOfEntry']) && $property['data']['property']['dateOfEntry'] !== '0000-00-00 00:00:00' && strtotime($property['data']['property']['dateOfEntry']) !== false ? date('Y-m-d H:i:s', strtotime($property['data']['property']['dateOfEntry'])) : 'N/A' }}" readonly>
                    </div>

                    <div class="form-actions">
                      <a href="{{ route('properties') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Properties
                      </a>
                      <a href="/property/{{ $property['data']['property']['id'] ?? $propertyId }}/edit" class="btn btn-warning ms-2">
                        <i class="ti ti-edit me-1"></i> Edit Property
                      </a>
                    </div>
                  </form>
                  @endif
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