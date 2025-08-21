@extends('layouts.app')

@section('title', 'Add New Payout')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Add New Payout</h4>
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h5>Validation Errors:</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            
                            <form id="addPayoutForm" method="POST" action="{{ route('payouts.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Landlord ID -->
                                <div class="mb-3">
                                    <label for="landlord_id" class="form-label">Landlord <span class="text-danger">*</span></label>
                                    <select class="form-select @error('landlord_id') is-invalid @enderror" 
                                            id="landlord_id" name="landlord_id" required>
                                        <option value="">Select a landlord...</option>
                                    </select>
                                    @error('landlord_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Select the landlord for this payout.</div>
                                </div>

                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount (₦) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                               id="amount" name="amount" 
                                               value="{{ old('amount') }}" 
                                               required min="0.01" step="0.01" 
                                               placeholder="0.00">
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Enter the payout amount in Naira.</div>
                                </div>

                                <!-- Payout Status -->
                                <div class="mb-3">
                                    <label for="payout_status" class="form-label">Payout Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payout_status') is-invalid @enderror" 
                                            id="payout_status" name="payout_status" required>
                                        <option value="pending" {{ old('payout_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ old('payout_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ old('payout_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ old('payout_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                    @error('payout_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Current status of the payout.</div>
                                </div>

                                <!-- Upload Receipt -->
                                <div class="mb-3">
                                    <label for="upload_receipt" class="form-label">Upload Receipt <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('upload_receipt') is-invalid @enderror" 
                                           id="upload_receipt" name="upload_receipt" 
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                    @error('upload_receipt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Upload a receipt or proof of payment (PDF, JPG, PNG, DOC, DOCX - max 5MB).</div>
                                </div>

                                <!-- Date Paid -->
                                <div class="mb-3">
                                    <label for="date_paid" class="form-label">Date Paid <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date_paid') is-invalid @enderror" 
                                           id="date_paid" name="date_paid" 
                                           value="{{ old('date_paid', date('Y-m-d')) }}" 
                                           required>
                                    @error('date_paid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Select the date when the payout was made.</div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="ti ti-wallet me-2"></i>Create Payout
                                    </button>
                                    <a href="{{ route('payouts') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-arrow-left me-2"></i>Back to Payouts
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Load landlords on page load
async function loadLandlords() {
    try {
        const landlordSelect = document.getElementById('landlord_id');
        
        const response = await fetch('{{ route("landlords.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.landlords && data.landlords.length > 0) {
            landlordSelect.innerHTML = '<option value="">Select a landlord...</option>';
            
            data.landlords.forEach((landlord) => {
                const landlordId = landlord.userID || landlord.user_id || landlord.id;
                const landlordName = `${landlord.firstName} ${landlord.lastName}` || 
                                   `${landlord.first_name} ${landlord.last_name}` || 
                                   landlord.name || 
                                   `Landlord ${landlordId}`;
                
                const option = document.createElement('option');
                option.value = landlordId;
                option.textContent = `${landlordName} (${landlordId})`;
                if ('{{ old("landlord_id") }}' === String(landlordId)) {
                    option.selected = true;
                }
                landlordSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading landlords:', error);
    }
}

// Form submission
document.getElementById('addPayoutForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating Payout...';
});

// Format amount input
document.getElementById('amount').addEventListener('blur', function(e) {
    let value = e.target.value;
    if (value && !isNaN(value) && parseFloat(value) > 0) {
        e.target.value = parseFloat(value).toFixed(2);
    }
});

// File upload validation
document.getElementById('upload_receipt').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (file.size > maxSize) {
            alert('File size must be less than 5MB');
            e.target.value = '';
            return;
        }
        
        if (!allowedTypes.includes(file.type)) {
            alert('Only PDF, JPG, PNG, DOC, and DOCX files are allowed');
            e.target.value = '';
            return;
        }
    }
});

// Load landlords when page is ready
document.addEventListener('DOMContentLoaded', function() {
    loadLandlords();
});
</script>
@endpush