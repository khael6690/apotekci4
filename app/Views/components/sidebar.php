<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="/assets/upload/img/<?= $_SESSION['logo'] ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $_SESSION['nama'] ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/upload/user/thumbs/' . User()->user_image) ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= base_url() ?>" class="d-block"><?= User()->fullname; ?></a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">MAIN NAVIGATION</li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if (has_permission('management-obat')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('obat') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Obat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('produsen') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Produsen</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('satuan') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Satuan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (has_permission('management-obat')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>
                                Management Stok
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('stok') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('stok-masuk') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Masuk</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?= base_url('stok-opname') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stok Opname</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('customers') ?>" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>
                <?php if (has_permission('management-transaksi')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('transjual') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('transbeli') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pembelian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (has_permission('management-user')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Management User
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('/user') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('/group') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Group</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (has_permission('management-laporan')) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('laporan-jual') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaksi Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('laporan-beli') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaksi Pembelian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-header">SETTING</li>
                <?php if (in_groups('Admin')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('setting') ?>" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Web</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('setuser') ?>" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>User</p>
                    </a>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>