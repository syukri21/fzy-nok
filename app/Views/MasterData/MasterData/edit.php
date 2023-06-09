<?php $this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Master Data</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk mengubah master data.
        </p>
        <form class="forms-sample" action="<?= base_url() ?>masterdata/managemasterdata/update" method="POST" autocomplete="off" enctype="multipart/form-data">
            <?php /** @var FORM $forms */
            foreach ($forms as $form): ?>
                <div class="form-group row mb-0 d-flex align-items-center" <?= $form['type'] === 'hidden' ? 'hidden' : '' ?> >
                    <label <?= $form['type'] === 'hidden' ? 'hidden' : '' ?>
                            class="col-sm-2 mb-0 col-form-label"
                            for="<?= $form['id'] ?>>"><?= $form['title'] ?>
                    </label>
                    <div class="col-sm-10">
                        <?php if ($form['type'] == 'dropdown'): ?>
                            <?php echo form_dropdown($form['name'], MasterDataType, $form['value'], 'class=' . $form['class']); ?>
                        <?php elseif ($form['type'] == 'file'): ?>
                        <div class="d-block" >
                            <img id="editmasterdataimage" style="height: 200px" class="p-2"  src="<?=esc($form['value'])?>" alt="#">
                            <?= form_input($form) ?>
                        </div>
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

<script>
    function editMasterData(el) {
        if (el.files.length === 0){
            return
        }
        let file = el.files[0]
        let reader = new FileReader();
        reader.onload = function(e) {
            let base64Value = e.target.result;
            $("#editmasterdataimage").attr("src", base64Value)
        };
        reader.readAsDataURL(file);
    }

</script>

<?= $this->endSection() ?>


