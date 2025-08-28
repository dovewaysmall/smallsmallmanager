@extends('layouts.app')

@section('title', 'Subscribers')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Subscribers</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Subscribers
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
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Subscribers..." disabled />
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
                            Add Subscriber
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="tenantsTable" class="table search-table align-middle text-nowrap">
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
                                <th>Property</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tenantsTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center" id="loadingState">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mb-0 text-muted">Loading subscribers...</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center d-none" id="errorState">
                                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                        <p class="mb-2 text-danger" id="errorMessage"></p>
                                        <button onclick="loadTenants()" class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-refresh me-1"></i> Retry
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Controls -->
                <div class="d-flex justify-content-between align-items-center mt-3" id="paginationContainer" style="display: none !important;">
                    <div class="pagination-info">
                        <span class="text-muted" id="paginationInfo">Showing 1 to 10 of 0 entries</span>
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
@endsection

@push('scripts')
<script>
let allTenants = [];
let filteredTenants = [];
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

function loadTenants() {
    showState('loadingState');
    
    fetch('{{ route("tenants.load") }}', {
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
            allTenants = data.tenants;
            // Sort by newest first
            allTenants.sort((a, b) => {
                const dateA = new Date(a.created_at || a.createdAt || a.date_created || 0);
                const dateB = new Date(b.created_at || b.createdAt || b.date_created || 0);
                
                if (dateA.getTime() === dateB.getTime()) {
                    const idA = parseInt(a.id || a.userID || 0);
                    const idB = parseInt(b.id || b.userID || 0);
                    return idB - idA;
                }
                
                return dateB - dateA;
            });
            filteredTenants = allTenants;
            renderTenants();
            document.getElementById('searchInput').disabled = false;
        } else {
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load subscribers');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        showError('An error occurred while loading subscribers');
    });
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
}

function renderTenants() {
    const tbody = document.getElementById('tenantsTableBody');
    
    if (filteredTenants.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No subscribers found</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('paginationContainer').style.display = 'none';
        return;
    }
    
    // Calculate pagination
    totalPages = Math.ceil(filteredTenants.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPageTenants = filteredTenants.slice(startIndex, endIndex);
    
    let html = '';
    currentPageTenants.forEach((tenant, index) => {
        const globalIndex = startIndex + index;
        
        // Handle different possible field names from API
        const userID = tenant.userID;
        const firstName = tenant.first_name || tenant.firstName || 'N/A';
        const lastName = tenant.last_name || tenant.lastName || '';
        const email = tenant.email || 'N/A';
        const phone = tenant.phone || tenant.phone_number || 'N/A';
        const propertyName = tenant.current_property_title || 'N/A';
        const status = tenant.status || tenant.tenant_status || 'Active';
        
        const fullName = `${firstName} ${lastName}`.trim();
        
        // Status badge color
        let statusClass = 'bg-secondary';
        switch (status.toLowerCase()) {
            case 'active':
            case 'current':
                statusClass = 'bg-success';
                break;
            case 'inactive':
            case 'terminated':
            case 'expired':
                statusClass = 'bg-danger';
                break;
            case 'pending':
            case 'new':
                statusClass = 'bg-warning text-dark';
                break;
            case 'on_notice':
            case 'notice':
                statusClass = 'bg-info';
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
                    <span class="usr-location">${propertyName}</span>
                </td>
                <td>
                    <span class="badge ${statusClass}">${status}</span>
                </td>
                <td>
                    <div class="action-btn">
                        <a href="/tenant/${userID}" class="btn btn-sm btn-primary me-2">
                            View More
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
        filteredTenants = allTenants;
    } else {
        filteredTenants = allTenants.filter(tenant => {
            const firstName = (tenant.first_name || tenant.firstName || '').toLowerCase();
            const lastName = (tenant.last_name || tenant.lastName || '').toLowerCase();
            const fullName = `${firstName} ${lastName}`.toLowerCase();
            const email = (tenant.email || '').toLowerCase();
            const phone = (tenant.phone || tenant.phone_number || '').toLowerCase();
            const propertyName = (tenant.current_property_title || '').toLowerCase();
            const status = (tenant.status || tenant.tenant_status || '').toLowerCase();
            
            return fullName.includes(searchTerm) || 
                   email.includes(searchTerm) || 
                   phone.includes(searchTerm) ||
                   propertyName.includes(searchTerm) ||
                   status.includes(searchTerm);
        });
    }
    
    currentPage = 1;
    renderTenants();
});

function updatePaginationInfo() {
    const startItem = filteredTenants.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredTenants.length);
    const totalItems = filteredTenants.length;
    
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
    renderTenants();
    
    // Prevent default link behavior
    event.preventDefault();
}

// Auto-load tenants when page is ready
document.addEventListener('DOMContentLoaded', function() {
    loadTenants();
});
</script>
@endpush