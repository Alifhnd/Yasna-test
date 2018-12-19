@each(
	'manage::layouts.asset-service-item',
	module('manage')->service('template_bottom_assets')->read(),
	'asset'
)
