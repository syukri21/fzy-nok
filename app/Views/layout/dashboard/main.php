<?php $this->extend('layout/main') ?>
<?php $this->section('content') ?>
<?= $this->include('layout/dashboard/navbar') ?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">

    <?= view_cell('SidebarCell') ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <?= view_cell('AlertMessageCell', ['type' => 'danger', 'error' => session()->getFlashdata("error"), 'errors' => session()->getFlashdata("errors")]) ?>

            <?= $this->renderSection('content') ?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">© Copyright  2021. All rights reserved.</span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
<?php $this->endSection() ?>

