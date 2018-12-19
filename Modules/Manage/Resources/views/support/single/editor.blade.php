{!!
    widget('form-open')
    	->method('')
    	->target($form_action ?? '')
    	->class('js')
		->setExtra('enctype', 'multipart/form-data')
 !!}

@if(yasnaSupport()->getTicketTypes())
{!!
	widget('combo')
		->inForm()
		->label($__module->getTrans('support.ticket-type'))
		->name('ticket_type')
		->options(yasnaSupport()->getTicketTypes())
		->valueField('slug')
		->captionField('title')
		->condition(!isset($ticket))
!!}
@endif

{!!
    widget('input')
    ->name('title')
    ->label('tr:manage::support.form.title')
    ->inForm()
 !!}

{!!
    widget('textarea')
    	->name('text')
		->class('tickets_tinymce_editor')
		->label('tr:manage::support.form.message')
		->inForm()
 !!}

<div class="form-group">
	<label class="control-label col-sm-2">
		{{ trans('manage::support.attach') }}
	</label>
	<div class="col-sm-10">
		<input type="file" name="attachments[]" multiple >
	</div>
</div>

{{--TODO: Uploaded files should be viewed in this list--}}
@if(isset($attached_files) and count($attached_files))
	<div class="p10 bg-gray-lighter well mt-lg">
		<ul>
			@foreach($attached_files as $attached_file)
				<li>
					<a href="{{ $attached_file['link']}}">
						{{ trans('manage::support.attach'). " " . ad($loop->iteration) }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>

@endif

{!! widget('feed') !!}

<div class="form-group">
	{!!
		widget('button')
		->type('submit')
		->shape('success')
		->class('btn-taha pull-right mh')
		->label('tr:manage::support.send')
	 !!}
</div>


{!!
    widget('form-close')
 !!}
