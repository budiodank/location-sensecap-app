<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('title', 'Tracker Location &mdash; Tracker Location')</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    @include('layouts.link')
    @stack('style')
</head>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <h5>Tracker Location</h5>
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="main-container">
        @yield('content')
    </div>
    @include('layouts.script')
    <script>
        $(document).ready(function() {
            // Event click pada elemen Logout
            $('#logout-link').on('click', function(event) {
                event.preventDefault(); // Menghentikan perilaku default link

                Swal.fire({
                    title: 'Logout Confirmation',
                    text: 'Are you sure you want to logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Permintaan HTTP ke endpoint logout
                        $.ajax({
                            url: '/apis/auth/logout',
                            method: 'POST',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Logged Out',
                                    text: 'You have been successfully logged out.',
                                    icon: 'success'
                                }).then((result) => {
                                    // Redirect ke halaman login atau lainnya setelah logout
                                    window.location.href = '/login'; // Ganti dengan path yang sesuai
                                });
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status == 401) {
                                    window.location.href = '/login';
                                    return
                                }
                                Swal.fire({
                                    title: 'Error' + xhr.status,
                                    text: xhr.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>