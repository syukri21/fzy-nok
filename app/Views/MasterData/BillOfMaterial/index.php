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
                    <th>Deskripsi</th>
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
                            <?= esc($item->description) ?>
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
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <?= view_cell('ButtonPaginationCell') ?>

        </div>
    </div>
</div>


<?= $this->endSection() ?>
