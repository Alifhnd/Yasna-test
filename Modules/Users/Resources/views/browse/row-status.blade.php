@include("manage::widgets.grid-badge" , [
	'fake' => $status_text = $model->as($request_role)->statusText() ,
	"fake2" => $default_text = trans("users::criteria.$status_text") ,
	'text' => isset($text)? "$text: $default_text" : $default_text,
	'icon' => config("users.status.icon.$status_text") ,
	'color' => config("users.status.color.$status_text") ,
	'link' => $model->as($request_role)->canPermit() ? "modal:manage/users/act/-hashid-/permits/$request_role"  : '',
]     )