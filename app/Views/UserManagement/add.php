<?php $this->extend("layout/Dashboard/main") ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create Akun</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk membuat akun baru.
        </p>
        <form class="forms-sample" action="<?= base_url() ?>usermanagement/manageuser" method="post" autocomplete="off">
            <div class="form-group row mb-0 d-flex align-items-center">
                <label class="col-sm-2 mb-0 col-form-label" for="email">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group row mb-0 d-flex align-items-center">
                <label class="col-sm-2 mb-0 col-form-label" for="first_name">Nama Depan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Nama depan">
                </div>
            </div>
            <div class="form-group row mb-0 d-flex align-items-center">
                <label class="col-sm-2 mb-0 col-form-label" for="last_name">Nama Belakang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Nama belakang">
                </div>
            </div>
            <div class="mt-5 d-flex align-items-center justify-content-end" >
                <a class="btn btn-outline-danger me-4" href="<?= base_url() .'usermanagement/manageuser'  ?>" >Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
