<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Tracker Location</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/assets/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/vendors/styles/style.css" />
</head>

<body class="login-page">
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="/assets/vendors/images/login-page-img.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login</h2>
                        </div>
                        <form>
                            <div class="input-group custom">
                                <input type="email" id="email" class="form-control form-control-lg" placeholder="Email" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="**********" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                        <label class="custom-control-label" for="customCheck1">Remember</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="forgot-password">
                                        <a href="#">Forgot Password</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
                                        <a class="btn btn-primary btn-lg btn-block" id="signin" href="#" onclick="login()">Sign In
                                            <span class="spinner-border spinner-border-sm d-none mb-1" role="status" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                                        OR
                                    </div>
                                    <div class="input-group mb-0">
                                        <a class="btn btn-outline-primary btn-lg btn-block" href="#">Register To Create Account</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="/assets/vendors/scripts/core.js"></script>
    <script src="/assets/vendors/scripts/script.min.js"></script>
    <script src="/assets/vendors/scripts/process.js"></script>
    <script src="/assets/vendors/scripts/layout-settings.js"></script>
    <script src="/assets/vendors/scripts/sweetalert2.min.js"></script>

    <script>
        $('#password').on('keypress', function(event) {
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                $('#signin').trigger('click')
            }
        })

        function login() {
            $('#signin').prop('disabled', true);
            $('#signin').find('.spinner-border').removeClass('d-none');

            const formData = {
                email: $('#email').val(),
                password: $('#password').val()
            };

            $.ajax({
                method: "post",
                data: formData,
                url: '/apis/auth/login',
                success: function(res) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    });


                    // Redirect ke halaman dashboard atau halaman lainnya
                    window.location.href = "/"; // Ganti dengan URL yang sesuai
                },
                error: function(xhr, status, error) {
                    var errorResponse = JSON.parse(xhr.responseText);
                    var errorMessage = errorResponse.message;

                    $('#signin').prop('disabled', false);
                    $('#signin').find('.spinner-border').addClass('d-none');

                    Swal.fire({
                        icon: 'error',
                        title: 'Mohon Isi Email Dan Password Anda Dengan Benar!',
                        text: 'Ada Kesalahan, ' + errorMessage
                    });
                },
                complete: function() {
                    $('#signin').prop('disabled', false);
                    $('#signin').html('Sign In');
                }
            });
        }

        $(".toggle-password").click(function() {
            if ($('#password').attr("type") == "password") {
                $('#password').attr("type", "text");
                $(this).removeClass("zmdi zmdi-eye").addClass("zmdi zmdi-eye-off");
            } else {
                $('#password').attr("type", "password");
                $(this).removeClass("zmdi zmdi-eye-off").addClass("zmdi zmdi-eye");
            }
        });
    </script>
</body>

</html>