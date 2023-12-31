<?php $this->extend("layout/Dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Create Akun</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk membuat akun baru.
        </p>
        <form class="forms-sample" action="<?= base_url() ?>usermanagement/manageuser/update" method="POST" autocomplete="off">
            <?php /** @var FORM $forms */
            foreach ($forms as $form): ?>
                <div class="form-group row mb-0 d-flex align-items-center" <?= $form['type'] === 'hidden' ? 'hidden': '' ?>  >
                    <label  <?= $form['type'] === 'hidden' ? 'hidden': '' ?>  class="col-sm-2 mb-0 col-form-label" for="<?= $form['id'] ?>>"><?= $form['title'] ?></label>
                    <div class="col-sm-10">
                        <?= form_input($form) ?>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="mt-5 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="<?= base_url() . 'usermanagement/manageuser' ?>">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
