@include("manage::layouts.modal-delete" , [
	'form_url' => route('user-save-delete'),
	'fake' => $action = $option[0] ,
	'modal_title' => trans( $action == 'delete' ? "manage::forms.button.soft_delete" : "manage::forms.button.undelete" ) ,
	'title_value' => $model->full_name ,
	'title_label' => trans("validation.attributes.name_first") ,
	'save_label' => trans ( $action == 'delete' ? "manage::forms.button.soft_delete" : "manage::forms.button.undelete" ),
	'save_value' => $action ,
	'save_shape' => $action == 'delete' ? 'danger' : 'primary' ,
]     )