<?php /** @var string $production_id */ ?>
<?php $this->extend("layout/dashboard/main") ?>
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



<div class="card p-4">
    <div class="mb-3 d-flex justify-content-between">
        <div>
            <h3 class="title">Hasil Produksi</h3>
            <p>Ini merupakan list daftar hasil produksi</p>
        </div>
        <div>
            <a class="btn btn-primary p-1 pe-4 ps-1 d-flex align-items-center"
               href="<?= base_url() . "production/result/add?production-id=" . $production_id ?>">
                <i class="mdi mdi-plus col mdi-24px px-2"></i>
                <span class="col-auto text-uppercase ps-0">Tambah Hasil Produksi</span>
            </a>
        </div>

    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal Produksi</th>
            <th>Jumlah Diproduksi</th>
            <th>Jumlah Ditolak</th>
            <th>Diperiksa Oleh</th>
            <th>Dilaporkan Oleh</th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var $data */
        foreach ($data as $datum): ?>
            <tr>
                <td><?= $datum->id ?></td>
                <td><?= $datum->production_date->humanize() ?></td>
                <td><?= $datum->quantity_produced ?></td>
                <td><?= $datum->quantity_rejected ?></td>
                <td><?= $datum->checked_by ?></td>
                <td><?= $datum->reported_by ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade mt" id="modalDetailProductionResutl" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalDetailProductionResutlLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen  modal-dialog-scrollable" style="margin-top: 0">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailProductionResutlLabel">Production Results Produksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"
                 id="modalDetailProductionResutl-content">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
