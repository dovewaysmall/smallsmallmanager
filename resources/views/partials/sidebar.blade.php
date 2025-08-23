<aside class="side-mini-panel with-vertical">
      <!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
      <div class="iconbar">
        <div>
          <div class="mini-nav">
            <div class="brand-logo d-flex align-items-center justify-content-center">
              <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
              </a>
            </div>
            <ul class="mini-nav-ul" data-simplebar>

              <!-- --------------------------------------------------------------------------------------------------------- -->
              <!-- Dashboards -->
              <!-- --------------------------------------------------------------------------------------------------------- -->
              <li class="mini-nav-item" id="mini-1">
                <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Dashboards">
                  <iconify-icon icon="solar:layers-line-duotone" class="fs-7"></iconify-icon>
                </a>
              </li>

            
            </ul>

          </div>
          <div class="sidebarmenu">
            <div class="brand-logo d-flex align-items-center nav-logo">
              <a href="../dashboard" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/rentsmallsmall-logo-blue.png')}}" alt="Logo" style="max-width: 120px; height: auto;" />
              </a>

            </div>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
              <ul class="sidebar-menu" id="sidebarnav">
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                  <span class="hide-menu">Dashboard</span>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Users</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('users') }}">
                        <span class="icon-small"></span>
                        Total Users 
                      </a>
                    </li>
                  </ul>
                </li>
                
                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Unconverted</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('unconverted-users') }}">
                        <span class="icon-small"></span>
                        Total Unconverted 
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('unconverted-users.this-week') }}">
                        <span class="icon-small"></span>
                        Unconverted(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('unconverted-users.this-month') }}">
                        <span class="icon-small"></span>
                        Unconverted(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('unconverted-users.this-year') }}">
                        <span class="icon-small"></span>
                        Unconverted(This Year)
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Subscribers</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('tenants') }}">
                        <span class="icon-small"></span>
                        Total Subscribers 
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('tenants.this-week') }}">
                        <span class="icon-small"></span>
                        Subscribers(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('tenants.this-month') }}">
                        <span class="icon-small"></span>
                        Subscribers(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('tenants.this-year') }}">
                        <span class="icon-small"></span>
                        Subscribers(This Year)
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Inspections</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('inspections') }}">
                        <span class="icon-small"></span>
                        Total Inspections
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('inspections.this-week') }}">
                        <span class="icon-small"></span>
                        Inspections(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('inspections.this-month') }}">
                        <span class="icon-small"></span>
                        Inspections(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('inspections.this-year') }}">
                        <span class="icon-small"></span>
                        Inspections(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Transactions</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('transactions') }}">
                        <span class="icon-small"></span>
                        Total Transactions
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('transactions.this-week') }}">
                        <span class="icon-small"></span>
                        Transactions(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('transactions.this-month') }}">
                        <span class="icon-small"></span>
                        Transactions(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('transactions.this-year') }}">
                        <span class="icon-small"></span>
                        Transactions(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                    <span class="hide-menu">Property</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('properties') }}">
                        <span class="icon-small"></span>
                        Total Properties
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('properties.this-week') }}">
                        <span class="icon-small"></span>
                        Properties(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('properties.this-month') }}">
                        <span class="icon-small"></span>
                        Properties(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('properties.this-year') }}">
                        <span class="icon-small"></span>
                        Properties(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:shield-check-line-duotone"></iconify-icon>
                    <span class="hide-menu">Verifications</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('verifications') }}">
                        <span class="icon-small"></span>
                        Total Verifications
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('verifications.this-week') }}">
                        <span class="icon-small"></span>
                        Verifications(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('verifications.this-month') }}">
                        <span class="icon-small"></span>
                        Verifications(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('verifications.this-year') }}">
                        <span class="icon-small"></span>
                        Verifications(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>
                
                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:shield-check-line-duotone"></iconify-icon>
                    <span class="hide-menu">Landlords</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords') }}">
                        <span class="icon-small"></span>
                        Total Landlords
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords.this-week') }}">
                        Landlords(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords.this-month') }}">
                        Landlords(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords.this-year') }}">
                        Landlords(This Year)
                      </a>
                    </li>

                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords.onboarded') }}">
                        Onboarded
                      </a>
                    </li>

                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('landlords.offboarded') }}">
                        Offboarded
                      </a>
                    </li>
                    
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:shield-check-line-duotone"></iconify-icon>
                    <span class="hide-menu">Repairs</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('repairs') }}">
                        <span class="icon-small"></span>
                        Total Repairs
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('repairs.this-week') }}">
                        <span class="icon-small"></span>
                        Repairs(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('repairs.this-month') }}">
                        <span class="icon-small"></span>
                        Repairs(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('repairs.this-year') }}">
                        <span class="icon-small"></span>
                        Repairs(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>

                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <iconify-icon icon="solar:wallet-money-line-duotone"></iconify-icon>
                    <span class="hide-menu">Payouts</span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('payouts') }}">
                        <span class="icon-small"></span>
                        Total Payouts
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('payouts.this-week') }}">
                        <span class="icon-small"></span>
                        Payouts(This Week)
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('payouts.this-month') }}">
                        <span class="icon-small"></span>
                        Payouts(This Month)
                      </a>
                    </li>
                    
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="{{ route('payouts.this-year') }}">
                        <span class="icon-small"></span>
                        Payouts(This Year)
                      </a>
                    </li>
                    
                  </ul>
                </li>

                
              </ul>
            </nav>

           
          </div>
        </div>
      </div>
    </aside>