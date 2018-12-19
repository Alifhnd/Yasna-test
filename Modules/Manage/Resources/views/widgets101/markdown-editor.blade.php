<div class="md_editor {{ $container_class }}" id="{{ $container_id }}">
	<div class="toolbar">
		<div class="tool toggle-preview">
			<span class="preview">
				{{ trans('manage::template.md_editor.preview') }}
			</span>
			<span class="editor" style="display: none">
				{{ trans('manage::template.md_editor.editor') }}
			</span>
		</div>
	</div>

	@include('manage::widgets101.textarea')

	<textarea name="{{ $name }}" id="{{ $id . "_hidden" }}" class="html_container"></textarea>


	<div class="markdown_preview"></div>
</div>



<script defer>

    jQuery(function($){
        let md_textarea = $('.md_editor #{{ $id }}');
        let html_textarea = $('.md_editor #{{ $id }}_hidden');
        let parent = md_textarea.parent('.md_editor');
        let preview = md_textarea.siblings('.markdown_preview');
		let previewToggler = parent.find('.toggle-preview');

        md_textarea.on('keyup', function () {
            html_textarea.val(marked(md_textarea.val()));
        });

        previewToggler.on('click', function () {

		    preview.html(marked(md_textarea.val()));

		    $(this).children('span').toggle();
            preview.toggleClass('show');
        });

    });
</script>