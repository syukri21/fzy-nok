<?php use App\Entities\ProductionPlan;

$this->extend("layout/dashboard/main");
$groups = auth()->getUser()->getGroups();

?>
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

        .table-compact tr td {
            cursor: pointer;
            padding: 0px 10px;
            border: 1px solid #dee2e6;
        }

        .card {
            box-shadow: none!important;
        }

        .dropdown-toggle:after {
            content: none !important;
        }
    </style>

<?php if (in_array("ppic", $groups)): ?>
    <div class="mb-5 d-flex justify-content-between">
        <h4 class="title">Perencanaan Produksi</h4>
        <a type="button" href="<?= base_url("/production/plan/add") ?>"
           class="btn btn-primary row p-2 d-flex align-items-center">
            <i class="mdi mdi-plus col mdi-24px px-2"></i>
            <span class="col-auto text-uppercase ps-0">Tambah Rencana Produksi</span>
        </a>
    </div>
<?php endif; ?>

    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rencana Produksi</h5>
                    <table class="table table-compact border-top border-bottom table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col">Manager</th>
                            <th scope="col">PPIC</th>
                            <th scope="col" class="text-end">Dead Line</th>
                            <?php if (in_array("manager", $groups)): ?>
                                <th class="text-center">Action</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $todo */
                        foreach ($todo['data'] as $key => $data) : ?>
                            <tr>
                                <td class="text-primary p-3" data-bs-toggle="modal" data-id="<?= esc($data->id) ?>"
                                    data-bs-target="#modalDetailProductionPlan"><?= esc($data->production_ticket) ?></td>
                                <td><?= esc($data->manager_first_name) ?></td>
                                <td><?= esc($data->ppic_first_name) ?></td>
                                <td class="text-end"><?= esc($data->due_date->humanize()) ?></td>
                                <?php if (in_array("manager", $groups)): ?>
                                    <td class="text-center p-2">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-primary"
                                               href="<?= base_url("/production/plan/start?id") . $data->id ?>"
                                               type="button"
                                               aria-expanded="false">
                                                Start
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>

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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produksi Sedang Berlangsung</h5>
                    <table class="table table-compact border-top border-bottom table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col">Manager</th>
                            <th scope="col">PPIC</th>
                            <th scope="col" class="text-end">Dead Line</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $onProgress */
                        foreach ($onProgress['data'] as $key => $data) : ?>
                            <tr data-id="<?= esc($data->id) ?>" data-bs-toggle="modal"
                                data-bs-target="#modalDetailProductionPlan"
                            >
                                <td class="text-primary p-3"><?= esc($data->production_ticket) ?></td>
                                <td><?= esc($data->manager_first_name) ?></td>
                                <td><?= esc($data->ppic_first_name) ?></td>
                                <td class="text-end"><?= esc($data->due_date->humanize()) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo $onProgress['pager']->simpleLinks('progress') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> Produksi Selesai</h5>
                    <table class="table table-compact border-top border-bottom table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Tiket</th>
                            <th scope="col" class="text-start">Manager</th>
                            <th scope="col" class="text-start">PPIC</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Tgl Selesai</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /** @var ProductionPlan $done */
                        foreach ($done['data'] as $key => $data) : ?>
                            <tr data-id="<?= esc($data->id) ?>" data-bs-toggle="modal"
                                data-bs-target="#modalDetailProductionPlan">
                                <td class="text-primary p-3"><?= esc($data->production_ticket) ?></td>
                                <td class="text-start"><?= esc($data->manager_first_name) ?></td>
                                <td class="text-start"><?= esc($data->ppic_first_name) ?></td>
                                <td class="text-center"><?= esc($data->quantity) ?></td>
                                <td class="text-end"><?= esc($data->done_date->format("d M Y")) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        <?php echo $done['pager']->simpleLinks('done') ?>
                    </div>
                </div>
            </div>
        </div>
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

    <script>
        function loadingContent() {
            return $(`
<div id="loadingIndicator" class="spinner-border" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
            `)
        }

        function modalContent() {
            return $(`
<div class="container">
    <div class="row g-3">
        <div class="col">
            <!-- Product -->
            <div class="card col">
                <div class="card-header bg-white">Produk</div>
                <div class="card-body">
                    <p><strong>Name:</strong> <span id="productName"></span></p>
                    <p><strong>Code:</strong> <span id="productCode"></span></p>
                    <p><strong>Price:</strong> <span id="productPrice"></span></p>
                    <p><strong>Description:</strong> <span id="productDescription"></span></p>
                </div>
            </div>
        </div>

        <!-- Production Plan -->
        <div class="col-8">
            <div class="card ">
                <div class="card-header bg-white">Rencana Production</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> <span id="productionPlanId"></span></p>
                            <p><strong>Production Ticket:</strong> <span id="productionTicket"></span></p>
                            <p><strong>Quantity:</strong> <span id="quantity"></span></p>
                            <p><strong>Status:</strong> <span id="status"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> <span id="orderDate"></span></p>
                            <p><strong>Due Date:</strong> <span id="dueDate"></span></p>
                            <p><strong>Done Date:</strong> <span id="doneDate"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- PPIC -->
        <div class="col-6">
            <div class="card">
                <div class="card-header bg-white">PPIC</div>
                <div class="card-body">
                    <p><strong>First Name:</strong> <span id="ppicFirstName"></span></p>
                    <p><strong>Last Name:</strong> <span id="ppicLastName"></span></p>
                    <p><strong>Employee ID:</strong> <span id="ppicEmployeeId"></span></p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <!-- Manager -->
            <div class="card ">
                <div class="card-header bg-white">Manager</div>
                <div class="card-body">
                    <p><strong>First Name:</strong> <span id="managerFirstName"></span></p>
                    <p><strong>Last Name:</strong> <span id="managerLastName"></span></p>
                    <p><strong>Employee ID:</strong> <span id="managerEmployeeId"></span></p>
                </div>
            </div>
        </div>


        <div class="col">
            <!-- Requirements -->
            <div class="card">
                <div class="card-header bg-white">Materials</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Masterdata Qty</th>
                            <th>Masterdata Type</th>
                            <th>Name</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody id="requirementsTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-12">
            <!-- Requirements -->
            <div class="row" id="operator-production" >
            </div>
        </div>


    </div>
</div>
            `)
        }

        function renderModalContent(data) {
            // Production Plan
            $('#productionPlanId').text(data.productionPlan.id);
            $('#productionTicket').text(data.productionPlan.production_ticket);
            $('#quantity').text(data.productionPlan.quantity);
            $('#orderDate').text(data.productionPlan.order_date.date.split(" ")[0]);
            $('#dueDate').text(data.productionPlan.due_date.date.split(" ")[0]);
            if (data.productionPlan.done_date != null) $('#doneDate').text(data.productionPlan.done_date.date.split(" ")[0]);
            $('#status').text(data.productionPlan.status);

            // PPIC
            $('#ppicFirstName').text(data.ppic.first_name);
            $('#ppicLastName').text(data.ppic.last_name);
            $('#ppicEmployeeId').text(data.ppic.employee_id);

            // Manager
            $('#managerFirstName').text(data.manager.first_name);
            $('#managerLastName').text(data.manager.last_name);
            $('#managerEmployeeId').text(data.manager.employee_id);

            // Product
            $('#productName').text(data.product.name);
            $('#productCode').text(data.product.code);
            $('#productPrice').text(data.product.price);
            $('#productDescription').text(data.product.description);

            // Requirements
            if (data.requirements.length > 0) {
                const requirementsTableBody = $('#requirementsTableBody');
                data.requirements.forEach(function (requirement) {
                    const row = `
                        <tr>
                          <td>${requirement.masterdata_qty}</td>
                          <td>${requirement.masterdata_type}</td>
                          <td>${requirement.name}</td>
                          <td>
                            <img src="<?= base_url("/uploads/") ?>${requirement.image}" alt="#">
                          </td>
                        </tr>
                      `;
                    requirementsTableBody.append(row);
                });
            }

            const operatorProduction = $('#operator-production');
            displayOperatorProduction(data.operatorProduction, operatorProduction)
        }

        function clearModalContent() {
            $("#modalDetailProductionPlan-content").empty();
        }

        function getProductionDetail(id) {
            clearModalContent();
            $("#modalDetailProductionPlan-content").append(loadingContent())
            $.ajax({
                url: '/api/production/plan?id=' + id,
                dataType: 'json',
                success: function (responseData) {
                    clearModalContent();
                    $("#modalDetailProductionPlan-content").append(modalContent())
                    renderModalContent(responseData.data)
                    console.log(responseData)
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    showToast("danger", "Gagal Menampilkan Detail")
                }
            });
        }

        function displayOperatorProduction(data, container) {
            // Loop through the operator production data
            for (var i = 0; i < data.length; i++) {
                var shift = data[i];

                // Create a card for each shift
                var card = $('<div>').addClass('card col-6 shift-card');
                $('<div>').addClass('card-header bg-white').text(shift.data.name).appendTo(card);
                var cardBody = $('<div>').addClass('card-body').appendTo(card);

                // Display shift name, start time, and end time
                $('<p>').addClass('card-text').text('Start Time: ' + shift.data.start_time).appendTo(cardBody);
                $('<p>').addClass('card-text').text('End Time: ' + shift.data.end_time).appendTo(cardBody);

                // Display operators in the shift
                var operatorsList = $('<ul>').addClass('list-group');
                for (var j = 0; j < shift.operators.length; j++) {
                    var operator = shift.operators[j];
                    var operatorName = operator.first_name + ' ' + operator.last_name;
                    $('<li>').addClass('list-group-item').text(operatorName).appendTo(operatorsList);
                }
                operatorsList.appendTo(cardBody);

                // Append the shift card to the main container
                card.appendTo(container);
            }
        }

        window.addEventListener('DOMContentLoaded', function () {
            $('#modalDetailProductionPlan').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                clearModalContent(); // Clear previous content
                getProductionDetail(id)
            });
        })
    </script>

<?= $this->endSection() ?>
<?php
