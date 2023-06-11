<?php $this->extend("layout/dashboard/main") ?>

<?= $this->section('content') ?>

<style>
    .dropdown-toggle:after {
        content: none !important;
    }
</style>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Kelola Master Data</h4>
        <p class="card-description w-50">
            Tabel master data.
        </p>
        <div class="w-100 d-flex justify-content-between align-items-end mb-4">
            <div class="btn-group btn-group-sm" role="group" id="masterdata-type-group"
                 aria-label="Masterdata Type Group">
                <a href="?type=ALL" type="button" class="btn btn-outline-primary ">All</a>
                <a href="?type=BAHAN" type="button" class="btn btn-outline-primary">Bahan</a>
                <a href="?type=ALAT" type="button" class="btn btn-outline-primary">Alat</a>
                <a href="?type=MESIN" type="button" class="btn btn-outline-primary">Mesin</a>
            </div>
            <div>
                <a type="button" class="btn btn-primary" href="<?= base_url() . 'masterdata/managemasterdata/add' ?>">Tambah
                    Master Data</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Berat</th>
                    <th>Dimensi</th>
                    <th>Created At</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /** @var array $data */
                foreach ($data as $key => $item) : ?>
                    <tr>
                        <td>
                            <?= esc($item->id) ?>
                        </td>
                        <td>
                            <?= esc($item->name) ?>
                        </td>
                        <td>
                            <?= esc($item->type) ?>
                        </td>
                        <td>
                            <?= esc($item->weight) . ' KG' ?>
                        </td>
                        <td>
                            <?= esc($item->dimension) ?>
                        </td>
                        <td>
                            <?= esc($item->getCreatedAt()) ?>
                        </td>
                        <td>
                            <img data-bs-toggle="modal" onclick="onImageClick(this)" data-bs-target="#imageModalStaticBackdrop" src="<?=$item->getImageBase64()?>" class="rounded mx-0 d-block"  alt="#">
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icons btn-inverse-light dropdown-toggle menu-icon mdi mdi-dots-vertical"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'masterdata/managemasterdata/edit?id=' . esc($item->id) ?>">Edit</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="<?= base_url() . 'masterdata/managemasterdata/delete?id=' . esc($item->id) ?>">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-2" >
                <nav aria-label="Pagination table">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-center changeQueryParam"  data-value="-1" style="width: 100px" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link text-center changeQueryParam" data-value="1" style="width: 100px" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        setActiveLink();
        initChangeQueryParam();
    })

    function setActiveLink() {
        let masterdataLinks = $("#masterdata-type-group>a")
        for (const masterdataLink of masterdataLinks) {
            let link = $(masterdataLink)
            let value = link.text().toUpperCase()
            if (window.location.href.includes(value)) {
                link.addClass('active')
                return
            }
        }
        $(masterdataLinks[0]).addClass('active')
    }

    function initChangeQueryParam(){
        $(".changeQueryParam").click(function (event){
            event.preventDefault(); // Prevent the default link behavior
            let currentURL = window.location.href;
            let url = new URL(currentURL);
            // Update or add the desired query parameter
            let page = url.searchParams.get('page')
            if (page === null) {
                page = 1
            }

            let stringData = $(this).attr('data-value')

            let data = parseInt(stringData)
            page = parseInt(page) + data


            if (page === 0){
                page = 1
            }
            url.searchParams.set('page', page);
            console.log(url.href)

            window.location.href = url.href;
        })
    }
</script>

<?= $this->endSection() ?>
