<?php $this->extend("layout/dashboard/main") ?>
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
            <div class="mt-5">
                <h6 class="card-title">Tambah Material</h6>
                <p class="card-description mb-4">
                    SubForm ini digunakan untuk menambah material.
                </p>
                <div class="form-group row mb-0 d-flex align-items-center">
                    <label class="col-sm-1 mb-0 col-form-label" for="autocompleteInput">Material</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control autocomplete" name="material" id="autocompleteInput"
                               placeholder="Search Material ...">
                    </div>
                    <label class="col-sm-1 mb-0 col-form-label" for="qty">Jumlah</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="qty" id="qty" placeholder="1..">
                    </div>
                    <div class="col-sm-2">
                        <button onclick="onAddMaterial(event)" type="button"
                                class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Add
                        </button>
                    </div>
                </div>
                <ul id="list" class="list-group mt-2"></ul>
            </div>
            <div class="mt-5 w-100 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="<?= base_url() . 'masterdata/managebom' ?>">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>

<script>

    let materialsData = []

    window.addEventListener('load', function () {
        initDatePicker();
        initAutocomplete();
        initOnSubmitWithExtraData(materialsData);
    })

    function onAddMaterial(e) {
        e.preventDefault();
        let input = $('input[name="material"]');
        var $inputMaterial = $('input[name="_material"]');
        let inputQty = $("#qty");

        if (input.length === 0 || inputQty.length === 0 | $inputMaterial.length === 0) {
            return
        }

        let id = input[0].value;
        let qty = inputQty[0].value;
        let name = $inputMaterial[0].value

        if (id === "" || qty === "" || name === "") {
            return;
        }

        let data = {
            "id": id,
            "name": name,
            "quantity": qty
        }

        materialsData.push(data)
        addListMaterial(data);

        input.val(null)
        $inputMaterial.val(null)
        inputQty.val(null)
    }

    function addListMaterial(data) {
        let badge = $("<span>", {
            text: data.quantity
        });

        let countText = $('<span class="fw-lighter mx-2" >jumlah : </span>')
        badge.append(countText);

        let t = new Date().getTime()
        let listItem = $("<li>", {
            class: "list-group-item",
            id: "list" + data.id + t,
            text: ''
        });

        let clearButton = $("<button>", {
            class: "btn btn-sm btn-close me-3",
            "aria-label": "Close",
            "type": "button",
            "click": function (e) {
                e.preventDefault();
                let index = materialsData.findIndex(function (obj) {
                    return obj.id === data.id;
                });
                if (index !== -1) {
                    materialsData.splice(index, 1);
                    $(`#list${data.id}${t}`).remove();
                }
            }
        });

        let parts = data.name.split(" | ");
        let name = parts[0].trim();
        let type = parts[1].trim();

        let nameLabel = $('<span>', {
            class: 'fw-lighter mx-2',
            text: 'nama :'
        });

        let nameText = $('<span>', {
            text: name
        });

        let typeLabel = $('<span>', {
            class: 'fw-lighter mx-2',
            text: 'tipe :'
        });

        let typeText = $('<span>', {
            text: type
        });


        listItem.append(clearButton);
        listItem.append(nameLabel);
        listItem.append(nameText);
        listItem.append(typeLabel);
        listItem.append(typeText);
        listItem.append(countText);
        listItem.append(badge);

        $("#list").append(listItem);
    }


    function initDatePicker() {
        $(".datepicker").datepicker();
    }

    function initAutocomplete() {
        import('<?= base_url() . "js/autocomplete.min.js" ?>')
            .then((Autocomplete) => {
                Autocomplete = Autocomplete.default
                let data = <?= /** @var string $options */ $options ?>;
                let src = [];

                for (let i = 0; i < data.length - 1; i++) {
                    let value = data[i]
                    src.push({
                        title: `${value.name}   |  ${value["masterdata_type"]} `,
                        id: value.id,
                        data: {
                            key: value.id,
                        },
                    });
                }

                Autocomplete.init('input.autocomplete', {
                    items: src,
                    valueField: "id",
                    labelField: "title",
                    highlightTyped: false,
                    hiddenInput: true,
                    fixed: true,
                });

            })
            .catch((error) => {
                console.log(error);
            });
    }

    function initOnSubmitWithExtraData(extraData) {
        document.getElementById("form").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the form from submitting normally
            // Convert the JavaScript object to a JSON string
            let jsonData = JSON.stringify(extraData);

            // Set the JSON string as the value of a hidden input field in the form
            let hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "requirements");
            hiddenInput.setAttribute("value", jsonData);
            document.getElementById("form").appendChild(hiddenInput);

            // Submit the form
            event.target.submit();
        });
    }

</script>
<?= $this->endSection() ?>
