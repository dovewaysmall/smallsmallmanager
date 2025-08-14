@extends('layouts.app')

@section('title', 'Verification Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Verification Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Verification Details
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
                    <h4 class="card-title">General Information</h4>

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

                  @if(session('info'))
                    <div class="alert alert-info">
                      {{ session('info') }}
                    </div>
                  @endif

                  @if(session('warning'))
                    <div class="alert alert-warning">
                      {{ session('warning') }}
                    </div>
                  @endif

                  @if(isset($verification) && $verification)
                    <form action="{{ route('verification.update', $id) }}" method="POST" class="form-horizontal">
                      @csrf
                      @method('PUT')
                      <div class="mb-4">
                        <label class="form-label">Verification ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $verification['data']['verification_id'] ?? $verification['data']['id'] ?? $verification['data']['verificationId'] ?? 'N/A' }}" readonly>

                        <label class="form-label mt-3">User ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $verification['data']['user_id'] ?? $verification['data']['userID'] ?? 'N/A' }}" readonly>

                        <label class="form-label mt-3">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $verification['data']['full_name'] ?? ($verification['data']['firstName'] . ' ' . $verification['data']['lastName']) ?? $verification['data']['name'] ?? '' }}" readonly>

                        <label class="form-label mt-3">Email</label>
                        <input type="email" class="form-control" value="{{ $verification['data']['email'] ?? '' }}" readonly>

                        <label class="form-label mt-3">Phone</label>
                        <input type="text" class="form-control" value="{{ trim($verification['data']['phone'] ?? '') }}" readonly>
                      </div>
                </div>
              </div>
              
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-7">Verification Details</h4>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Gross Annual Income</label>
                          <input type="text" class="form-control" value="{{ isset($verification['data']['gross_annual_income']) ? '₦' . number_format($verification['data']['gross_annual_income']) : ($verification['data']['grossAnnualIncome'] ?? $verification['data']['annual_income'] ?? 'N/A') }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Occupation</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['occupation'] ?? $verification['data']['job_title'] ?? $verification['data']['profession'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Marital Status</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['marital_status'] ?? $verification['data']['maritalStatus'] ?? $verification['data']['relationship_status'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Verification Status</label>
                          @php
                            $currentStatus = $verification['data']['Verified'] ?? $verification['data']['verified'] ?? $verification['data']['status'] ?? $verification['data']['verification_status'] ?? 'Pending';
                          @endphp
                          <select class="form-select" name="verification_status">
                            <option value="yes" {{ strtolower($currentStatus) == 'yes' || strtolower($currentStatus) == 'verified' || strtolower($currentStatus) == 'approved' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ strtolower($currentStatus) == 'no' || strtolower($currentStatus) == 'rejected' || strtolower($currentStatus) == 'denied' ? 'selected' : '' }}>No</option>
                            <option value="processing" {{ strtolower($currentStatus) == 'processing' || strtolower($currentStatus) == 'reviewing' || strtolower($currentStatus) == 'in_review' ? 'selected' : '' }}>Processing</option>
                            <option value="received" {{ strtolower($currentStatus) == 'received' || strtolower($currentStatus) == 'submitted' || strtolower($currentStatus) == 'pending' ? 'selected' : '' }}>Received</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Company Name</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['company_name'] ?? $verification['data']['companyName'] ?? $verification['data']['employer'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Employment Type</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['employment_type'] ?? $verification['data']['employmentType'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Bank Name</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['bank_name'] ?? $verification['data']['bankName'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Account Number</label>
                          <input type="text" class="form-control" value="{{ $verification['data']['account_number'] ?? $verification['data']['accountNumber'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Work Address</label>
                      <textarea class="form-control" rows="3" readonly>{{ $verification['data']['work_address'] ?? $verification['data']['workAddress'] ?? $verification['data']['office_address'] ?? 'N/A' }}</textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Date Created</label>
                          <input type="datetime-local" class="form-control" value="{{ isset($verification['data']['created_at']) ? date('Y-m-d\TH:i', strtotime($verification['data']['created_at'])) : (isset($verification['data']['dateCreated']) ? date('Y-m-d\TH:i', strtotime($verification['data']['dateCreated'])) : '') }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Last Updated</label>
                          <input type="datetime-local" class="form-control" value="{{ isset($verification['data']['updated_at']) ? date('Y-m-d\TH:i', strtotime($verification['data']['updated_at'])) : (isset($verification['data']['lastUpdated']) ? date('Y-m-d\TH:i', strtotime($verification['data']['lastUpdated'])) : '') }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Save Changes
                      </button>
                      <a href="{{ route('verifications') }}" class="btn btn-outline-secondary ms-3">
                        <i class="ti ti-arrow-left me-1"></i> Back to Verifications
                      </a>
                    </div>
                    </form>
                  @else
                    <div class="text-center py-5">
                      <iconify-icon icon="solar:shield-cross-line-duotone" class="fs-8 text-danger mb-3"></iconify-icon>
                      <h5 class="mb-3">Verification Not Found</h5>
                      <p class="text-muted mb-4">The requested verification could not be loaded.</p>
                      <a href="{{ route('verifications') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Verifications
                      </a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="offcanvas-lg offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                @if(isset($verification) && $verification)
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Verification Summary</h5>
                    <div class="mb-3">
                      <small class="text-muted d-block">Verification ID</small>
                      <strong>{{ $verification['data']['verification_id'] ?? $verification['data']['id'] ?? $verification['data']['verificationId'] ?? 'N/A' }}</strong>
                    </div>
                    <div class="mb-3">
                      <small class="text-muted d-block">Status</small>
                      @php
                        $status = $verification['data']['Verified'] ?? $verification['data']['verified'] ?? $verification['data']['status'] ?? 'Pending';
                        $statusClass = 'badge-secondary';
                        switch(strtolower($status)) {
                          case 'yes':
                          case 'approved':
                          case 'verified':
                            $statusClass = 'badge-success';
                            break;
                          case 'no':
                          case 'rejected':
                          case 'denied':
                            $statusClass = 'badge-danger';
                            break;
                          case 'pending':
                          case 'reviewing':
                            $statusClass = 'badge-warning';
                            break;
                        }
                      @endphp
                      <span class="badge bg-{{ str_replace('badge-', '', $statusClass) }}">{{ $status }}</span>
                    </div>
                    <div class="mb-3">
                      <small class="text-muted d-block">Annual Income</small>
                      <strong>{{ isset($verification['data']['gross_annual_income']) ? '₦' . number_format($verification['data']['gross_annual_income']) : 'N/A' }}</strong>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          <!-- end Basic Area Chart -->
        </div>
      </div>
@endsection