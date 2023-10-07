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


<div class="mb-5 d-flex justify-content-between">
    <h4 class="title">Perencanaan Hasil Produksi</h4>
    <button class="btn btn-primary row p-2 d-flex align-items-center">
        <i class="mdi mdi-plus col mdi-24px px-2"></i>
        <span class="col-auto text-uppercase ps-0">Tambah Hasil Produksi</span>
    </button>
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
