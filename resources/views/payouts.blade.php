@extends('layouts.app')

@section('title', 'Payouts')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Payouts</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Payouts
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
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Payouts..." disabled />
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn">
                            <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center">
                                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
                            </a>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary me-2 d-flex align-items-center">
                            <i class="ti ti-wallet text-white me-1 fs-5"></i> Export Payouts
                        </a>
                        <a href="{{ route('payouts.add') }}" class="btn btn-success d-flex align-items-center">
                            <i class="ti ti-plus text-white me-1 fs-5"></i> Add Payout
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="payoutsTable" class="table search-table align-middle text-nowrap">
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
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="payoutsTableBody">
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center" id="loadingState">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mb-0 text-muted">Loading payouts...</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center d-none" id="errorState">
                                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                        <p class="mb-2 text-danger" id="errorMessage"></p>
                                        <button onclick="loadPayouts()" class="btn btn-sm btn-outline-primary">
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePayoutModal" tabindex="-1" aria-labelledby="deletePayoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="deletePayoutModalLabel">
                        <i class="ti ti-trash text-danger me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #fef2f2; border-radius: 50%;">
                            <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="text-danger" style="font-size: 3rem;"></iconify-icon>
                        </div>
                        <h6 class="mb-2">Delete Payout</h6>
                        <p class="text-muted mb-0">Are you sure you want to delete this payout? This action cannot be undone.</p>
                    </div>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="me-2"></iconify-icon>
                        <small>This will permanently remove the payout from the system.</small>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="ti ti-trash me-1"></i>Delete Payout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="ti ti-check text-success me-2"></i>
                        Success
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center">
                        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #f0fdf4; border-radius: 50%;">
                            <iconify-icon icon="solar:check-circle-bold-duotone" class="text-success" style="font-size: 3rem;"></iconify-icon>
                        </div>
                        <h6 class="mb-2">Payout Deleted</h6>
                        <p class="text-muted mb-0" id="successMessage">The payout has been successfully deleted.</p>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="ti ti-check me-1"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="ti ti-alert-circle text-danger me-2"></i>
                        Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center">
                        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #fef2f2; border-radius: 50%;">
                            <iconify-icon icon="solar:close-circle-bold-duotone" class="text-danger" style="font-size: 3rem;"></iconify-icon>
                        </div>
                        <h6 class="mb-2">Delete Failed</h6>
                        <p class="text-muted mb-0" id="errorMessage">An error occurred while deleting the payout.</p>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
let allPayouts = [];
let filteredPayouts = [];
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 1;
let landlordMap = {};

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    
    if (stateName) {
        document.getElementById(stateName).classList.remove('d-none');
    }
}

async function loadLandlords() {
    try {
        const response = await fetch('{{ route("landlords.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        if (data.success && data.landlords) {
            // Create landlord lookup map using userID
            landlordMap = {};
            data.landlords.forEach(landlord => {
                const landlordId = landlord.userID || landlord.user_id || landlord.id;
                const landlordName = `${landlord.firstName} ${landlord.lastName}` || 
                                   `${landlord.first_name} ${landlord.last_name}` || 
                                   landlord.name || 
                                   landlord.full_name || 
                                   `Landlord ${landlordId}`;
                landlordMap[landlordId] = landlordName;
            });
            console.log('Landlord map created:', landlordMap);
        }
    } catch (error) {
        console.error('Error loading landlords:', error);
    }
}

function loadPayouts() {
    showState('loadingState');
    
    // Check for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showError('CSRF token not found. Please refresh the page.');
        return;
    }
    
    console.log('Loading payouts from:', '{{ route("payouts.load") }}');
    console.log('CSRF token:', csrfToken.getAttribute('content'));
    
    fetch('{{ route("payouts.load") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        if (response.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        console.log('API Response data:', data);
        
        if (!data) return;
        
        if (data.success) {
            console.log('Payouts received:', data.payouts);
            allPayouts = data.payouts || [];
            filteredPayouts = allPayouts;
            renderPayouts();
            document.getElementById('searchInput').disabled = false;
        } else {
            console.error('API Error:', data.error);
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load payouts');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showError('Network error occurred while loading payouts');
    });
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
}

function renderPayouts() {
    const tbody = document.getElementById('payoutsTableBody');
    
    if (!allPayouts || allPayouts.length === 0 || !filteredPayouts || filteredPayouts.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:wallet-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No payouts found</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('paginationContainer').style.display = 'none';
        return;
    }
    
    // Calculate pagination
    totalPages = Math.ceil(filteredPayouts.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPagePayouts = filteredPayouts.slice(startIndex, endIndex);
    
    let html = '';
    currentPagePayouts.forEach((payout, index) => {
        const globalIndex = startIndex + index;
        
        // Handle different API response structures
        const payoutId = payout.id || payout.payout_id || 'N/A';
        const reference = payout.reference || payout.transaction_reference || payout.ref || 'N/A';
        
        // Get landlord name using landlord_id lookup
        const landlordId = payout.landlord_id;
        const recipient = landlordMap[landlordId] || payout.landlord_name || payout.recipient_name || payout.recipient || payout.user_name || landlordId || 'N/A';
        
        const amount = payout.amount || payout.payout_amount || '0.00';
        const status = payout.status || payout.payout_status || 'pending';
        const date = payout.date_paid || payout.created_at || payout.payout_date || payout.date || 'N/A';
        
        // Format date
        let formattedDate = date;
        if (date !== 'N/A' && date) {
            try {
                formattedDate = new Date(date).toLocaleDateString();
            } catch (e) {
                formattedDate = date;
            }
        }
        
        // Status badge color
        let statusClass = 'bg-secondary';
        switch (status.toLowerCase()) {
            case 'completed':
            case 'success':
            case 'paid':
                statusClass = 'bg-success';
                break;
            case 'pending':
                statusClass = 'bg-warning text-dark';
                break;
            case 'failed':
            case 'declined':
                statusClass = 'bg-danger';
                break;
            case 'processing':
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
                        <h6 class="user-name mb-0">${recipient}</h6>
                    </div>
                </td>
                <td>
                    <span class="usr-phone text-success fw-bold">₦${parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                </td>
                <td>
                    <span class="badge ${statusClass}">${status}</span>
                </td>
                <td>
                    <span class="usr-date">${formattedDate}</span>
                </td>
                <td>
                    <div class="action-btn d-flex align-items-center">
                        <a href="/payout/${payoutId}" class="btn btn-sm btn-primary me-2">
                            View Details
                        </a>
                        <a href="javascript:void(0)" class="text-danger delete ms-2 d-flex align-items-center" title="Delete" onclick="deletePayout('${payoutId}')" style="transition: all 0.2s ease;">
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
        filteredPayouts = allPayouts;
    } else {
        filteredPayouts = allPayouts.filter(payout => {
            const landlordId = payout.landlord_id;
            const landlordName = landlordMap[landlordId] || '';
            const recipient = (landlordName || payout.landlord_name || payout.recipient_name || payout.recipient || '').toLowerCase();
            const status = (payout.status || '').toLowerCase();
            
            return recipient.includes(searchTerm) || 
                   status.includes(searchTerm);
        });
    }
    
    currentPage = 1;
    renderPayouts();
});

function updatePaginationInfo() {
    const startItem = filteredPayouts.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredPayouts.length);
    const totalItems = filteredPayouts.length;
    
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
    
    // Calculate page range
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
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
    renderPayouts();
    event.preventDefault();
}

let payoutToDelete = null;

function deletePayout(payoutId) {
    if (!payoutId) {
        showErrorModal('Invalid payout ID');
        return;
    }
    
    payoutToDelete = payoutId;
    const deleteModal = new bootstrap.Modal(document.getElementById('deletePayoutModal'));
    deleteModal.show();
}

async function confirmDeletePayout() {
    if (!payoutToDelete) {
        return;
    }
    
    // Close the confirmation modal
    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deletePayoutModal'));
    deleteModal.hide();
    
    // Show loading state on the confirm button
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const originalText = confirmBtn.innerHTML;
    confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Deleting...';
    confirmBtn.disabled = true;
    
    try {
        const response = await fetch(`{{ url('/payout') }}/${payoutToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Delete response status:', response.status);
        console.log('Delete response ok:', response.ok);
        
        // Check if response is successful (2xx status codes)
        if (response.ok) {
            let data = null;
            try {
                data = await response.json();
                console.log('Delete response data:', data);
            } catch (jsonError) {
                console.log('Response is not JSON, but delete was successful');
                // If response is not JSON but status is OK, assume success
                data = { success: true };
            }
            
            // Remove the payout from allPayouts array
            const payoutIndex = allPayouts.findIndex(p => 
                String(p.id) === String(payoutToDelete) || 
                String(p.payout_id) === String(payoutToDelete)
            );
            if (payoutIndex !== -1) {
                allPayouts.splice(payoutIndex, 1);
            }
            
            // Update filteredPayouts as well
            const filteredIndex = filteredPayouts.findIndex(p => 
                String(p.id) === String(payoutToDelete) || 
                String(p.payout_id) === String(payoutToDelete)
            );
            if (filteredIndex !== -1) {
                filteredPayouts.splice(filteredIndex, 1);
            }
            
            // Recalculate pagination
            totalPages = Math.ceil(filteredPayouts.length / itemsPerPage);
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            } else if (totalPages === 0) {
                currentPage = 1;
            }
            
            // Re-render the table with updated data and pagination
            renderPayouts();
            
            // Show success modal
            showSuccessModal('Payout deleted successfully!');
            
        } else {
            // Try to get error message from response
            let errorMessage = 'Failed to delete payout';
            try {
                const data = await response.json();
                errorMessage = data.error || data.message || errorMessage;
            } catch (jsonError) {
                errorMessage += ` (HTTP ${response.status})`;
            }
            console.error('Delete failed:', errorMessage);
            showErrorModal(errorMessage);
        }
    } catch (error) {
        console.error('Error deleting payout:', error);
        showErrorModal('Network error occurred while deleting payout: ' + error.message);
    } finally {
        // Reset the confirm button
        confirmBtn.innerHTML = originalText;
        confirmBtn.disabled = false;
        payoutToDelete = null;
    }
}

function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

function showErrorModal(message) {
    document.getElementById('errorMessage').textContent = message;
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
}

// Auto-load payouts when page is ready
document.addEventListener('DOMContentLoaded', async function() {
    await loadLandlords();
    loadPayouts();
    
    // Add event listener for confirm delete button
    document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDeletePayout);
});
</script>
@endpush