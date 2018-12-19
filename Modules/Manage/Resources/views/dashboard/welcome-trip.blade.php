<script>
	jQuery(function ($) {

		let options = {
			showNavigation: true,
			prevLabel     : '{{ trans('manage::template.prev') }}',
			nextLabel     : '{{ trans('manage::template.next') }}',
			skipLabel     : '{{ trans('manage::template.skip') }}',
			finishLabel   : '{{ trans('manage::template.finish') }}',
			showCloseBox  : true,
			delay         : -1,
			animation     : 'fadeIn',
			tripTheme     : "black",
			showHeader    : true,
			onStart       : function () {
				$('.trip-skip').show();
			},
			onEnd         : function () {

			}
		};
		let trip    = new Trip([


			{
				sel        : $("#lnkSidebarCollapse"),
				header     : '{{ trans_safe("manage::trip.sidebar_collapse.header") }}',
				content    : '{{ trans_safe("manage::trip.sidebar_collapse.content") }}',
				position   : "s",
				onTripStart: function (tripIndex) {
//					setTimeout(function () {
//						$("#lnkSidebarCollapse").click();
//					}, 500);
					console.log('onTripStart : ', tripIndex);
				},
				onTripEnd  : function (tripIndex) {
					console.log('onTripEnd : ', tripIndex);
				}
			},


			{
				sel        : $("#lnkSidebarCollapse"),
				header     : '{{ trans_safe("manage::trip.sidebar_collapse.header") }}',
				content    : '{{ trans_safe("manage::trip.sidebar_collapse.content") }}',
				position   : "s",
				onTripStart: function (tripIndex) {
//					setTimeout(function () {
//						$("#lnkSidebarCollapse").click();
//					}, 500);
			    $("#lnkSidebarCollapse").click();
					console.log('onTripStart : ', tripIndex);
				},
				onTripEnd  : function (tripIndex) {
					console.log('onTripEnd : ', tripIndex);
				}
			},


		], options);

		//Trip start and customization
		//trip.start();
		$("#start-tour").on("click", function () {
			trip.start();
		});
	}); //End Of siaf!
</script>