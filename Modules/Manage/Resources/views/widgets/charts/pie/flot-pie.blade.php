{{--
---- Flot Chart _ Pie and Doughnut Chart blade and setup.
---- Input: Data (array), class (string), donut (boolean), label (string of true or false),
---- Data Structure:
[
    "label"=> "Label Name",
    "color"=> "#aad874",
    "data" => [
        ["a", 50],
        ["b", 84],
        ["c", 52],
        ["d", 88],
        ["e", 69],
        ["f", 92],
    ]
];

--}}


<div class="{{ $class or ""}} flot-chart">

</div>

{{--Chart Pie Script--}}

<script>
    $(function(){

        @php
          if( $doughnut ){
            $innerRadius = 0.5;
          }else{
            $innerRadius = 0;
          }
        @endphp

        let data = {!! json_encode($data) !!};

        let options = {
            series: {
                pie: {
                    show: true,
                    innerRadius: {{ $innerRadius or 0 }},
                    label: {
                        show: {{ $label or false }},
                        radius: 0.8,
                        formatter: function (label, series) {
                            return '<div class="flot-pie-label">' +
                                //label + ' : ' +
                                Math.round(series.percent) +
                                '%</div>';
                        },
                        background: {
                            opacity: 0.8,
                            color: '#222'
                        }
                    }
                }
            }
        };

        let chart = $('.{{ $class or "" }}');
        if(chart.length)
            $.plot(chart, data, options);

    });
</script>