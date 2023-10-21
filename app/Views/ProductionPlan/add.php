<?php $this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Buat Rencana Produksi</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk membuat rencana produksi.
        </p>
        <form class="forms-sample" id="form" action="<?= base_url() ?>production/result/add" method="POST"
              autocomplete="off"
              enctype="multipart/form-data">
            <div class="form-group">
                <label class="card-title" for="autocompleteInputBOM">Pilih Oil Seal</label>
                <div class="form-group row mb-0 d-flex align-items-center">
                    <div class="col">
                        <input type="text"
                               class="form-control autocomplete-bom"
                               name="bom" id="autocompleteInputBOM"
                               placeholder="Search Bill of Material ...">
                    </div>
                    <div class="col-2">
                        <button onclick="onClickSelectBOM(event)" type="button" id="selectBOM"
                                class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Pilih
                        </button>
                    </div>
                </div>

                <div id="dataproduct">
                </div>
            </div>

            <div class="form-group">
                <label class="card-title" for="autocompleteInputManager">Pilih Manager</label>
                <div class="form-group row mb-0 d-flex align-items-center">
                    <div class="col">
                        <input type="text"
                               class="form-control autocomplete-manager"
                               name="manager" id="autocompleteInputManager"
                               placeholder="Search Manager">
                    </div>
                    <div class="col-2">
                        <button onclick="onClickSelectManager(event)" type="button" id="selectManager"
                                class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Pilih
                        </button>
                    </div>
                </div>

                <div id="datamanager">
                </div>
            </div>

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
                            <div class="d-block">
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

    let srcBoms = [];
    let srcManagers = [];

    window.addEventListener('load', function () {
        initAutocomplete();
    })

    function onClickSelectBOM(e) {
        e.preventDefault();
        const id = $('input[name="bom"]').val();
        if (id === "") {
            return;
        }
        const item = srcBoms.filter(data => data.id === id)
        if (item.length === 0) return;
        const data = item[0].data;
        $("#dataproduct").html(`
<div class="container mt-4 px-2">
<div class="border row g-3">
  <div class="col-6">
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Name</span>: </strong>
      <span id="productName">${data.name}</span>
    </p>
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Code</span>: </strong>
      <span id="productCode">${data.code}</span>
    </p>
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Price</span>: </strong>
      <span id="productPrice">${data.price}</span>
    </p>
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Description</span>: </strong>
      <span id="productDescription">${data.description}</span>
    </p>
  </div>
  <div class="col-6">
    <img class="w-50" src="<?= base_url("uploads/") ?>${data.image}" alt="">
  </div>
</div>
</div>
        `)
    }

    function onClickSelectManager(e) {
        e.preventDefault();
        const id = $('input[name="manager"]').val();
        if (id === "") {
            return;
        }
        const item = srcManagers.filter(data => data.id.toString() === id.toString())
        if (item.length === 0) return;
        const data = item[0].data;
        $("#datamanager").html(`
<div class="container mt-4 px-2">
<div class="border row g-3">
  <div class="col-6">
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">First Name</span>: </strong>
      <span id="productName">${data.first_name}</span>
    </p>
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Last Name</span>: </strong>
      <span id="productCode">${data.last_name}</span>
    </p>
    <p>
      <strong>
        <span class="d-inline-block" style="width: 100px;">Employee ID</span>: </strong>
      <span id="productPrice">${data.username}</span>
    </p>
  </div>
</div>
</div>
        `)
    }

    function initAutocomplete() {
        import('<?= base_url() . "js/autocomplete.min.js" ?>')
            .then((Autocomplete) => {
                Autocomplete = Autocomplete.default
                {
                    let data = <?= /** @var string $boms */ $boms ?>;
                    for (let i = 0; i <= data.length - 1; i++) {
                        let value = data[i]
                        srcBoms.push({
                            title: `${value.name}`,
                            id: value.id,
                            data: value,
                        });
                    }

                    Autocomplete.init('input.autocomplete-bom', {
                        items: srcBoms,
                        valueField: "id",
                        labelField: "title",
                        highlightTyped: false,
                        hiddenInput: true,
                        fixed: true,
                    });
                }

                {
                    let data = <?= /** @var string $managers */ $managers ?>;
                    for (let i = 0; i <= data.length - 1; i++) {
                        let value = data[i]
                        srcManagers.push({
                            title: `${value.username} | ${value.first_name} ${value.last_name}`,
                            id: value.id,
                            data: value,
                        });
                    }
                    Autocomplete.init('input.autocomplete-manager', {
                        items: srcManagers,
                        valueField: "id",
                        labelField: "title",
                        highlightTyped: false,
                        hiddenInput: true,
                        fixed: true,
                    });
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }

</script>

<?= $this->endSection() ?>
