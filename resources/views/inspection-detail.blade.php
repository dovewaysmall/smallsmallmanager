@extends('layouts.app')

@section('title', 'Inspection Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Inspection Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Inspection Details
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <!-- start Basic Area Chart -->
          <div class="row">
            <div class="col-lg-8 ">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-7">
                    <h4 class="card-title">General</h4>

                    <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                      <i class="ti ti-menu fs-5 d-flex"></i>
                    </button>
                  </div>
                  @if(isset($error))
                    <div class="alert alert-danger">
                      {{ $error }}
                    </div>
                  @endif

                  @if(session('success'))
                    <div class="alert alert-success">
                      {{ session('success') }}
                    </div>
                  @endif

                  @if(session('error'))
                    <div class="alert alert-danger">
                      {{ session('error') }}
                    </div>
                  @endif


                  <form action="{{ route('inspection.update', $id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                      <label class="form-label">User ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="User ID" value="{{ $inspection['data']['userID'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Inspection ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Inspection ID" value="{{ $inspection['data']['inspectionID'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">First Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="First Name" value="{{ $inspection['data']['firstName'] ?? '' }}" readonly>

                      <label class="form-label mt-3">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Last Name" value="{{ $inspection['data']['lastName'] ?? '' }}" readonly>

                      <label class="form-label mt-3">Email</label>
                      <input type="email" class="form-control" placeholder="Email" value="{{ $inspection['data']['email'] ?? '' }}" readonly>

                      <label class="form-label mt-3">Phone</label>
                      <input type="text" class="form-control" placeholder="Phone" value="{{ trim($inspection['data']['phone'] ?? '') }}" readonly>
                    </div>
                </div>
              </div>
              
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-7">Inspection Details</h4>
                    <div class="mb-4">
                      <label class="form-label">Property ID</label>
                      <input type="text" class="form-control" placeholder="Property ID" value="{{ $inspection['data']['propertyID'] ?? '' }}" readonly>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Property Title</label>
                      <input type="text" class="form-control" placeholder="Property Title" value="{{ $inspection['data']['propertyTitle'] ?? '' }}" readonly>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Inspection Date</label>
                          <input type="datetime-local" class="form-control" value="{{ isset($inspection['data']['inspectionDate']) ? date('Y-m-d\TH:i', strtotime($inspection['data']['inspectionDate'])) : '' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Updated Inspection Date</label>
                          <input type="datetime-local" class="form-control" name="updated_inspection_date" value="{{ isset($inspection['data']['updated_inspection_date']) ? date('Y-m-d\TH:i', strtotime($inspection['data']['updated_inspection_date'])) : '' }}">
                        </div>
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Status</label>
                      <select class="form-select" name="inspection_status">
                        <option value="">Select Status</option>
                        <option value="pending" {{ ($inspection['data']['inspection_status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="pending-assigned" {{ ($inspection['data']['inspection_status'] ?? '') == 'pending-assigned' ? 'selected' : '' }}>Pending Assigned</option>
                        <option value="completed" {{ ($inspection['data']['inspection_status'] ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ ($inspection['data']['inspection_status'] ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="in_progress" {{ ($inspection['data']['inspection_status'] ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                      </select>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Assigned TSR</label>
                      <select class="form-select" name="assigned_tsr">
                        <option value="">Select a TSR</option>
                        
                        {{-- Show currently assigned TSR first (from assigned_tsr object) --}}
                        @if(isset($inspection['assigned_tsr']) && is_array($inspection['assigned_tsr']))
                          <option value="{{ $inspection['assigned_tsr']['adminID'] }}" selected>
                            {{ $inspection['assigned_tsr']['firstName'] }} {{ $inspection['assigned_tsr']['lastName'] }}
                          </option>
                        @endif
                        
                        {{-- Show other available TSRs from available_tsrs array --}}
                        @if(isset($inspection['available_tsrs']) && is_array($inspection['available_tsrs']))
                          @foreach($inspection['available_tsrs'] as $tsr)
                            <option value="{{ $tsr['adminID'] }}">
                              {{ $tsr['firstName'] }} {{ $tsr['lastName'] }}
                            </option>
                          @endforeach
                        @endif
                        
                      </select>
                      <p class="fs-2">Technical Service Representative assigned to this inspection.</p>
                    </div>
                  
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Inspection Type</label>
                          <select class="form-select" name="inspectionType">
                            <option value="">Select inspection type</option>
                            <option value="Physical" {{ ($inspection['data']['inspectionType'] ?? '') == 'Physical' ? 'selected' : '' }}>Physical</option>
                            <option value="Virtual" {{ ($inspection['data']['inspectionType'] ?? '') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="Remote" {{ ($inspection['data']['inspectionType'] ?? '') == 'Remote' ? 'selected' : '' }}>Remote</option>
                          </select>
                          <p class="fs-2">Type of inspection being conducted.</p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Platform</label>
                          <input type="text" class="form-control" name="platform" placeholder="Platform" value="{{ $inspection['data']['platform'] ?? '' }}">
                          <p class="fs-2">Platform used for the inspection.</p>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Customer Feedback</label>
                          <select class="form-select" name="customer_inspec_feedback">
                            <option value="">Select feedback</option>
                            <option value="excellent" {{ ($inspection['data']['customer_inspec_feedback'] ?? '') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ ($inspection['data']['customer_inspec_feedback'] ?? '') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="average" {{ ($inspection['data']['customer_inspec_feedback'] ?? '') == 'average' ? 'selected' : '' }}>Average</option>
                            <option value="poor" {{ ($inspection['data']['customer_inspec_feedback'] ?? '') == 'poor' ? 'selected' : '' }}>Poor</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Verified Status</label>
                          <select class="form-select" name="verified">
                            <option value="yes" {{ ($inspection['data']['verified'] ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ ($inspection['data']['verified'] ?? '') == 'no' ? 'selected' : '' }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Customer Feedback Details</label>
                      <textarea class="form-control" name="cx_feedback_details" rows="3" placeholder="Customer feedback details">{{ $inspection['data']['cx_feedback_details'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Inspection Remarks</label>
                      <textarea class="form-control" name="inspection_remarks" rows="3" placeholder="Inspection remarks">{{ $inspection['data']['inspection_remarks'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Comments</label>
                      <textarea class="form-control" name="comment" rows="3" placeholder="Additional comments">{{ $inspection['data']['comment'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Date of Entry</label>
                      <input type="datetime-local" class="form-control" value="{{ isset($inspection['data']['dateOfEntry']) ? date('Y-m-d\TH:i', strtotime($inspection['data']['dateOfEntry'])) : '' }}" readonly>
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary">
                        Save changes
                      </button>
                      <button type="button" class="btn bg-danger-subtle text-danger ms-6">
                        Cancel
                      </button>
                    </div>
                </div>
              </div>
              </form>
            </div>
            <div class="col-lg-4">
              <div class="offcanvas-lg offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            
              
         
              </div>
            </div>
          </div>
          <!-- end Basic Area Chart -->
        </div>
      </div>
@endsection