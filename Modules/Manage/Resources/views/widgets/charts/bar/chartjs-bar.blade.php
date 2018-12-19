{{--
---- Chart.js _ Bar Chart blade and setup.
---- Input: id ( string ), labels ( Array ), data ( Associative Array ).
---- data Structure:
[
    'backgroundColor' => 'rgb or hex',
    'borderColor' => 'rgb or hex',
    'data' => [10, 20, 30, 40, 50, 60, 70]
]
-----
----- Recommendation:
----- 'backgroundColor' and 'borderColor' be the same color.
_______________________________________________________________
--}}
@php
	$other = "{}";
	 if (isset($options) and $options){
		$other = json_encode($options);
	 }

    $isHorizontal = (isset($type) and $type === 'horizontalBar');

    if($isHorizontal){
        $height = count($labels) * 30 . "px";
    }

@endphp
<div class="chart-parent" style="{{ $parent_style or "" }}">
	<canvas id="{{ $id or '' }}" style="height: {{ $height or "" }}; width: {{ $width or "" }}"></canvas>
</div>

<!-- Chart.js Scripts -->

<script>

    $(document).ready(function () {
        var barData = {
            labels  : {!! json_encode($labels) !!},
            datasets: {!! json_encode($data) !!}
        };

        var barOptions = {
            maintainAspectRatio: !{!! json_encode($isHorizontal) !!},
            legend  : {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        //get the concerned dataset
                        var dataset      = data.datasets[tooltipItem.datasetIndex];
                        //get the current items value
                        var currentValue = dataset.data[tooltipItem.index];

                        return ad(addCommas(currentValue));
                    }
                }
            }

        };


        var otherOptions = {!! $other !!};
        var options      = $.extend(true, barOptions, otherOptions);
        var barctx       = document.getElementById('{{ $id or "" }}').getContext('2d');
        var barChart     = new Chart(barctx, {
            data   : barData,
            type   : "{{ $type or "bar" }}",
            options: options
        });

    });

</script>
