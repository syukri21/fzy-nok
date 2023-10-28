<?php $this->extend("layout/Dashboard/main") ?>

<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<div class="card">
    <div class="card-body">
        <div class="card-title">
            <span>Grafik Production</span>
        </div>
        <div class="row">
            <div class="col">
                <canvas id="month_production" style="width:100%;max-width:700px"></canvas>
            </div>
            <div class="col">
                <canvas id="total_production" style="width:100%;max-width:700px"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    let allTimeProduction = <?= /** @var array $allTime */ json_encode($allTime) ?>;
    new Chart("total_production", {
        type: "pie",
        data: {
            labels: allTimeProduction.label,
            datasets: [{
                backgroundColor: ["#F875AA", "#AEDEFC", "#132043", "#3876BF"],
                data: allTimeProduction.data
            }]
        },
        options: {
            title: {
                display: true,
                text: "Total Production Oil Seal"
            }
        }
    });

    const labels = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];

    const dataset1 = []
    const dataset2 = []

    let month = <?= /** @var array $month */ json_encode($month) ?>;

    console.log(month)
    const dataset = month.dataset

    new Chart("month_production", {
        type: "line",
        data: {
            labels: labels,
            datasets: dataset,
        },
        options: {
            legend: {display: false},
            title: {
                display: true,
                text: "Grafik Produktifitas Tahunan"
            }
        }
    });
</script>

<?= $this->endSection() ?>
