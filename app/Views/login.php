<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/css/icons.css" rel="stylesheet">
    <title>Login - PT. Nur Lisan Sakti</title>
</head>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">

                    <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">

                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">
                                <img src="<?= base_url(); ?>assets/images/login-images/login-cover.svg" class="img-fluid auth-img-cover-login" width="600" alt="" />
                            </div>
                        </div>

                    </div>

                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                            <div class="card-body p-sm-5">
                                <div class="">
                                    <div class="mb-3 text-center">
                                        <img src="<?= base_url(); ?>assets/images/logo-icon.png" width="80" alt="">
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Dashboard Admin</h5>
                                        <p class="mb-0">Silahkan Masukan Username dan Password.</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="post" action="" id="form-login">
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                                                <div class="invalid-feedback" id="error_username"></div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                                <div class="invalid-feedback" id="error_password"></div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary" id="summit-btn-form">Masuk</button>
                                                </div>
                                            </div>
                                            <?= csrf_field(); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <link type="text/css" href="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>

    <script>
        //alert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    <!--app JS-->
    <script src="<?= base_url(); ?>assets/js/app.js"></script>
    <script>
        $('#form-login').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            $('#form-login .form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#summit-btn-form').attr('disabled', true).text('Masuk...'); // Disable button dan ubah teks

            var url = $(this).attr('action'); // Ambil URL action dari form

            var formData = new FormData(this); // Ambil data form
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false, // Jangan proses data
                contentType: false, // Jangan tetapkan tipe konten
                success: function(response) {
                    if (response.status === 200) {
                        window.location.href = `${response.data.redirect}`;

                    } else {

                        Toast.fire({
                            timer: 2000,
                            icon: 'error',
                            title: response.message
                        });
                        $('#summit-btn-form').attr('disabled', false).text('Masuk'); // button dan ubah teks
                    }
                },
                
                error: function(response) {
                    response = response.responseJSON;
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: response.message
                    });
                    $('#summit-btn-form').attr('disabled', false).text('Masuk'); // button dan ubah teks
                }
            });
        })
    </script>
</body>


</html>