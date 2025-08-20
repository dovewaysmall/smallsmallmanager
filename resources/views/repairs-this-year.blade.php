@extends('layouts.app')

@section('title', 'Repairs This Year')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Repairs This Year</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Repairs This Year
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
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Repairs..." disabled />
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn">
                            <a href="{{ route('repairs') }}" class="btn btn-primary me-2 d-flex align-items-center">
                                <i class="ti ti-eye me-1 fs-5"></i> View More
                            </a>
                            <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center">
                                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
                            </a>
                        </div>
                        <a href="{{ route('repairs.add') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-tools text-white me-1 fs-5"></i> Add New Repair
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="repairsTable" class="table search-table align-middle text-nowrap">
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
                                <th>Title</th>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Items Repaired</th>
                                <th>Handler</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th>Repair Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="repairsTableBody">
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center" id="loadingState">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mb-0 text-muted">Loading repairs...</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center d-none" id="errorState">
                                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                        <p class="mb-2 text-danger" id="errorMessage"></p>
                                        <button onclick="loadRepairs()" class="btn btn-sm btn-outline-primary">
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
                        <span class="text-muted" id="paginationInfo">Showing 0 to 0 of 0 entries</span>
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
let allRepairs = [];
let filteredRepairs = [];
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 1;
let propertyMap = {};

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    
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
            // Create property lookup map
            propertyMap = {};
            data.properties.forEach(property => {
                const propertyName = property.property_title || property.property_name || property.address || `Property ${property.id}`;
                propertyMap[property.id] = propertyName;
            });
        }
    } catch (error) {
        console.error('Error loading properties:', error);
    }
}

function loadRepairs() {
    showState('loadingState');
    
    // Check for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showError('CSRF token not found. Please refresh the page.');
        return;
    }
    
    console.log('Loading repairs from:', '{{ route("repairs.this-year.load") }}');
    console.log('CSRF token:', csrfToken.getAttribute('content'));
    
    fetch('{{ route("repairs.this-year.load") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (response.status === 419) {
            // CSRF token expired
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        console.log('API Response data:', data);
        
        if (!data) return; // Handle early return from 419
        
        if (data.success) {
            console.log('Repairs received:', data.repairs);
            allRepairs = data.repairs || [];
            filteredRepairs = allRepairs;
            renderRepairs();
            document.getElementById('searchInput').disabled = false;
        } else {
            console.error('API Error:', data.error);
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load repairs');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        console.error('Error details:', {
            message: error.message,
            stack: error.stack,
            name: error.name
        });
        showError('Network error occurred while loading repairs. Check console for details.');
    });
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
}

function renderRepairs() {
    const tbody = document.getElementById('repairsTableBody');
    
    if (!allRepairs || allRepairs.length === 0 || !filteredRepairs || filteredRepairs.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:tools-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No repairs found this year</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('paginationContainer').style.display = 'none';
        return;
    }
    
    // Calculate pagination
    totalPages = Math.ceil(filteredRepairs.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPageRepairs = filteredRepairs.slice(startIndex, endIndex);
    
    let html = '';
    currentPageRepairs.forEach((repair, index) => {
        const globalIndex = startIndex + index;
        
        // Handle database field names from API
        const repairId = repair.id;
        const titleOfRepair = repair.title_of_repair || 'N/A';
        const propertyId = repair.property_id || 'N/A';
        const propertyTitle = propertyMap[propertyId] || `Property ${propertyId}`;
        const typeOfRepair = repair.type_of_repair || 'N/A';
        const itemsRepaired = repair.items_repaired || 'N/A';
        const whoIsHandlingRepair = repair.who_is_handling_repair || 'Unassigned';
        const description = repair['description_of_the repair'] || 'N/A';
        const costOfRepair = repair.cost_of_repair || '0.00';
        const repairStatus = repair.repair_status || 'pending';
        const repairDate = repair.repair_date || 'N/A';
        const feedback = repair.feedback || '';
        const imageFolder = repair.image_folder || '';
        const imagesPaths = repair.images_paths || null;
        
        // Format date if it exists
        let formattedDate = repairDate;
        if (repairDate !== 'N/A' && repairDate) {
            try {
                formattedDate = new Date(repairDate).toLocaleDateString();
            } catch (e) {
                formattedDate = repairDate;
            }
        }
        
        // Status badge color
        let statusClass = 'bg-secondary';
        switch (repairStatus.toLowerCase()) {
            case 'completed':
                statusClass = 'bg-success';
                break;
            case 'pending':
                statusClass = 'bg-warning text-dark';
                break;
            case 'on going':
                statusClass = 'bg-info';
                break;
        }
        
        // Type badge color for repair type
        let typeClass = 'bg-info';
        
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
                        <h6 class="user-name mb-0">${titleOfRepair}</h6>
                    </div>
                </td>
                <td>
                    <span class="usr-email-addr">${propertyTitle}</span>
                </td>
                <td>
                    <span class="badge ${typeClass}">${typeOfRepair}</span>
                </td>
                <td>
                    <span class="usr-email-addr">${itemsRepaired.length > 50 ? itemsRepaired.substring(0, 50) + '...' : itemsRepaired}</span>
                </td>
                <td>
                    <span class="usr-location">${whoIsHandlingRepair}</span>
                </td>
                <td>
                    <span class="text-success fw-bold">₦${parseFloat(costOfRepair).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                </td>
                <td>
                    <span class="badge ${statusClass}">${repairStatus}</span>
                </td>
                <td>
                    <span class="usr-date">${formattedDate}</span>
                </td>
                <td>
                    <div class="action-btn d-flex align-items-center">
                        <a href="{{ url('/repair') }}/${repairId}" class="btn btn-sm btn-primary me-2">
                            View More
                        </a>
                        ${imagesPaths ? `<a href="javascript:void(0)" onclick="viewImages('${repairId}', '${imageFolder}')" class="btn btn-sm btn-info me-2" title="View Images">
                            <iconify-icon icon="solar:gallery-line-duotone" class="fs-5"></iconify-icon>
                        </a>` : ''}
                        <a href="javascript:void(0)" class="text-danger delete ms-2 d-flex align-items-center" title="Delete" style="transition: all 0.2s ease;" onmouseover="this.style.color='#000000'; this.style.transform='scale(1.1)'; this.querySelector('iconify-icon').style.color='#000000'" onmouseout="this.style.color='#dc3545'; this.style.transform='scale(1)'; this.querySelector('iconify-icon').style.color='#dc3545'">
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
        filteredRepairs = allRepairs;
    } else {
        filteredRepairs = allRepairs.filter(repair => {
            const titleOfRepair = (repair.title_of_repair || '').toLowerCase();
            const propertyId = (repair.property_id || '').toLowerCase();
            const typeOfRepair = (repair.type_of_repair || '').toLowerCase();
            const itemsRepaired = (repair.items_repaired || '').toLowerCase();
            const whoIsHandlingRepair = (repair.who_is_handling_repair || '').toLowerCase();
            const description = (repair['description_of_the repair'] || '').toLowerCase();
            const repairStatus = (repair.repair_status || '').toLowerCase();
            
            return titleOfRepair.includes(searchTerm) || 
                   propertyId.includes(searchTerm) || 
                   typeOfRepair.includes(searchTerm) ||
                   itemsRepaired.includes(searchTerm) ||
                   whoIsHandlingRepair.includes(searchTerm) ||
                   description.includes(searchTerm) ||
                   repairStatus.includes(searchTerm);
        });
    }
    
    currentPage = 1; // Reset to first page when searching
    renderRepairs();
});

function updatePaginationInfo() {
    const startItem = filteredRepairs.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredRepairs.length);
    const totalItems = filteredRepairs.length;
    
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
    renderRepairs();
    
    // Prevent default link behavior
    event.preventDefault();
}

function viewRepair(repairId) {
    window.location.href = `{{ url('/repair') }}/${repairId}`;
}

function viewImages(repairId, imageFolder) {
    const repair = allRepairs.find(r => r.id == repairId);
    if (!repair || !repair.images_paths) {
        alert('No images available for this repair');
        return;
    }
    
    try {
        const imagePaths = JSON.parse(repair.images_paths);
        if (imagePaths && imagePaths.length > 0) {
            // Create a modal or lightbox to display images
            let imageHtml = '';
            imagePaths.forEach(imagePath => {
                imageHtml += `<img src="${imagePath}" class="img-fluid mb-2" style="max-width: 300px; margin: 5px;" />`;
            });
            
            // Simple modal implementation
            const modal = `
                <div class="modal fade" id="imageModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Repair Images</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                ${imageHtml}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('imageModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body and show it
            document.body.insertAdjacentHTML('beforeend', modal);
            const bootstrapModal = new bootstrap.Modal(document.getElementById('imageModal'));
            bootstrapModal.show();
        } else {
            alert('No images found for this repair');
        }
    } catch (e) {
        console.error('Error parsing image paths:', e);
        alert('Error loading images');
    }
}

// Auto-load repairs when page is ready
document.addEventListener('DOMContentLoaded', async function() {
    await loadProperties();
    loadRepairs();
});
</script>
@endpush