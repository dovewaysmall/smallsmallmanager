@extends('layouts.app')

@section('title', 'Add New Repair')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Add New Repair</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('repairs') }}">Repairs</a>
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
                  <form id="addRepairForm" method="POST" action="{{ route('repairs.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                      <label for="property_id" class="form-label">Property <span class="text-danger">*</span></label>
                      <select class="form-select" id="property_id" name="property_id" required>
                        <option value="">Select a property...</option>
                        <!-- Properties will be loaded here -->
                      </select>
                      <div class="form-text">Select the property that needs repair.</div>
                      <div class="invalid-feedback" id="property_id-error"></div>
                    </div>

                    <div class="mb-3">
                      <label for="description" class="form-label">Repair Description <span class="text-danger">*</span></label>
                      <textarea class="form-control" id="description" name="description" rows="4" required maxlength="1000" placeholder="Describe the repair issue in detail..."></textarea>
                      <div class="form-text">Provide a detailed description of the repair needed.</div>
                      <div class="invalid-feedback" id="description-error"></div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                        <select class="form-select" id="priority" name="priority" required>
                          <option value="">Select priority...</option>
                          <option value="low">Low</option>
                          <option value="medium" selected>Medium</option>
                          <option value="high">High</option>
                          <option value="urgent">Urgent</option>
                        </select>
                        <div class="invalid-feedback" id="priority-error"></div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                          <option value="">Select category...</option>
                          <option value="plumbing">Plumbing</option>
                          <option value="electrical">Electrical</option>
                          <option value="hvac">HVAC</option>
                          <option value="appliances">Appliances</option>
                          <option value="structural">Structural</option>
                          <option value="painting">Painting</option>
                          <option value="flooring">Flooring</option>
                          <option value="roofing">Roofing</option>
                          <option value="landscaping">Landscaping</option>
                          <option value="security">Security</option>
                          <option value="other">Other</option>
                        </select>
                        <div class="invalid-feedback" id="category-error"></div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="tenant_id" class="form-label">Requesting Tenant</label>
                        <select class="form-select" id="tenant_id" name="tenant_id">
                          <option value="">Select tenant...</option>
                          <!-- Tenants will be loaded here -->
                        </select>
                        <div class="form-text">Optional: Select the tenant who requested this repair.</div>
                        <div class="invalid-feedback" id="tenant_id-error"></div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <label for="assignee" class="form-label">Assign To</label>
                        <input type="text" class="form-control" id="assignee" name="assignee" placeholder="Technician or company name">
                        <div class="form-text">Optional: Assign this repair to a specific technician or company.</div>
                        <div class="invalid-feedback" id="assignee-error"></div>
                      </div>
                    </div>

                    <!-- Error Alert -->
                    <div class="alert alert-danger d-none" id="errorAlert">
                      <i class="ti ti-alert-circle me-2"></i>
                      <strong>Error:</strong> <span id="errorAlertMessage">An error occurred</span>
                      <button type="button" class="btn-close float-end" aria-label="Close" onclick="hideErrorAlert()"></button>
                    </div>

                    <!-- Debug Info Alert -->
                    <div class="alert alert-warning d-none" id="debugAlert">
                      <i class="ti ti-bug me-2"></i>
                      <strong>Debug Information:</strong>
                      <button type="button" class="btn-close float-end" aria-label="Close" onclick="hideDebugAlert()"></button>
                      <div class="mt-2" id="debugContent"></div>
                    </div>

                    <div class="alert alert-info">
                      <i class="ti ti-info-circle me-2"></i>
                      <strong>Note:</strong> The repair request will be created with a "Pending" status. You can update the status and assign technicians after creation.
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="{{ route('repairs') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Repairs
                      </a>
                      <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="ti ti-plus me-1"></i> Create Repair Request
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
            <p class="mb-0" id="successMessage">Repair request has been created successfully!</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a href="{{ route('repairs') }}" class="btn btn-primary">View Repairs</a>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadProperties();
    loadTenants();
});

function loadProperties() {
    fetch('/properties/load', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const propertySelect = document.getElementById('property_id');
        
        if (data && data.success && data.properties) {
            data.properties.forEach(property => {
                const option = document.createElement('option');
                option.value = property.id || property.propertyId;
                option.textContent = property.title || property.property_name || property.address || 'Unknown Property';
                propertySelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error loading properties:', error);
    });
}

function loadTenants() {
    fetch('/tenants/load', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const tenantSelect = document.getElementById('tenant_id');
        
        if (data && data.success && data.tenants) {
            data.tenants.forEach(tenant => {
                const option = document.createElement('option');
                option.value = tenant.userID || tenant.id;
                const name = `${tenant.firstName || ''} ${tenant.lastName || ''}`.trim() || tenant.email || 'Unknown Tenant';
                option.textContent = name;
                tenantSelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error loading tenants:', error);
    });
}

document.getElementById('addRepairForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    console.log('=== REPAIR FORM SUBMISSION DEBUG ===');
    
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating...';
    
    // Clear previous errors
    clearFormErrors();
    hideErrorAlert();
    hideDebugAlert();
    
    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        if (key !== '_token') {
            jsonData[key] = value;
        }
    });
    
    console.log('Form data being sent:', jsonData);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    console.log('Route URL:', '{{ route("repairs.store") }}');
    
    fetch('{{ route("repairs.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (response.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        
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
        console.log('Parsed response data:', data);
        
        if (!data) return;
        
        if (data.success) {
            console.log('Success! Repair created successfully');
            
            // Hide any previous error messages
            hideErrorAlert();
            hideDebugAlert();
            
            // Show success modal
            document.getElementById('successMessage').textContent = data.message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
            // Reset form
            document.getElementById('addRepairForm').reset();
            document.getElementById('priority').value = 'medium'; // Reset to default
        } else {
            console.log('Error response:', data);
            
            // Handle validation errors
            if (data.errors) {
                console.log('Validation errors:', data.errors);
                displayFormErrors(data.errors);
                showErrorAlert('Validation failed. Please check the form fields below.');
            } else if (data.api_errors) {
                console.log('API errors:', data.api_errors);
                displayFormErrors(data.api_errors);
                showErrorAlert('API validation failed. Please check the form fields below.');
            } else {
                console.log('General error:', data.message);
                
                // Show error message
                showErrorAlert(data.message || 'Unknown error occurred while creating repair request');
                
                // Show debug information if available
                if (data.debug) {
                    console.log('=== DEBUG INFORMATION ===');
                    console.log('API Status Code:', data.debug.status_code);
                    console.log('API Response Body:', data.debug.response_body);
                    console.log('Sent Data:', data.debug.sent_data);
                    console.log('API URL:', data.debug.api_url);
                    
                    showDebugAlert(data.debug);
                }
            }
        }
    })
    .catch(error => {
        console.error('=== CATCH ERROR ===');
        console.error('Error object:', error);
        console.error('Error message:', error.message);
        console.error('Error stack:', error.stack);
        
        showErrorAlert('Network error or server issue occurred. Please check your connection and try again.');
        
        showDebugAlert({
            error_type: 'Network/JavaScript Error',
            error_message: error.message,
            error_stack: error.stack
        });
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

function showErrorAlert(message) {
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorAlertMessage');
    
    errorMessage.textContent = message;
    errorAlert.classList.remove('d-none');
    
    // Scroll to error message
    errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function hideErrorAlert() {
    const errorAlert = document.getElementById('errorAlert');
    errorAlert.classList.add('d-none');
}

function showDebugAlert(debugInfo) {
    const debugAlert = document.getElementById('debugAlert');
    const debugContent = document.getElementById('debugContent');
    
    let debugHtml = '<div class="small">';
    
    if (debugInfo.api_url) {
        debugHtml += `<div><strong>API URL:</strong> ${debugInfo.api_url}</div>`;
    }
    
    if (debugInfo.status_code) {
        debugHtml += `<div><strong>Status Code:</strong> ${debugInfo.status_code}</div>`;
    }
    
    if (debugInfo.error_type) {
        debugHtml += `<div><strong>Error Type:</strong> ${debugInfo.error_type}</div>`;
    }
    
    if (debugInfo.error_message) {
        debugHtml += `<div><strong>Error Message:</strong> ${debugInfo.error_message}</div>`;
    }
    
    if (debugInfo.response_body) {
        debugHtml += `<div><strong>API Response:</strong></div>`;
        debugHtml += `<pre class="bg-light p-2 rounded mt-1">${JSON.stringify(debugInfo.response_body, null, 2)}</pre>`;
    }
    
    if (debugInfo.sent_data) {
        debugHtml += `<div><strong>Data Sent:</strong></div>`;
        debugHtml += `<pre class="bg-light p-2 rounded mt-1">${JSON.stringify(debugInfo.sent_data, null, 2)}</pre>`;
    }
    
    if (debugInfo.error_stack) {
        debugHtml += `<div><strong>Stack Trace:</strong></div>`;
        debugHtml += `<pre class="bg-light p-2 rounded mt-1">${debugInfo.error_stack}</pre>`;
    }
    
    debugHtml += '</div>';
    
    debugContent.innerHTML = debugHtml;
    debugAlert.classList.remove('d-none');
}

function hideDebugAlert() {
    const debugAlert = document.getElementById('debugAlert');
    debugAlert.classList.add('d-none');
}
</script>
@endpush