{{--
---- Esy Pie Chart _ Pie Chart blade and setup.
---- Input: percent (number), id (string), barColor (hex or rgb), trackColor (hex or rgb ),
---- scaleColor (hex or rgb ), lineWidth (number)
---- "trackColor", "scaleColor" and "lineWidth" are optional.
--}}

<div id="{{ $id or "" }}" data-percent="{{ $percent or "" }}" class="easypie-chart">
    <span>{{ $text or pd($percent) }}</span>
</div>

<!-- Chart Scripts -->

<script>
    $(function () {
        if(! $.fn.easyPieChart ) return;

        var pieOptions = {
            animate: {
                duration: 800,
                enabled: true
            },
            barColor: '{{ $barColor or "#23b7e5" }}',
            trackColor: '{{ $trackColor or false }}',
            scaleColor: '{{ $scaleColor or false }}',
            lineWidth: '{{ $lineWidth or "10" }}',
            lineCap: 'circle'
        };
        $('#{{ $id or "" }}').easyPieChart(pieOptions);

    });
</script>
