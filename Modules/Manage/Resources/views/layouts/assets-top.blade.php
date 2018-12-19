@each(
	'manage::layouts.asset-service-item',
	module('manage')->service('template_assets')->read(),
	'asset'
)