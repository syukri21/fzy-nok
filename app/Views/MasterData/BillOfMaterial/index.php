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
                Form pengelolaan bill of material.
            </p>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'masterdata/masterdata/add' ?>">Tambah Bill Of Material</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nomor Induk Karyawan</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Generated Password</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>


<?= $this->endSection() ?>
