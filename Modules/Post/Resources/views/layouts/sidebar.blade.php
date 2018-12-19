@include('manage::layouts.sidebar-link' , [
    'icon'       => 'fa fa-book',
    'caption'    => trans_safe('post::message.posts'),
    'sub_menus'  => [
        [
			 'link'    => 'posts' ,
			 'caption' => trans_safe('post::message.posts_list'),
			 'icon'    => 'fa fa-plus' ,
        ],
    ],
])
