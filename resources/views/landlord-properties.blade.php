@extends('layouts.app')

@section('title', $landlordName . '\'s Properties')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">{{ $landlordName }}'s Properties</h4>
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
                        <a class="text-muted text-decoration-none" href="{{ route('landlord.show', $landlordId) }}">Details</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Properties
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="widget-content searchable-container list">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Properties..." disabled />
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <a href="{{ route('landlord.show', $landlordId) }}" class="btn btn-outline-secondary d-flex align-items-center">
                            <i class="ti ti-arrow-left text-muted me-1 fs-5"></i> Back to Landlord Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="propertiesTable" class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Property ID</th>
                                <th>Property Title</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="propertiesTableBody">
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="mt-2">Loading properties...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const landlordId = '{{ $landlordId }}';
    
    if (!landlordId) {
        showError('No landlord ID provided.');
        return;
    }
    
    loadProperties();
});

function loadProperties() {
    const landlordId = '{{ $landlordId }}';
    
    fetch(`/landlord/${landlordId}/properties/load`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
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
            populatePropertiesTable(data.properties);
        } else if (data && data.error) {
            showError(data.error);
        } else {
            showError('Failed to load properties.');
        }
    })
    .catch(error => {
        console.error('Error loading properties:', error);
        showError('An error occurred while loading properties.');
    });
}

function populatePropertiesTable(properties) {
    const tbody = document.getElementById('propertiesTableBody');
    
    if (!properties || properties.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:home-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                        <h6 class="text-muted">No Properties Found</h6>
                        <p class="text-muted mb-0">This landlord doesn't have any properties yet.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = properties.map(property => {
        const propertyId = property.id || property.propertyId || 'N/A';
        const title = property.title || property.property_title || 'N/A';
        const location = formatLocation(property);
        const type = property.type || property.property_type || 'N/A';
        const price = formatPrice(property.price || property.rent_price || property.rental_price);
        const status = formatStatus(property.status || property.property_status);
        const dateAdded = formatDate(property.created_at || property.date_added);
        
        return `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <div class="user-meta-info">
                                <h6 class="user-name mb-0">${propertyId}</h6>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="fw-normal">${title}</span>
                </td>
                <td>
                    <span class="fw-normal">${location}</span>
                </td>
                <td>
                    <span class="fw-normal">${type}</span>
                </td>
                <td>
                    <span class="fw-normal">${price}</span>
                </td>
                <td>
                    ${status}
                </td>
                <td>
                    <span class="fw-normal">${dateAdded}</span>
                </td>
                <td>
                    <div class="action-btn">
                        <a href="javascript:void(0)" class="text-info edit" onclick="viewProperty('${propertyId}')">
                            <i class="ti ti-eye fs-5"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    
    // Enable search functionality
    document.getElementById('searchInput').disabled = false;
    setupSearch();
}

function formatLocation(property) {
    const city = property.city || property.location_city || '';
    const state = property.state || property.location_state || '';
    const area = property.area || property.location_area || '';
    
    const parts = [area, city, state].filter(part => part && part !== '');
    return parts.length > 0 ? parts.join(', ') : 'N/A';
}

function formatPrice(price) {
    if (!price) return 'N/A';
    
    // Convert to number if it's a string
    const numPrice = typeof price === 'string' ? parseFloat(price) : price;
    
    if (isNaN(numPrice)) return 'N/A';
    
    return '₦' + numPrice.toLocaleString();
}

function formatStatus(status) {
    if (!status) return '<span class="badge bg-secondary">N/A</span>';
    
    const statusLower = status.toLowerCase();
    let badgeClass = 'bg-secondary';
    let statusText = status;
    
    switch (statusLower) {
        case 'available':
        case 'active':
            badgeClass = 'bg-success';
            statusText = 'Available';
            break;
        case 'occupied':
        case 'rented':
            badgeClass = 'bg-warning';
            statusText = 'Occupied';
            break;
        case 'maintenance':
            badgeClass = 'bg-info';
            statusText = 'Maintenance';
            break;
        case 'inactive':
        case 'unavailable':
            badgeClass = 'bg-danger';
            statusText = 'Inactive';
            break;
    }
    
    return `<span class="badge ${badgeClass}">${statusText}</span>`;
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

function setupSearch() {
    const searchInput = document.getElementById('searchInput');
    const tbody = document.getElementById('propertiesTableBody');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

function viewProperty(propertyId) {
    // This would typically link to a property details page
    alert(`View property details for Property ID: ${propertyId}`);
}

function showError(message) {
    const tbody = document.getElementById('propertiesTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="8" class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-1 text-danger mb-3"></iconify-icon>
                    <h6 class="text-danger">Error</h6>
                    <p class="text-muted mb-0">${message}</p>
                </div>
            </td>
        </tr>
    `;
}
</script>
@endpush