{{--
---- Chart.js _ Polar Chart blade and setup.
---- Input: id ( string ), labels ( Array ), data ( Associative Array ).
---- data Structure For Area:
[
     'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
     'data' => [45, 20, 100, 40, 50],
     'label'=> 'فصل ها'
]
-----
----- Recommendation:
-----
_______________________________________________________________
--}}


<canvas id="{{ $id or '' }}"></canvas>

<!-- Chart.js Scripts -->

<script>

    $(function () {
        var polarData = {
            labels: {!! json_encode($labels) !!},
            datasets: {!! json_encode($data) !!}

        };

        var polarOptions = {
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
        var polarctx = document.getElementById('{{ $id or "" }}').getContext('2d');
        var polarChart = new Chart(polarctx, {
            data: polarData,
            type: 'polarArea',
            options: polarOptions
        });

    });

</script>