<?php use App\Entities\ProductionPlan;

$this->extend("layout/dashboard/main") ?>
<?= $this->section('content') ?>

    <style>
        .table-compact {
            border-collapse: collapse;
        }

        .table-compact th,
        .table-compact td {
            padding: 15px 10px;
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="mb-5 d-flex justify-content-between">
        <h4 class="title">Perencanaan Produksi</h4>
        <button class="btn btn-primary row p-2 d-flex align-items-center">
            <i class="mdi mdi-plus col mdi-24px px-2"></i>
            <span class="col-auto text-uppercase ps-0">Tambah Rencana Produksi</span>
        </button>
    </div>


    <div class="row g-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-gray">TODO</h5>
                    <table class="table table-compact table-borderless table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col">PPIC</th>
                            <th scope="col" class="text-end">Dead Line</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $todo */
                        foreach ($todo['data'] as $key => $data) : ?>
                            <tr>
                                <td class="text-primary"><?= esc($data->production_ticket) ?></td>
                                <td><?= esc($data->ppic_first_name) ?></td>
                                <td class="text-end"><?= esc($data->due_date->humanize()) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo $todo['pager']->simpleLinks('todo') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-info">ON PROGRESS</h5>
                    <table class="table table-compact table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col">Manager</th>
                            <th scope="col" class="text-end">Dead Line</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $onProgress */
                        foreach ($onProgress['data'] as $key => $data) : ?>
                            <tr>
                                <td class="text-primary"><?= esc($data->production_ticket) ?></td>
                                <td><?= esc($data->manager_first_name) ?></td>
                                <td class="text-end"><?= esc($data->due_date->humanize()) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo $todo['pager']->simpleLinks('progress') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-success">DONE</h5>
                    <table class="table table-compact  table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Tgl Selesai</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $done */
                        foreach ($done['data'] as $key => $data) : ?>
                            <tr>
                                <td class="text-primary"><?= esc($data->production_ticket) ?></td>
                                <td class="text-center"><?= esc($data->quantity) ?></td>
                                <td class="text-end"><?= esc($data->done_date->format("d M Y")) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo $todo['pager']->simpleLinks('done') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?= $this->endSection() ?>
<?php
