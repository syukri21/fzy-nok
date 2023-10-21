<?php
$this->extend("layout/dashboard/main");
$groups = auth()->getUser()->getGroups();
?>
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

<?php /**
 * @var stdClass $production
 * @var boolean $empty
 * */ ?>

<?php if ($empty): ?>
    <div class="card">
        <div class="card-body d-flex align-items-center justify-content-center flex-column">
            <img class="w-50" src="<?= base_url() . "/images/no-data.png" ?>" alt="#">
        </div>
    </div>
<?php else: ?>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <h3>Detail Tiket Produksi </h3>
                <div>
                    <h3 class="badge bg-success ms-3"><?= $production->status ?></h3>
                </div>
            </div>
            <?php if (in_array("operator", $groups)) : ?>
            <div>
                <a type="button" class="btn btn-primary row p-2 d-flex align-items-center" href="<?= base_url() . "production/result/add?production-id=" . $production->id ?>">
                    <i class="mdi mdi-plus col mdi-24px px-2"></i>
                    <span class="col-auto text-uppercase ps-0">Tambah Hasil Produksi</span>
                </a>
            </div>
            <?php endif; ?>

            <?php if (in_array("manager", $groups)) : ?>
                <form action="<?= base_url() . "production/running/done" ?>" method="post">
                    <!-- Hidden input field for the production ID -->
                    <input type="hidden" name="production_id" value="<?= $production->id ?>">

                    <!-- Button to submit the form as a POST request -->
                    <button type="submit" class="btn btn-success row p-2 d-flex align-items-center">
                        <i class="mdi mdi-check col mdi-24px px-2"></i>
                        <span class="col-auto text-uppercase ps-0">Selesaikan Produksi</span>
                    </button>
                </form>

            <?php endif; ?>
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
                                    <img data-bs-toggle="modal" onclick="onImageClick(this)"
                                         data-bs-target="#imageModalStaticBackdrop"
                                         src="<?= base_url('/uploads/' . $masterdata->image) ?>"
                                         alt="<?= $masterdata->name ?>"
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
<?php endif; ?>

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
