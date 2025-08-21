@extends('layouts.app')

@section('title', 'Payouts This Week')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Payouts This Week</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Payouts This Week
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
                            <a href="{{ route('payouts') }}" class="btn btn-primary me-2 d-flex align-items-center">
                                <i class="ti ti-eye me-1 fs-5"></i> View More
                            </a>
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
                                <th>Reference</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="payoutsTableBody">
                            <tr>
                                <td colspan="8" class="text-center py-5">
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
@endsection

@push('scripts')
<script>
let allPayouts = [];
let filteredPayouts = [];
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

function loadPayouts() {
    showState('loadingState');
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showError('CSRF token not found. Please refresh the page.');
        return;
    }
    
    console.log('Loading payouts from:', '{{ route("payouts.this-week.load") }}');
    
    fetch('{{ route("payouts.this-week.load") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
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
            allPayouts = data.payouts || [];
            filteredPayouts = allPayouts;
            renderPayouts();
            document.getElementById('searchInput').disabled = false;
        } else {
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
                <td colspan="8" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:wallet-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No payouts found this week</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('paginationContainer').style.display = 'none';
        return;
    }
    
    totalPages = Math.ceil(filteredPayouts.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPagePayouts = filteredPayouts.slice(startIndex, endIndex);
    
    let html = '';
    currentPagePayouts.forEach((payout, index) => {
        const globalIndex = startIndex + index;
        
        const payoutId = payout.id || payout.payout_id || 'N/A';
        const reference = payout.reference || payout.transaction_reference || payout.ref || 'N/A';
        const recipient = payout.recipient_name || payout.recipient || payout.user_name || 'N/A';
        const amount = payout.amount || payout.payout_amount || '0.00';
        const status = payout.status || payout.payout_status || 'pending';
        const type = payout.type || payout.payout_type || 'general';
        const date = payout.created_at || payout.payout_date || payout.date || 'N/A';
        
        let formattedDate = date;
        if (date !== 'N/A' && date) {
            try {
                formattedDate = new Date(date).toLocaleDateString();
            } catch (e) {
                formattedDate = date;
            }
        }
        
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
        
        let typeClass = 'bg-info';
        switch (type.toLowerCase()) {
            case 'rent':
                typeClass = 'bg-primary';
                break;
            case 'commission':
                typeClass = 'bg-success';
                break;
            case 'refund':
                typeClass = 'bg-warning text-dark';
                break;
            case 'bonus':
                typeClass = 'bg-info';
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
                    <span class="usr-email-addr">${reference}</span>
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
                    <span class="badge ${typeClass}">${type}</span>
                </td>
                <td>
                    <span class="usr-date">${formattedDate}</span>
                </td>
                <td>
                    <div class="action-btn d-flex align-items-center">
                        <a href="javascript:void(0)" onclick="viewPayout('${payoutId}')" class="btn btn-sm btn-primary me-2">
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
            const reference = (payout.reference || payout.transaction_reference || '').toLowerCase();
            const recipient = (payout.recipient_name || payout.recipient || '').toLowerCase();
            const status = (payout.status || '').toLowerCase();
            const type = (payout.type || '').toLowerCase();
            
            return reference.includes(searchTerm) || 
                   recipient.includes(searchTerm) || 
                   status.includes(searchTerm) ||
                   type.includes(searchTerm);
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
    
    html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }
    
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

function viewPayout(payoutId) {
    console.log('View payout:', payoutId);
    alert('Payout detail view coming soon');
}

function deletePayout(payoutId) {
    if (confirm('Are you sure you want to delete this payout?')) {
        console.log('Delete payout:', payoutId);
        alert('Delete functionality coming soon');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    loadPayouts();
});
</script>
@endpush