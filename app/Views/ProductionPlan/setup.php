<?php

/** @var object¬ $data */

$this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Assign Operator Untuk Rencana Produksi</h4>
        <p class="card-description mb-4">
            Form ini digunakan untuk Assign Operator Untuk Rencana Produksi
        </p>
        <form class="forms-sample" id="form" action="<?= base_url() ?>production/plan/start"
              method="POST"
              autocomplete="off"
              enctype="multipart/form-data">

            <div class="border ">
                <div class="card-body">
                    <div class="card-subtitle">Product</div>
                    <div class="row">
                        <div class="col-6">
                            <p>
                                <strong>
                                    <span class="d-inline-block" style="width: 100px;">Name</span>: </strong>
                                <span id="productName"> <?php
                                    echo $data->name; ?></span>
                            </p>
                            <p>
                                <strong>
                                    <span class="d-inline-block" style="width: 100px;">Ticket</span>: </strong>
                                <span id="productCode"> <?php echo $data->production_ticket; ?></span>
                            </p>
                            <p>
                                <strong>
                                    <span class="d-inline-block" style="width: 100px;">Quantity</span>: </strong>
                                <span id="productPrice"> <?php echo $data->quantity; ?></span>
                            </p>
                            <p>
                                <strong>
                                    <span class="d-inline-block" style="width: 100px;">Description</span>:
                                </strong>
                                <span id="productDescription"> <?php echo $data->description; ?></span>
                            </p>
                        </div>
                        <div class="col-6">
                            <div>
                                <div class="border w-25 p-2 m-2">
                                    <img class="w-100" src="<?= base_url("uploads/") . $data->image ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mt-4 form-group">
                        <label class="card-subtitle" for="shift_a">Pilih Operator Untuk Shift A <strong>10:50 -
                                15:00</strong></label>
                        <div class="form-group row mb-0 d-flex align-items-center">
                            <div class="col">
                                <input type="text"
                                       class="form-control autocomplete-shift-a"
                                       name="shift_a" id="shift_a"
                                       placeholder="Search operator">
                            </div>
                            <div class="col-2">
                                <button onclick="onClickAddShiftA(event)" type="button" id="select-shift-a"
                                        class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Pilih
                                </button>
                            </div>
                        </div>

                        <ul id="list-shift-a" class="list-group mt-2">
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="mt-4 form-group">
                        <label class="card-subtitle" for="shift_b">Pilih Operator Untuk Shift B <strong>15:00 -
                                24:00</strong></label>
                        <div class="form-group row mb-0 d-flex align-items-center">
                            <div class="col">
                                <input type="text"
                                       class="form-control autocomplete-shift-b"
                                       name="shift_b" id="shift_b"
                                       placeholder="Search operator">
                            </div>
                            <div class="col-2">
                                <button onclick="onClickAddShiftB(event)" type="button" id="select-shift-b"
                                        class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Pilih
                                </button>
                            </div>
                        </div>

                        <ul id="list-shift-b" class="list-group mt-2">
                        </ul>
                    </div>
                </div>
            </div>
            <input name="shift_a_ids" id="shift_a_ids" hidden>
            <input name="shift_b_ids" id="shift_b_ids" hidden>
            <input name="id" hidden value="<?= request()->getGet(['id'])['id'] ?>">

            <div class="mt-5 w-100 d-flex align-items-center justify-content-end">
                <a class="btn btn-outline-danger me-4" href="javascript:history.back()">Cancel</a>
                <button type="submit" class="btn w-25 btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
</div>
<script>


    let srcOperators = null

    let shiftA = []
    let shiftB = []
    let operators = {shiftA: shiftA, shiftB: shiftB}

    // Override the bomMaterialList property with a setter
    Object.defineProperty(operators, 'shiftA', {
        set: (value) => {
            let oldLength = shiftA.length;
            shiftA = value;
            if (shiftA.length > oldLength) {
                renderListMaterial(shiftA, "a")
                cleanInput();
            }
        },
        enumerable: true,
        configurable: true
    });

    // Override the bomMaterialList property with a setter
    Object.defineProperty(operators, 'shiftB', {
        set: (value) => {
            let oldLength = shiftB.length;
            shiftB = value;
            if (shiftB.length > oldLength) {
                renderListMaterial(shiftB, "b")
                cleanInput();
            }
        },
        enumerable: true,
        configurable: true
    });

    function renderListMaterial(materials, type = "a") {
        $("#list-shift-" + type).empty();
        for (const material of materials) {
            addListMaterial(material, type)
        }
    }

    function addListMaterial(data, type = "a") {
        let listItem = $("<li>", {
            class: "list-group-item",
            id: "list-shift-" + type + data.id,
            text: ''
        });


        let nameLabel = $('<span>', {
            class: 'fw-lighter mx-2',
            text: ''
        });
        let nameText = $('<span>', {
            text: data.name
        });

        listItem.append(nameLabel);
        listItem.append(nameText);

        $("#list-shift-" + type).append(listItem);

        $("#shift_a_ids").val(JSON.stringify(shiftA))
        $("#shift_b_ids").val(JSON.stringify(shiftB))
    }

    function onClickAddShiftA(event) {
        event.preventDefault();
        const id = $('input[name="shift_a"]').val();
        const name = $('input[name="_shift_a"]').val();
        if (id === "" || name === "") {
            return;
        }

        let index = srcOperators.findIndex(obj => obj.id.toString() === id.toString());
        if (index !== -1) {
            srcOperators.splice(index, 1)
        } else {
            showToast("warning", "Operator sudah digunakan.")
            return;
        }

        const data = {
            "name": name,
            "id": id
        };

        console.log(srcOperators)
        operators.shiftA = [...shiftA, data];
    }

    function onClickAddShiftB(event) {
        event.preventDefault();
        const id = $('input[name="shift_b"]').val();
        const name = $('input[name="_shift_b"]').val();
        if (id === "" || name === "") {
            return;
        }

        let index = srcOperators.findIndex(obj => obj.id.toString() === id.toString());
        if (index !== -1) {
            srcOperators.splice(index, 1)
        } else {
            showToast("warning", "Operator sudah digunakan.")
            return;
        }

        const data = {
            "name": name,
            "id": id
        };

        operators.shiftB = [...shiftB, data];
    }

    function cleanInput() {
        {
            let input = $('input[name="shift_a"]');
            let $inputMaterial = $('input[name="_shift_a"]');
            input.val(null)
            $inputMaterial.val(null)
        }
        {
            let input = $('input[name="shift_b"]');
            let $inputMaterial = $('input[name="_shift_b"]');
            input.val(null)
            $inputMaterial.val(null)
        }
    }

    window.addEventListener('load', function () {
        initAutocomplete();
    })

    function initAutocomplete() {
        import('<?= base_url() . "js/autocomplete.min.js" ?>')
            .then((Autocomplete) => {
                Autocomplete = Autocomplete.default
                {
                    if (srcOperators === null) {
                        srcOperators = []
                        let data = <?= /** @var string $operators */ $operators ?>;
                        for (let i = 0; i <= data.length - 1; i++) {
                            let value = data[i]
                            srcOperators.push({
                                title: `${value.username.padEnd(25 - value.username.length, " ")} | ${value.first_name} ${value.last_name}`,
                                id: value.id,
                                data: value,
                            });
                        }
                    }

                    Autocomplete.init('input.autocomplete-shift-a', {
                        items: srcOperators,
                        valueField: "id",
                        labelField: "title",
                        highlightTyped: false,
                        hiddenInput: true,
                        fixed: false,
                    });

                    Autocomplete.init('input.autocomplete-shift-b', {
                        items: srcOperators,
                        valueField: "id",
                        labelField: "title",
                        highlightTyped: false,
                        hiddenInput: true,
                        fixed: false,
                    });

                }

            })
            .catch((error) => {
                console.log(error);
            });
    }


</script>

<?= $this->endSection() ?>
