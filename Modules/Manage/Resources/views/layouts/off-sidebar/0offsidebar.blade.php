<aside class="offsidebar hide">
    <!-- START Off Sidebar (right)-->
    <nav>
        <div role="tabpanel">
			<ul role="tablist" class="nav nav-tabs nav-justified">
				<li role="presentation" class="active">
					<a href="#app-notifications" aria-controls="app-notifications" role="tab" data-toggle="tab" aria-expanded="true">
						<em class="icon-bell fa-lg"></em>
					</a>
				</li>
				<li role="presentation" class="">
					<a href="#app-settings" aria-controls="app-settings" role="tab" data-toggle="tab" aria-expanded="false">
						<em class="icon-equalizer fa-lg"></em>
					</a>
				</li>
			</ul>
            <!-- Tab panes-->
            <div class="tab-content">
				<!-- Notifications Panel -->
				<div id="app-notifications" role="tabpanel" class="tab-pane fade in active">
					@include('manage::layouts.off-sidebar.tab-pane.notifications')
				</div>
                <!-- Setting Panel -->
				<div id="app-settings" role="tabpanel" class="tab-pane fade">
					@include('manage::layouts.off-sidebar.tab-pane.settings')
				</div>
            </div>
        </div>
    </nav>
    <!-- END Off Sidebar (right)-->
</aside>
