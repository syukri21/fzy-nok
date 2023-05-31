<?php $this->extend("layout/dashboard/main") ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Kelola User</h4>

        <div class="w-100 d-flex justify-content-between align-items-end mb-4">
            <p class="card-description w-50">
                Form pengelolaan user di dashboard.
            </p>
            <div >
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'usermanagement/manageuser/add' ?>">Create</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        Nomor Induk Karyawan
                    </th>
                    <th>
                        Nama
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Generated Password
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Created At
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($users as $key => $user) : ?>
                    <tr>
                        <td>
                            <?= esc($user->username) ?>
                        </td>
                        <td>
                            <?= esc($user->first_name . ' ' . $user->last_name) ?>
                        </td>
                        <td>
                            <?= esc($user->email) ?>
                        </td>
                        <td>
                            <?= esc($user->confirmation_code) ?? '-' ?>
                        </td>
                        <td class="<?= $user->active ? 'text-success' : 'text-danger' ?>" >
                            <?= $user->active ? 'active' : 'non active' ?>
                        </td>
                        <td>
                            <?= esc($user->created_at) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
