<!-- Breadcrumb navigation -->
<ol class="breadcrumb">
    <li>
        <a class="" href="{{ url ('/') }}">
            {{ setting('site_title')->gain() }}
        </a>
    </li>

    <li>
        <a class="" href="{{ url ('/manage') }}">
            {{ trans('manage::template.title') }}
        </a>

        @php
            $trans = $link = "manage";
        @endphp
    </li>



    @if(isset($page))
        @foreach($page as $i => $p)
            @php
                $trans .= ".$p[0]";
                $link .= "/$p[0]";
            @endphp

            <li>
                <a class="" href="{{ isset($p[2])? url('manage/'.$p[2]) : url($link) }}">
                    @if(isset($p[1]))
                        {{ $p[1] }}
                    @else
                        {{ trans("$trans.trans") }}
                    @endif
                </a>
            </li>

        @endforeach
    @endif
</ol>
