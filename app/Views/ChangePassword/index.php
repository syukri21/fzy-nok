<?= $this->extend("layout/main") ?>

<?= $this->section('content') ?>
<div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-5 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo">
                        <img src="https://www.nok.co.jp/common/images/logo.svg" alt="logo">
                    </div>
                    <h4>Hai! Selamat datang di NOK</h4>
                    <h6 class="fw-light">Sebelum melanjutkan silahkan mengganti password Anda.</h6>
                    <form class="pt-3">
                        <div class="form-group">
                            <input type="password" autocomplete="off" class="form-control form-control-lg"
                                   id="oldPassword" placeholder="Password Lama">
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" class="form-control form-control-lg"
                                   id="newPassword" placeholder="Password Baru">
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" class="form-control form-control-lg"
                                   id="newPasswordConfirmation" placeholder="Konfirmasi Password Baru">
                        </div>
                        <div class="mt-3">
                            <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                               href="/index.html">Submit</a>
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

