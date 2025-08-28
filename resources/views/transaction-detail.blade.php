@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Transaction Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('transactions') }}">Transactions</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Details
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <!-- Transaction Details Content -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-7">
                    <h4 class="card-title">General</h4>
                    <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                      <i class="ti ti-menu fs-5 d-flex"></i>
                    </button>
                  </div>
                  
                  @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                  @endif

                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif

                  @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif

                  @if(session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                  @endif

                  @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                  @endif

                  <form class="form-horizontal">
                    <div class="mb-4">
                      <label class="form-label">Transaction ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Transaction ID" value="{{ $transaction['data']['id'] ?? $transaction['data']['transaction_id'] ?? $id ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">User ID</label>
                      <input type="text" class="form-control" placeholder="User ID" value="{{ $transaction['data']['userID'] ?? $transaction['data']['user_id'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">User Name</label>
                      <input type="text" class="form-control" placeholder="User Name" value="{{ trim(($transaction['data']['user_firstName'] ?? '') . ' ' . ($transaction['data']['user_lastName'] ?? '')) ?: 'N/A' }}" readonly>

                      <label class="form-label mt-3">Email</label>
                      <input type="email" class="form-control" placeholder="Email" value="{{ $transaction['data']['email'] ?? $transaction['data']['user_email'] ?? 'N/A' }}" readonly>

                      <label class="form-label mt-3">Phone</label>
                      <input type="text" class="form-control" placeholder="Phone" value="{{ $transaction['data']['phone'] ?? $transaction['data']['user_phone'] ?? 'N/A' }}" readonly>
                    </div>
                  </form>
                </div>
              </div>
              
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-7">Transaction Details</h4>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control" placeholder="Amount" value="{{ $transaction['data']['amount'] ? '₦' . number_format($transaction['data']['amount'], 2) : 'N/A' }}" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Currency</label>
                        <input type="text" class="form-control" placeholder="Currency" value="{{ $transaction['data']['currency'] ?? 'NGN' }}" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Transaction Type</label>
                        <input type="text" class="form-control" placeholder="Type" value="{{ $transaction['data']['type'] ?? $transaction['data']['transaction_type'] ?? 'N/A' }}" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" placeholder="Status" value="{{ $transaction['data']['status'] ?? 'N/A' }}" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Transaction Date</label>
                        <input type="text" class="form-control" placeholder="Date" value="{{ isset($transaction['data']['date']) ? date('Y-m-d H:i:s', strtotime($transaction['data']['date'])) : (isset($transaction['data']['created_at']) ? date('Y-m-d H:i:s', strtotime($transaction['data']['created_at'])) : 'N/A') }}" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Payment Method</label>
                        <input type="text" class="form-control" placeholder="Payment Method" value="{{ $transaction['data']['payment_method'] ?? $transaction['data']['method'] ?? 'N/A' }}" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Reference</label>
                    <input type="text" class="form-control" placeholder="Reference" value="{{ $transaction['data']['reference'] ?? $transaction['data']['transaction_reference'] ?? 'N/A' }}" readonly>
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" placeholder="Description" readonly>{{ $transaction['data']['description'] ?? $transaction['data']['purpose'] ?? 'N/A' }}</textarea>
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Gateway Response</label>
                    <textarea class="form-control" rows="2" placeholder="Gateway Response" readonly>{{ $transaction['data']['gateway_response'] ?? $transaction['data']['response_message'] ?? 'N/A' }}</textarea>
                  </div>

                  <div class="form-actions">
                    <a href="{{ route('transactions') }}" class="btn btn-primary">
                      <i class="ti ti-arrow-left me-1"></i> Back to Transactions
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4">
              <div class="offcanvas-lg offcanvas-end overflow-auto" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <!-- Sidebar content can be added here in future -->
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection