@extends('layouts.app')

@section('title', 'Add New Landlord')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Add New Landlord</h4>
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
                          Add New
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <form id="addLandlordForm" method="POST" action="{{ route('landlords.store') }}">
                    @csrf
                    
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

                    <div class="mb-3">
                      <label for="income" class="form-label">Monthly Income <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" id="income" name="income" required min="0" step="0.01" value="0">
                      <div class="form-text">Enter landlord's monthly income in your local currency. Use 0 if unknown.</div>
                      <div class="invalid-feedback" id="income-error"></div>
                    </div>

                    <div class="mb-4">
                      <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                      <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="255">
                      <div class="form-text">Password must be at least 8 characters long.</div>
                      <div class="invalid-feedback" id="password-error"></div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="{{ route('landlords') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Landlords
                      </a>
                      <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="ti ti-plus me-1"></i> Add Landlord
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
            <p class="mb-0" id="successMessage">Landlord has been added successfully!</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="{{ route('landlords') }}" class="btn btn-primary">View Landlords</a>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('addLandlordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Adding...';
    
    // Clear previous errors
    clearFormErrors();
    
    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    console.log('=== FORM DEBUG ===');
    console.log('Form data being sent:', jsonData);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    console.log('Route URL:', '{{ route("landlords.store") }}');
    
    // Try with FormData first (traditional form submission)
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page and try again.');
        return;
    }
    
    // Add CSRF token to FormData
    formData.append('_token', csrfToken);
    
    fetch('{{ route("landlords.store") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('=== RESPONSE DEBUG ===');
        console.log('Status:', response.status);
        console.log('Status Text:', response.statusText);
        console.log('Headers:', response.headers);
        
        if (response.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        
        // Always try to parse JSON, even for error responses
        return response.text().then(text => {
            console.log('Raw response text:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON response:', e);
                console.error('Response text:', text);
                throw new Error('Invalid JSON response from server');
            }
        });
    })
    .then(data => {
        if (!data) return;
        
        if (data.success) {
            // Show success modal
            document.getElementById('successMessage').textContent = data.message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
            // Reset form
            document.getElementById('addLandlordForm').reset();
        } else {
            // Handle validation errors
            if (data.errors) {
                displayFormErrors(data.errors);
            } else if (data.api_errors) {
                displayFormErrors(data.api_errors);
            } else {
                console.log('=== LANDLORD CREATION ERROR ===');
                console.log('Full error response:', JSON.stringify(data, null, 2));
                console.log('Message:', data.message);
                
                if (data.debug) {
                    console.log('=== DEBUG INFORMATION ===');
                    console.log('Error:', data.debug.error);
                    console.log('API Status Code:', data.debug.status_code);
                    console.log('API URL:', data.debug.api_url);
                    console.log('Sent Data:', JSON.stringify(data.debug.sent_data, null, 2));
                    console.log('API Response Body:', JSON.stringify(data.debug.response_body, null, 2));
                }
                
                console.log('=== END ERROR INFO ===');
                
                // Show user-friendly message for known income issue
                if (data.known_issue) {
                    alert('⚠️ Known API Issue\n\n' + data.message + '\n\nThis is a technical issue that needs to be resolved by the API development team.');
                } else {
                    // Show simple alert but detailed info is in console
                    alert('Error creating landlord. Check browser console (F12) for detailed information.');
                }
            }
        }
    })
    .catch(error => {
        console.error('=== CATCH ERROR ===');
        console.error('Error object:', error);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);
        
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        alert('An error occurred while adding the landlord. Check console for details.');
    })
    .finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
});

function clearFormErrors() {
    const errorElements = document.querySelectorAll('.invalid-feedback');
    const inputElements = document.querySelectorAll('.form-control');
    
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