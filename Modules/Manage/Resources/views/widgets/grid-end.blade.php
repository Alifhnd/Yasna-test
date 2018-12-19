@if(0)
    <div>
        <div>
            <div>
                <table>
                    <tbody>
                    @endif
                    
                    
                    @if(1)
                    </tbody>
                </table>
            </div>
            <div class="grid_count">
                @if($models->count() and method_exists($models , 'total') )
                    {{ trans("manage::forms.feed.showing_x_numbers_out_of_total" , [
                        'x' => pd($models->count()) ,
                        'total' => pd($models->total()) ,
                    ]) }}
                @endif
            </div>
        </div>
    </div>
@endif