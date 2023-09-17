<?php

$this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>
    <style>
        .table-compact {
            border-collapse: collapse;
        }

        .table-compact th,
        .table-compact td {
            cursor: pointer;
            padding: 15px 10px;
            border: 1px solid #dee2e6;
        }

        .card {
            box-shadow: none !important;
        }

        .label {
            width: 150px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-right: 10px;
        }

    </style>

<?php /** @var stdClass $production */ ?>
    <div>
        <div class="d-flex">
            <h3>Detail Tiket Produksi </h3>
            <h3 class="badge bg-success ms-3"><?= $production->status ?></h3>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Umum</h5>
                <p class="card-text d-flex"><span class="label">Tiket Produksi<span>:</span></span> <strong><span
                                class="badge bg-primary"><?= $production->production_ticket ?></span></strong></p>
                <p class="card-text d-flex"><span class="label">Jumlah Pesanan<span>:</span></span>
                    <strong><?= $production->quantity ?></strong></p>
                <p class="card-text d-flex"><span class="label">Tanggal Pesanan<span>:</span></span>
                    <strong><?= $production->order_date ?></strong></p>
                <p class="card-text d-flex"><span class="label">Tanggal Jatuh Tempo<span>:</span></span>
                    <strong><?= $production->due_date ?></strong></p>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Detail Manager -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Manager</h5>
                        <p class="card-text d-flex"><span class="label">ID Karyawan<span>:</span></span>
                            <strong><?= $production->manager_employee_id ?></strong></p>
                        <p class="card-text d-flex"><span class="label">Nama Depan<span>:</span></span>
                            <strong><?= $production->manager_first_name ?></strong></p>
                        <p class="card-text d-flex"><span class="label">Nama Belakang<span>:</span></span>
                            <strong><?= $production->manager_last_name ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- Detail PPIC -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail PPIC</h5>
                        <p class="card-text d-flex"><span class="label">ID Karyawan<span>:</span></span>
                            <strong><?= $production->ppic_employee_id ?></strong></p>
                        <p class="card-text d-flex"><span class="label">Nama Depan<span>:</span></span>
                            <strong><?= $production->ppic_first_name ?></strong></p>
                        <p class="card-text d-flex"><span class="label">Nama Belakang<span>:</span></span>
                            <strong><?= $production->ppic_last_name ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Produk Utama -->
        <h3 class="mt-4">Detail Produk</h3>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><strong><?= $production->master_product_name ?></strong></h5>
                <p class="card-text d-flex"><span class="label">Kode<span>:</span></span> <strong><?= $production->master_product_code ?></strong></p>
                <p class="card-text d-flex"><span class="label">Harga<span>:</span></span> <strong><?= $production->master_product_price ?></strong></p>
                <p class="card-text d-flex"><span class="label">Deskripsi<span>:</span></span> <strong><?= $production->master_product_description ?></strong></p>

                <!-- Detail Data Utama -->
                <h5 class="mt-5">Detail Alat dan Bahan</h5>
                <table class="table mt-3">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Berat</th>
                        <th>Dimensi</th>
                        <th>Gambar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($production->masterdatas as $masterdata): ?>
                        <tr>
                            <td><strong><?= $masterdata->name ?></strong></td>
                            <td><?= $masterdata->masterdata_type ?></td>
                            <td><?= $masterdata->weight ?></td>
                            <td><?= $masterdata->dimension ?></td>
                            <td>
                                <?php if (!empty($masterdata->image)): ?>
                                    <img src="<?= base_url($masterdata->image) ?>" alt="<?= $masterdata->name ?>"
                                         class="img-fluid">
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade mt" id="modalDetailProductionPlan" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="modalDetailProductionPlanLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen  modal-dialog-scrollable" style="margin-top: 0">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailProductionPlanLabel">Pesanan Produksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"
                     id="modalDetailProductionPlan-content">
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
<?php
