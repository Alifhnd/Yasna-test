{{--
    Vue.js component for Color Picker
--}}
<div id="{{ $id }}">
    <colorpicker :color="defaultColor" :name="inputName" :title="inputTooltip" v-model="defaultColor" />
</div>


<script>
    $(document).ready(function () {
        var vueOptions = {
            el: '#{{ $id }}',
            data: {
                defaultColor: '{{ $value }}',
                inputName: '{{ $name or "" }}',
                inputTooltip: '{{ $title or "" }}',
            }
        };
        if(typeof vueOptions !== 'undefined'){
            new Vue(vueOptions);
        }
    })
</script>