@extends('layouts.app')

@section('title', 'Edit Landlord')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Edit Landlord</h4>
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
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('landlord.show', $userID) }}">Details</a>
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

          <!-- Loading State -->
          <div id="loadingState" class="card">
            <div class="card-body text-center py-5">
              <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <h5 class="text-muted">Loading landlord information...</h5>
            </div>
          </div>

          <!-- Error State -->
          <div id="errorState" class="card d-none">
            <div class="card-body text-center py-5">
              <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-1 text-danger mb-3"></iconify-icon>
              <h5 class="text-danger">Error Loading Landlord</h5>
              <p class="text-muted mb-4" id="errorMessage">Unable to load landlord information.</p>
              <a href="{{ route('landlords') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Back to Landlords
              </a>
            </div>
          </div>

          <!-- Edit Form -->
          <div id="editForm" class="card d-none">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <form id="editLandlordForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                        <div class="invalid-feedback" id="firstName-error"></div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                        <div class="invalid-feedback" id="lastName-error"></div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" id="email" name="email" required>
                      <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <div class="mb-3">
                      <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                      <input type="tel" class="form-control" id="phone" name="phone" required>
                      <div class="invalid-feedback" id="phone-error"></div>
                    </div>

                    <div class="mb-4">
                      <label for="verified" class="form-label">Verification Status</label>
                      <select class="form-select" id="verified" name="verified">
                        <option value="0">Not Verified</option>
                        <option value="1">Verified</option>
                      </select>
                      <div class="form-text">Update the landlord's verification status.</div>
                      <div class="invalid-feedback" id="verified-error"></div>
                    </div>

                    <div class="alert alert-info">
                      <i class="ti ti-info-circle me-2"></i>
                      <strong>Note:</strong> Only basic information and verification status can be updated. Password changes and other advanced settings are not supported through this form.
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="{{ route('landlord.show', $userID) }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Details
                      </a>
                      <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="ti ti-device-floppy me-1"></i> Update Landlord
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success" id="successModalLabel">
              <i class="ti ti-check-circle me-2"></i>Success
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-0" id="successMessage">Landlord has been updated successfully!</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="{{ route('landlord.show', $userID) }}" class="btn btn-primary">View Details</a>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
const userID = '{{ $userID ?? "" }}';

document.addEventListener('DOMContentLoaded', function() {
    if (!userID) {
        showError('No landlord ID provided.');
        return;
    }
    
    loadLandlordData();
});

function loadLandlordData() {
    fetch(`/api/landlord-details/${userID}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            populateForm(data.landlord);
            showEditForm();
        } else {
            showError(data?.message || 'Failed to load landlord information.');
        }
    })
    .catch(error => {
        console.error('Error loading landlord data:', error);
        showError('An error occurred while loading landlord information.');
    });
}

function populateForm(landlord) {
    document.getElementById('firstName').value = landlord.firstName || '';
    document.getElementById('lastName').value = landlord.lastName || '';
    document.getElementById('email').value = landlord.email || '';
    document.getElementById('phone').value = landlord.phone || '';
    
    // Handle verification status - convert different formats to boolean
    let verifiedValue = '0'; // default to not verified
    if (landlord.verified === 1 || landlord.verified === '1' || 
        landlord.verified === true || landlord.verified === 'yes') {
        verifiedValue = '1';
    }
    document.getElementById('verified').value = verifiedValue;
}

function showEditForm() {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('editForm').classList.remove('d-none');
}

function showError(message) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('editForm').classList.add('d-none');
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorState').classList.remove('d-none');
}

document.getElementById('editLandlordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Updating...';
    
    // Clear previous errors
    clearFormErrors();
    
    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        if (key !== '_token' && key !== '_method') {
            // Convert verified field to boolean
            if (key === 'verified') {
                jsonData[key] = value === '1' ? true : false;
            } else {
                jsonData[key] = value;
            }
        }
    });
    
    fetch(`/api/landlord-update/${userID}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            // Show success modal
            document.getElementById('successMessage').textContent = data.message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        } else {
            // Handle validation errors
            if (data.errors) {
                displayFormErrors(data.errors);
            } else if (data.api_errors) {
                displayFormErrors(data.api_errors);
            } else {
                alert('Error updating landlord: ' + (data.message || 'Unknown error occurred'));
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the landlord. Please try again.');
    })
    .finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
});

function clearFormErrors() {
    const errorElements = document.querySelectorAll('.invalid-feedback');
    const inputElements = document.querySelectorAll('.form-control, .form-select');
    
    errorElements.forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });
    
    inputElements.forEach(el => {
        el.classList.remove('is-invalid');
    });
}

function displayFormErrors(errors) {
    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(field + '-error');
        const inputElement = document.getElementById(field);
        
        if (errorElement && inputElement) {
            errorElement.textContent = errors[field][0];
            errorElement.style.display = 'block';
            inputElement.classList.add('is-invalid');
        }
    });
}
</script>
@endpush