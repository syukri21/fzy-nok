<?php $this->extend("layout/dashboard/main") ?>

<?= $this->section('content') ?>

<style>
    .dropdown-toggle:after {
        content: none !important;
    }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Kelola Bill Off Material</h4>
        <div class="w-100 d-flex justify-content-between align-items-end mb-4">
            <p class="card-description w-50">
                Tabel bill of material.
            </p>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'masterdata/managebom/add' ?>">Tambah
                    Bill Of Material</a>
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Dibuat pada</th>
                        <th>Batas waktu</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /** @var array $data */
                    foreach ($data as $key => $item) : ?>
                        <tr>
                            <td>
                                <?= esc($item->id) ?>
                            </td>
                            <td>
                                <?= esc($item->name) ?>
                            </td>
                            <td>
                                <?= esc($item->code) ?>
                            </td>
                            <td>
                                <?= esc($item->getPriceRupiah()) ?>
                            </td>
                            <td>
                                <img data-bs-toggle="modal" onclick="onImageClick(this)"
                                     data-bs-target="#imageModalStaticBackdrop" src="<?= $item->getImageBase64() ?>"
                                     class="rounded mx-0 d-block img-fluid" alt="#">
                            </td>
                            <td>
                                <?= esc($item->created_at->humanize()) ?>
                            </td>
                            <td>
                                <?= esc($item->due_date->humanize()) ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-icons btn-inverse-light dropdown-toggle menu-icon mdi mdi-dots-vertical"
                                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item"
                                               href="<?= base_url() . 'masterdata/managebom/edit?id=' . esc($item->id) ?>">Ubah</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                               href="<?= base_url() . 'masterdata/managebom/delete?id=' . esc($item->id) ?>">Hapus</a>
                                        </li>
                                        <li>
                                            <button type="submit" class="dropdown-item bom-detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#bomdetailModal"
                                                    data-requirements-image="<?= esc(json_encode($item->getRequirementsImageBase64())) ?>"
                                                    data-requirements="<?= esc(json_encode($item->getRequirements())) ?>"
                                                    data-image="<?= $item->getImageBase64() ?>"
                                                    data-value="<?= esc(json_encode($item)) ?>">Lihat Detail
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
                <?= view_cell('ButtonPaginationCell') ?>

                <!-- Item Modal -->
                <div class="modal fade" id="bomdetailModal" tabindex="-1" aria-labelledby="bomdetailModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered mt-4">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bomdetailModalLabel">Detail Bill Of Material</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container" >
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_id" class="form-label col-3">ID</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_id"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_name" class="form-label col-3">Nama</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_name"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_code" class="form-label col-3">Kode</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_code"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_price" class="form-label col-3">Harga</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_price"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_desc" class="form-label col-3">Deskripsi</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_desc"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_image" class="form-label col-3">Gambar</label>
                                        <div class="col p-2">
                                            <img data-bs-toggle="modal" id="bomDetailImageModal"
                                                 onclick="onImageClick(this)"
                                                 data-bs-target="#imageModalStaticBackdrop"
                                                 height="100px"
                                                 src="" class="rounded mx-0 d-block img" alt="#">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_createdAt" class="form-label col-3">Dibuat
                                            pada</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_createdAt"></div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="bomdetailModal_dueDate" class="form-label col-3">Batas Waktu</label>
                                        <div class="form-control col p-2 " id="bomdetailModal_dueDate"></div>
                                    </div>
                                    <h6 class="card-title mt-5">Material</h6>
                                    <ul id="requirementList">
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function humanizeDate(dateStr) {
                        const date = new Date(dateStr);
                        const options = {day: 'numeric', month: 'long', year: 'numeric'};
                        return date.toLocaleDateString('id-ID', options)
                    }
                    window.addEventListener("load", function () {
                        let modal = $('#bomdetailModal');
                        let list = $('#requirementList');

                        modal.on('show.bs.modal', function (event) {
                            const button = $(event.relatedTarget);
                            const itemData = button.data('value');
                            const image = button.data('image');
                            const requirements = button.data('requirements');
                            const imageRequirements = button.data('requirements-image');


                            requirements.forEach(function (item, index) {
                                const listItem = $('<li>').addClass('list-group-item d-flex align-items-center row');
                                const itemImage = $('<div>').append($('<img height="50px" width="50px" >').attr('src', imageRequirements[index]).addClass('rounded')).addClass('col-1  mr-3 me-3')
                                const itemTitle = $('<h5>').addClass('mb-0 me-3 col').text(item.name);
                                const itemQuantity = $('<p>').addClass('mb-0 me-3 col').text(`Quantity: ${item.masterdata_qty}`);
                                listItem.append(itemTitle, itemQuantity, itemImage);
                                list.append(listItem);
                            });


                            $("#bomDetailImageModal").attr('src', image);
                            $('#bomdetailModal_id').text(itemData.id);
                            $('#bomdetailModal_name').text(itemData.name);
                            $('#bomdetailModal_code').text(itemData.code);
                            $('#bomdetailModal_price').text(itemData.price);
                            $('#bomdetailModal_createdAt').text(humanizeDate(itemData.created_at.date));
                            $('#bomdetailModal_dueDate').text(humanizeDate(itemData.due_date.date));
                            $('#bomdetailModal_desc').text(itemData.description);

                        });
                        modal.on('hide.bs.modal', function (event) {
                            const list = $('#requirementList');
                            list.empty()
                        });
                    })
                </script>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
