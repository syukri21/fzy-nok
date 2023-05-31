<?= $this->extend("layout/main") ?>

<?= $this->section('content') ?>

    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-5 mx-auto">
                    <?= view_cell('AlertMessageCell', ['type' => 'danger', 'error' => session()->getFlashdata("error"), 'errors' => session()->getFlashdata("errors")]) ?>
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="https://www.nok.co.jp/common/images/logo.svg" alt="logo">
                        </div>
                        <h4>Hai! Selamat datang di NOK Admin</h4>
                        <h6 class="fw-light">Sign untuk melanjutkan.</h6>
                        <form class="pt-3" action="<?= base_url() ?>login" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="username_field">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" id="username"
                                       autocomplete="off" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password_field">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg"
                                       id="passwords" autocomplete="off" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
<?= $this->endSection() ?>