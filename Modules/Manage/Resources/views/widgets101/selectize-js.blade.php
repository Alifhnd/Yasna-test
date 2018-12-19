<script>

    $(document).ready(function () {
        let ajax_source = "{{ $ajax_source }}";
        let load        = null;

        if (ajax_source) {
            load = function (query, callback) {
                if (query.length < {{ $ajax_source_limit }}) return callback();
                $.ajax({
                    url     : ajax_source,
                    type    : 'GET',
                    dataType: 'json',
                    data    : {
                        'search': query,
                    },
                    error   : function () {
                        callback();
                    },
                    success : function (res) {
                        callback(res);
                    }
                })
            };
        }

        tagObj = JSON.parse('{!! $options !!}');

        window.selectize        = {};
        window.selectize['obj'] = $('#{{$id}}').selectize({
            plugins    : ['drag_drop', 'remove_button'],
            persist    : '{{$persist}}',
            create     : '{{$create}}',
            valueField : '{{$value_field}}',
            labelField : '{{$caption_field}}',
            searchField: '{{$search_field}}',
            render     : {

                item: function (item, escape) {
                    let value     = item['{{ $value_field }}'] || "";
                    let label     = item['{{ $caption_field }}'] || "";
                    let bgColor   = item['{{ $custom_background }}'] || "#5d9cec";
                    let textColor = (bgColor === "#5d9cec") ? "#fff" : autoTextColor(bgColor);

                    let style = "background:" + bgColor +
                        "; border-color:" + bgColor
                        + "; color:" + textColor + ";";


                    return '<div class="item" style="' + style + '" data-value="' + value + '">' +
                        label + '</div>'
                },

                option_create: function (data, escape) {
                    return '<div class="create" style="font-weight: bold"> {{$create_text}} <strong>' + escape(data.input) + '</strong></div>';
                }
            },
            onItemAdd  : function (value, $item) {
//            console.log(value);
            },
            options    : tagObj,
            load       : load,
        });

        window.selectize['select']    = window.selectize['obj'][0].selectize;
		@if(isset($value))
			let valueSplited = '{{str_replace("\n",'',$value)}}'.split(',');
			
			// Filter out empty string values
            window.selectize['value'] = valueSplited.filter(function (value) {
				return value.length;
            });

        window.selectize['select'].setValue(window.selectize['value']);
		@endif
    });

</script>
