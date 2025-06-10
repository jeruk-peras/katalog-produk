<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png" />

	<!--plugins-->
	<link href="<?= base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />

	<!-- Bootstrap CSS -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">


	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/icons.css" rel="stylesheet">

	<title><?= $title; ?> - PT. Nur Lisan Sakti</title>

	<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>

	<script src="<?= base_url(); ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

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

	<style>
		div.tox-editor-header>div.tox-promotion {
			display: none;
		}
		div.tox-statusbar__right-container>span.tox-statusbar__branding {
			display: none;
		}
	</style>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?= $this->include('Admin/layout/sidemenu'); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?= $this->include('Admin/layout/header'); ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper" id="test">
			<?= $this->renderSection('content'); ?>
		</div>
		<!--end page wrapper -->
	</div>

		<!--Start Back To Top Button-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2023. All right reserved.</p>
		</footer>

	<!--end wrapper-->



	<!-- Bootstrap JS -->
	<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

	<script src="<?= base_url(); ?>assets/plugins/tinymce/tinymce.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
	 <script>
        $(document).ready(function() {
            // tyni mce
            tinymce.init({
                selector: 'textarea#tyni-mce',
                plugins: 'searchreplace autolink  directionality code visualchars fullscreen link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount charmap accordion ',
                menubar: 'file edit view  format tools table ',
                toolbar: "blocks fontsize | bold italic underline lineheight | align numlist bullist | link table media | outdent indent| forecolor backcolor removeformat | code fullscreen preview",
                line_height_formats: '0 1 1.2 1.4 1.6 2',
                height: 500,
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            });
        });
    </script>
	<!--app JS-->
	<script src="<?= base_url(); ?>assets/js/app.js"></script>
</body>

</html>