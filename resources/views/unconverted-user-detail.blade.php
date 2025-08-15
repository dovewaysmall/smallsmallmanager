@extends('layouts.app')

@section('title', 'Unconverted User Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Unconverted User Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('unconverted-users') }}">Unconverted Users</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          User Details
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

                  @if(isset($user) && $user)
                    <div class="mb-4">
                      <label class="form-label">User ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{ $user['data']['user_id'] ?? $user['data']['id'] ?? $user['data']['userID'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Full Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{ $user['data']['full_name'] ?? ($user['data']['firstName'] . ' ' . $user['data']['lastName']) ?? $user['data']['name'] ?? '' }}" readonly>

                      <label class="form-label mt-3">Email</label>
                      <input type="email" class="form-control" value="{{ $user['data']['email'] ?? '' }}" readonly>

                      <label class="form-label mt-3">Phone</label>
                      <input type="text" class="form-control" value="{{ trim($user['data']['phone'] ?? '') }}" readonly>

                      <label class="form-label mt-3">Registration Date</label>
                      <input type="text" class="form-control" value="{{ isset($user['data']['created_at']) ? date('Y-m-d H:i:s', strtotime($user['data']['created_at'])) : (isset($user['data']['registration_date']) ? date('Y-m-d H:i:s', strtotime($user['data']['registration_date'])) : 'N/A') }}" readonly>
                    </div>
                </div>
              </div>
              
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-7">User Details</h4>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Status</label>
                          <input type="text" class="form-control" value="{{ $user['data']['status'] ?? $user['data']['user_status'] ?? 'Active' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Account Type</label>
                          <input type="text" class="form-control" value="{{ $user['data']['account_type'] ?? $user['data']['type'] ?? 'User' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Last Login</label>
                          <input type="text" class="form-control" value="{{ isset($user['data']['last_login']) ? date('Y-m-d H:i:s', strtotime($user['data']['last_login'])) : (isset($user['data']['last_login_at']) ? date('Y-m-d H:i:s', strtotime($user['data']['last_login_at'])) : 'Never') }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Email Verified</label>
                          <input type="text" class="form-control" value="{{ isset($user['data']['email_verified_at']) && $user['data']['email_verified_at'] ? 'Yes' : 'No' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Location</label>
                          <input type="text" class="form-control" value="{{ $user['data']['location'] ?? $user['data']['city'] ?? $user['data']['address'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Referral Source</label>
                          <input type="text" class="form-control" value="{{ $user['data']['referral_source'] ?? $user['data']['source'] ?? $user['data']['how_did_you_hear'] ?? 'N/A' }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="mb-4">
                      <label class="form-label">Profile Completion</label>
                      <input type="text" class="form-control" value="{{ isset($user['data']['profile_completion']) ? $user['data']['profile_completion'] . '%' : 'N/A' }}" readonly>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Account Created</label>
                          <input type="datetime-local" class="form-control" value="{{ isset($user['data']['created_at']) ? date('Y-m-d\TH:i', strtotime($user['data']['created_at'])) : (isset($user['data']['registration_date']) ? date('Y-m-d\TH:i', strtotime($user['data']['registration_date'])) : '') }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                          <label class="form-label">Last Updated</label>
                          <input type="datetime-local" class="form-control" value="{{ isset($user['data']['updated_at']) ? date('Y-m-d\TH:i', strtotime($user['data']['updated_at'])) : (isset($user['data']['last_modified']) ? date('Y-m-d\TH:i', strtotime($user['data']['last_modified'])) : '') }}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                      <a href="{{ route('unconverted-users') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Unconverted Users
                      </a>
                    </div>
                  @else
                    <div class="text-center py-5">
                      <iconify-icon icon="solar:user-cross-line-duotone" class="fs-8 text-danger mb-3"></iconify-icon>
                      <h5 class="mb-3">User Not Found</h5>
                      <p class="text-muted mb-4">The requested unconverted user could not be loaded.</p>
                      <a href="{{ route('unconverted-users') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Unconverted Users
                      </a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="offcanvas-lg offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                @if(isset($user) && $user)
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">User Summary</h5>
                    <div class="mb-3">
                      <small class="text-muted d-block">User ID</small>
                      <strong>{{ $user['data']['user_id'] ?? $user['data']['id'] ?? $user['data']['userID'] ?? 'N/A' }}</strong>
                    </div>
                    <div class="mb-3">
                      <small class="text-muted d-block">Status</small>
                      <span class="badge bg-warning">Unconverted</span>
                    </div>
                    <div class="mb-3">
                      <small class="text-muted d-block">Registration Date</small>
                      <strong>{{ isset($user['data']['created_at']) ? date('M d, Y', strtotime($user['data']['created_at'])) : 'N/A' }}</strong>
                    </div>
                    <div class="mb-3">
                      <small class="text-muted d-block">Last Activity</small>
                      <strong>{{ isset($user['data']['last_login']) ? date('M d, Y', strtotime($user['data']['last_login'])) : 'Never' }}</strong>
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