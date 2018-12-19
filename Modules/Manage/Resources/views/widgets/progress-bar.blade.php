<div class="progress {{ $size or "" }}">

    @foreach($bars as $bar)

        <div role="progressbar"
             aria-valuenow="{{ $bar['value'] or "" }}"
             aria-valuemin="{{ $bar['min'] or "" }}"
             aria-valuemax="{{ $bar['max'] or "" }}"
             style="width: {{ $bar['value'] }}%"
             class="progress-bar progress-bar-{{ $bar['color'] }} {{ $bar['type'] or "" }}"
        >

            <span class="sr-only">{{ $bar['value'] }}% Complete ({{ $bar['color'] }})</span>

        </div>

    @endforeach
</div>