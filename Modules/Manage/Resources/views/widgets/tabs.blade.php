{{-- $tabs = [ 0:url 1:caption 2:badge 3:condition 4:badge-color ] --}}
<ul class="nav nav-tabs main-nav-tabs">
	@if(isset($refresh_url))
		<div class="refresh">{{ url($refresh_url."/".urlencode(str_replace('/','-',$current))) }}</div>
	@endif
	@foreach($tabs as $tab)
		<?php
		if(isset($tab['url'])) {
			$url = $tab['url'];
		}
		else {
			$url = $tab[0];
		}

		if(isset($tab['caption'])) {
			$caption = $tab['caption'];
		}
		elseif(isset($tab[1]) and $tab[1]) {
			$caption = $tab[1];
		}
		else {
			$caption = trans('manage/' . $page[0][0] . ".$tab.trans");
		}

		if(isset($tab['condition'])) {
			$condition = $tab['condition'];
		}
		elseif(isset($tab[3])) {
			$condition = $tab[3];
		}
		else {
			$condition = true;
		}

		if(isset($tab['badge_count'])) {
			$badge_count = $tab['badge_count'];
		}
		else {
			$badge_count = null;
		}

		if(isset($tab['badge_color'])) {
			$badge_color = $tab['badge_color'];
		}
		else {
			$badge_color = 'primary';
		}

		if($url == $current) {
			$active = true;
		}
		else {
			$active = false;
		}

		?>
		@if($condition)
			<li class="{{ $active ? 'active' : '' }}">
				<a href="{{ url("manage/".$page[0][0]."/".$url) }}">
					@if(isset($badge_count))
						<div class="pull-right ml-sm label text-ultralight label-{{ $badge_color }}">{{ pd( $badge_count) }}</div>
					@endif
					{{$caption}}
					@if(isset($tab[2]) and $tab[2]>0)
						<span class="ph5 text-{{$tab[4] or ''}}">
							<span style="font-size: smaller">[</span>
							<span style="font-size: larger">@pd($tab[2])</span>
							<span style="font-size: smaller">]</span>
						</span>
					@endif
				</a>
			</li>
		@endif
	@endforeach
</ul>
