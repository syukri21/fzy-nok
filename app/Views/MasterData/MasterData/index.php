<?php $this->extend("layout/dashboard/main") ?>

<?= $this->section('content') ?>

<style>
    .dropdown-toggle:after {
        content: none !important;
    }
</style>

<div class="card">

    <div class="card-body">
        <h4 class="card-title">Kelola Master Data</h4>
        <div class="btn-group btn-group-sm mb-4" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-primary">Bahan</button>
            <button type="button" class="btn btn-outline-primary">Alat</button>
            <button type="button" class="btn btn-outline-primary">Mesin</button>
        </div>
        <div class="w-100 d-flex justify-content-between align-items-end mb-4">
            <p class="card-description w-50">
                Tabel master data.
            </p>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'masterdata/managemasterdata/add' ?>">Tambah
                    Master Data</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Berat</th>
                    <th>Dimensi</th>
                    <th>Created At</th>
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
                            <?= esc($item->type) ?>
                        </td>
                        <td>
                            <?= esc($item->weight) . ' KG' ?>
                        </td>
                        <td>
                            <?= esc($item->dimension) ?>
                        </td>
                        <td>
                            <?= esc($item->created_at) ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icons btn-inverse-light dropdown-toggle menu-icon mdi mdi-dots-vertical"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'masterdata/managemasterdata/add?id=' . esc($item->id) ?>">Edit</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'masterdata/managemasterdata/delete?id=' . esc($item->id) ?>">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>


<?= $this->endSection() ?>
