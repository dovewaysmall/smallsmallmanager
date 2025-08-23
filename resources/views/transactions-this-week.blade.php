@extends('layouts.app')

@section('title', 'Transactions This Week')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Transactions(This Week)</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Transactions(This Week)
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
                            <input type="text" class="form-control product-search ps-5" id="searchInput" placeholder="Search Transactions..." disabled />
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
                            Add Transaction
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="table-responsive">
                    <table id="transactionsTable" class="table search-table align-middle text-nowrap">
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
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center" id="loadingState">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mb-0 text-muted">Loading transactions...</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-center d-none" id="errorState">
                                        <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                        <p class="mb-2 text-danger" id="errorMessage"></p>
                                        <button onclick="loadTransactions()" class="btn btn-sm btn-outline-primary">
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
let allTransactions = [];
let filteredTransactions = [];
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

function loadTransactions() {
    showState('loadingState');
    
    fetch('{{ route("transactions.this-week.load") }}', {
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
            allTransactions = data.transactions;
            
            // Sort by newest first
            allTransactions.sort((a, b) => {
                const dateA = new Date(a.created_at || a.createdAt || a.date_created || a.transaction_date || 0);
                const dateB = new Date(b.created_at || b.createdAt || b.date_created || b.transaction_date || 0);
                
                if (dateA.getTime() === dateB.getTime()) {
                    const idA = parseInt(a.id || a.transactionId || 0);
                    const idB = parseInt(b.id || b.transactionId || 0);
                    return idB - idA;
                }
                
                return dateB - dateA;
            });
            
            filteredTransactions = allTransactions;
            renderTransactions();
            document.getElementById('searchInput').disabled = false;
        } else {
            if (data.error && data.error.includes('Session expired')) {
                alert('Your session has expired. You will be redirected to login.');
                window.location.href = '{{ route("login") }}';
                return;
            }
            showError(data.error || 'Failed to load transactions');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.status === 419) {
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
            return;
        }
        showError('An error occurred while loading transactions');
    });
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
}

function renderTransactions() {
    const tbody = document.getElementById('transactionsTableBody');
    
    if (filteredTransactions.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <iconify-icon icon="solar:card-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                        <p class="mb-0 text-muted">No transactions found</p>
                    </div>
                </td>
            </tr>
        `;
        updatePaginationInfo();
        document.getElementById('paginationContainer').style.display = 'flex';
        return;
    }
    
    // Calculate pagination
    totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentPageTransactions = filteredTransactions.slice(startIndex, endIndex);
    
    let html = '';
    currentPageTransactions.forEach((transaction, index) => {
        const globalIndex = startIndex + index;
        
        // Handle different possible field names from API
        const reference = transaction.reference || transaction.id || 'N/A';
        const amount = transaction.amount || '0';
        const type = transaction.type || transaction.transaction_type || 'N/A';
        const date = transaction.date || transaction.created_at || transaction.transaction_date || 'N/A';
        const status = transaction.status || 'Pending';
        
        // Format amount
        const formattedAmount = new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN'
        }).format(amount);
        
        // Format date
        let formattedDate = 'N/A';
        if (date !== 'N/A') {
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
            case 'successful':
                statusClass = 'bg-success';
                break;
            case 'failed':
            case 'declined':
            case 'error':
                statusClass = 'bg-danger';
                break;
            case 'pending':
            case 'processing':
                statusClass = 'bg-warning text-dark';
                break;
            case 'cancelled':
            case 'canceled':
                statusClass = 'bg-info';
                break;
        }
        
        // Type badge color
        let typeClass = 'bg-primary';
        switch (type.toLowerCase()) {
            case 'credit':
            case 'deposit':
            case 'payment_received':
                typeClass = 'bg-success';
                break;
            case 'debit':
            case 'withdrawal':
            case 'payment':
                typeClass = 'bg-danger';
                break;
            case 'transfer':
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
                    <div class="d-flex align-items-center">
                        <h6 class="user-name mb-0">${reference}</h6>
                    </div>
                </td>
                <td>
                    <span class="usr-amount">${formattedAmount}</span>
                </td>
                <td>
                    <span class="badge ${typeClass}">${type}</span>
                </td>
                <td>
                    <span class="usr-date">${formattedDate}</span>
                </td>
                <td>
                    <span class="badge ${statusClass}">${status}</span>
                </td>
                <td>
                    <div class="action-btn">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary me-2">
                            View Details
                        </a>
                        <a href="javascript:void(0)" class="text-dark delete ms-2">
                            <i class="ti ti-trash fs-5"></i>
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
        filteredTransactions = allTransactions;
    } else {
        filteredTransactions = allTransactions.filter(transaction => {
            const reference = (transaction.reference || transaction.id || '').toString().toLowerCase();
            const amount = (transaction.amount || '').toString().toLowerCase();
            const type = (transaction.type || transaction.transaction_type || '').toLowerCase();
            const status = (transaction.status || '').toLowerCase();
            const date = (transaction.date || transaction.created_at || transaction.transaction_date || '').toLowerCase();
            
            return reference.includes(searchTerm) || 
                   amount.includes(searchTerm) || 
                   type.includes(searchTerm) ||
                   status.includes(searchTerm) ||
                   date.includes(searchTerm);
        });
    }
    
    currentPage = 1;
    renderTransactions();
});

function updatePaginationInfo() {
    const totalItems = filteredTransactions.length;
    
    if (totalItems === 0) {
        document.getElementById('paginationInfo').textContent = 'Showing 0 to 0 of 0 entries';
        return;
    }
    
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredTransactions.length);
    
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
    renderTransactions();
    
    // Prevent default link behavior
    event.preventDefault();
}

// Auto-load transactions when page is ready
document.addEventListener('DOMContentLoaded', function() {
    loadTransactions();
});
</script>
@endpush