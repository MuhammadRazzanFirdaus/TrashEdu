@extends('templates.petugas')

@section('content')
<div class="container mt-5">
    <h5>Grafik Penukaran Hadiah & Sampah</h5>
    <div class="row">
        <div class="col-6">
            <h5>Penukaran Hadiah Bulanan</h5>
            <canvas id="chartLine" width="400" height="300"></canvas>
        </div>
        <div class="col-6">
            <h5>Total Poin Penukaran Sampah</h5>
            <canvas id="chartPie" width="400" height="300"></canvas>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let labelLine = [];
let dataLine = [];
let dataPie = [];

$(function() {
    $.ajax({
        url: "{{ route('staff.rewards.chart.line') }}",
        method: "GET",
        success: function(res) {
            console.log('Line chart:', res);
            labelLine = res.labels;
            dataLine = res.data;
            renderLineChart();
        },
        error: function(err) {
            console.error('Line Chart error:', err);
        }
    });

    $.ajax({
        url: "{{ route('staff.rewards.chart.pie') }}",
        method: "GET",
        success: function(res) {
            console.log('Pie chart:', res);
            dataPie = res.data;
            renderPieChart();
        },
        error: function(err) {
            console.error('Pie Chart error:', err);
        }
    });
});

function renderLineChart() {
    const ctx = document.getElementById('chartLine').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelLine,
            datasets: [{
                label: 'Hadiah',
                data: dataLine,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Penukaran Hadiah Bulanan' }
            }
        }
    });
}

function renderPieChart() {
    const ctx = document.getElementById('chartPie').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Poin Sampah'],
            datasets: [{
                data: [dataPie.approved || 0],
                backgroundColor: ['rgba(255, 159, 64, 0.7)'],
                borderColor: ['rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Total Poin Penukaran Sampah' }
            }
        }
    });
}
</script>
@endpush
