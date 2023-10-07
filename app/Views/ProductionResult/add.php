<?php $this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Hasil Produksi</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk menambah hasil produksi.
        </p>
        <form class="forms-sample" id="form" action="<?= base_url() ?>production/result/add" method="POST"
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
                        <?php elseif ($form['type'] == 'file'): ?>
                            <div class="d-block" >
                                <img id="<?= $form['id'] ?>-image" style="height: 200px" class="p-2" hidden alt="#">
                                <?= form_input($form) ?>
                            </div>
                        <?php else: ?>
                            <?= form_input($form) ?>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>

            <div class="mt-5 w-100 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="javascript:history.back()">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function onChangeImage(el){
        if (el.files.length === 0){
            $("#evidence-image").attr("hidden", true)
            return
        }
        let file = el.files[0]
        let reader = new FileReader();
        reader.onload = function(e) {
            let base64Value = e.target.result;
            let $evidence = $("#evidence-image");
            $evidence.attr("src", base64Value)
            $evidence.removeAttr("hidden", true)
        };
        reader.readAsDataURL(file);
    }
</script>

<?= $this->endSection() ?>
