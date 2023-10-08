<?php /** @var string $production_id */
/** @var string $production_ticket */
?>
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
    <div class="card-body">
        <div class="card-title mb-3 d-flex justify-content-between">
            <div>
                <div class="d-flex">
                    <h3 class="title me-3">Hasil Produksi</h3>
                    <strong><span class="badge bg-primary"><?= $production_ticket ?></span></strong>
                </div>
                <p>Ini merupakan list daftar hasil produksi</p>
                <h5>Total Produksi : <span id="total_produksi"></span></h5>
            </div>
            <div>
                <a class="btn btn-primary p-1 pe-4 ps-1 d-flex align-items-center"
                   href="<?= base_url() . "production/result/add?production-id=" . $production_id ?>">
                    <i class="mdi mdi-plus col mdi-24px px-2"></i>
                    <span class="col-auto text-uppercase ps-0">Tambah Hasil Produksi</span>
                </a>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tanggal Produksi</th>
                    <th>Jumlah Diproduksi</th>
                    <th>Jumlah Ditolak</th>
                    <th>Diperiksa Oleh</th>
                    <th>Dilaporkan Oleh</th>
                    <th>Bukti</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var $data */
                foreach ($data as $datum): ?>
                    <tr>
                        <td><?= $datum->production_date->format('d F Y') ?></td>
                        <td class="qty_produced"><?= $datum->quantity_produced ?></td>
                        <td><?= $datum->quantity_rejected ?></td>
                        <td>
                            <span class="text-black fw-bold">(<?= $datum->checker_first_name ?>)</span><?= $datum->checked_by ?>
                        </td>
                        <td><span class="text-black fw-bold"><?= $datum->reporter_first_name ?></span> <span
                                    class="fw-light">(<?= $datum->reported_by ?>)</span></td>
                        <td><img data-bs-toggle="modal" onclick="onImageClick(this)"
                                 data-bs-target="#imageModalStaticBackdrop"
                                 src="<?= base_url() . "/uploads/" . $datum->evidence(0) ?>" alt=""></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icons btn-inverse-light menu-icon mdi mdi-dots-vertical"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'production/result/edit?id=' . esc($datum->id) ?>">Edit</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'production/result/delete?id=' . esc($datum->id) ?>">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
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

<script>
    window.addEventListener('load', function () {
        let total = 0;
        let elementNodeListOf = document.querySelectorAll("td.qty_produced");
        elementNodeListOf.forEach(item => {
            total += parseInt(item.textContent)
        })

        $("#total_produksi").html(total)
    })
</script>
<?= $this->endSection() ?>
