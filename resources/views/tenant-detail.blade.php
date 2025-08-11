@extends('layouts.app')

@section('title', 'Tenant Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Tenant Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('tenants') }}">Tenants</a>
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

          <div class="card">
            <div class="card-body">
                <div class="text-center py-5">
                    <iconify-icon icon="solar:user-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <h5 class="text-muted">Tenant Details Page</h5>
                    <p class="text-muted">Tenant ID: {{ $userID ?? 'N/A' }}</p>
                    <p class="text-muted">This page is under construction.</p>
                    <a href="{{ route('tenants') }}" class="btn btn-primary">
                        <i class="ti ti-arrow-left me-1"></i> Back to Tenants
                    </a>
                </div>
            </div>
          </div>
        </div>
    </div>
@endsection