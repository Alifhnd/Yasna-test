{{--
---- Chart.js _ Area and Line Chart blade and setup.
---- Input: id ( string ), labels ( Array ), data ( Associative Array ).
---- data Structure For Area:
[
    'label' => 'گروه اول داده ها',
    'backgroundColor' => 'rgba(114,102,186,0.2)',
    'borderColor' => 'rgba(114,102,186,1)',
    'pointBorderColor' => '#fff',
    'data' => [10, 20, 30, 40, 50, 60, 70]
]
---- data Structure For line:
[
    'label' => 'گروه اول داده ها',
    'backgroundColor' => 'transparent',
    'borderColor' => 'rgba(114,102,186,1)',
    'pointBorderColor' => '#fff',
    'data' => [10, 20, 30, 40, 50, 60, 70]
]
-----
----- Recommendation:
----- 'backgroundColor' and 'borderColor' be the same color, following this order:
----- 'backgroundColor' => 'rgba(x,y,z,0.2)' and 'borderColor' => 'rgba(x,y,z,1)'.
----- 'pointBorderColor' => '#fff', usually looks good.
_______________________________________________________________
--}}


@php
    $other = "{}";
	 if (isset($options) and $options){
		$other = json_encode($options);
	 }

@endphp

<div class="chart-parent">
    <canvas id="{{ $id or '' }}" style="height: {{ $height or "" }}; width: {{ $width or "" }}"></canvas>
</div>

<!-- Chart.js Scripts -->

<script>

   $(document).ready(function () {
       var lineData = {
           labels: {!! json_encode($labels) !!},
           datasets: {!! json_encode($data) !!}
       };

       var lineOptions = {
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

                       return ad(addCommas(currentValue));
                   }
               }
           }
       };

       var otherOptions = {!! $other !!};
       var options      = $.extend(true, lineOptions, otherOptions);
       var linectx = document.getElementById('{{ $id or "" }}').getContext('2d');
       var lineChart = new Chart(linectx, {
           data: lineData,
           type: 'line',
           options: options
       });
   });

</script>
