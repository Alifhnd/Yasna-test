{{--
---- Chart.js _ Pie and Doughnut Chart blade and setup.
---- Input: id ( string ), labels ( Array ), data ( Associative Array ).
---- data Structure For Pie and Doughnut:
[
     'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
     'hoverBackgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
     'data' => [45, 20, 100, 40, 50]
]
-----
----- Recommendation:
-----
_______________________________________________________________
--}}

@php
    $other = "{}";
	 if (isset($options) and $options){
		$other = json_encode($options);
	 }

@endphp

<div class="chart-parent">
    <canvas id="{{ $id or '' }}" style="height: {{ $height or "400" }}; width: {{ $width or "" }}"></canvas>
</div>

<!-- Chart.js Scripts -->

<script>

    $(document).ready(function () {
        var doughnutData = {
            labels: {!! json_encode( $labels ) !!},
            datasets: {!! json_encode($data) !!}
        };

        var doughnutOptions = {
            maintainAspectRatio: false ,
            legend: {
                display: "{{$legend or false}}",
                position: "bottom"
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        //get the concerned dataset
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        //calculate the total of this data set
                        var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                            return previousValue + currentValue;
                        });
                        //get the current items value
                        var currentValue = dataset.data[tooltipItem.index];
                        //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
                        var precentage = Math.floor(((currentValue/total) * 100)+0.5);

                        return pd(data.labels[tooltipItem.index] + " " + addCommas(currentValue) + " (" + precentage + "%)");
                    }
                }
            },
            onResize: function () {
                resizePieChart(doughnutChart);
            }
        };


        var otherOptions = {!! $other !!};
        var options = $.extend(true, doughnutOptions, otherOptions);
        var doughnutctx = document.getElementById('{{ $id or "" }}').getContext('2d');
        var doughnutChart = new Chart(doughnutctx, {
            data: doughnutData,
            type: '{{ $type or "" }}',
            options: options
        });
        resizePieChart(doughnutChart);
    });
</script>
