{{--
---- Flot Chart _ Area Chart blade and setup.
---- Input: Data (array), class (string), curve (boolean), xMode(string),
---- yMin (number), yMax (number optional), yLabel (string optional).
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


{{--Chart Area Script--}}

<script>
        $(function(){

            @if($curve)
                @php
                $lineType = [
                    'lines' => [
                        'show' => false,
                        'fill' => "undefined"
                    ],
                    'points' => [
                        'show' => [
                            'show' => true,
                            'radius' => 4
                        ]
                    ],
                    'splines' => [
                        'show' => true,
                        'tension' => 0.4,
                        'lineWidth' => 1,
                        'fill' => 0.5
                    ]
                ];
                @endphp
            @else
                @php
                    $lineType = [
                    'lines' => [
                        'show' => true,
                        'fill' => 0.7
                    ],
                    'points' => [
                        'show' => [
                            'show' => true,
                            'radius' => 4
                        ]
                    ]
                ];
                @endphp
            @endif

            let data = {!! json_encode($data) !!};

            let options = {
                series: {!! json_encode($lineType) !!},
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
                    mode: "{{ $xMode or "" }}",
                    font: {
                        size: 14,
                        lineHeight: 14,
                        //style: "italic",
                        weight: "400",
                        family: "IRANSans",
                        //variant: "small-caps",
                        color: "#656565"
                    },
                },
                yaxis: {
                    min: {{ $yMin or "undefined" }},
                    max: {{ $yMax or "undefined" }},
                    tickColor: '#eee',
                    // position: 'right' or 'left'
                    tickFormatter: function (v) {
                        return v + '{{ $yLabel or "" }}';
                    },
                    font: {
                        size: 11,
                        lineHeight: 13,
                        //style: "italic",
                        weight: "400",
                        family: "IRANSans",
                        //variant: "small-caps",
                        color: "#656565"
                    }
                },
                shadowSize: 0
            };


            let chart = $('.{{$class or "" }}');
            if(chart.length)
                $.plot(chart, data, options);

        });

</script>