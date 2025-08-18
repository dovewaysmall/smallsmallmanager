@extends('layouts.app')

@section('title', 'Landlord Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Landlord Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('landlords') }}">Landlords</a>
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
              <h5 class="text-muted">Loading landlord details...</h5>
            </div>
          </div>

          <!-- Error State -->
          <div id="errorState" class="card d-none">
            <div class="card-body text-center py-5">
              <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-1 text-danger mb-3"></iconify-icon>
              <h5 class="text-danger">Error Loading Landlord</h5>
              <p class="text-muted mb-4" id="errorMessage">Unable to load landlord details.</p>
              <a href="{{ route('landlords') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Back to Landlords
              </a>
            </div>
          </div>

          <!-- Main Content -->
          <div id="mainContent" class="row d-none">
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
                  <h4 id="landlordName" class="mb-1"></h4>
                  <p id="landlordEmail" class="text-muted mb-3"></p>
                  <div class="d-flex justify-content-center gap-2">
                    <span id="userTypeBadge" class="badge bg-primary-subtle text-primary"></span>
                    <span id="statusBadge" class="badge bg-success-subtle text-success"></span>
                  </div>
                </div>
              </div>

              <!-- Quick Stats -->
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="text-center">
                        <iconify-icon icon="solar:home-line-duotone" class="fs-1 text-primary mb-2"></iconify-icon>
                        <h6 class="mb-1">Properties</h6>
                        <span id="propertiesCount" class="text-muted">-</span>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="text-center">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="fs-1 text-success mb-2"></iconify-icon>
                        <h6 class="mb-1">Tenants</h6>
                        <span id="tenantsCount" class="text-muted">-</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-8">
              <!-- Personal Information -->
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">User ID</label>
                      <p id="userID" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Registration Date</label>
                      <p id="regDate" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">First Name</label>
                      <p id="firstName" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Last Name</label>
                      <p id="lastName" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Email Address</label>
                      <p id="email" class="form-control-plaintext"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Phone Number</label>
                      <p id="phone" class="form-control-plaintext"></p>
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

              <!-- Additional Information -->
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Additional Information</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Referral Code</label>
                      <p id="referral" class="form-control-plaintext text-muted"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">Interest Areas</label>
                      <p id="interest" class="form-control-plaintext text-muted"></p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                  <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('landlords') }}" class="btn btn-outline-secondary">
                      <i class="ti ti-arrow-left me-1"></i> Back to Landlords
                    </a>
                    <a href="{{ route('landlord.edit', $userID ?? '') }}" class="btn btn-primary">
                      <i class="ti ti-edit me-1"></i> Edit Landlord
                    </a>
                    <button type="button" class="btn btn-success" onclick="viewProperties()">
                      <i class="ti ti-home me-1"></i> View Properties
                    </button>
                    <button type="button" class="btn btn-info" onclick="contactLandlord()">
                      <i class="ti ti-phone me-1"></i> Contact
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-info" id="contactModalLabel">
              <i class="ti ti-phone me-2"></i>Contact Landlord
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex align-items-center mb-3">
              <div class="me-3">
                <iconify-icon icon="solar:user-circle-line-duotone" class="fs-1 text-primary"></iconify-icon>
              </div>
              <div>
                <h6 class="mb-1" id="contactLandlordName">Landlord Name</h6>
                <small class="text-muted" id="contactLandlordId">ID: -</small>
              </div>
            </div>
            
            <div class="contact-info">
              <div class="d-flex align-items-center mb-3" id="emailContact">
                <div class="contact-icon me-3">
                  <iconify-icon icon="solar:letter-line-duotone" class="fs-4 text-success"></iconify-icon>
                </div>
                <div>
                  <small class="text-muted d-block">Email Address</small>
                  <strong id="contactEmail">-</strong>
                  <div class="mt-1">
                    <a href="#" class="btn btn-sm btn-outline-success" id="emailBtn">
                      <i class="ti ti-mail me-1"></i>Send Email
                    </a>
                    <button class="btn btn-sm btn-outline-secondary ms-1" onclick="copyToClipboard('contactEmail')">
                      <i class="ti ti-copy me-1"></i>Copy
                    </button>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center mb-3" id="phoneContact">
                <div class="contact-icon me-3">
                  <iconify-icon icon="solar:phone-line-duotone" class="fs-4 text-info"></iconify-icon>
                </div>
                <div>
                  <small class="text-muted d-block">Phone Number</small>
                  <strong id="contactPhone">-</strong>
                  <div class="mt-1">
                    <a href="#" class="btn btn-sm btn-outline-info" id="phoneBtn">
                      <i class="ti ti-phone me-1"></i>Call Now
                    </a>
                    <button class="btn btn-sm btn-outline-secondary ms-1" onclick="copyToClipboard('contactPhone')">
                      <i class="ti ti-copy me-1"></i>Copy
                    </button>
                  </div>
                </div>
              </div>

              <div id="noContactInfo" class="text-center py-3 d-none">
                <iconify-icon icon="solar:info-circle-line-duotone" class="fs-1 text-warning mb-2"></iconify-icon>
                <p class="text-muted mb-0">No contact information available for this landlord.</p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userID = '{{ $userID ?? "" }}';
    
    if (!userID) {
        showError('No landlord ID provided.');
        return;
    }
    
    loadLandlordDetails(userID);
});

function loadLandlordDetails(userID) {
    console.log('Making API call for userID:', userID);
    console.log('API URL:', `/api/landlord-details/${userID}`);
    
    fetch(`/api/landlord-details/${userID}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        console.log('API Response Status:', response.status);
        console.log('API Response:', response);
        
        if (response.status === 401) {
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        console.log('API Response Data:', data);
        
        if (data && data.success) {
            console.log('Landlord data received:', data.landlord);
            populateLandlordDetails(data.landlord);
            showMainContent();
        } else {
            console.error('API call failed:', data);
            showError(data?.message || 'Failed to load landlord details.');
        }
    })
    .catch(error => {
        console.error('Error loading landlord details:', error);
        showError('An error occurred while loading landlord details.');
    });
}

function populateLandlordDetails(landlord) {
    // Profile section
    document.getElementById('landlordName').textContent = `${landlord.firstName || ''} ${landlord.lastName || ''}`.trim() || 'N/A';
    document.getElementById('landlordEmail').textContent = landlord.email || 'N/A';
    
    // Profile picture with fallback
    const profileImg = document.getElementById('profilePicture');
    if (landlord.profile_picture && landlord.profile_picture !== '') {
        profileImg.src = landlord.profile_picture;
    } else {
        profileImg.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik02MCA0NkM2Ny4xOCA0NiA3MyA0MC4xOCA3MyAzM0M3MyAyNS44MiA2Ny4xOCAyMCA2MCAyMEM1Mi44MiAyMCA0NyAyNS44MiA0NyAzM0M0NyA0MC4xOCA1Mi44MiA0NiA2MCA0NloiIGZpbGw9IiM5Q0ExQTYiLz4KPHA0dGggZD0iTTYwIDUzQzQ1LjY0IDUzIDM0IDY0LjY0IDM0IDc5VjkzSDg2Vjc5Qzg2IDY0LjY0IDc0LjM2IDUzIDYwIDUzWiIgZmlsbD0iIzlDQTFBNiIvPgo8L3N2Zz4K';
    }
    
    // Verification badge
    const verificationBadge = document.getElementById('verificationBadge');
    if (landlord.verified && landlord.verified != '0') {
        verificationBadge.className = 'position-absolute bottom-0 end-0 badge bg-success rounded-pill';
        verificationBadge.innerHTML = '<i class="ti ti-check fs-4"></i>';
    } else {
        verificationBadge.className = 'position-absolute bottom-0 end-0 badge bg-warning rounded-pill';
        verificationBadge.innerHTML = '<i class="ti ti-clock fs-4"></i>';
    }
    
    // Badges
    document.getElementById('userTypeBadge').textContent = (landlord.user_type || 'landlord').toUpperCase();
    const statusBadge = document.getElementById('statusBadge');
    const status = landlord.status || 'active';
    statusBadge.textContent = status.toUpperCase();
    statusBadge.className = status === 'active' ? 'badge bg-success-subtle text-success' : 'badge bg-warning-subtle text-warning';
    
    // Personal Information
    document.getElementById('userID').textContent = landlord.userID || 'N/A';
    document.getElementById('regDate').textContent = formatDate(landlord.regDate) || 'N/A';
    document.getElementById('firstName').textContent = landlord.firstName || 'N/A';
    document.getElementById('lastName').textContent = landlord.lastName || 'N/A';
    document.getElementById('email').textContent = landlord.email || 'N/A';
    document.getElementById('phone').textContent = landlord.phone || 'N/A';
    
    // Verification Status
    const verificationText = landlord.verified && landlord.verified != '0' ? 'Verified' : 'Pending Verification';
    document.getElementById('verificationStatus').textContent = verificationText;
    
    // Account Status
    document.getElementById('accountStatus').textContent = (landlord.status || 'active').charAt(0).toUpperCase() + (landlord.status || 'active').slice(1);
    
    // Additional Information
    document.getElementById('referral').textContent = landlord.referral || 'No referral code';
    document.getElementById('interest').textContent = landlord.interest || 'Not specified';
    
    // Stats (placeholder - would need actual data from API)
    document.getElementById('propertiesCount').textContent = landlord.properties_count || '0';
    document.getElementById('tenantsCount').textContent = landlord.tenants_count || '0';
}

function showMainContent() {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('mainContent').classList.remove('d-none');
}

function showError(message) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('mainContent').classList.add('d-none');
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorState').classList.remove('d-none');
}

function formatDate(dateString) {
    if (!dateString) return '';
    
    try {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(date);
    } catch (e) {
        return dateString;
    }
}


function viewProperties() {
    alert('Property viewing functionality would be implemented here.');
}

function contactLandlord() {
    const name = document.getElementById('landlordName').textContent;
    const userID = document.getElementById('userID').textContent;
    const email = document.getElementById('email').textContent;
    const phone = document.getElementById('phone').textContent;
    
    // Populate modal with landlord info
    document.getElementById('contactLandlordName').textContent = name || 'N/A';
    document.getElementById('contactLandlordId').textContent = `ID: ${userID || 'N/A'}`;
    
    // Handle email contact
    const emailContact = document.getElementById('emailContact');
    const contactEmail = document.getElementById('contactEmail');
    const emailBtn = document.getElementById('emailBtn');
    
    if (email && email !== 'N/A') {
        contactEmail.textContent = email;
        emailBtn.href = `mailto:${email}`;
        emailContact.classList.remove('d-none');
    } else {
        emailContact.classList.add('d-none');
    }
    
    // Handle phone contact
    const phoneContact = document.getElementById('phoneContact');
    const contactPhone = document.getElementById('contactPhone');
    const phoneBtn = document.getElementById('phoneBtn');
    
    if (phone && phone !== 'N/A') {
        contactPhone.textContent = phone;
        phoneBtn.href = `tel:${phone}`;
        phoneContact.classList.remove('d-none');
    } else {
        phoneContact.classList.add('d-none');
    }
    
    // Show "no contact info" message if both email and phone are missing
    const noContactInfo = document.getElementById('noContactInfo');
    if ((!email || email === 'N/A') && (!phone || phone === 'N/A')) {
        noContactInfo.classList.remove('d-none');
        emailContact.classList.add('d-none');
        phoneContact.classList.add('d-none');
    } else {
        noContactInfo.classList.add('d-none');
    }
    
    // Show the modal
    const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
    contactModal.show();
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            showCopyFeedback();
        }).catch(() => {
            fallbackCopyToClipboard(text);
        });
    } else {
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showCopyFeedback();
    } catch (err) {
        console.error('Unable to copy to clipboard', err);
    }
    
    textArea.remove();
}

function showCopyFeedback() {
    // Create a temporary toast-like notification
    const feedback = document.createElement('div');
    feedback.className = 'position-fixed top-50 start-50 translate-middle bg-success text-white px-3 py-2 rounded shadow';
    feedback.style.zIndex = '9999';
    feedback.innerHTML = '<i class="ti ti-check me-1"></i>Copied to clipboard!';
    
    document.body.appendChild(feedback);
    
    setTimeout(() => {
        feedback.remove();
    }, 2000);
}
</script>
@endpush