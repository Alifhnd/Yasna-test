{{--
---- Chart.js _ Radar Chart blade and setup.
---- Input: id ( string ), labels ( Array ), data ( Associative Array ).
---- data Structure For Radar:
[
     'label' => 'گروه اول',
     'backgroundColor' => 'rgba(114,102,186,0.2)',
     'borderColor' => 'rgba(114,102,186,1)',
     'data' => [65, 59, 90, 81, 56, 55, 40]
]
-----
----- Recommendation:
----- 'backgroundColor' and 'borderColor' be the same color, following this order:
----- 'backgroundColor' => 'rgba(x,y,z,0.2)' and 'borderColor' => 'rgba(x,y,z,1)'.
-----
_______________________________________________________________
--}}


<canvas id="{{ $id or '' }}"></canvas>

<!-- Chart.js Scripts -->

<script>

    $(function () {
        var radarData = {
            labels: {!! json_encode($labels) !!},
            datasets: {!! json_encode($data) !!}
        };

        var radarOptions = {
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        //get the concerned dataset
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        //get the current items value
                        var currentValue = dataset.data[tooltipItem.index];

                        return pd(addCommas(currentValue));
                    }
                }
            }
        };
        Chart.defaults.global.defaultFontFamily = "IRANSans";
        var radarctx = document.getElementById('{{ $id or "" }}').getContext('2d');
        var radarChart = new Chart(radarctx, {
            data: radarData,
            type: 'radar',
            options: radarOptions
        });

    });

</script>