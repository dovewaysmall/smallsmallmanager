@extends('layouts.app')

@section('title', 'Landlords This Week')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Landlords This Week</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Landlords This Week
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
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Landlords..." disabled />
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn">
                            <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center">
                                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
                            </a>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center">
                            Add Landlord
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="landlordsTable" class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>
                                    <div class="n-chk align-self-center text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input primary" id="contact-check-all" />
                                            <label class="form-check-label" for="contact-check-all"></label>
                                        </div>
                                    </div>
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Properties</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="landlordsTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center" id="loadingState">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mb-0 text-muted">Loading landlords...</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center d-none" id="errorState">
                                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                        <p class="mb-2 text-danger" id="errorMessage"></p>
                                        <button onclick="loadLandlords()" class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-refresh me-1"></i> Retry
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <div class="d-flex justify-content-between align-items-center mt-3" id="paginationContainer" style="display: none;">
                    <div class="pagination-info">
                        <span class="text-muted" id="paginationInfo">Loading...</span>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0" id="paginationControls">
                            <!-- Pagination buttons will be generated here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        </div>
    </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLandlordModal" tabindex="-1" aria-labelledby="deleteLandlordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-danger" id="deleteLandlordModalLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center">
                    <div class="mb-3">
                        <iconify-icon icon="solar:danger-bold-duotone" class="fs-1 text-danger"></iconify-icon>
                    </div>
                    <h6 class="mb-3">Are you sure you want to delete this landlord?</h6>
                    <p class="text-muted mb-3" id="deleteLandlordDetails">
                        This will permanently remove the landlord from the system.
                    </p>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-4 me-2"></iconify-icon>
                        <small>This action cannot be undone!</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteLandlordBtn">
                    <i class="ti ti-trash me-1"></i> Delete Landlord
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let allLandlords = [];
let filteredLandlords = [];
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 1;

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    
    if (stateName) {
        document.getElementById(stateName).classList.remove('d-none');
    }
}

function loadLandlords() {
    showState('loadingState');
    
    fetch('{{ route("landlords.this-week.load") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 419) {
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
            filteredLandlords = allLandlords;
            renderLandlords();
            document.getElementById('searchInput').disabled = false;
        } else {
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load landlords');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        showError('An error occurred while loading landlords');
    });
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
}

function renderLandlords() {
    const tbody = document.getElementById('landlordsTableBody');
    
    if (filteredLandlords.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:user-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No landlords found</p>
                    </div>
                </td>
            </tr>
        `;
        updatePaginationInfo();
        document.getElementById('paginationContainer').style.display = 'flex';
        document.getElementById('paginationControls').innerHTML = '';
        return;
    }
    
    // Calculate pagination
    totalPages = Math.ceil(filteredLandlords.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPageLandlords = filteredLandlords.slice(startIndex, endIndex);
    
    let html = '';
    currentPageLandlords.forEach((landlord, index) => {
        const globalIndex = startIndex + index;
        
        // Handle different possible field names from API
        const landlordId = landlord.id || landlord.landlordId || globalIndex + 1;
        const firstName = landlord.firstName || landlord.first_name || 'N/A';
        const lastName = landlord.lastName || landlord.last_name || 'N/A';
        const email = landlord.email || 'N/A';
        const phone = landlord.phone || landlord.phoneNumber || 'N/A';
        const propertiesCount = landlord.properties_count || landlord.propertiesCount || 0;
        const status = landlord.status || 'Active';
        
        const fullName = `${firstName} ${lastName}`.trim();
        
        // Status badge color
        let statusClass = 'bg-secondary';
        switch (status.toLowerCase()) {
            case 'active':
            case 'verified':
                statusClass = 'bg-success';
                break;
            case 'inactive':
            case 'suspended':
                statusClass = 'bg-danger';
                break;
            case 'pending':
            case 'unverified':
                statusClass = 'bg-warning text-dark';
                break;
        }
        
        html += `
            <tr class="search-items">
                <td>
                    <div class="n-chk align-self-center text-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input contact-chkbox primary" id="checkbox${globalIndex + 1}" />
                            <label class="form-check-label" for="checkbox${globalIndex + 1}"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <h6 class="user-name mb-0">${fullName || 'N/A'}</h6>
                    </div>
                </td>
                <td>
                    <span class="usr-email-addr">${email}</span>
                </td>
                <td>
                    <span class="usr-ph-no">${phone}</span>
                </td>
                <td>
                    <span class="badge bg-info">${propertiesCount} Properties</span>
                </td>
                <td>
                    <span class="badge ${statusClass}">${status}</span>
                </td>
                <td>
                    <div class="action-btn d-flex align-items-center">
                        <a href="/landlord/${landlord.userID || landlord.id}" class="btn btn-sm btn-primary me-2">
                            View Details
                        </a>
                        <a href="javascript:void(0)" class="text-danger delete ms-2 d-flex align-items-center" title="Delete" style="transition: all 0.2s ease;" onclick="confirmDeleteLandlord('${landlord.userID || landlord.id}', '${landlord.firstName || ''} ${landlord.lastName || ''}')" onmouseover="this.style.color='#000000'; this.style.transform='scale(1.1)'; this.querySelector('iconify-icon').style.color='#000000'" onmouseout="this.style.color='#dc3545'; this.style.transform='scale(1)'; this.querySelector('iconify-icon').style.color='#dc3545'">
                            <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                        </a>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    updatePaginationControls();
    updatePaginationInfo();
    document.getElementById('paginationContainer').style.display = 'flex';
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    if (searchTerm === '') {
        filteredLandlords = allLandlords;
    } else {
        filteredLandlords = allLandlords.filter(landlord => {
            const fullName = `${landlord.firstName || landlord.first_name || ''} ${landlord.lastName || landlord.last_name || ''}`.toLowerCase();
            const email = (landlord.email || '').toLowerCase();
            const phone = (landlord.phone || landlord.phoneNumber || '').toLowerCase();
            const status = (landlord.status || '').toLowerCase();
            
            return fullName.includes(searchTerm) || 
                   email.includes(searchTerm) || 
                   phone.includes(searchTerm) ||
                   status.includes(searchTerm);
        });
    }
    
    currentPage = 1; // Reset to first page when searching
    renderLandlords();
});

function updatePaginationInfo() {
    const startItem = filteredLandlords.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredLandlords.length);
    const totalItems = filteredLandlords.length;
    
    document.getElementById('paginationInfo').textContent = 
        `Showing ${startItem} to ${endItem} of ${totalItems} entries`;
}

function updatePaginationControls() {
    const paginationControls = document.getElementById('paginationControls');
    
    if (totalPages <= 1) {
        paginationControls.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Previous button
    html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;
    
    // Calculate page range to show
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    // Adjust range if we're near the beginning or end
    if (endPage - startPage < 4) {
        if (startPage === 1) {
            endPage = Math.min(totalPages, startPage + 4);
        } else if (endPage === totalPages) {
            startPage = Math.max(1, endPage - 4);
        }
    }
    
    // First page and ellipsis if needed
    if (startPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)">1</a></li>`;
        if (startPage > 2) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }
    
    // Last page and ellipsis if needed
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
    }
    
    // Next button
    html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;
    
    paginationControls.innerHTML = html;
}

function changePage(page) {
    if (page < 1 || page > totalPages || page === currentPage) {
        return;
    }
    
    currentPage = page;
    renderLandlords();
    
    // Prevent default link behavior
    event.preventDefault();
}

// Auto-load landlords when page is ready
document.addEventListener('DOMContentLoaded', function() {
    loadLandlords();
});

// Delete landlord functions
let landlordToDelete = null;

function confirmDeleteLandlord(userID, landlordName) {
    landlordToDelete = userID;
    
    // Update modal content
    document.getElementById('deleteLandlordDetails').innerHTML = 
        `<strong>${landlordName || 'User ID: ' + userID}</strong><br>This will permanently remove the landlord from the system.`;
    
    // Show the modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteLandlordModal'));
    deleteModal.show();
}

// Handle delete confirmation
document.getElementById('confirmDeleteLandlordBtn').addEventListener('click', function() {
    if (!landlordToDelete) return;
    
    const btn = this;
    const originalText = btn.innerHTML;
    
    // Show loading state
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Deleting...';
    
    // Make delete API call
    fetch(`/api/landlord/${landlordToDelete}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        if (data.success) {
            // Close modal
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteLandlordModal'));
            deleteModal.hide();
            
            // Show success message
            showSuccessToast('Landlord deleted successfully!');
            
            // Remove landlord from arrays
            allLandlords = allLandlords.filter(l => (l.userID || l.id) != landlordToDelete);
            filteredLandlords = filteredLandlords.filter(l => (l.userID || l.id) != landlordToDelete);
            
            // Re-render the table
            renderLandlords();
            
            // Reset
            landlordToDelete = null;
        } else {
            if (data.message && data.message.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showErrorToast(data.message || 'Failed to delete landlord');
        }
    })
    .catch(error => {
        console.error('Error deleting landlord:', error);
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        showErrorToast('An error occurred while deleting the landlord');
    })
    .finally(() => {
        // Reset button
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});

// Toast notification functions
function showSuccessToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 m-3';
    toast.style.zIndex = '9999';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="solar:check-circle-bold" class="fs-4 me-2"></iconify-icon>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function showErrorToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-bg-danger border-0 position-fixed top-0 end-0 m-3';
    toast.style.zIndex = '9999';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <iconify-icon icon="solar:danger-circle-bold" class="fs-4 me-2"></iconify-icon>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}
</script>
@endpush