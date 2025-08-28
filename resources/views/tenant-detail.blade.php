@extends('layouts.app')

@section('title', 'Subscriber Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Subscriber Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('tenants') }}">Subscribers</a>
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

          <!-- Loading State -->
          <div id="loadingState" class="card">
            <div class="card-body text-center py-5">
              <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <h5 class="text-muted">Loading subscriber details...</h5>
            </div>
          </div>

          <!-- Error State -->
          <div id="errorState" class="card d-none">
            <div class="card-body text-center py-5">
              <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-1 text-danger mb-3"></iconify-icon>
              <h5 class="text-danger">Error Loading Subscriber</h5>
              <p class="text-muted mb-4" id="errorMessage">Unable to load subscriber details.</p>
              <a href="{{ route('tenants') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Back to Subscribers
              </a>
            </div>
          </div>

          <!-- Main Content -->
          <div id="mainContent" class="d-none">
            <!-- Actions Row -->
            <div class="row justify-content-end">
              <div class="col-auto">
                <!-- Actions -->
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                      <a href="{{ route('tenants') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Subscribers
                      </a>
                      <button type="button" class="btn btn-success" onclick="viewRentals()">
                        <i class="ti ti-home me-1"></i> View Rentals
                      </button>
                      <button type="button" class="btn btn-info" onclick="contactTenant()">
                        <i class="ti ti-phone me-1"></i> Contact
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Profile and Personal Information Row -->
            <div class="row">
              <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card">
                  <div class="card-body text-center">
                    <div class="position-relative mb-4">
                      <img id="profilePicture" src="" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                      <span id="verificationBadge" class="position-absolute bottom-0 end-0 badge bg-success rounded-pill">
                        <i class="ti ti-check fs-4"></i>
                      </span>
                    </div>
                    <h4 id="tenantName" class="mb-1"></h4>
                    <p id="tenantEmail" class="text-muted mb-3"></p>
                    <div class="d-flex justify-content-center gap-2">
                      <span id="userTypeBadge" class="badge bg-primary-subtle text-primary"></span>
                      <span id="statusBadge" class="badge bg-success-subtle text-success"></span>
                    </div>
                  </div>
                </div>

                <!-- Quick Stats -->
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6">
                        <div class="text-center">
                          <iconify-icon icon="solar:home-line-duotone" class="fs-1 text-primary mb-2"></iconify-icon>
                          <h6 class="mb-1">Rentals</h6>
                          <span id="rentalsCount" class="text-muted">-</span>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="text-center">
                          <iconify-icon icon="solar:eye-line-duotone" class="fs-1 text-info mb-2"></iconify-icon>
                          <h6 class="mb-1">Inspections</h6>
                          <span id="paymentsCount" class="text-muted">-</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-8">
                <div class="card">
                  <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <div class="row">
                        <div class="col-6">
                          <label class="form-label fw-semibold">User ID</label>
                          <p id="userID" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-6">
                          <label class="form-label fw-semibold">Email Address</label>
                          <p id="email" class="form-control-plaintext"></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="row">
                        <div class="col-6">
                          <label class="form-label fw-semibold">First Name</label>
                          <p id="firstName" class="form-control-plaintext"></p>
                        </div>
                        <div class="col-6">
                          <label class="form-label fw-semibold">Last Name</label>
                          <p id="lastName" class="form-control-plaintext"></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Phone Number</label>
                      <p id="phone" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Subscriber Status</label>
                      <p id="tenantStatus" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Verification Status</label>
                      <p id="verificationStatus" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Account Status</label>
                      <p id="accountStatus" class="form-control-plaintext"></p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Contact Information & Additional Information Row - Full Width -->
          <div class="row" id="additionalInfo">
            <!-- Contact Information -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Address</label>
                    <p id="address" class="form-control-plaintext text-muted"></p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">City</label>
                    <p id="city" class="form-control-plaintext text-muted"></p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">State</label>
                    <p id="state" class="form-control-plaintext text-muted"></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Information -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Additional Information</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Date of Birth</label>
                    <p id="dateOfBirth" class="form-control-plaintext text-muted"></p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Gender</label>
                    <p id="gender" class="form-control-plaintext text-muted"></p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Occupation</label>
                    <p id="occupation" class="form-control-plaintext text-muted"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
const userID = '{{ $userID }}';

document.addEventListener('DOMContentLoaded', function() {
    loadTenantDetails();
});

function loadTenantDetails() {
    console.log('Loading tenant details for userID:', userID);
    
    fetch(`/api/tenant-details/${userID}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (response.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (!data) return;
        
        if (data.success && data.tenant) {
            populateTenantDetails(data.tenant);
            showMainContent();
        } else {
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load tenant details');
        }
    })
    .catch(error => {
        console.error('Error loading tenant details:', error);
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        showError('An error occurred while loading tenant details');
    });
}

function populateTenantDetails(tenant) {
    console.log('Populating tenant details with:', tenant);
    
    // Extract tenant info from the API structure
    const tenantInfo = tenant.tenant_info || tenant;
    const bookings = tenant.bookings || [];
    const inspections = tenant.inspections || [];
    const bookingsCount = tenant.bookings_count || 0;
    const inspectionsCount = tenant.inspections_count || 0;
    
    // Basic info
    const firstName = tenantInfo.firstName || '';
    const lastName = tenantInfo.lastName || '';
    const fullName = `${firstName} ${lastName}`.trim() || 'N/A';
    
    document.getElementById('tenantName').textContent = fullName;
    document.getElementById('tenantEmail').textContent = tenantInfo.email || 'N/A';
    
    // Profile picture - use a default avatar if none provided
    const profileImg = document.getElementById('profilePicture');
    if (tenantInfo.profile_picture && tenantInfo.profile_picture !== '') {
        profileImg.src = tenantInfo.profile_picture;
    } else {
        // Use a placeholder avatar service or default image
        profileImg.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(fullName)}&size=120&background=6366f1&color=ffffff`;
    }
    profileImg.alt = fullName + ' Avatar';
    
    // Badges
    document.getElementById('userTypeBadge').textContent = 'SUBSCRIBER';
    const status = tenantInfo.status || 'Active';
    const statusBadge = document.getElementById('statusBadge');
    statusBadge.textContent = status;
    statusBadge.className = `badge ${getStatusBadgeClass(status)}`;
    
    // Verification badge - check for different verification statuses
    const verified = tenantInfo.verified === 'received' || tenantInfo.verified === true || tenantInfo.verified === 1 || tenantInfo.verified === '1';
    const verificationBadge = document.getElementById('verificationBadge');
    if (verified) {
        verificationBadge.className = 'position-absolute bottom-0 end-0 badge bg-success rounded-pill';
        verificationBadge.innerHTML = '<i class="ti ti-check fs-4"></i>';
    } else {
        verificationBadge.className = 'position-absolute bottom-0 end-0 badge bg-warning rounded-pill';
        verificationBadge.innerHTML = '<i class="ti ti-clock fs-4"></i>';
    }
    
    // Personal Information
    document.getElementById('userID').textContent = tenantInfo.userID || userID;
    document.getElementById('firstName').textContent = firstName || 'N/A';
    document.getElementById('lastName').textContent = lastName || 'N/A';
    document.getElementById('email').textContent = tenantInfo.email || 'N/A';
    document.getElementById('phone').textContent = tenantInfo.phone || 'N/A';
    document.getElementById('tenantStatus').textContent = status;
    document.getElementById('verificationStatus').textContent = verified ? 'Verified' : 'Pending Verification';
    document.getElementById('accountStatus').textContent = status;
    
    // Contact Information - these fields might not be in the API response
    document.getElementById('address').textContent = 'N/A';
    document.getElementById('city').textContent = 'N/A';
    document.getElementById('state').textContent = 'N/A';
    
    // Additional Information
    document.getElementById('dateOfBirth').textContent = 'N/A';
    document.getElementById('gender').textContent = tenantInfo.gender || 'N/A';
    document.getElementById('occupation').textContent = tenantInfo.interest || 'N/A';
    
    // Quick Stats - use actual counts from API
    document.getElementById('rentalsCount').textContent = bookingsCount.toString();
    document.getElementById('paymentsCount').textContent = inspectionsCount.toString();
    
    // Update page title
    document.title = `${fullName} - Subscriber Details`;
}

function getStatusBadgeClass(status) {
    switch (status.toLowerCase()) {
        case 'active':
        case 'verified':
            return 'bg-success-subtle text-success';
        case 'pending':
        case 'unverified':
            return 'bg-warning-subtle text-warning';
        case 'inactive':
        case 'suspended':
            return 'bg-danger-subtle text-danger';
        default:
            return 'bg-secondary-subtle text-secondary';
    }
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    
    try {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }).format(date);
    } catch (e) {
        return dateString;
    }
}

function showMainContent() {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('mainContent').classList.remove('d-none');
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.remove('d-none');
    document.getElementById('mainContent').classList.add('d-none');
}

// Action functions
function editTenant() {
    alert('Edit subscriber functionality would be implemented here');
}

function viewRentals() {
    alert('View subscriber rentals functionality would be implemented here');
}

function contactTenant() {
    alert('Contact subscriber functionality would be implemented here');
}
</script>
@endpush