<?php $this->extend("layout/Dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Bill Of Material</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk Bill Of Material.
        </p>
        <form class="forms-sample" id="form" action="<?= base_url() ?>masterdata/managebom" method="POST"
              autocomplete="off"
              enctype="multipart/form-data">
            <?php /** @var FORM $forms */
            foreach ($forms as $form): ?>
                <div class="form-group row mb-0 d-flex align-items-center" <?= $form['type'] === 'hidden' ? 'hidden' : '' ?> >
                    <label <?= $form['type'] === 'hidden' ? 'hidden' : '' ?> class="col-sm-2 mb-0 col-form-label">
                        <?= $form['title'] ?>
                    </label>
                    <div class="col-sm-10">
                        <?php if ($form['type'] == 'dropdown'): ?>
                            <?php echo form_dropdown($form['name'], MasterDataType, 'BAHAN', 'class=' . $form['class']); ?>
                        <?php elseif ($form['type'] == 'text' && array_key_exists('textarea', $form)): ?>
                            <?= form_textarea($form) ?>
                        <?php elseif ($form['type'] == 'text' && array_key_exists('date', $form)): ?>
                            <div class="input-group date">
                                <?= form_input($form) ?>
                                <span class="input-group-text bg-light d-block">
                                    <i class="mdi mdi-calendar-clock"></i>
                                </span>
                            </div>
                        <?php else: ?>
                            <?= form_input($form) ?>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>

            <?= /** @var string $options */
            view_cell('MaterialListEditCell', ["options" => $options]) ?>

            <div class="mt-5 w-100 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="<?= base_url() . 'masterdata/managebom' ?>">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>

<script>


    window.addEventListener('load', function () {
        initDatePicker();
        initAutocomplete();
    })


    function initDatePicker() {
        $(".datepicker").datepicker();
    }

</script>
<?= $this->endSection() ?>
