<td>
	@include($__module->getBladePath('widgets.grid-text'), [
		'text' => $data['title'],
		'size' => '16',
		'link' => 'url:' . route('manage.support.single', [
			'hashid' => $data['id'],
			'type' => $ticket_type['slug']
		], false)
	])
</td>
