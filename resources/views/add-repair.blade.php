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
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">Add New</span>
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
                            <form id="addRepairForm" method="POST">
                                @csrf
                                
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

                                <!-- Priority (required by controller) -->
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select" id="priority" name="priority" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>

                                <!-- Description (required by controller) -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required placeholder="Describe the repair issue"></textarea>
                                    <div class="form-text">Detailed description of the repair needed.</div>
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
                                        <label for="who_is_handling_the_repair" class="form-label">Who is Handling the Repair</label>
                                        <input type="text" class="form-control" id="who_is_handling_the_repair" name="who_is_handling_the_repair" maxlength="100" placeholder="Person handling repair">
                                        <div class="form-text">Person responsible for the repair</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cost_of_repair" class="form-label">Cost <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="cost_of_repair" name="cost_of_repair" step="0.01" min="0" required placeholder="0.00">
                                        <div class="form-text">Estimated or actual cost of repair.</div>
                                    </div>
                                </div>

                                <!-- Status and Date -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="repair_status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="repair_status" name="repair_status" required>
                                            <option value="pending" selected>Pending</option>
                                            <option value="on going">On Going</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="repair_date" class="form-label">Repair Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="repair_date" name="repair_date" required>
                                        <div class="form-text">Date when repair is scheduled/completed.</div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description_of_the_repair" class="form-label">Additional Description</label>
                                    <textarea class="form-control" id="description_of_the_repair" name="description_of_the_repair" rows="3" placeholder="Additional details or notes"></textarea>
                                    <div class="form-text">Optional: Any additional details about the repair.</div>
                                </div>

                                <!-- Feedback -->
                                <div class="mb-3">
                                    <label for="feedback" class="form-label">Feedback</label>
                                    <textarea class="form-control" id="feedback" name="feedback" rows="2" placeholder="Feedback or comments"></textarea>
                                    <div class="form-text">Optional: Feedback about the repair.</div>
                                </div>

                                <!-- Hidden fields for image data -->
                                <input type="hidden" id="image_folder" name="image_folder" value="public">
                                <input type="hidden" id="images_paths" name="images_paths" value="">

                                <!-- Image Upload -->
                                <div class="mb-4">
                                    <label for="repair_images" class="form-label">Repair Images</label>
                                    <input type="file" class="form-control" id="repair_images" name="repair_images[]" multiple accept="image/*">
                                    <div class="form-text">Optional: Upload images related to the repair.</div>
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('repairs') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-arrow-left me-1"></i> Back to Repairs
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="ti ti-plus me-1"></i> Create Repair
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
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success">
                        <i class="ti ti-check-circle me-2"></i>Success
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="successMessage">Repair created successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('repairs') }}" class="btn btn-primary">View Repairs</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="ti ti-alert-circle me-2"></i>Error Creating Repair
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="errorMessage" class="mb-3"></div>
                    <div id="errorDetails" class="collapse">
                        <hr>
                        <h6 class="text-muted mb-2">Technical Details:</h6>
                        <pre id="errorDebugInfo" class="bg-light p-3 rounded" style="font-size: 12px; max-height: 300px; overflow-y: auto;"></pre>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#errorDetails">
                        <i class="ti ti-code me-1"></i>Show Details
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('repair_date').value = today;
    
    // Load properties for dropdown
    loadProperties();
    
    // Setup image preview
    document.getElementById('repair_images').addEventListener('change', function(e) {
        previewImages(e.target.files);
    });
});

// Load properties from API
function loadProperties() {
    console.log('Loading properties...');
    
    fetch('/properties/load', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Properties response:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Properties data:', data);
        const select = document.getElementById('property_id');
        
        if (data && data.success && data.properties) {
            console.log(`Found ${data.properties.length} properties`);
            
            data.properties.forEach(property => {
                const option = document.createElement('option');
                
                // Handle different possible ID field names from API
                const propertyId = property.id || property.propertyId || property.property_id;
                option.value = propertyId; // This is what gets submitted to database
                
                // Handle different possible name/address field names from API
                let displayText = '';
                const title = property.title || property.property_name || property.name;
                const address = property.address || property.property_address || property.location;
                
                if (title) {
                    displayText = title;
                    if (address) {
                        displayText += ` - ${address}`;
                    }
                } else if (address) {
                    displayText = address;
                } else {
                    displayText = `Property ${propertyId}`;
                }
                
                option.textContent = displayText;
                select.appendChild(option);
                console.log(`Added: ${propertyId} = "${displayText}"`);
            });
            
            console.log('Properties loaded successfully');
        } else {
            console.error('No properties found or API failed:', data);
        }
    })
    .catch(error => {
        console.error('Error loading properties:', error);
    });
}

// Preview selected images
function previewImages(files) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (files.length === 0) return;
    
    const title = document.createElement('div');
    title.className = 'small text-muted mb-2';
    title.textContent = `${files.length} image(s) selected`;
    preview.appendChild(title);
    
    Array.from(files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'd-inline-block me-2 mb-2';
                container.style.maxWidth = '150px';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                
                const name = document.createElement('div');
                name.className = 'small text-muted text-center mt-1';
                name.textContent = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
                
                container.appendChild(img);
                container.appendChild(name);
                preview.appendChild(container);
            };
            reader.readAsDataURL(file);
        }
    });
}

// Handle form submission
document.getElementById('addRepairForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    
    // Prepare form data
    const formData = new FormData(this);
    
    // Handle images if selected
    const imageFiles = formData.getAll('repair_images[]');
    if (imageFiles.length > 0 && imageFiles[0].size > 0) {
        const imagePaths = [];
        imageFiles.forEach((file, index) => {
            if (file.size > 0) {
                const timestamp = Date.now();
                const ext = file.name.split('.').pop();
                imagePaths.push(`/uploads/repairs/repair_${timestamp}_${index}.${ext}`);
            }
        });
        formData.set('images_paths', JSON.stringify(imagePaths));
    }
    
    // Log form data being sent
    console.log('Form data being sent:');
    console.log('=== CHECKING REQUIRED FIELDS (API EXPECTS) ===');
    console.log('property_id:', formData.get('property_id'));
    console.log('title_of_repair:', formData.get('title_of_repair'));
    console.log('type_of_repair:', formData.get('type_of_repair'));
    console.log('cost_of_repair:', formData.get('cost_of_repair'));
    console.log('repair_status:', formData.get('repair_status'));
    console.log('=== ALL FORM DATA ===');
    for (let pair of formData.entries()) {
        if (pair[0] === 'repair_images[]') {
            console.log(pair[0] + ': [File] ' + pair[1].name + ' (' + pair[1].size + ' bytes)');
        } else {
            console.log(pair[0] + ': ' + pair[1]);
        }
    }
    
    // Submit to server
    fetch('/repairs/store', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            // Show success modal
            document.getElementById('successMessage').textContent = data.message;
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
            
            // Reset form
            document.getElementById('addRepairForm').reset();
            document.getElementById('repair_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('repair_status').value = 'pending';
            document.getElementById('priority').value = 'medium';
            document.getElementById('imagePreview').innerHTML = '';
            
        } else {
            // Handle validation errors with better display
            console.log('Full error response:', data);
            
            // Show detailed error modal instead of basic alert
            showErrorModal(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal({
            message: 'Network error occurred while creating the repair',
            debug: {
                error: error.message,
                stack: error.stack
            }
        });
    })
    .finally(() => {
        // Restore button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Function to show detailed error modal
function showErrorModal(data) {
    let errorMessage = data.message || data.error || 'An error occurred while creating the repair';
    
    // Format the error message for better display
    let formattedMessage = '';
    
    if (data.errors) {
        // Laravel validation errors
        formattedMessage = '<div class="alert alert-danger"><strong>Validation Errors:</strong><ul class="mb-0 mt-2">';
        Object.keys(data.errors).forEach(field => {
            const errors = Array.isArray(data.errors[field]) ? data.errors[field] : [data.errors[field]];
            errors.forEach(error => {
                formattedMessage += `<li><strong>${field}:</strong> ${error}</li>`;
            });
        });
        formattedMessage += '</ul></div>';
    } else if (data.api_errors && Object.keys(data.api_errors).length > 0) {
        // API validation errors
        formattedMessage = '<div class="alert alert-warning"><strong>API Validation Errors:</strong><ul class="mb-0 mt-2">';
        Object.keys(data.api_errors).forEach(field => {
            const errors = Array.isArray(data.api_errors[field]) ? data.api_errors[field] : [data.api_errors[field]];
            errors.forEach(error => {
                formattedMessage += `<li><strong>${field}:</strong> ${error}</li>`;
            });
        });
        formattedMessage += '</ul></div>';
    } else {
        // General error
        formattedMessage = `<div class="alert alert-danger">${errorMessage}</div>`;
    }
    
    // Set the error message
    document.getElementById('errorMessage').innerHTML = formattedMessage;
    
    // Set debug information if available
    if (data.debug) {
        document.getElementById('errorDebugInfo').textContent = JSON.stringify(data.debug, null, 2);
    } else {
        document.getElementById('errorDebugInfo').textContent = 'No debug information available';
    }
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('errorModal'));
    modal.show();
}
</script>
@endpush