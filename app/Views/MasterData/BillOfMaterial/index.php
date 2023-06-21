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
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'masterdata/managebom/add' ?>">Tambah Bill Of Material</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Due date</th>
                    <th>Action</th>
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
                            <?= esc($item->getPriceRupiah())?>
                        </td>
                        <td>
                            <img data-bs-toggle="modal" onclick="onImageClick(this)"
                                 data-bs-target="#imageModalStaticBackdrop" src="<?= $item->getImageBase64() ?>"
                                 class="rounded mx-0 d-block" alt="#">
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
                                           href="<?= base_url() . 'masterdata/managebom/edit?id=' . esc($item->id) ?>">Edit</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'masterdata/managebom/delete?id=' . esc($item->id) ?>">Delete</a>
                                    </li>
                                    <li>
                                        <button type="submit" class="dropdown-item bom-detail"
                                                data-image="<?= $item->getImageBase64() ?>" data-bs-toggle="modal"
                                                data-bs-target="#bomdetailModal"
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body container ps-0">
                            <div class="mb-3 row">
                                <label for="bomdetailModal_id" class="form-label col-3">ID</label>
                                <div class="form-control col p-2 " id="bomdetailModal_id"></div>
                            </div>
                            <div class="mb-3 row">
                                <label for="bomdetailModal_name" class="form-label col-3">Nama</label>
                                <div class="form-control col p-2 " id="bomdetailModal_name"></div>
                            </div>
                            <div class="mb-3 row">
                                <label for="bomdetailModal_code" class="form-label col-3">Code</label>
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
                                    <img data-bs-toggle="modal" id="bomDetailImageModal" onclick="onImageClick(this)"
                                         data-bs-target="#imageModalStaticBackdrop"
                                         src="" class="rounded mx-0 d-block img-fluid" alt="#">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="bomdetailModal_createdAt" class="form-label col-3">Dibuat pada</label>
                                <div class="form-control col p-2 " id="bomdetailModal_createdAt"></div>
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
                    const diff = Date.now() - date.getTime();
                    const seconds = Math.floor(diff / 1000);
                    const minutes = Math.floor(seconds / 60);
                    const hours = Math.floor(minutes / 60);
                    const days = Math.floor(hours / 24);

                    if (days > 0) {
                        return `${days} day${days === 1 ? '' : 's'} ago`;
                    } else if (hours > 0) {
                        return `${hours} hour${hours === 1 ? '' : 's'} ago`;
                    } else if (minutes > 0) {
                        return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
                    } else {
                        return 'just now';
                    }
                }


                window.addEventListener("load", function () {
                    $('#bomdetailModal').on('show.bs.modal', function (event) {
                        const button = $(event.relatedTarget); // Button that triggered the modal
                        const itemData = button.data('value');
                        const image = button.data('image');
                        $("#bomDetailImageModal").attr('src', image);
                        $('#bomdetailModal_id').text(itemData.id);
                        $('#bomdetailModal_name').text(itemData.name);
                        $('#bomdetailModal_code').text(itemData.code);
                        $('#bomdetailModal_price').text(itemData.price);
                        $('#bomdetailModal_createdAt').text(humanizeDate(itemData.created_at.date));
                        $('#bomdetailModal_desc').text(itemData.description);

                    });

                })
            </script>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
