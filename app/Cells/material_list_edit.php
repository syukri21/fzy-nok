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
            <button onclick="onClickAddMaterial(event)" type="button" id="addMaterialButton"
                    class="btn btn-sm btn-icon-append btn-outline-primary w-100 me-2">Add
            </button>
        </div>
    </div>
    <ul id="list" class="list-group mt-2">

    </ul>
</div>

<script>

    let bomMaterialList = []

    // Override the bomMaterialList property with a setter
    Object.defineProperty(window, 'bomMaterialList', {
        set: setMaterialsData,
        enumerable: true,
        configurable: true
    });

    // Setter for bomMaterialList
    function setMaterialsData(value) {
        let oldLength = bomMaterialList.length;
        bomMaterialList = value;
        if (bomMaterialList.length > oldLength) {
            onMaterialDataPush(value[value.length - 1]);
        }
    }

    // Event listener for bomMaterialList changes
    function onMaterialDataPush(data) {
        createMaterial(data)
        renderListMaterial(bomMaterialList)
        cleanInput();
    }

    window.addEventListener('load', function () {
        initAutocomplete();
        initOnSubmitWithExtraData();
        initListMaterialData();
    })

    function initOnSubmitWithExtraData() {
        document.getElementById("form").addEventListener("submit", function (event) {
            event.preventDefault();
            // Prevent the form from submitting normally
            // Convert the JavaScript object to a JSON string
            let jsonData = JSON.stringify(bomMaterialList);

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

    function onClickAddMaterial(e) {
        e.preventDefault();
        const id = $('input[name="material"]').val();
        const qty = $("#qty").val();
        const name = $('input[name="_material"]').val();

        if (id === "" || qty === "" || name === "") {
            return;
        }

        const data = {
            "name": name,
            "quantity": qty,
            "masterdata_id": id
        };

        window.bomMaterialList = [...bomMaterialList, data];
    }

    function cleanInput() {
        let input = $('input[name="material"]');
        let $inputMaterial = $('input[name="_material"]');
        let inputQty = $("#qty");

        input.val(null)
        $inputMaterial.val(null)
        inputQty.val(null)
    }

    function renderListMaterial(materials) {
        $("#list").empty();
        for (const material of materials) {
            addListMaterial(material)
        }
    }

    function addListMaterial(data) {
        let badge = $("<span>", {
            text: data.quantity
        });

        let countText = $('<span class="fw-lighter mx-2" >jumlah : </span>')
        badge.append(countText);

        let listItem = $("<li>", {
            class: "list-group-item",
            id: "list" + data.id,
            text: ''
        });

        let clearButton = $("<button>", {
            class: "btn btn-sm btn-close me-3",
            "aria-label": "Close",
            "data-id": data.id,
            "type": "button",
            "click": function (e) {
                e.preventDefault();
                let id = $(clearButton).data('id')
                let index = bomMaterialList.findIndex(function (obj) {
                    return obj.id === id;
                });
                if (index !== -1) {
                    bomMaterialList.splice(index, 1);
                    $(`#list${id}`).remove();
                }
                deleteMaterial(id);
            }
        });

        let parts = data.name.split("|");
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

    function initListMaterialData() {
        let data = <?= /** @var array $materials */ json_encode(esc($materials)) ?>;
        for (const datum of data) {
            let material = {
                id: parseInt(datum.id),
                name: datum.name + "|" + datum.masterdata_type,
                quantity: datum.masterdata_qty,
            };
            bomMaterialList.push(material)
        }
        renderListMaterial(bomMaterialList)
    }

    function deleteMaterial(id) {
        if (id === "undefined") return
        $.ajax({
            url: '/masterdata/api/material?id=' + id,
            type: 'DELETE',
            success: function (response) {
                console.log('Material deleted successfully.', response);
                showToast("success", "Sukses menghapus item")
                // Handle the response
            },
            error: function (xhr, status, error) {
                console.error('Failed to delete material:', error);
                showToast("danger", "Gagal menghapus item!!!")
                // Handle the error
            }
        });
    }

    function createMaterial(data) {
        let productId = <?= json_encode($masterProductId ?? null) ?>;
        if (productId === null) return;
        $("#addMaterialButton").prop("disabled", true)
        $.ajax({
            url: '/masterdata/api/material',
            type: 'POST',
            data: JSON.stringify({
                "masterproduct_id": productId,
                "masterdata_id": parseInt(data.masterdata_id),
                "qty": parseInt(data.quantity),
            }),
            contentType: 'application/json',
            success: function (response) {
                console.log('Material created successfully.', response);
                bomMaterialList[bomMaterialList.length - 1].id = response.data.id
                $("#listundefined > button").attr("data-id", response.data.id)
                $("#listundefined").attr("id", "list" + response.data.id)
                showToast("success", "Sukses menambahkan item.")
            },
            error: function (xhr, status, error) {
                console.error('Failed to create material:', error);
                $("#listundefined").remove()
                showToast("danger", "Gagal menghapus item!!!")

            },
            complete: function () {
                $("#addMaterialButton").prop("disabled", false)
            }
        });
    }


</script>

