@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="body-wrapper">
      <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body p-4 pb-0" data-simplebar="">
                    <div class="row">
                      <div class="col-xl col-md-6 col-sm-12">
                        <div class="card primary-gradient">
                          <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mb-3 mx-auto">
                              <iconify-icon icon="solar:dollar-minimalistic-linear" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">Total Users</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="userCount">0</h4>
                            <a href="{{ route('users') }}" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                              Details</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl col-md-6 col-sm-12">
                        <div class="card warning-gradient">
                          <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mb-3 mx-auto">
                              <iconify-icon icon="solar:recive-twice-square-linear" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">Total Inspections</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="inspectionCount">0</h4>
                            <a href="{{ route('inspections') }}" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                              Details</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl col-md-6 col-sm-12">
                        <div class="card secondary-gradient">
                          <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                              <iconify-icon icon="ic:outline-backpack" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">Total Transactions</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="transactionCount">0</h4>
                            <a href="{{ route('transactions') }}" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                              Details</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl col-md-6 col-sm-12">
                        <div class="card danger-gradient">
                          <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                              <iconify-icon icon="ic:baseline-sync-problem" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">Total Properties</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="propertyCount">0</h4>
                            <a href="{{ route('properties') }}" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                              Details</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl col-md-6 col-sm-12">
                        <div class="card success-gradient">
                          <div class="card-body text-center px-9 pb-4">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                              <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                            </div>
                            <h6 class="fw-normal fs-3 mb-1">Total Tenants</h6>
                            <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="tenantCount">0</h4>
                            <a href="{{ route('tenants') }}" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                              Details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ----------------------------------------- -->
              <!-- Revenue Forecast -->
              <!-- ----------------------------------------- -->
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-body">
                    <div class="d-md-flex align-items-center justify-content-between mb-3">
                      <div>
                        <h5 class="card-title">Revenue Forecast</h5>
                        <p class="card-subtitle mb-0">Overview of Profit</p>
                      </div>

                      <div class="hstack gap-9 mt-4 mt-md-0">
                        <div class="d-flex align-items-center gap-2">
                          <span class="d-block flex-shrink-0 round-10 bg-primary rounded-circle"></span>
                          <span class="text-nowrap text-muted">2025</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                          <span class="d-block flex-shrink-0 round-10 bg-danger rounded-circle"></span>
                          <span class="text-nowrap text-muted">2026</span>
                        </div>
                      </div>
                    </div>
                    <div style="height: 305px;" class="me-n2 rounded-bars">
                      <div id="revenue-forecast"></div>
                    </div>
                    <div class="row mt-4 mb-2">
                      <div class="col-md-4">
                        <div class="hstack gap-6 mb-3 mb-md-0">
                          <span class="d-flex align-items-center justify-content-center round-48 bg-light rounded">
                            <iconify-icon icon="solar:pie-chart-2-linear" class="fs-7 text-dark"></iconify-icon>
                          </span>
                          <div>
                            <span>Revenue</span>
                            <h5 class="mt-1 fw-medium mb-0">₦120,000,000</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="hstack gap-6 mb-3 mb-md-0">
                          <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded">
                            <iconify-icon icon="solar:cash-out-linear" class="fs-7 text-primary"></iconify-icon>
                          </span>
                          <div>
                            <span>Profit</span>
                            <h5 class="mt-1 fw-medium mb-0">₦70,000,000</h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="hstack gap-6">
                          <span class="d-flex align-items-center justify-content-center round-48 bg-danger-subtle rounded">
                            <iconify-icon icon="solar:database-linear" class="fs-7 text-danger"></iconify-icon>
                          </span>
                          <div>
                            <span>Expenses</span>
                            <h5 class="mt-1 fw-medium mb-0">₦50,000,000</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ----------------------------------------- -->
              <!-- Annual Profit -->
              <!-- ----------------------------------------- -->
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title mb-4">Annual Stats</h5>
                    <div class="bg-primary bg-opacity-10 rounded-1 overflow-hidden mb-4">
                      <div class="p-4 mb-9">
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="text-dark-light">Conversion Rate</span>
                          <h3 class="mb-0" id="conversionRate">Loading...</h3>
                        </div>
                      </div>
                      <div id="annual-profit"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pb-6 border-bottom">
                      <div>
                        <span class="text-muted fw-medium">Total Users</span>
                        <span class="fs-11 fw-medium d-block mt-1">Percentage</span>
                      </div>
                      <div class="text-end">
                        <h6 class="fw-bolder mb-1 lh-base" id="totalUsersThisYear">Loading...</h6>
                        <span class="fs-11 fw-medium text-success">100%</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-6 border-bottom">
                      <div>
                        <span class="text-muted fw-medium">Converted Users</span>
                        <span class="fs-11 fw-medium d-block mt-1">Percentage</span>
                      </div>
                      <div class="text-end">
                        <h6 class="fw-bolder mb-1 lh-base" id="convertedUsers">Loading...</h6>
                        <span class="fs-11 fw-medium text-success" id="convertedUsersPercentage">Loading...</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-6">
                      <div>
                        <span class="text-muted fw-medium">Unconverted Users</span>
                        <span class="fs-11 fw-medium d-block mt-1">Percentage</span>
                      </div>
                      <div class="text-end">
                        <h6 class="fw-bolder mb-1 lh-base" id="unconvertedUsers">Loading...</h6>
                        <span class="fs-11 fw-medium text-danger" id="unconvertedUsersPercentage">Loading...</span>
                      </div>
                    </div>
                    <div class="mt-3">
                      <a href="/unconverted-users" class="btn btn-outline-primary btn-sm">View More</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                <!-- -------------------------------------------- -->
                <!-- Your Performance -->
                <!-- -------------------------------------------- -->
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title fw-semibold">Performance This Month</h5>
                    <p class="card-subtitle mb-0 lh-base"></p>

                    <div class="row mt-4">
                      <div class="col-md-6">
                        <div class="vstack gap-9 mt-2">
                          <div class="hstack align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded bg-primary-subtle flex-shrink-0">
                              <iconify-icon icon="solar:shop-2-linear" class="fs-7 text-primary"></iconify-icon>
                            </div>
                            <div>
                              <h6 class="mb-0 text-nowrap" id="newUsersThisMonth">0</h6>
                              <span>New Users</span>
                            </div>

                          </div>
                          <div class="hstack align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded bg-danger-subtle">
                              <iconify-icon icon="solar:filters-outline" class="fs-7 text-danger"></iconify-icon>
                            </div>
                            <div>
                              <h6 class="mb-0" id="tenantsThisMonth">0</h6>
                              <span>Tenants This Month</span>
                            </div>

                          </div>
                          <div class="hstack align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle">
                              <iconify-icon icon="solar:pills-3-linear" class="fs-7 text-secondary"></iconify-icon>
                            </div>
                            <div>
                              <h6 class="mb-0" id="pendingInspectionsThisMonth">0</h6>
                              <span>Pending Inspections</span>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="text-center mt-sm-n7">
                          <div id="your-preformance"></div>
                          <h2 class="fs-8" id="inspectionsThisMonth">0</h2>
                          <p class="mb-0">
                            Inspections booked
                          </p>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                
              </div>
              <div class="col-lg-7">
                <div class="row">
                  <div class="col-md-6">
                    <!-- -------------------------------------------- -->
                    <!-- Customers -->
                    <!-- -------------------------------------------- -->
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                          <div>
                            <h5 class="card-title fw-semibold">Customers</h5>
                            <p class="card-subtitle mb-0">Last 7 days</p>
                          </div>
                          <span class="fs-11 text-success fw-semibold lh-lg">+26.5%</span>
                        </div>
                        <div class="py-4 my-1">
                          <div id="customers-area"></div>
                        </div>
                        <div class="d-flex flex-column align-items-center gap-2 w-100 mt-3">
                          <div class="d-flex align-items-center gap-2 w-100">
                            <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                            <h6 class="fs-3 fw-normal text-muted mb-0">April 07 - April 14</h6>
                            <h6 class="fs-3 fw-normal mb-0 ms-auto text-muted">6,380</h6>
                          </div>
                          <div class="d-flex align-items-center gap-2 w-100">
                            <span class="d-block flex-shrink-0 round-8 bg-light rounded-circle"></span>
                            <h6 class="fs-3 fw-normal text-muted mb-0">Last Week</h6>
                            <h6 class="fs-3 fw-normal mb-0 ms-auto text-muted">4,298</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- -------------------------------------------- -->
                    <!-- Sales Overview -->
                    <!-- -------------------------------------------- -->
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                        <p class="card-subtitle mb-1">Last 7 days</p>

                        <div class="position-relative labels-chart">
                          <span class="fs-11 label-1">0%</span>
                          <span class="fs-11 label-2">25%</span>
                          <span class="fs-11 label-3">50%</span>
                          <span class="fs-11 label-4">75%</span>
                          <div id="sales-overview"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
      
              <div class="col-12">
                <div class="card mb-0">
                  <div class="card-body calender-sidebar app-calendar">
                    <div id="calendar"></div>
                  </div>
                </div>
                <!-- BEGIN MODAL -->
                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">
                          Add / Edit Event
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div>
                              <label class="form-label">Event Title</label>
                              <input id="event-title" type="text" class="form-control" />
                            </div>
                          </div>
                          <div class="col-md-12 mt-6">
                            <div>
                              <label class="form-label">Event Color</label>
                            </div>
                            <div class="d-flex">
                              <div class="n-chk">
                                <div class="form-check form-check-primary form-check-inline">
                                  <input class="form-check-input" type="radio" name="event-level" value="Danger" id="modalDanger" />
                                  <label class="form-check-label" for="modalDanger">Danger</label>
                                </div>
                              </div>
                              <div class="n-chk">
                                <div class="form-check form-check-warning form-check-inline">
                                  <input class="form-check-input" type="radio" name="event-level" value="Success" id="modalSuccess" />
                                  <label class="form-check-label" for="modalSuccess">Success</label>
                                </div>
                              </div>
                              <div class="n-chk">
                                <div class="form-check form-check-success form-check-inline">
                                  <input class="form-check-input" type="radio" name="event-level" value="Primary" id="modalPrimary" />
                                  <label class="form-check-label" for="modalPrimary">Primary</label>
                                </div>
                              </div>
                              <div class="n-chk">
                                <div class="form-check form-check-danger form-check-inline">
                                  <input class="form-check-input" type="radio" name="event-level" value="Warning" id="modalWarning" />
                                  <label class="form-check-label" for="modalWarning">Warning</label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12 mt-6">
                            <div>
                              <label class="form-label">Enter Start Date</label>
                              <input id="event-start-date" type="date" class="form-control" />
                            </div>
                          </div>

                          <div class="col-md-12 mt-6">
                            <div>
                              <label class="form-label">Enter End Date</label>
                              <input id="event-end-date" type="date" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
                          Update changes
                        </button>
                        <button type="button" class="btn btn-primary btn-add-event">
                          Add Event
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END MODAL -->
              </div>
            </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
// Update conversion rate chart with real data
function updateConversionChart(monthlyBreakdown) {
    // Ensure we have data
    if (!monthlyBreakdown || monthlyBreakdown.length === 0) {
        console.log('No monthly breakdown data available');
        return;
    }
    
    console.log('Updating chart with monthly breakdown data:', monthlyBreakdown);
    
    // Add small delay to ensure DOM is ready and original chart is cleared
    setTimeout(() => {
        // Extract converted users count from monthly breakdown
        const monthlyConvertedUsers = monthlyBreakdown.map(month => month.converted_users);
        const monthNames = monthlyBreakdown.map(month => month.month); // Full month names
        
        console.log('Monthly converted users:', monthlyConvertedUsers);
        
        // Chart configuration
        var options = {
        chart: {
            id: "annual-profit",
            type: "area",
            height: 80,
            sparkline: {
                enabled: true,
            },
            group: "sparklines",
            fontFamily: "inherit",
            foreColor: "#adb0bb",
        },
        series: [
            {
                name: "Converted Users",
                color: "var(--bs-primary)",
                data: monthlyConvertedUsers,
            },
        ],
        stroke: {
            curve: "smooth",
            width: 2,
        },
        fill: {
            type: "gradient",
            color: "var(--bs-primary)",
            gradient: {
                shadeIntensity: 0,
                inverseColors: false,
                opacityFrom: 0.1,
                opacityTo: 0.1,
                stops: [100],
            },
        },
        markers: {
            size: 0,
        },
        tooltip: {
            theme: "dark",
            fixed: {
                enabled: true,
                position: "right",
            },
            x: {
                show: true,
            },
        },
        xaxis: {
            categories: monthNames,
        },
    };
    
        // Clear existing chart and render new one
        const chartElement = document.querySelector("#annual-profit");
        if (chartElement) {
            chartElement.innerHTML = ''; // Clear existing chart
            new ApexCharts(chartElement, options).render();
        }
    }, 500); // 500ms delay
}

// Fetch conversion rate from API
function loadConversionRate() {
    console.log('Starting conversion rate fetch...');
    fetch('{{ route("api.conversion-rate.this-year") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);
            const conversionRateElement = document.getElementById('conversionRate');
            const convertedUsersElement = document.getElementById('convertedUsers');
            const convertedUsersPercentageElement = document.getElementById('convertedUsersPercentage');
            const totalUsersThisYearElement = document.getElementById('totalUsersThisYear');
            const unconvertedUsersElement = document.getElementById('unconvertedUsers');
            const unconvertedUsersPercentageElement = document.getElementById('unconvertedUsersPercentage');
            
            if (data && data.conversion_summary && data.conversion_summary.conversion_rate_percentage !== undefined) {
                console.log('Setting conversion rate to:', data.conversion_summary.conversion_rate_percentage + '%');
                conversionRateElement.textContent = data.conversion_summary.conversion_rate_percentage + '%';
                
                // Set converted users count
                const convertedUsersCount = data.conversion_summary.users_converted_to_tenants || 0;
                console.log('Setting converted users to:', convertedUsersCount);
                convertedUsersElement.textContent = convertedUsersCount;
                
                // Set converted users percentage
                const conversionPercentage = data.conversion_summary.conversion_rate_percentage || 0;
                console.log('Setting converted users percentage to:', conversionPercentage + '%');
                convertedUsersPercentageElement.textContent = conversionPercentage + '%';
                
                // Set total users this year
                const totalUsersThisYear = data.conversion_summary.total_users_registered || 0;
                console.log('Setting total users this year to:', totalUsersThisYear);
                totalUsersThisYearElement.textContent = totalUsersThisYear;
                
                // Set unconverted users count
                const unconvertedUsersCount = data.conversion_summary.unconverted_users || 0;
                console.log('Setting unconverted users to:', unconvertedUsersCount);
                unconvertedUsersElement.textContent = unconvertedUsersCount;
                
                // Calculate and set unconverted users percentage
                const unconvertedPercentage = 100 - conversionPercentage;
                console.log('Setting unconverted users percentage to:', unconvertedPercentage + '%');
                unconvertedUsersPercentageElement.textContent = unconvertedPercentage + '%';
                
                // Update the conversion rate chart with monthly data
                if (data.monthly_breakdown) {
                    updateConversionChart(data.monthly_breakdown);
                }
            } else {
                console.log('Condition failed - setting to 0%');
                console.log('Full data:', data);
                conversionRateElement.textContent = '0%';
                convertedUsersElement.textContent = '0';
                convertedUsersPercentageElement.textContent = '0%';
                totalUsersThisYearElement.textContent = '0';
                unconvertedUsersElement.textContent = '0';
                unconvertedUsersPercentageElement.textContent = '0%';
            }
        })
        .catch(error => {
            console.error('Error fetching conversion rate:', error);
            document.getElementById('conversionRate').textContent = 'Error';
            document.getElementById('convertedUsers').textContent = 'Error';
            document.getElementById('convertedUsersPercentage').textContent = 'Error';
            document.getElementById('totalUsersThisYear').textContent = 'Error';
            document.getElementById('unconvertedUsers').textContent = 'Error';
            document.getElementById('unconvertedUsersPercentage').textContent = 'Error';
        });
}

// Create performance semi-circle chart
function createPerformanceChart() {
    console.log('Inside createPerformanceChart function');
    
    var options = {
        series: [20, 20, 20, 20, 20],
        labels: ["245", "45", "14", "78", "95"],
        chart: {
            height: 205,
            fontFamily: "inherit",
            type: "donut",
        },
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 10,
                donut: {
                    size: "90%",
                },
            },
        },
        grid: {
            padding: {
                bottom: -80,
            },
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
            name: {
                show: false,
            },
        },
        stroke: {
            width: 2,
            colors: "var(--bs-card-bg)",
        },
        tooltip: {
            fillSeriesColor: false,
        },
        colors: [
            "var(--bs-danger)",
            "var(--bs-warning)",
            "var(--bs-warning-bg-subtle)",
            "var(--bs-secondary-bg-subtle)",
            "var(--bs-secondary)",
        ],
        responsive: [{
            breakpoint: 1400,
            options: {
                chart: {
                    height: 170
                },
            },
        }],
    };
    
    const chartElement = document.querySelector("#your-preformance");
    console.log('Chart element:', chartElement);
    
    if (chartElement) {
        console.log('Clearing and creating chart...');
        chartElement.innerHTML = ''; // Clear existing content
        
        try {
            const chart = new ApexCharts(chartElement, options);
            chart.render();
            console.log('Chart rendered successfully');
        } catch (error) {
            console.error('Error creating chart:', error);
        }
    } else {
        console.error('Chart element #your-preformance not found');
    }
}

// Activate the dashboard sidebar section when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard DOM loaded - starting initialization...');
    
    // Load conversion rate (this will also update the chart)
    loadConversionRate();
    
    // Immediate check for chart element
    const element = document.querySelector('#your-preformance');
    console.log('Performance chart element check:', element);
    console.log('ApexCharts library check:', typeof ApexCharts);
    
    // Wait for everything to load, then create chart
    setTimeout(() => {
        console.log('Attempting chart creation after longer delay...');
        
        // Try multiple selectors
        let chartEl = document.getElementById('your-preformance');
        if (!chartEl) {
            chartEl = document.querySelector('#your-preformance');
        }
        
        console.log('Element found:', chartEl);
        console.log('Element parent:', chartEl ? chartEl.parentElement : 'No parent');
        console.log('Element visible:', chartEl ? getComputedStyle(chartEl).display : 'No element');
        
        if (!chartEl) {
            console.error('Element still not found after delay');
            // Create the element if it doesn't exist
            const parentEl = document.querySelector('.col-md-6 .text-center');
            if (parentEl) {
                chartEl = document.createElement('div');
                chartEl.id = 'your-preformance';
                chartEl.style.height = '200px';
                parentEl.insertBefore(chartEl, parentEl.firstChild);
                console.log('Created new chart element');
            }
        }
        
        if (typeof ApexCharts === 'undefined') {
            console.error('ApexCharts still not loaded');
            return;
        }
        
        if (chartEl) {
            console.log('Creating chart with valid element...');
            
            // Ensure element is properly mounted
            chartEl.innerHTML = '';
            chartEl.style.height = '150px';
            chartEl.style.width = '200px';
            chartEl.style.marginTop = '10px';
            chartEl.style.marginBottom = '5px';
            chartEl.style.marginLeft = 'auto';
            chartEl.style.marginRight = 'auto';
            chartEl.style.display = 'block';
            chartEl.style.position = 'relative';
            chartEl.style.left = '-20px';
            
            const options = {
                series: [20, 20, 20, 20, 20],
                chart: {
                    height: 150,
                    width: 200,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 90,
                        offsetY: 0,
                        donut: {
                            size: '65%'
                        }
                    }
                },
                grid: {
                    padding: {
                        bottom: -50
                    }
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#e74c3c', '#f39c12', '#f1c40f', '#95a5a6', '#34495e']
            };
            
            try {
                // Double-check element is in DOM
                if (document.contains(chartEl)) {
                    const chart = new ApexCharts(chartEl, options);
                    chart.render().then(() => {
                        console.log('Performance chart rendered successfully!');
                    }).catch(err => {
                        console.error('Chart render promise error:', err);
                    });
                } else {
                    console.error('Element not in DOM');
                }
            } catch (error) {
                console.error('Chart creation error:', error);
            }
        }
    }, 1500); // Reduced delay
    // Activate the dashboard mini-nav item
    const dashboardMiniNav = document.getElementById('mini-1');
    if (dashboardMiniNav) {
        dashboardMiniNav.classList.add('selected');
        
        // Show the dashboard submenu
        const dashboardMenu = document.getElementById('menu-right-mini-1');
        if (dashboardMenu) {
            dashboardMenu.style.display = 'block';
            dashboardMenu.classList.add('show');
        }
        
        // Hide other menu sections
        for (let i = 2; i <= 10; i++) {
            const otherMenu = document.getElementById(`menu-right-mini-${i}`);
            if (otherMenu) {
                otherMenu.style.display = 'none';
                otherMenu.classList.remove('show');
            }
        }
        
        // Remove selected class from other mini-nav items
        document.querySelectorAll('.mini-nav-item').forEach(item => {
            if (item.id !== 'mini-1') {
                item.classList.remove('selected');
            }
        });
    }
});

// Dashboard Performance Enhancement - Load data via AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Fetch dashboard data in background
    fetch('/api/dashboard/data')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Dashboard data error:', data.error);
                return;
            }
            
            // Update all counts with smooth transition
            updateCount('userCount', data.userCount);
            updateCount('inspectionCount', data.inspectionCount);
            updateCount('transactionCount', data.transactionCount);
            updateCount('propertyCount', data.propertyCount);
            updateCount('tenantCount', data.tenantCount);
            updateCount('newUsersThisMonth', data.newUsersThisMonth);
            updateCount('inspectionsThisMonth', data.inspectionsThisMonth);
            updateCount('pendingInspectionsThisMonth', data.pendingInspectionsThisMonth);
            updateCount('tenantsThisMonth', data.tenantsThisMonth);
            
        })
        .catch(error => {
            console.error('Dashboard data fetch error:', error);
            // Values will remain as initial '0' on error
        });
});

function updateCount(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        // Update with formatted number and smooth animation
        element.innerHTML = new Intl.NumberFormat().format(value || 0);
        
        // Add a subtle animation
        element.style.opacity = '0.7';
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transition = 'opacity 0.3s ease';
        }, 100);
    }
}
</script>

<style>
.loading-skeleton {
    display: inline-block;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 4px;
    height: 1.2em;
    width: 60px;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

/* Ensure smooth transitions for count updates */
[id$="Count"] {
    transition: opacity 0.3s ease;
}
</style>
@endpush