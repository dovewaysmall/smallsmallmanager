@extends('layouts.app')

@section('title', 'Repair Details')

@section('content')
    <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Repair Details</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('dashboard') }}">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('repairs') }}">Repairs</a>
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

          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Repair Information</h4>
                    <button class="btn btn-outline-primary btn-sm" onclick="window.history.back()">
                      <i class="ti ti-arrow-left me-1"></i> Back
                    </button>
                  </div>

                  <div id="loadingState" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0 text-muted">Loading repair details...</p>
                  </div>

                  <div id="errorState" class="d-none">
                    <div class="alert alert-danger">
                      <i class="ti ti-alert-circle me-2"></i>
                      <span id="errorMessage">Failed to load repair details</span>
                    </div>
                    <button onclick="loadRepairDetails()" class="btn btn-outline-primary">
                      <i class="ti ti-refresh me-1"></i> Retry
                    </button>
                  </div>

                  <div id="repairDetails" class="d-none">
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Title:</label>
                        <p class="text-muted" id="repairTitle">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Property:</label>
                        <p class="text-muted" id="repairProperty">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Type:</label>
                        <p id="repairType">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p id="repairStatus">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Cost:</label>
                        <p class="text-success fw-bold" id="repairCost">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Date:</label>
                        <p class="text-muted" id="repairDate">-</p>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Handler:</label>
                        <p class="text-muted" id="repairHandler">-</p>
                      </div>
                      <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Items Repaired:</label>
                        <p class="text-muted" id="repairItems">-</p>
                      </div>
                      <div class="col-12 mb-3" id="descriptionSection">
                        <label class="form-label fw-bold">Description:</label>
                        <p class="text-muted" id="repairDescription">-</p>
                      </div>
                      <div class="col-12 mb-3" id="feedbackSection">
                        <label class="form-label fw-bold">Feedback:</label>
                        <p class="text-muted" id="repairFeedback">-</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4">Actions</h5>
                  <div class="d-grid gap-2">
                    <a href="{{ route('repairs') }}" class="btn btn-outline-secondary">
                      <i class="ti ti-list me-1"></i> Back to Repairs
                    </a>
                    <a href="{{ route('repair.edit', $repairId) }}" class="btn btn-primary">
                      <i class="ti ti-edit me-1"></i> Edit Repair
                    </a>
                    <button class="btn btn-outline-danger" onclick="deleteRepair()">
                      <i class="ti ti-trash me-1"></i> Delete Repair
                    </button>
                  </div>
                </div>
              </div>

              <!-- Images Section -->
              <div class="card mt-3" id="imagesCard" style="display: none;">
                <div class="card-body">
                  <h5 class="card-title mb-4">Images</h5>
                  <div id="repairImages">
                    <!-- Images will be loaded here -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const repairId = {{ $repairId }};
let repairData = null;
let propertyMap = {};

function showState(stateName) {
    document.getElementById('loadingState').classList.add('d-none');
    document.getElementById('errorState').classList.add('d-none');
    document.getElementById('repairDetails').classList.add('d-none');
    
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

async function loadRepairDetails() {
    showState('loadingState');
    
    try {
        const response = await fetch('{{ route("repairs.load") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();
        if (data.success && data.repairs) {
            const repair = data.repairs.find(r => r.id == repairId);
            if (repair) {
                repairData = repair;
                displayRepairDetails(repair);
                showState('repairDetails');
            } else {
                document.getElementById('errorMessage').textContent = 'Repair not found';
                showState('errorState');
            }
        } else {
            document.getElementById('errorMessage').textContent = data.error || 'Failed to load repair details';
            showState('errorState');
        }
    } catch (error) {
        console.error('Error loading repair details:', error);
        document.getElementById('errorMessage').textContent = 'Network error occurred';
        showState('errorState');
    }
}

function displayRepairDetails(repair) {
    // Basic info
    document.getElementById('repairTitle').textContent = repair.title_of_repair || 'N/A';
    document.getElementById('repairProperty').textContent = propertyMap[repair.property_id] || `Property ${repair.property_id}`;
    document.getElementById('repairItems').textContent = repair.items_repaired || 'N/A';
    document.getElementById('repairHandler').textContent = repair.who_is_handling_repair || 'Unassigned';
    
    // Cost with formatting
    const cost = repair.cost_of_repair ? 
        `₦${parseFloat(repair.cost_of_repair).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}` : 
        'N/A';
    document.getElementById('repairCost').textContent = cost;
    
    // Date
    let formattedDate = repair.repair_date || 'N/A';
    if (repair.repair_date && repair.repair_date !== 'N/A') {
        try {
            formattedDate = new Date(repair.repair_date).toLocaleDateString();
        } catch (e) {
            formattedDate = repair.repair_date;
        }
    }
    document.getElementById('repairDate').textContent = formattedDate;
    
    // Type badge
    const typeElement = document.getElementById('repairType');
    const type = repair.type_of_repair || 'N/A';
    let typeClass = 'badge bg-secondary';
    switch (type.toLowerCase()) {
        case 'plumbing': typeClass = 'badge bg-primary'; break;
        case 'electrical': typeClass = 'badge bg-warning text-dark'; break;
        case 'hvac': typeClass = 'badge bg-info'; break;
        case 'appliances': typeClass = 'badge bg-success'; break;
        case 'structural': typeClass = 'badge bg-danger'; break;
    }
    typeElement.innerHTML = `<span class="${typeClass}">${type}</span>`;
    
    // Status badge
    const statusElement = document.getElementById('repairStatus');
    const status = repair.repair_status || 'pending';
    let statusClass = 'badge bg-secondary';
    switch (status.toLowerCase()) {
        case 'completed': statusClass = 'badge bg-success'; break;
        case 'pending': statusClass = 'badge bg-warning text-dark'; break;
        case 'on going': statusClass = 'badge bg-info'; break;
    }
    statusElement.innerHTML = `<span class="${statusClass}">${status}</span>`;
    
    // Description
    const description = repair.description_of_repair || repair['description_of_the repair'] || '';
    if (description) {
        document.getElementById('repairDescription').textContent = description;
        document.getElementById('descriptionSection').style.display = 'block';
    } else {
        document.getElementById('descriptionSection').style.display = 'none';
    }
    
    // Feedback
    const feedback = repair.feedback || '';
    if (feedback) {
        document.getElementById('repairFeedback').textContent = feedback;
        document.getElementById('feedbackSection').style.display = 'block';
    } else {
        document.getElementById('feedbackSection').style.display = 'none';
    }
    
    // Images
    if (repair.images_paths) {
        try {
            const imagePaths = JSON.parse(repair.images_paths);
            if (imagePaths && imagePaths.length > 0) {
                let imageHtml = '';
                imagePaths.forEach(imagePath => {
                    imageHtml += `<img src="${imagePath}" class="img-fluid mb-2 rounded" style="max-width: 100%; margin-bottom: 10px;" />`;
                });
                document.getElementById('repairImages').innerHTML = imageHtml;
                document.getElementById('imagesCard').style.display = 'block';
            }
        } catch (e) {
            console.error('Error parsing image paths:', e);
        }
    }
}

function editRepair() {
    window.location.href = `{{ route('repair.edit', $repairId) }}`;
}

function deleteRepair() {
    if (confirm('Are you sure you want to delete this repair?')) {
        alert('Delete functionality coming soon');
    }
}

// Load data when page is ready
document.addEventListener('DOMContentLoaded', async function() {
    await loadProperties();
    loadRepairDetails();
});
</script>
@endpush