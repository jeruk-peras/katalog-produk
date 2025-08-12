<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Shopping Cart -->
<div class="shopping-cart section pt-5 pb-5">
    <div class="container">

        <form action="" id="form-pengiriman">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-steps-form-style-1">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_sales" id="id_sales">
                        <ul id="accordionExample">
                            <li>
                                <h6 class="title" data-bs-toggle="collapse" data-bs-target="#list-produk" aria-expanded="true" aria-controls="list-produk">List Produk</h6>
                                <section class="checkout-steps-form-content collapse show" id="list-produk" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="overflow-x: scroll;">
                                    <div id="cart-list" style="width: 100%; min-width: 800px;"></div>
                                </section>
                            </li>
                            <li class="mb-5">
                                <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Informasi Customer</h6>
                                <section class="checkout-steps-form-content collapse show" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="nama_lengkap" class="form-control" id="nama-lengkap" placeholder="">
                                                    <label for="nama-lengkap">Nama Lengkap</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <div class="form-floating mb-2">
                                                    <input type="tel" name="no_handphone" class="form-control" id="tel" placeholder="">
                                                    <label for="tel">No. Handphone</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <div class="form-floating mb-2">
                                                    <input type="email" name="email" class="form-control" id="email" placeholder="">
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="nama_tempat" class="form-control" id="nama-tempat" placeholder="">
                                                    <label for="nama-tempat">Nama Tempat</label>
                                                    <div class="form-text">*isi dengan nama perusahaan/instansi/nama toko ...</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <div class="select-items">
                                                    <select name="provinsi" id="provinsi" class="form-control">
                                                        <option value="0">Provinsi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <div class="select-items">
                                                    <select name="kota_kabupaten" id="kota_kabupaten" class="form-control">
                                                        <option value="0">Kota/Kabupaten</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <div class="single-form form-default">
                                                <div class="select-items">
                                                    <select name="kecamatan" id="kecamatan" class="form-control">
                                                        <option value="0">Kecamatan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <div class="single-form form-default">
                                                <div class="select-items">
                                                    <select name="kelurahan" id="kelurahan" class="form-control">
                                                        <option value="0">Desa/Kelurahan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <div class="form-floating mb-2">
                                                    <textarea class="form-control" name="alamat" placeholder="" style="height: 100px" id="alamat"></textarea>
                                                    <label for="alamat">Alamat</label>
                                                    <div class="form-text">*Isikan lebih detail seperti nama jalan, RT/RW, No Rumah ...</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <div class="form-floating mt-4">
                                                    <textarea class="form-control" name="catatan" placeholder="" style="height: 100px" id="catatan"></textarea>
                                                    <label for="catatan">Catatan (opsional)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="single-form button text-end">
                                                <button class="btn" id="btn-simpan-data">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-price-table mb-3">
                            <div class="row">
                                <div class="col-12 mb-3 text-start">
                                    <h5>Methode Payment</h5>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="cod" value="cod">
                                        <label class="form-check-label" for="cod">Cash on Delivery</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" id="top" value="top">
                                        <label class="form-check-label" for="top">Terms of Payment</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-sidebar-price-table mb-3">
                        <div class="sub-total-price">
                            <div class="total-price">
                                <h5 class="value">Total:</h5>
                                <h5 class="price" id="total"></h5>
                            </div>
                        </div>
                        <div class="price-table-btn button">
                            <button type="button" class="col btn btn-alt" id="checkout">Checkout Pesanan</button>
                        </div>
                    </div>

                    <div class="checkout-sidebar-coupon mb-3">
                        <div class="single-form form-default" id="data-sales"></div>
                    </div>

                    <div class="checkout-sidebar-price-table mb-3" id="customer-data">
                        <div class="row">
                            <div class="col text-start">
                                Data Customer
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Nama Lengkap</th>
                                                <th>No Handphone</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-sidebar-price-table mb-3">
                        <div class="row">
                            <div class="col text-center">
                                Hapus Data
                            </div>
                        </div>
                        <div class="price-table-btn button text-center">
                            <button type="button" class="btn" style="background-color: #dc3545;" id="hapus-penerima">Customer</button>
                            <button type="button" class="btn" style="background-color: #dc3545;" id="hapus-keranjang">Keranjang</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<input type="hidden" name="id_produk">
<input type="hidden" name="jumlah">

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

<script>
    $(function() {
        // Hapus semua item di keranjang saat tombol diklik
        $('#hapus-keranjang').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('keranjang_belanja');
                    localStorage.removeItem('total-items');
                    $('#total-items').text('0');
                    $('#total').text('');
                    renderCart();
                }
            })
        });

        // hapus data penerima barang
        $('#hapus-penerima').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('pengiriman_data');
                }
            })
        });

        // render keranjang
        function renderCart() {
            let cart = JSON.parse(localStorage.getItem('keranjang_belanja') || '[]');
            let $cartList = $('#cart-list');
            if (cart.length === 0) {
                $cartList.html('<p>Keranjang belanja kosong.</p>');
                return;
            }
            let html = `
            <div><button type="button" id="refresh-data" class="btn btn-sm mb-2 btn-outline-primary"> <i class="bx bx-refresh"></i> Refesh data</button></div>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th style="width: 35%;">Nama Produk</th>
                        <th>Stok</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
            `;
            var total_harga = 0;
            // console.log(cart);
            cart.forEach(function(item, idx) {
                let hargaSatuan = (item.harga_diskon && item.harga_diskon > 0) ? item.harga_diskon : item.harga;
                let total = hargaSatuan * item.jumlah;
                total_harga = (total_harga + parseInt(total))
                html += `
                <tr data-idx="${idx}">
                    <input type="hidden" name="id_produk[]" value="${item.id_produk}">
                    <input type="hidden" name="id_varian[]" value="${item.id_varian}">
                    <input type="hidden" name="harga[]" value="${item.harga}">
                    <input type="hidden" name="harga_diskon[]" value="${(item.harga_diskon > 0 ? item.harga_diskon : 0)}">
                    <td><img src="${item.gambar}" alt="${item.nama_produk}" style="width:60px;height:60px;object-fit:cover;"></td>
                    <td>${item.nama_produk} <br> <span style="font-size: smaller;">- ${item.nama_varian}</span></td>
                    <td>${item.stok_varian}</td>
                    <td>
                        <div class="input-group input-group-sm text-center" style="width: 70%;">
                            <button class="input-group-text btn-minus" data-id_produk="${item.id_produk}" data-id_varian="${item.id_varian}">-</button>
                            <input type="tel" class="form-control form-control-sm text-center p-0" name="jumlah[]" readonly maxlength="4" value="${item.jumlah}">
                            <button class="input-group-text btn-plus" data-id_produk="${item.id_produk}" data-id_varian="${item.id_varian}">+</button>
                        </div>
                    </td>
                    <td>
                        Rp${(item.harga_diskon && item.harga_diskon > 0 ? item.harga_diskon : item.harga).toLocaleString()}
                        ${item.harga_diskon && item.harga_diskon > 0 ? `<br><span style="font-size: smaller; text-decoration:line-through; color:#888;">Rp${item.harga.toLocaleString()}</span>` : ''}
                    </td>
                    <td>Rp${total.toLocaleString()}</td>
                    <td><button class="btn btn-danger btn-sm remove-btn">X</button></td>
                </tr>`;
            });
            html += '</tbody></table>';
            $('#total').text(`Rp ${total_harga.toLocaleString() || 0}`);
            $cartList.html(html);
        }
        renderCart();

        // update keranjang
        function updateKeranjang(id_produk, id_varian, action) {
            // Ambil data keranjang dari localStorage
            var keranjang = JSON.parse(localStorage.getItem('keranjang_belanja')) || [];

            // Cari item berdasarkan id_produk
            keranjang = keranjang.map(function(item) {
                if (item.id_produk === id_produk && item.id_varian === id_varian) {
                    // Update jumlah dan total harga
                    var newJumlah = (action == 'plus' ? (item.jumlah + 1) : (action == 'minus' ? (item.jumlah == 1 ? item.jumlah : (item.jumlah - 1)) : 0))
                    if (item.jumlah <= item.stok_varian || action == 'minus') {
                        item.jumlah = newJumlah
                        item.total = item.harga * newJumlah;
                    }
                }
                return item;
            });

            // Simpan kembali ke localStorage
            localStorage.setItem('keranjang_belanja', JSON.stringify(keranjang));

            // Update jumlah total item di UI (opsional)
            $('#total-items').text(keranjang.length);

            // Tampilkan notifikasi
            // Toast.fire({
            //     timer: 2000,
            //     icon: 'success',
            //     title: 'Produk berhasil diperbarui di keranjang!'
            // });
        }
        // handle plus/minus button in cart
        $('#cart-list').on('click', '.btn-plus', function() {
            // var id_produk, id_varian;
            id_produk = $(this).data('id_produk');
            id_varian = $(this).data('id_varian');
            updateKeranjang(id_produk, id_varian, 'plus');
            renderCart();
        });
        $('#cart-list').on('click', '.btn-minus', function() {
            var id_produk, id_varian;
            id_produk = $(this).data('id_produk');
            id_varian = $(this).data('id_varian');
            updateKeranjang(id_produk, id_varian, 'minus');
            renderCart();
        });

        // hendle refresh data keranjang
        $(document).on('click', 'button#refresh-data', function() {
            keranjangrefresh()
        })

        function keranjangrefresh() {
            var cart = JSON.parse(localStorage.getItem('keranjang_belanja') || '[]');
            $.ajax({
                url: './keranjang-refresh',
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    cart
                },
                success: function(response) {
                    localStorage.removeItem('keranjang_belanja');
                    localStorage.setItem('keranjang_belanja', JSON.stringify(response));
                    renderCart()
                }
            })
        }
        keranjangrefresh()

        // hendle hapus data keranjang
        $('#cart-list').on('click', '.remove-btn', function() {
            let idx = $(this).closest('tr').data('idx');
            let cart = JSON.parse(localStorage.getItem('keranjang_belanja') || '[]');
            cart.splice(idx, 1);
            localStorage.setItem('keranjang_belanja', JSON.stringify(cart));
            localStorage.setItem('total-items', cart.length);
            $('#total-items').text(cart.length);
            renderCart();
        });

        // hendle data alamat wilahayah indonesia
        function loadWilayah(url, $select, placeholder, selected = null, callback = null) {
            $select.html(`<option value="0">${placeholder}</option>`);
            var id = 0;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $.each(response, function(_, item) {
                        let val = item.id;
                        let name = item.name;
                        let selectedAttr = (selected && selected == name) ? 'selected' : '';
                        id = (selected && selected == name) ? val : id;
                        $select.append(`<option value="${name}" data-id="${val}" ${selectedAttr}>${name}</option>`);
                    });
                    if (callback) callback(id);
                },
                error: function(er) {
                    console.log(er.error);
                }
            })

        }

        // Load provinsi on page load
        loadWilayah('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', $('#provinsi'), 'Provinsi');

        // When provinsi changes, load kabupaten/kota
        $('#provinsi').on('change', function() {
            let provId = $(this).find(':selected').data('id');
            $('#kota_kabupaten').html('<option value="0">Kota/Kabupaten</option>');
            $('#kecamatan').html('<option value="0">Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
            if (provId != "0") {
                loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, $('#kota_kabupaten'), 'Kota/Kabupaten');
            }
        });

        // When kabupaten/kota changes, load kecamatan
        $('#kota_kabupaten').on('change', function() {
            let kabId = $(this).find(':selected').data('id');
            $('#kecamatan').html('<option value="0">Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
            if (kabId != "0") {
                loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`, $('#kecamatan'), 'Kecamatan');
            }
        });

        // When kecamatan changes, load kelurahan
        $('#kecamatan').on('change', function() {
            let kecId = $(this).find(':selected').data('id');
            $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
            if (kecId != "0") {
                loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, $('#kelurahan'), 'Desa/Kelurahan');
            }
        });

        // Simpan data form ke localStorage saat tombol diklik
        $('#btn-simpan-data').on('click', function(e) {
            e.preventDefault();
            let data = {
                nama_lengkap: $('#nama-lengkap').val(),
                no_handphone: $('#tel').val(),
                email: $('#email').val(),
                nama_perusahaan: $('#nama-tempat').val(),
                provinsi: $('#provinsi').val(),
                kota_kabupaten: $('#kota_kabupaten').val(),
                kecamatan: $('#kecamatan').val(),
                kelurahan: $('#kelurahan').val(),
                alamat: $('#alamat').val(),
                catatan: $('#catatan').val()
            };

            localStorage.setItem('pengiriman_data', JSON.stringify(data));
            // Optional: tampilkan notifikasi sukses
            Toast.fire({
                timer: 2000,
                icon: 'success',
                title: 'Data pengiriman berhasil disimpan!'
            });
        });

        // Isi form dari localStorage jika ada data
        function loadPengirimanData() {
            let data = localStorage.getItem('pengiriman_data');
            if (!data) return;
            data = JSON.parse(data);
            $('#nama-lengkap').val(data.nama_lengkap || '');
            $('#tel').val(data.no_handphone || '');
            $('#email').val(data.email || '');
            $('#nama-tempat').val(data.nama_perusahaan || '');
            $('#alamat').val(data.alamat || '');
            $('#catatan').val(data.catatan || '');

            // Set provinsi, lalu trigger change untuk load kota/kabupaten
            loadWilayah('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', $('#provinsi'), 'Provinsi', data.provinsi, function(id) {
                loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, $('#kota_kabupaten'), 'Kota/Kabupaten', data.kota_kabupaten, function(id) {
                    loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, $('#kecamatan'), 'Kecamatan', data.kecamatan, function(id) {
                        loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, $('#kelurahan'), 'Desa/Kelurahan', data.kelurahan);
                    });
                });
            });
        }
        // Panggil saat halaman siap
        loadPengirimanData();

        // hendle checkout pesanan
        $('#checkout').click(function() {
            $(this).attr('disabled', true).text('Checkout Pesanan ...');
            var $formData = $('#form-pengiriman').serializeArray()

            // cek payment
            var metodePembayaran = $('input[name="metode_pembayaran"]:checked').val();
            if (!metodePembayaran) {
                Swal.fire({
                    title: 'Metode Pembayaran Belum Dipilih',
                    text: 'Silakan pilih metode pembayaran sebelum checkout.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                $('#checkout').attr('disabled', false).text('Checkout Pesanan');
                return;
            }

            // check data sales
            var dataSales = localStorage.getItem('data_sales');
            if (!dataSales) {
                Swal.fire({
                    title: 'Kode Sales Belum Diisi',
                    text: 'Silakan masukkan kode sales terlebih dahulu sebelum checkout.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                $('#checkout').attr('disabled', false).text('Checkout Pesanan');
                return;
            }

            // cek data keranjang dan penerima di localStorage
            var cart = JSON.parse(localStorage.getItem('keranjang_belanja') || '[]');
            var pengiriman = JSON.parse(localStorage.getItem('pengiriman_data') || '{}');
            if (cart.length === 0) {
                Swal.fire({
                    title: 'Keranjang Kosong',
                    text: 'Silakan tambahkan produk ke keranjang sebelum checkout.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                $('#checkout').attr('disabled', false).text('Checkout Pesanan');
                return;
            }
            if (!pengiriman.nama_lengkap || !pengiriman.no_handphone || !pengiriman.provinsi || !pengiriman.kota_kabupaten || !pengiriman.kecamatan || !pengiriman.kelurahan || !pengiriman.alamat) {
                Swal.fire({
                    title: 'Data Penerima Belum Lengkap',
                    text: 'Silakan lengkapi data penerima sebelum checkout.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                $('#checkout').attr('disabled', false).text('Checkout Pesanan');
                return;
            }

            $.ajax({
                url: '<?= base_url('/keranjang-checkout') ?>',
                type: 'POST',
                data: $formData,
                success: function(response) {

                    if (response.status == 200) {
                        Swal.fire({
                            title: 'Checkout pesanan berhasil',
                            text: "Silahkan tunggu admin kami menghubungi anda. Terimakasih..",
                            icon: 'success',
                            // backdrop: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#total-items').text('0');
                                $('#total').text(`Rp 0`);
                                $('#checkout').attr('disabled', false).text('Checkout Pesanan');

                                // console.log(response);
                                redirectToWA(response);
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'Checkout pesanan gagal',
                            text: response.message || "Maaf ada kesalahan, hubungi admin jika ada masalah",
                            icon: 'warning',
                            backdrop: false,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#checkout').attr('disabled', false).text('Checkout Pesanan');
                                window.location.reload();
                                // redirectToWA(response);
                            }
                        })
                    }
                },
            })
        });

        // hendle untuk redirect ke wa
        function redirectToWA(data) {
            var text = ``;
            var phone = '<?= no_pengirim() ?>';

            // enter %0D%0A
            let keranjang = localStorage.getItem('keranjang_belanja');
            keranjang = JSON.parse(keranjang);

            // data seles
            let dataSales = localStorage.getItem('data_sales');
            dataSales = JSON.parse(dataSales);

            data = data.data;

            console.log(data.header);
            text = `Hallo.., Saya ${data.header.nama}, telah order di <?= base_url() ?>, dari sales ${dataSales.nama_sales} %0D%0A %0D%0AData Orders, No Order: ${data.header.no_order}%0D%0A`;

            var $total = 0;
            $.each(keranjang, function(_, item) {
                text += `${item.nama_produk} (${item.nama_varian}) %0D%0A ${item.jumlah} x Rp ${(item.harga_diskon > 0 ? item.harga_diskon : item.harga )} : ${item.total} %0D%0A ----------------------------------------------- %0D%0A`;
                $total += item.total;
            })

            text += `TOTAL : ${$total} %0D%0A %0D%0A`;

            text += `Catatan : ${data.header.catatan} %0D%0A %0D%0A`;
            text += `Alamat Pengiriman : %0D%0A`;
            text += `${data.header.nama} ${data.header.no_handphone} %0D%0A`;
            text += `${data.header.nama_tempat} %0D%0A`;
            text += `${data.header.alamat} `;

            localStorage.removeItem('keranjang_belanja');
            localStorage.removeItem('total-items');
            renderCart();
            window.open(`https://api.whatsapp.com/send/?phone=${phone}&text=${text}&type=phone_number&app_absent=1`, 'blank');
        }

        // submit kode sales
        $('#data-sales').on('click', '#btn-submit-kode-sales', function(e) {
            e.preventDefault();
            var kode_sales = $('#kode_sales').val();
            var $btn = $('#btn-submit');
            $btn.attr('disabled', true).text('Mengirim...');
            $.ajax({
                url: '<?= base_url('check-kode-sales'); ?>',
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    kode_sales: kode_sales
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Toast.fire({
                            timer: 2000,
                            icon: 'success',
                            title: response.message || 'Kode sales valid!'
                        });
                        renderKodeSales(false, response.data);
                        renderKodeSales(true);
                    } else {
                        Toast.fire({
                            timer: 2000,
                            icon: 'error',
                            title: response.message || 'Kode sales tidak valid!'
                        });
                    }
                    $btn.attr('disabled', false).text('Kirim');
                },
                error: function() {
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: 'Terjadi kesalahan, coba lagi!'
                    });
                    $btn.attr('disabled', false).text('Kirim');
                }
            });
        });

        // hendle render kode sales
        function renderKodeSales(render = false, dataSales = null) {

            if (render == false) {
                localStorage.removeItem('data_sales');
                let data = {
                    id: dataSales.id,
                    nama_sales: dataSales.nama_sales,
                    kode_sales: dataSales.kode_sales,
                };
                localStorage.setItem('data_sales', JSON.stringify(data));
            } else {
                var data = localStorage.getItem('data_sales');
                data = JSON.parse(data);
                if (data) {
                    renderCustomer(data.id)
                    $('#customer-data').show();
                    $('#id_sales').val(data.id);
                    var html =
                        `<div class="form-input form">
                            ${data.nama_sales} / ${data.kode_sales}
                        </div>
                        <div class="button" style="top: -12px !important">
                            <button class="btn" type="button" style="background-color: #dc3545;" id="btn-remove-datasales">X</button>
                        </div>`;
                    $('#data-sales').html(html);
                } else {
                    $('#customer-data').hide();
                    var html =
                        `<div class="form-input form">
                            <input type="text" name="kode_sales" id="kode_sales" placeholder="Kode Sales">
                        </div>
                        <div class="button">
                            <button class="btn" type="button" id="btn-submit-kode-sales">Kirim</button>
                        </div>`;
                    $('#data-sales').html(html);
                }
            }
        }
        renderKodeSales(true)

        // hendle remove data sales
        $('#data-sales').on('click', '#btn-remove-datasales', function(e) {
            e.preventDefault();
            localStorage.removeItem('data_sales');
            $('#id_sales').val('');
            renderKodeSales(true);
        });

        // hendle data
        function renderCustomer() {
            var data = localStorage.getItem('data_sales');
            data = JSON.parse(data);
            $.ajax({
                url: '/render-customer/' + data.id,
                type: 'GET',
                success: function(response) {
                    var data = response.data;

                    var html = ``;
                    data.forEach(function(item, idx) {
                        html += `
                            <tr>
                                <td><button type="button" class="btn btn-sm btn-primary btn-set-cust" data-id="${item.id}">Pilih</button></td>
                                <td>${item.nama_perusahaan}</td>
                                <td>${item.nama_lengkap}</td>
                                <td>${item.no_handphone}</td>
                            </tr>`;
                    });

                    $('#customer').html(html);
                },
                error: function(er) {
                    console.log(er.error);
                }
            })
        }
        renderCustomer();

        $(document).on('click', '.btn-set-cust', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            $.ajax({
                url: '/get-customer/' + id,
                type: 'GET',
                success: function(response) {
                    var data = response.data;

                    localStorage.setItem('pengiriman_data', JSON.stringify(data));
                    Toast.fire({
                        timer: 2000,
                        icon: 'success',
                        title: 'Data customer berhasil dipilih!'
                    });
                    loadPengirimanData();

                },
                error: function(er) {
                    console.log(er.error);
                }
            })
        })
    });
</script>
<?= $this->endSection(); ?>