
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <title>Smallsmall Manager</title>
  
  <!-- Theme Persistence Script (must run early) -->
  <script>
    (function() {
      // Default settings
      const defaultSettings = {
        Layout: "vertical",
        SidebarType: "full",
        BoxedLayout: true,
        Direction: "ltr",
        Theme: "light",
        ColorTheme: "Blue_Theme",
        cardBorder: false
      };
      
      // Load saved theme settings
      const savedSettings = JSON.parse(localStorage.getItem('smallsmallThemeSettings')) || defaultSettings;
      
      // Apply theme immediately to prevent flash
      document.documentElement.setAttribute("data-bs-theme", savedSettings.Theme);
      document.documentElement.setAttribute("data-color-theme", savedSettings.ColorTheme);
      document.documentElement.setAttribute("data-layout", savedSettings.Layout);
      
      if (savedSettings.Direction === "rtl") {
        document.documentElement.setAttribute("dir", "rtl");
      }
      
      if (savedSettings.BoxedLayout) {
        document.documentElement.setAttribute("data-boxed-layout", "boxed");
      } else {
        document.documentElement.setAttribute("data-boxed-layout", "full");
      }
      
      if (savedSettings.cardBorder) {
        document.documentElement.setAttribute("data-card", "border");
      } else {
        document.documentElement.setAttribute("data-card", "shadow");
      }
    })();
  </script>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    @include('partials.sidebar')
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      @include('partials.header')
      <!--  Header End -->

      <aside class="left-sidebar with-horizontal">
        <!-- Sidebar scroll-->
        @include('partials.left-sidebar')
        <!-- End Sidebar scroll-->
      </aside>

      
        @yield('content')
     

      <script>
  function handleColorTheme(e) {
    document.documentElement.setAttribute("data-color-theme", e);
    if (typeof userSettings !== 'undefined') {
      userSettings.ColorTheme = e;
      if (typeof saveSettings === 'function') saveSettings();
    }
  }
</script>
    </div>

    <!--  Search Bar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-bottom">
            <input type="search" class="form-control" placeholder="Search here" id="search" />
            <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
              <i class="ti ti-x fs-5 ms-3"></i>
            </a>
          </div>
          <div class="modal-body message-body" data-simplebar="">
            <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
            <ul class="list mb-0 py-2">
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Analytics</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">eCommerce</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">CRM</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard3</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Contacts</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Posts</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Detail</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Shop</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Modern</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Dashboard</span>
                  <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Contacts</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Posts</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Detail</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                </a>
              </li>
              <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                <a href="javascript:void(0)">
                  <span class="text-dark fw-semibold d-block">Shop</span>
                  <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <script src="{{ asset('assets/js/vendor.min.js')}}"></script>
  <!-- Import Js Files -->
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.min.js')}}"></script>
  <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  
  <!-- DataTables JS (jQuery already loaded in vendor.min.js) -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <!-- highlight.js (code view) -->
  <script src="{{ asset('assets/js/highlights/highlight.min.js') }}"></script>
  <script>
  hljs.initHighlightingOnLoad();


  document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
    codeBlock.textContent = codeBlock.innerHTML;
  });
</script>
  <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboards/dashboard3.js') }}"></script>
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  
  <!-- Session and CSRF Management -->
  <script>
    // Handle logout with CSRF token refresh
    function performLogout() {
        // Try to get fresh CSRF token
        fetch(window.location.href, {
            method: 'HEAD',
            credentials: 'same-origin'
        }).then(() => {
            // Update CSRF token if possible
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            if (metaToken) {
                const formToken = document.querySelector('#logout-form input[name="_token"]');
                if (formToken) {
                    formToken.value = metaToken.getAttribute('content');
                }
            }
            // Submit logout form
            document.getElementById('logout-form').submit();
        }).catch(() => {
            // If CSRF failed, redirect to logout GET route
            window.location.href = '{{ route("logout.get") }}';
        });
    }

    // Replace all logout onclick handlers
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLinks = document.querySelectorAll('a[href="{{ route("logout") }}"]');
        logoutLinks.forEach(link => {
            link.onclick = function(event) {
                event.preventDefault();
                performLogout();
            };
        });
    });

    // Handle AJAX errors globally (for users API calls)
    window.addEventListener('unhandledrejection', function(event) {
        if (event.reason && event.reason.status === 419) {
            // CSRF token expired
            alert('Your session has expired. You will be redirected to login.');
            window.location.href = '{{ route("login") }}';
        }
    });

    // Detect if page is stale (for back button after logout)
    if (performance.navigation.type === 2) {
        // Page was accessed via back button
        fetch('{{ route("dashboard") }}', { method: 'HEAD' })
            .then(response => {
                if (response.redirected || response.status === 302) {
                    // Session expired, redirect to login
                    window.location.href = '{{ route("login") }}';
                }
            })
            .catch(() => {
                // Network error, might be session issue
                window.location.href = '{{ route("login") }}';
            });
    }
  </script>
  
  @stack('scripts')
</body>

</html>