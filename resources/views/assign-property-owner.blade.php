@extends('layouts.app')

@section('title', 'Assign Property Owner')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Assign Property Owner</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('properties') }}">Properties</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Assign Owner
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4">Property Details</h5>
                  <div id="propertyDetails">
                    <div class="d-flex justify-content-center py-5">
                      <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4">Assign Owner</h5>
                  
                  <div class="mb-3">
                    <label for="searchLandlord" class="form-label">Search Landlords</label>
                    <input type="text" class="form-control" id="searchLandlord" placeholder="Type to search landlords...">
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label">Available Landlords</label>
                    <div id="landlordsList" style="max-height: 300px; overflow-y: auto;">
                      <div class="d-flex justify-content-center py-3">
                        <div class="spinner-border text-primary" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="mt-4">
                    <button class="btn btn-primary" id="assignOwnerBtn" disabled>
                      <i class="ti ti-check me-1"></i> Assign Owner
                    </button>
                    <a href="{{ route('properties') }}" class="btn btn-outline-secondary ms-2">
                      <i class="ti ti-arrow-left me-1"></i> Back to Properties
                    </a>
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
const propertyId = {{ $propertyId }};
let selectedLandlord = null;
let allLandlords = [];

// Load property details
function loadPropertyDetails() {
    document.getElementById('propertyDetails').innerHTML = `
        <div class="d-flex justify-content-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    // Get access token from session and make API call
    fetch('/api/property-details/' + propertyId, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 419 || response.status === 401) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        if (data.success && data.data && data.data.property) {
            const property = data.data.property;
            renderPropertyDetails(property);
        } else {
            // Check if the error message indicates session expiry
            if (data.message && (data.message.includes('Session expired') || data.message.includes('expired'))) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            document.getElementById('propertyDetails').innerHTML = `
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    ${data.message || 'Failed to load property details'}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('propertyDetails').innerHTML = `
            <div class="alert alert-danger">
                <i class="ti ti-x me-2"></i>
                An error occurred while loading property details
            </div>
        `;
    });
}

// Render property details
function renderPropertyDetails(property) {
    const propertyTitle = property.propertyTitle || property.title || 'N/A';
    const propertyID = property.propertyID || property.id || 'N/A';
    const location = property.location || property.address || 'N/A';
    const type = property.type || property.propertyType || 'N/A';
    const price = property.price || property.rent || 'N/A';
    const status = property.status || property.availability || 'Available';
    const description = property.description || property.propertyDescription || '';
    
    // Format price
    let formattedPrice = price;
    if (price !== 'N/A' && price && !isNaN(price)) {
        formattedPrice = '₦' + parseInt(price).toLocaleString();
    }
    
    // Status badge color
    let statusClass = 'bg-secondary';
    switch (status.toLowerCase()) {
        case 'available':
        case 'active':
            statusClass = 'bg-success';
            break;
        case 'rented':
        case 'occupied':
            statusClass = 'bg-info';
            break;
        case 'maintenance':
            statusClass = 'bg-warning text-dark';
            break;
        case 'unavailable':
        case 'inactive':
            statusClass = 'bg-danger';
            break;
    }
    
    document.getElementById('propertyDetails').innerHTML = `
        <div class="d-flex align-items-start mb-3">
            <iconify-icon icon="solar:home-angle-line-duotone" class="fs-2 text-primary me-3 mt-1"></iconify-icon>
            <div class="flex-grow-1">
                <h6 class="mb-1">${propertyTitle}</h6>
                <small class="text-muted">ID: ${propertyID}</small>
            </div>
            <span class="badge ${statusClass}">${status}</span>
        </div>
        
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:map-point-line-duotone" class="text-muted me-2"></iconify-icon>
                    <div>
                        <small class="text-muted d-block">Location</small>
                        <span class="fw-medium">${location}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:home-2-line-duotone" class="text-muted me-2"></iconify-icon>
                    <div>
                        <small class="text-muted d-block">Type</small>
                        <span class="fw-medium">${type}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:dollar-minimalistic-line-duotone" class="text-muted me-2"></iconify-icon>
                    <div>
                        <small class="text-muted d-block">Price</small>
                        <span class="fw-medium">${formattedPrice}</span>
                    </div>
                </div>
            </div>
        </div>
        
        ${description ? `
            <div class="mt-3">
                <small class="text-muted d-block mb-1">Description</small>
                <p class="mb-0 small">${description}</p>
            </div>
        ` : ''}
    `;
}

// Load landlords
function loadLandlords() {
    fetch('{{ route("landlords.load") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 419 || response.status === 401) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        if (data.success) {
            allLandlords = data.landlords;
            
            
            renderLandlords(allLandlords);
        } else {
            // Check if the error message indicates session expiry
            if (data.error && (data.error.includes('Session expired') || data.error.includes('expired'))) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            document.getElementById('landlordsList').innerHTML = `
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    ${data.error || 'Failed to load landlords'}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('landlordsList').innerHTML = `
            <div class="alert alert-danger">
                <i class="ti ti-x me-2"></i>
                An error occurred while loading landlords
            </div>
        `;
    });
}

// Render landlords list
function renderLandlords(landlords) {
    const landlordsList = document.getElementById('landlordsList');
    
    if (landlords.length === 0) {
        landlordsList.innerHTML = `
            <div class="text-center py-4">
                <iconify-icon icon="solar:user-line-duotone" class="fs-1 text-muted mb-2"></iconify-icon>
                <p class="text-muted mb-0">No landlords found</p>
            </div>
        `;
        return;
    }
    
    // Clear the container
    landlordsList.innerHTML = '';
    
    landlords.forEach((landlord, index) => {
        const firstName = landlord.firstName || landlord.first_name || 'N/A';
        const lastName = landlord.lastName || landlord.last_name || 'N/A';
        const email = landlord.email || 'N/A';
        const phone = landlord.phone || landlord.phoneNumber || 'N/A';
        const fullName = `${firstName} ${lastName}`.trim();
        const landlordId = landlord.userID || landlord.id || landlord.landlordId;
        
        // Create element
        const itemDiv = document.createElement('div');
        itemDiv.className = 'border rounded p-3 mb-2';
        itemDiv.style.cssText = 'cursor: pointer; background-color: rgba(13, 110, 253, 0.1); border: 1px solid #dee2e6 !important;';
        itemDiv.setAttribute('data-landlord-id', landlordId);
        
        itemDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="mb-1">${fullName}</h6>
                    <div class="text-muted small">
                        <div><i class="ti ti-mail me-1"></i> ${email}</div>
                        <div><i class="ti ti-phone me-1"></i> ${phone}</div>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="landlordRadio" value="${landlordId}" id="radio-${index}">
                </div>
            </div>
        `;
        
        // Add click event
        itemDiv.addEventListener('click', function() {
            selectLandlord(landlordId, itemDiv);
        });
        
        // Add radio change event
        const radio = itemDiv.querySelector('input[type="radio"]');
        radio.addEventListener('change', function() {
            if (this.checked) {
                selectLandlord(landlordId, itemDiv);
            }
        });
        
        landlordsList.appendChild(itemDiv);
    });
}

// Select landlord (unified function)
function selectLandlord(landlordId, clickedElement) {
    // Find landlord data
    const landlord = allLandlords.find(l => (l.userID || l.id || l.landlordId) == landlordId);
    if (!landlord) return;
    
    selectedLandlord = landlord;
    
    // Clear all selections
    document.querySelectorAll('[data-landlord-id]').forEach(item => {
        item.style.cssText = 'cursor: pointer; background-color: rgba(13, 110, 253, 0.1); border: 1px solid #dee2e6;';
        const radio = item.querySelector('input[type="radio"]');
        if (radio) radio.checked = false;
    });
    
    // Select current item
    clickedElement.style.cssText = 'cursor: pointer; background-color: rgba(13, 110, 253, 0.15); border: 1px solid var(--bs-primary);';
    const radio = clickedElement.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
    
    // Enable assign button
    document.getElementById('assignOwnerBtn').disabled = false;
}

// Clear all selections
function clearAllSelections() {
    document.querySelectorAll('[data-landlord-id]').forEach(item => {
        item.style.cssText = 'cursor: pointer; background-color: rgba(13, 110, 253, 0.1); border: 1px solid #dee2e6;';
        const radio = item.querySelector('input[type="radio"]');
        if (radio) radio.checked = false;
    });
    
    selectedLandlord = null;
    document.getElementById('assignOwnerBtn').disabled = true;
}

// Get currently filtered landlords (used for search)
function getFilteredLandlords() {
    const searchTerm = document.getElementById('searchLandlord').value.toLowerCase().trim();
    
    if (searchTerm === '') {
        return allLandlords;
    } else {
        return allLandlords.filter(landlord => {
            const fullName = `${landlord.firstName || landlord.first_name || ''} ${landlord.lastName || landlord.last_name || ''}`.toLowerCase();
            const email = (landlord.email || '').toLowerCase();
            const phone = (landlord.phone || landlord.phoneNumber || '').toLowerCase();
            
            return fullName.includes(searchTerm) || 
                   email.includes(searchTerm) || 
                   phone.includes(searchTerm);
        });
    }
}

// Search functionality
document.getElementById('searchLandlord').addEventListener('input', function() {
    // Clear all selections first
    clearAllSelections();
    
    // Render filtered landlords
    const filteredLandlords = getFilteredLandlords();
    renderLandlords(filteredLandlords);
});

// Assign owner
document.getElementById('assignOwnerBtn').addEventListener('click', function() {
    if (!selectedLandlord) {
        alert('Please select a landlord first.');
        return;
    }
    
    const button = this;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Assigning...';
    
    const landlordId = selectedLandlord.userID || selectedLandlord.id || selectedLandlord.landlordId;
    const landlordName = `${selectedLandlord.firstName || selectedLandlord.first_name || ''} ${selectedLandlord.lastName || selectedLandlord.last_name || ''}`.trim();
    
    // Additional check for landlord ID
    if (!landlordId) {
        alert('Error: Selected landlord has no ID. Please try selecting a different landlord.');
        button.disabled = false;
        button.innerHTML = '<i class="ti ti-check me-1"></i> Assign Owner';
        return;
    }
    
    
    // Make API call to assign owner via backend using JSON
    fetch('/api/assign-property-owner', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            property_id: propertyId,
            landlord_id: landlordId
        })
    })
    .then(response => {
        if (response.status === 419 || response.status === 401) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        if (data.success) {
            alert(`Owner assigned successfully! Property is now assigned to ${landlordName}.`);
            window.location.href = '{{ route("properties") }}';
        } else {
            // Check if the error message indicates session expiry
            if (data.message && (data.message.includes('Session expired') || data.message.includes('expired'))) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            
            
            alert('Failed to assign owner: ' + (data.message || data.error || 'Unknown error'));
            button.disabled = false;
            button.innerHTML = '<i class="ti ti-check me-1"></i> Assign Owner';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while assigning owner. Please try again.');
        button.disabled = false;
        button.innerHTML = '<i class="ti ti-check me-1"></i> Assign Owner';
    });
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadPropertyDetails();
    loadLandlords();
});
</script>

<style>
[data-landlord-id]:hover {
    background-color: rgba(13, 110, 253, 0.25) !important;
    border-color: var(--bs-primary) !important;
}
</style>
@endpush