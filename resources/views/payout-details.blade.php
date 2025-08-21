@extends('layouts.app')

@section('title', 'Payout Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Payout Details</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="{{ route('payouts') }}">Payouts</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">Details</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" id="payoutDetailsContainer">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;" id="loadingState">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">Loading payout details...</span>
                    </div>
                    
                    <div class="d-none" id="errorState">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Error!</h4>
                            <p id="errorMessage">Failed to load payout details.</p>
                            <hr>
                            <div class="mb-0">
                                <a href="{{ route('payouts') }}" class="btn btn-outline-danger">
                                    <i class="ti ti-arrow-left me-1"></i>Back to Payouts
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-none" id="contentState">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Payout Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Payout ID:</strong></div>
                                            <div class="col-sm-8" id="payoutId">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Reference:</strong></div>
                                            <div class="col-sm-8" id="payoutReference">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Recipient:</strong></div>
                                            <div class="col-sm-8" id="payoutRecipient">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Amount:</strong></div>
                                            <div class="col-sm-8" id="payoutAmount">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Status:</strong></div>
                                            <div class="col-sm-8" id="payoutStatus">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Date Paid:</strong></div>
                                            <div class="col-sm-8" id="payoutDate">-</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Created:</strong></div>
                                            <div class="col-sm-8" id="payoutCreated">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Receipt</h5>
                                    </div>
                                    <div class="card-body" id="receiptContainer">
                                        <div class="text-center text-muted" id="noReceipt">
                                            <iconify-icon icon="solar:file-smile-line-duotone" class="fs-1"></iconify-icon>
                                            <p class="mt-2">No receipt uploaded</p>
                                            <a href="#" id="pdfReceiptLinkNoFile" target="_blank" class="btn btn-primary mt-3">
                                                <i class="ti ti-file-type-pdf me-1"></i>Generate PDF Receipt
                                            </a>
                                        </div>
                                        <div class="d-none" id="receiptContent">
                                            <div class="text-center">
                                                <a href="#" id="receiptLink" target="_blank" class="btn btn-primary mb-2">
                                                    <i class="ti ti-download me-1"></i>View Original Receipt
                                                </a>
                                                <br>
                                                <a href="#" id="pdfReceiptLink" target="_blank" class="btn btn-outline-primary">
                                                    <i class="ti ti-file-type-pdf me-1"></i>Generate PDF Receipt
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('payouts') }}" class="btn btn-outline-secondary">
                                                <i class="ti ti-arrow-left me-1"></i>Back to Payouts
                                            </a>
                                            <button class="btn btn-outline-danger" onclick="deletePayout()">
                                                <i class="ti ti-trash me-1"></i>Delete Payout
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="redirectToPayouts()">
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
                        <p class="text-muted mb-0" id="errorModalMessage">An error occurred while deleting the payout.</p>
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
let currentPayoutId = null;
let landlordMap = {};

// Get payout ID from URL
const urlParts = window.location.pathname.split('/');
const payoutIndex = urlParts.indexOf('payout');
const payoutId = payoutIndex !== -1 ? urlParts[payoutIndex + 1] : urlParts[urlParts.length - 1];

console.log('Payout details - URL parts:', urlParts);
console.log('Payout details - Extracted payout ID:', payoutId);

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('contentState').classList.add('d-none');
    
    if (stateName) {
        document.getElementById(stateName).classList.remove('d-none');
    }
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    showState('errorState');
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
            landlordMap = {};
            data.landlords.forEach(landlord => {
                const landlordId = landlord.userID || landlord.user_id || landlord.id;
                const landlordName = `${landlord.firstName} ${landlord.lastName}` || 
                                   `${landlord.first_name} ${landlord.last_name}` || 
                                   landlord.name || 
                                   `Landlord ${landlordId}`;
                landlordMap[landlordId] = landlordName;
            });
        }
    } catch (error) {
        console.error('Error loading landlords:', error);
    }
}

async function loadPayoutDetails() {
    if (!payoutId || payoutId === 'undefined') {
        showError('Invalid payout ID');
        return;
    }
    
    currentPayoutId = payoutId;
    showState('loadingState');
    
    try {
        // First load landlords for name mapping
        await loadLandlords();
        
        // Then load payout details
        const response = await fetch('{{ route("payouts.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        console.log('Payout details - API Response:', data);
        
        if (data.success && data.payouts) {
            console.log('Payout details - Total payouts received:', data.payouts.length);
            console.log('Payout details - Looking for ID:', payoutId);
            console.log('Payout details - Sample payout IDs:', data.payouts.slice(0, 3).map(p => ({
                id: p.id,
                payout_id: p.payout_id,
                landlord_id: p.landlord_id
            })));
            
            const payout = data.payouts.find(p => 
                String(p.id) === String(payoutId) || 
                String(p.payout_id) === String(payoutId)
            );
            
            if (payout) {
                console.log('Payout details - Found payout:', payout);
                displayPayoutDetails(payout);
                showState('contentState');
            } else {
                showError(`Payout not found. Looking for ID: ${payoutId}`);
            }
        } else {
            showError(data.error || 'Failed to load payout details');
        }
    } catch (error) {
        console.error('Error loading payout details:', error);
        showError('Network error occurred while loading payout details');
    }
}

function displayPayoutDetails(payout) {
    // Basic payout information
    const payoutIdElement = payout.id || payout.payout_id || 'N/A';
    const reference = payout.reference || payout.transaction_reference || payout.ref || 'N/A';
    
    // Get landlord name using landlord_id lookup
    const landlordId = payout.landlord_id;
    const recipient = landlordMap[landlordId] || payout.landlord_name || payout.recipient_name || payout.recipient || payout.user_name || landlordId || 'N/A';
    
    const amount = payout.amount || payout.payout_amount || '0.00';
    const status = payout.status || payout.payout_status || 'pending';
    const datePaid = payout.date_paid || payout.payout_date || payout.date || 'N/A';
    const createdAt = payout.created_at || 'N/A';
    
    // Format dates
    let formattedDatePaid = datePaid;
    let formattedCreatedAt = createdAt;
    
    if (datePaid !== 'N/A' && datePaid) {
        try {
            formattedDatePaid = new Date(datePaid).toLocaleDateString();
        } catch (e) {
            formattedDatePaid = datePaid;
        }
    }
    
    if (createdAt !== 'N/A' && createdAt) {
        try {
            formattedCreatedAt = new Date(createdAt).toLocaleDateString();
        } catch (e) {
            formattedCreatedAt = createdAt;
        }
    }
    
    // Status badge color
    let statusClass = 'badge bg-secondary';
    switch (status.toLowerCase()) {
        case 'completed':
        case 'success':
        case 'paid':
            statusClass = 'badge bg-success';
            break;
        case 'pending':
            statusClass = 'badge bg-warning text-dark';
            break;
        case 'failed':
        case 'declined':
            statusClass = 'badge bg-danger';
            break;
        case 'processing':
            statusClass = 'badge bg-info';
            break;
    }
    
    // Update UI elements
    document.getElementById('payoutId').textContent = payoutIdElement;
    document.getElementById('payoutReference').textContent = reference;
    document.getElementById('payoutRecipient').textContent = recipient;
    document.getElementById('payoutAmount').innerHTML = `<span class="text-success fw-bold">₦${parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>`;
    document.getElementById('payoutStatus').innerHTML = `<span class="${statusClass}">${status}</span>`;
    document.getElementById('payoutDate').textContent = formattedDatePaid;
    document.getElementById('payoutCreated').textContent = formattedCreatedAt;
    
    // Set PDF receipt links
    const pdfReceiptUrl = `/payout/${payoutId}/receipt`;
    document.getElementById('pdfReceiptLinkNoFile').href = pdfReceiptUrl;
    if (document.getElementById('pdfReceiptLink')) {
        document.getElementById('pdfReceiptLink').href = pdfReceiptUrl;
    }
    
    // Handle receipt
    console.log('Receipt data:', {
        receipt_url: payout.receipt_url,
        upload_receipt: payout.upload_receipt,
        all_payout_keys: Object.keys(payout)
    });
    
    if (payout.receipt_url || payout.upload_receipt) {
        let receiptUrl = payout.receipt_url || payout.upload_receipt;
        
        // If it's just a filename, construct the full URL
        if (receiptUrl && !receiptUrl.startsWith('http') && !receiptUrl.startsWith('/')) {
            receiptUrl = `/storage/receipts/${receiptUrl}`;
        }
        
        // If it starts with 'receipts/', prepend '/storage/'
        if (receiptUrl && receiptUrl.startsWith('receipts/')) {
            receiptUrl = `/storage/${receiptUrl}`;
        }
        
        console.log('Final receipt URL:', receiptUrl);
        
        // Use the Laravel route to serve the receipt file
        const receiptFileUrl = `/payout/${currentPayoutId}/file`;
        
        // Check if the receipt file exists by trying to fetch it
        checkReceiptExists(receiptFileUrl, pdfReceiptUrl);
    } else {
        console.log('No receipt found');
        showNoReceipt();
    }
}

async function checkReceiptExists(receiptUrl, pdfReceiptUrl) {
    try {
        // Try to fetch just the headers to check if file exists
        const response = await fetch(receiptUrl, { 
            method: 'HEAD',
            cache: 'no-cache'
        });
        
        if (response.ok) {
            console.log('Receipt file exists, showing receipt content');
            showReceiptContent(receiptUrl, pdfReceiptUrl);
        } else {
            console.warn(`Receipt file not found (${response.status}):`, receiptUrl);
            showReceiptMissing(pdfReceiptUrl);
        }
    } catch (error) {
        console.error('Error checking receipt file:', error);
        showReceiptMissing(pdfReceiptUrl);
    }
}

function showReceiptContent(receiptUrl, pdfReceiptUrl) {
    document.getElementById('receiptLink').href = receiptUrl;
    document.getElementById('pdfReceiptLink').href = pdfReceiptUrl;
    document.getElementById('noReceipt').classList.add('d-none');
    document.getElementById('receiptContent').classList.remove('d-none');
}

function showReceiptMissing(pdfReceiptUrl) {
    // Show the no receipt state but with a warning about missing file
    const noReceiptDiv = document.getElementById('noReceipt');
    
    noReceiptDiv.innerHTML = `
        <div class="alert alert-warning" role="alert">
            <iconify-icon icon="solar:file-corrupted-line-duotone" class="fs-2 me-2"></iconify-icon>
            <strong>Receipt file not accessible</strong><br>
            <small>The original receipt file may have been moved, deleted, or there may be a server configuration issue.</small>
        </div>
        <div class="text-center">
            <a href="${pdfReceiptUrl}" target="_blank" class="btn btn-primary">
                <i class="ti ti-file-type-pdf me-1"></i>Generate PDF Receipt
            </a>
        </div>
    `;
    
    noReceiptDiv.classList.remove('d-none');
    document.getElementById('receiptContent').classList.add('d-none');
}

function showNoReceipt() {
    document.getElementById('noReceipt').classList.remove('d-none');
    document.getElementById('receiptContent').classList.add('d-none');
}

function deletePayout() {
    if (!currentPayoutId) {
        showErrorModal('Invalid payout ID');
        return;
    }
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deletePayoutModal'));
    deleteModal.show();
}

async function confirmDeletePayout() {
    if (!currentPayoutId) {
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
        const response = await fetch(`{{ url('/payout') }}/${currentPayoutId}`, {
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
    }
}

function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

function showErrorModal(message) {
    document.getElementById('errorModalMessage').textContent = message;
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
}

function redirectToPayouts() {
    window.location.href = '{{ route("payouts") }}';
}

// Load payout details when page is ready
document.addEventListener('DOMContentLoaded', function() {
    loadPayoutDetails();
    
    // Add event listener for confirm delete button
    document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDeletePayout);
});
</script>
@endpush