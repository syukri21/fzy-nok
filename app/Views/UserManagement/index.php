<?php $this->extend("layout/Dashboard/main") ?>
<?php /** @var $pager */ ?>

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
                Tabel pengelolaan user.
            </p>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'usermanagement/manageuser/add' ?>">Tambah User</a>
            </div>

        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search ..." aria-label="search" id="search-users"
                   aria-describedby="basic-addon2">
            <button class="input-group-text" id="search-users-button">Search</button>
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
            <div class="d-flex w-100 justify-content-end">
                <?php echo $pager->simpleLinks('users') ?>
            </div>
        </div>
    </div>
</div>


<script>

    window.addEventListener('load', function () {
        $("#search-users-button").on("click", function () {
            let textContent = $("#search-users").val();
            console.log(textContent);
            let currentUrl = window.location.href;
            let queryParams = {search: textContent};
            let queryString = Object.keys(queryParams).map(function (key) {
                return key + '=' + encodeURIComponent(queryParams[key]);
            }).join('&');
            window.location.href = currentUrl.split('?')[0] + '?' + queryString;
        })
    })
</script>

<?= $this->endSection() ?>
