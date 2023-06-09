<?php $this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Master Data</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk membuat master data.
        </p>
        <form class="forms-sample" action="<?= base_url() ?>masterdata/managemasterdata" method="POST" autocomplete="off" enctype="multipart/form-data">
            <?php /** @var FORM $forms */
            foreach ($forms as $form): ?>
                <div class="form-group row mb-0 d-flex align-items-center" <?= $form['type'] === 'hidden' ? 'hidden': '' ?>  >
                    <label  <?= $form['type'] === 'hidden' ? 'hidden': '' ?>  class="col-sm-2 mb-0 col-form-label" for="<?= $form['id'] ?>>"><?= $form['title'] ?></label>
                    <div class="col-sm-10">
                        <?php if ($form['type'] == 'dropdown'): ?>
                            <?php echo form_dropdown($form['name'], MasterDataType, 'BAHAN', 'class=' . $form['class']); ?>
                        <?php else: ?>
                            <?= form_input($form) ?>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="mt-5 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="<?= base_url() . 'masterdata/managemasterdata' ?>">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
