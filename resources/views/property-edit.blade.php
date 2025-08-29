@extends('layouts.app')

@section('title', 'Edit Property')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Edit Property</h4>
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
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('property.show', $propertyId ?? '') }}">Details</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Edit
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <!-- Property Edit Content -->
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
                  <form action="{{ route('property.update', $propertyId) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                      <label class="form-label">Property ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Property ID" value="{{ $property['data']['property']['propertyID'] ?? $propertyId ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Property Title <span class="text-danger">*</span></label>
                      <input type="text" name="propertyTitle" class="form-control" placeholder="Property Title" value="{{ $property['data']['property']['propertyTitle'] ?? '' }}" required>

                      <label class="form-label mt-3">Description</label>
                      <textarea name="propertyDescription" class="form-control" rows="6" placeholder="Description">{{ isset($property['data']['property']['propertyDescription']) ? strip_tags(html_entity_decode($property['data']['property']['propertyDescription'])) : '' }}</textarea>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Address</label>
                          <input type="text" name="address" class="form-control" placeholder="Address" value="{{ $property['data']['property']['address'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">City</label>
                          <input type="text" name="city" class="form-control" placeholder="City" value="{{ $property['data']['property']['city'] ?? '' }}">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Property Type</label>
                          <input type="text" name="propertyType" class="form-control" placeholder="Type" value="{{ $property['data']['property']['propertyType'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Status</label>
                          <select name="status" class="form-select">
                            <option value="yes" {{ ($property['data']['property']['status'] ?? '') === 'yes' ? 'selected' : '' }}>Active</option>
                            <option value="no" {{ ($property['data']['property']['status'] ?? '') === 'no' ? 'selected' : '' }}>Inactive</option>
                          </select>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Price (₦)</label>
                          <input type="number" name="price" class="form-control" placeholder="Price" value="{{ $property['data']['property']['price'] ?? '' }}" step="0.01">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Service Charge (₦)</label>
                          <input type="number" name="serviceCharge" class="form-control" placeholder="Service Charge" value="{{ $property['data']['property']['serviceCharge'] ?? '' }}" step="0.01">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Security Deposit (₦)</label>
                          <input type="number" name="securityDeposit" class="form-control" placeholder="Security Deposit" value="{{ $property['data']['property']['securityDeposit'] ?? '' }}" step="0.01">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Payment Plan</label>
                          <select name="paymentPlan" class="form-select">
                            <option value="flexible" {{ ($property['data']['property']['paymentPlan'] ?? '') === 'flexible' ? 'selected' : '' }}>Flexible</option>
                            <option value="fixed" {{ ($property['data']['property']['paymentPlan'] ?? '') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="installment" {{ ($property['data']['property']['paymentPlan'] ?? '') === 'installment' ? 'selected' : '' }}>Installment</option>
                          </select>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-4">
                          <label class="form-label">Bedrooms</label>
                          <input type="number" name="bed" class="form-control" placeholder="Bedrooms" value="{{ $property['data']['property']['bed'] ?? '0' }}" min="0">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Bathrooms</label>
                          <input type="number" name="bath" class="form-control" placeholder="Bathrooms" value="{{ $property['data']['property']['bath'] ?? '0' }}" min="0">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Toilets</label>
                          <input type="number" name="toilet" class="form-control" placeholder="Toilets" value="{{ $property['data']['property']['toilet'] ?? '0' }}" min="0">
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-md-6">
                          <label class="form-label">Furnishing</label>
                          <select name="furnishing" class="form-select">
                            <option value="1" {{ ($property['data']['property']['furnishing'] ?? '') === '1' ? 'selected' : '' }}>Furnished</option>
                            <option value="0" {{ ($property['data']['property']['furnishing'] ?? '') === '0' ? 'selected' : '' }}>Unfurnished</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Available Date</label>
                          <input type="date" name="available_date" class="form-control" value="{{ isset($property['data']['property']['available_date']) && !empty($property['data']['property']['available_date']) && $property['data']['property']['available_date'] !== '0000-00-00' && strtotime($property['data']['property']['available_date']) !== false ? date('Y-m-d', strtotime($property['data']['property']['available_date'])) : '' }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-success">
                        <i class="ti ti-device-floppy me-1"></i> Save Changes
                      </button>
                      <a href="{{ route('property.show', $propertyId) }}" class="btn btn-secondary ms-2">
                        <i class="ti ti-arrow-left me-1"></i> Cancel
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