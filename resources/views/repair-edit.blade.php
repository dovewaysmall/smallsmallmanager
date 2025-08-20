@extends('layouts.app')

@section('title', 'Edit Repair')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Edit Repair</h4>
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
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="{{ route('repair.show', $repairId) }}">Details</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">Edit</span>
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
                            <div id="loadingState" class="text-center py-5">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mb-0 text-muted">Loading repair data...</p>
                            </div>

                            <div id="errorState" class="d-none">
                                <div class="alert alert-danger">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    <span id="errorMessage">Failed to load repair data</span>
                                </div>
                                <button onclick="loadRepairData()" class="btn btn-outline-primary">
                                    <i class="ti ti-refresh me-1"></i> Retry
                                </button>
                            </div>

                            <form id="editRepairForm" method="PUT" class="d-none">
                                @csrf
                                @method('PUT')
                                
                                <!-- Title of Repair -->
                                <div class="mb-3">
                                    <label for="title_of_repair" class="form-label">Repair Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title_of_repair" name="title_of_repair" required maxlength="100" placeholder="Brief title for the repair">
                                    <div class="form-text">Enter a brief title describing the repair.</div>
                                </div>

                                <!-- Property ID -->
                                <div class="mb-3">
                                    <label for="property_id" class="form-label">Property <span class="text-danger">*</span></label>
                                    <select class="form-select" id="property_id" name="property_id" required>
                                        <option value="">Select a property...</option>
                                    </select>
                                    <div class="form-text">Select the property that needs repair.</div>
                                </div>

                                <!-- Type of Repair -->
                                <div class="mb-3">
                                    <label for="type_of_repair" class="form-label">Type of Repair <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type_of_repair" name="type_of_repair" required>
                                        <option value="">Select repair type...</option>
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
                                </div>

                                <!-- Items Repaired -->
                                <div class="mb-3">
                                    <label for="items_repaired" class="form-label">Items to be Repaired <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="items_repaired" name="items_repaired" rows="3" required placeholder="Describe the items that need repair"></textarea>
                                    <div class="form-text">List the specific items or areas that need repair.</div>
                                </div>

                                <!-- Handler and Cost -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="who_is_handling_repair" class="form-label">Who is Handling the Repair</label>
                                        <input type="text" class="form-control" id="who_is_handling_repair" name="who_is_handling_repair" maxlength="100" placeholder="Person handling repair">
                                        <div class="form-text">Person responsible for the repair</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cost_of_repair" class="form-label">Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="cost_of_repair" name="cost_of_repair" step="0.01" min="0" required placeholder="0.00">
                                        <div class="form-text">Estimated or actual cost of repair.</div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="repair_status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="repair_status" name="repair_status" required>
                                        <option value="pending">Pending</option>
                                        <option value="on going">On Going</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description_of_the_repair" class="form-label">Description</label>
                                    <textarea class="form-control" id="description_of_the_repair" name="description_of_the_repair" rows="3" placeholder="Additional details or notes"></textarea>
                                    <div class="form-text">Optional: Any additional details about the repair.</div>
                                </div>

                                <!-- Feedback -->
                                <div class="mb-3">
                                    <label for="feedback" class="form-label">Feedback</label>
                                    <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Feedback about the repair"></textarea>
                                    <div class="form-text">Optional: Any feedback about the repair work.</div>
                                </div>

                                <!-- Error Alert -->
                                <div class="alert alert-danger d-none" id="errorAlert">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    <strong>Error:</strong> <span id="errorAlertMessage">An error occurred</span>
                                    <button type="button" class="btn-close float-end" aria-label="Close" onclick="hideErrorAlert()"></button>
                                </div>

                                <!-- Success Alert -->
                                <div class="alert alert-success d-none" id="successAlert">
                                    <i class="ti ti-check me-2"></i>
                                    <strong>Success:</strong> <span id="successAlertMessage">Repair updated successfully</span>
                                    <button type="button" class="btn-close float-end" aria-label="Close" onclick="hideSuccessAlert()"></button>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                        <i class="ti ti-arrow-left me-1"></i> Cancel
                                    </button>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" onclick="window.location.href='{{ route('repair.show', $repairId) }}'">
                                            <i class="ti ti-eye me-1"></i> View Details
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitButton">
                                            <span class="spinner-border spinner-border-sm d-none me-2" id="submitSpinner" role="status" aria-hidden="true"></span>
                                            <i class="ti ti-device-floppy me-1" id="submitIcon"></i>
                                            <span id="submitText">Update Repair</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const repairId = {{ $repairId }};
let repairData = null;
let allProperties = [];

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('editRepairForm').classList.add('d-none');
    
    if (stateName) {
        document.getElementById(stateName).classList.remove('d-none');
    }
}

async function loadProperties() {
    try {
        const response = await fetch('{{ route("properties.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        if (data.success && data.properties) {
            allProperties = data.properties;
            populatePropertySelect();
        }
    } catch (error) {
        console.error('Error loading properties:', error);
    }
}

function populatePropertySelect() {
    const propertySelect = document.getElementById('property_id');
    propertySelect.innerHTML = '<option value="">Select a property...</option>';
    
    allProperties.forEach(property => {
        const propertyName = property.property_title || property.property_name || property.address || `Property ${property.id}`;
        const option = document.createElement('option');
        option.value = property.id;
        option.textContent = propertyName;
        propertySelect.appendChild(option);
    });
}

async function loadRepairData() {
    showState('loadingState');
    
    try {
        const response = await fetch('{{ route("repairs.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();
        if (data.success && data.repairs) {
            const repair = data.repairs.find(r => r.id == repairId);
            if (repair) {
                repairData = repair;
                populateForm(repair);
                showState('editRepairForm');
            } else {
                document.getElementById('errorMessage').textContent = 'Repair not found';
                showState('errorState');
            }
        } else {
            document.getElementById('errorMessage').textContent = data.error || 'Failed to load repair data';
            showState('errorState');
        }
    } catch (error) {
        console.error('Error loading repair data:', error);
        document.getElementById('errorMessage').textContent = 'Network error occurred';
        showState('errorState');
    }
}

function populateForm(repair) {
    document.getElementById('title_of_repair').value = repair.title_of_repair || '';
    document.getElementById('property_id').value = repair.property_id || '';
    document.getElementById('type_of_repair').value = repair.type_of_repair || '';
    document.getElementById('items_repaired').value = repair.items_repaired || '';
    document.getElementById('who_is_handling_repair').value = repair.who_is_handling_repair || '';
    document.getElementById('cost_of_repair').value = repair.cost_of_repair || '';
    document.getElementById('repair_status').value = repair.repair_status || 'pending';
    document.getElementById('description_of_the_repair').value = repair.description_of_repair || repair['description_of_the repair'] || '';
    document.getElementById('feedback').value = repair.feedback || '';
}

function showSubmitLoading(show) {
    const submitButton = document.getElementById('submitButton');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    
    if (show) {
        submitButton.disabled = true;
        submitSpinner.classList.remove('d-none');
        submitIcon.classList.add('d-none');
        submitText.textContent = 'Updating...';
    } else {
        submitButton.disabled = false;
        submitSpinner.classList.add('d-none');
        submitIcon.classList.remove('d-none');
        submitText.textContent = 'Update Repair';
    }
}

function showErrorAlert(message) {
    document.getElementById('errorAlertMessage').textContent = message;
    document.getElementById('errorAlert').classList.remove('d-none');
    hideSuccessAlert();
}

function hideErrorAlert() {
    document.getElementById('errorAlert').classList.add('d-none');
}

function showSuccessAlert(message) {
    document.getElementById('successAlertMessage').textContent = message;
    document.getElementById('successAlert').classList.remove('d-none');
    hideErrorAlert();
}

function hideSuccessAlert() {
    document.getElementById('successAlert').classList.add('d-none');
}

// Form submission
document.getElementById('editRepairForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    showSubmitLoading(true);
    hideErrorAlert();
    hideSuccessAlert();
    
    const formData = new FormData(this);
    const repairData = {};
    
    // Convert FormData to object
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && key !== '_method') {
            // Handle empty values for optional fields - send empty string instead of null
            repairData[key] = value || '';
        }
    }
    
    console.log('Sending repair data:', repairData);
    
    try {
        const response = await fetch(`{{ url('/repair') }}/${repairId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(repairData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showSuccessAlert(result.message || 'Repair updated successfully!');
            // Optionally redirect after a delay
            setTimeout(() => {
                window.location.href = `{{ route('repair.show', $repairId) }}`;
            }, 2000);
        } else {
            // Handle validation errors
            let errorMessage = result.message || 'Failed to update repair';
            
            if (result.errors || result.api_errors) {
                // Display specific validation errors
                const errors = result.errors || result.api_errors;
                const errorList = Object.entries(errors).map(([field, messages]) => {
                    const fieldMessages = Array.isArray(messages) ? messages.join(', ') : messages;
                    return `${field}: ${fieldMessages}`;
                }).join('\n');
                errorMessage = `Validation failed:\n${errorList}`;
                console.log('Detailed validation errors:', errors);
            }
            
            showErrorAlert(errorMessage);
            console.error('API Error:', result);
            
            // Log debug information if available
            if (result.debug) {
                console.error('Debug info:', result.debug);
            }
        }
    } catch (error) {
        console.error('Error updating repair:', error);
        showErrorAlert('Network error occurred while updating repair');
    } finally {
        showSubmitLoading(false);
    }
});

// Load data when page is ready
document.addEventListener('DOMContentLoaded', async function() {
    await loadProperties();
    loadRepairData();
});
</script>
@endpush