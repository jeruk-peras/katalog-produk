<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<script src="<?= base_url(); ?>assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<div class="page-content">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Selamat Datang di Dashboard Admin!</h4>
        <p>Halo, selamat datang di halaman dashboard. Silakan gunakan menu di samping untuk mengelola data aplikasi.</p>
    </div>

    <div class="row">
        <div class="col-12 col-lg-7 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div id="chart5"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah <br> Terbeli</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($terlaris as $t): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $t['nama_kategori']; ?></td>
                                        <td><?= $t['nama_produk']; ?> #<b><?= $t['nama_varian']; ?></b></td>
                                        <td><?= $t['jumlah']; ?></td>
                                    </tr>
                                <?php endforeach;  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    GrafikBulanan();
    GrafikBulananBySales();

    function GrafikBulanan() {
        var title, series, categories;

        $.ajax({
            url: '/admin/dashboard-bulanan',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                title = response.data.title;
                series = response.data.series;
                categories = response.data.categories;

                // chart 4
                var options = {
                    series: [series],
                    chart: {
                        foreColor: '#9ba7b2',
                        type: 'area',
                        height: 360,
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                    },
                    title: {
                        text: title,
                        align: 'left',
                        style: {
                            fontSize: '14px',
                            color: "#32393f"
                        }
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            formatter: (val) => (val / 1000000).toFixed(1) + 'Jt'
                        }
                    },
                    xaxis: {
                        categories: categories,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp" + addCommas(val);
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                };
                var chart = new ApexCharts(document.querySelector("#chart5"), options);
                chart.render();
            }
        })
    }

    function GrafikBulananBySales() {
        var title, series, categories;

        $.ajax({
            url: '/admin/dashboard-bulanan-bysales',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                title = response.data.title;
                series = response.data.series;
                categories = response.data.categories;

                // chart 4
                var options = {
                    series: series,
                    chart: {
                        foreColor: '#9ba7b2',
                        type: 'bar',
                        height: 360
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '75%',
                            borderRadius: 5,
                            borderRadiusApplication: 'end'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    title: {
                        text: title,
                        align: 'left',
                        style: {
                            fontSize: '14px',
                            color: "#32393f"
                        }
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            formatter: (val) => (val / 1000000).toFixed(1) + 'Jt'
                        }
                    },
                    xaxis: {
                        categories: categories,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp" + addCommas(val);
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                };
                var chart = new ApexCharts(document.querySelector("#chart4"), options);
                chart.render();
            }
        })


        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            let rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
</script>
<?= $this->endSection(); ?>