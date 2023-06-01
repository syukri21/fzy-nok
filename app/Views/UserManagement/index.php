<?php $this->extend("layout/dashboard/main") ?>

<?= $this->section('content') ?>

<style>
    .dropdown-toggle:after {
        content: none !important;
    }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Kelola User</h4>
        <div class="w-100 d-flex justify-content-between align-items-end mb-4">
            <p class="card-description w-50">
                Form pengelolaan user.
            </p>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'usermanagement/manageuser/add' ?>">Tambah User</a>
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

                <?php /** @var \App\Entities\UserEntity $users */
                foreach ($users as $key => $user) : ?>
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
                            <?= esc($user->confirmation_code) ?? '######' ?>
                        </td>
                        <td class="<?= $user->active ? 'text-success' : 'text-danger' ?>">
                            <?= $user->active ? 'active' : 'non active' ?>
                        </td>
                        <td>
                            <?= esc($user->created_at) ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icons btn-inverse-light dropdown-toggle menu-icon mdi mdi-dots-vertical"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="<?= base_url() . 'usermanagement/manageuser/edit?employee_id=' .esc($user->username)  ?>">Edit</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url() . 'usermanagement/manageuser/delete?employee_id=' .esc($user->username) ?>">Delete</a></li>
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
