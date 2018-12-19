{{--
---- Flot Chart _ Bar Chart blade and setup.
---- Input: Data (array), class (string), xMode(string)
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


<script>
    $(function(){

        let data = {!! json_encode($data) !!}

        var options = {
            series: {
                bars: {
                    align: 'center',
                    lineWidth: 0,
                    show: true,
                    barWidth: 0.6,
                    fill: 0.9
                }
            },
            grid: {
                borderColor: '#eee',
                borderWidth: 1,
                hoverable: true,
                backgroundColor: '#fcfcfc'
            },
            tooltip: true,
            tooltipOpts: {
                content: function (label, x, y) { return x + ' : ' + y; }
            },
            xaxis: {
                tickColor: '#fcfcfc',
                mode: '{{ $xMode or "" }}'
            },
            yaxis: {
                // position: 'right' or 'left'
                tickColor: '#eee'
            },
            shadowSize: 0
        };

        let chart = $('.{{ $class or "" }}');
        if(chart.length)
            $.plot(chart, data, options);

    });
</script>