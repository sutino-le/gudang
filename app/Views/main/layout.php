<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Gudang</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>/index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a href="<?= site_url('login/keluar') ?>"><i class="fas fa-sign-out-alt"></i> Logout &nbsp;</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">App Gudang</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?= session()->namauser . ' / ' . session()->levelnama ?>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php
                        // if (session()->idlevel == 1) :
                        if (session()->idlevel == 1) {
                            $master = "show";
                            $kategori = "show";
                            $satuan = "show";
                            $barang = "show";

                            $keluar_masuk = "show";
                            $barangmasuk = "show";
                            $barangkeluar = "show";
                        } else if (session()->idlevel == 2) {
                            $master = "none";
                            $kategori = "none";
                            $satuan = "none";
                            $barang = "none";

                            $keluar_masuk = "show";
                            $barangmasuk = "none";
                            $barangkeluar = "show";
                        } else if (session()->idlevel == 3) {
                            $master = "none";
                            $kategori = "none";
                            $satuan = "none";
                            $barang = "none";

                            $keluar_masuk = "show";
                            $barangmasuk = "show";
                            $barangkeluar = "none";
                        } else if (session()->idlevel == 4) {
                            $master = "show";
                            $kategori = "none";
                            $satuan = "none";
                            $barang = "show";

                            $keluar_masuk = "show";
                            $barangmasuk = "show";
                            $barangkeluar = "show";
                        } else {
                            $master = "none";
                            $kategori = "none";
                            $satuan = "none";
                            $barang = "none";

                            $keluar_masuk = "none";
                            $barangmasuk = "none";
                            $barangkeluar = "none";
                        }

                        ?>


                        <li class="nav-item" style="display: <?= $master ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-database text-primary"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $kategori ?>;">
                                    <a href="<?= site_url('kategori/index') ?>" class="nav-link">
                                        <i class="fas fa-tasks nav-icon text-warning"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $satuan ?>;">
                                    <a href="<?= site_url('satuan/index') ?>" class="nav-link">
                                        <i class="fa fa-chevron-right nav-icon text-warning"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $barang ?>;">
                                    <a href="<?= site_url('barang/index') ?>" class="nav-link">
                                        <i class="fas fa-box-open nav-icon text-info"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item" style="display: <?= $keluar_masuk ?>;">
                            <a href="#" class="nav-link">
                                <i class="fas fa-exchange-alt text-warning"></i>
                                <p>
                                    Keluar - Masuk
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item" style="display: <?= $barangmasuk ?>;">
                                    <a href="<?= site_url('barangmasuk/data') ?>" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon text-primary"></i>
                                        <p>Barang Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: <?= $barangkeluar ?>;">
                                    <a href="<?= site_url('barangkeluar/data') ?>" class="nav-link">
                                        <i class="fas fa-arrow-left nav-icon text-danger"></i>
                                        <p>Barang Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php //endif; 
                        ?>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?= $this->section('judul') ?>
                            <?php
                            if ($subjudul != "Awal") {
                                $judule     = "";
                                $subjudule  = "";
                            } else {
                                $judule     = $judul;
                                $subjudule  = session()->levelnama;
                            }
                            ?>
                            <?= $this->endSection('judul') ?>
                            <ol class="breadcrumb float">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><?= $judule; ?><?= $this->renderSection('judul'); ?></a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= $subjudule; ?><?= $this->renderSection('subjudul'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <?= $this->renderSection('isi'); ?>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2022 <a href="<?= base_url() ?>">App Gudang</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/plugins/pdfmake/vfs_fonts.js"></script>


</body>

</html>