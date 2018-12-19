/**
 * Created by jafar on 7/6/2016 AD.
 */
$(document).ready(function () {
	sidebarInitiate();

	// Negar: Does not remove loading class since the whole document in ready to interact
	$('.content-wrapper').removeClass('whirl');

	$("#divSideMother").css('height', $(window).height() - 50);
	$(window).resize(function () {
		$("#divSideMother").css('height', $(window).height() - 50);
	});

// 	heyCheck() ;
});

function rowHide($table_id, $model_id) {
	if ($table_id == 'auto')
		var $table_selector = ' .tableGrid';
	else
		var $table_selector = '#' + $table_id;

	var $row_selector = $table_selector + ' #tr-' + $model_id;
	$($row_selector).slideUp();
	tabReload();
}

function heyCheck() {
	// Last Run...
	in_server = false;
	now = new Date();
	heyChecked = parseInt(localStorage.getItem('heyChecked'));
	if (now.getTime() - heyChecked > 1000 * 60 * 10) {
		in_server = true;
		localStorage.setItem('heyChecked', now.getTime());
	}

	// Check Process
	if (in_server) {
		$.ajax({
			url     : url('manage/heyCheck'),
			dataType: "json",
			cache   : false
		})
			.done(function (result) {
				forms_log(result);
				localStorage.setItem('heyCheck', result.ok);
			});
	}

	// Action...
	if (localStorage.getItem('heyCheck') == 'false') {
		loginAlert('on');
	}
	else {
		loginAlert('off');
	}

	setTimeout('heyCheck()', 1000);
// 	forms_log( "heyCheck #" + localStorage.getItem('heyChecked') + "; in_server:" + in_server + "; result: " + localStorage.getItem('heyCheck') );
}

function loginAlert(mood) {
	$alert = $('#divHeyCheck');
	if (mood == 'on') {
		$alert.fadeIn('fast');
	}
	else {
		$alert.fadeOut('fast');
	}
}

function rowUpdate($table_id, $model_id) {
	if ($table_id == 'auto')
		var $table_selector = ' .tableGrid';
	else
		var $table_selector = '#' + $table_id;

	if ($model_id == '0' || $model_id == hashid0()) {
		if ($($table_selector).length) {
			forms_delaiedPageRefresh(1);
		}
	}
	else {
		var $row_selector = $table_selector + ' #tr-' + $model_id;
		var $url = $($row_selector + ' .refresh ').html();
		var $counter = $($row_selector + ' .-rowCounter ').html();

		forms_log('loading [' + $url + '] in [' + $row_selector + ']');

		$($row_selector).addClass('loading');
		$.ajax({
			url  : $url,
			cache: false,
		})
			.done(function (html) {
				$($row_selector).html(html);
				$($row_selector).removeClass('loading');
				$($row_selector + ' .-rowCounter ').html($counter);
			});
	}
}

function tabReload() {
	var url = $("#divTab .refresh").html();
	var $tab_div = $("#divTab");

	if (!url) {
		return;
	}

	$tab_div.addClass('loading');

	forms_log(url);
	$.ajax({
		url  : url,
		cache: false
	})
		.done(function (html) {
			$tab_div.html(html);
			$tab_div.removeClass('loading');
		});
}

function divReload(div_id, additive = '') {

	//Preparations...
	var $div = $("#" + div_id);
	var reload_url = $("#" + div_id + " .refresh").html();
    reload_url = $('<div>').html(reload_url).text();
    
    if (!reload_url) {
        reload_url = $div.attr('data-src') + additive;
        reload_url = reload_url.replaceAll("-id-", $div.attr('data-id'));

        // Checks if reload_url starts with http
        if (!/^http.+$/.test(reload_url)) {
            reload_url = url(reload_url);
        }
    }
	if (!reload_url) {
		return;
	}

	//Loading Effect...
	has_loading = $div.attr('data-loading');

	if (has_loading != 'no') {
		$div.addClass('loading');
	}
	forms_log('loading [' + reload_url + '] in [' + div_id + ']');

	//Ajax...
	$.ajax({
		url  : reload_url,
		cache: false
	}).done(function (html) {
			if ($div.attr('data-type') == 'append') {
				$div.append(html);
			}
			else {
				$div.html(html);
			}
			$div.removeClass('loading');

			if($div.data('src-callback')){
                let callback = eval($div.data('src-callback'));
                if(typeof callback === "function") {
					callback();
                }
            }
		}
	)
	;
}

function divReloadWith(div_id, new_src, additive = '') {

    var $div = $("#" + div_id);

    $div.attr('data-src', new_src);
    divReload(div_id, additive);
}

function masterModal($url, $size) {
	//Preparetions...
	if (!$size) $size = 'lg';
	var $modal_selector = '#masterModal-' + $size;

	//Form Load...
	$($modal_selector + ' .modal-content').html('<div class="modal-wait whirl no-overlay line back-and-forth grow"></div>').load($url, function () {
		$('.selectpicker').selectpicker();
	});
	$($modal_selector).modal();


}
function modalForm($modal_id, $item_id, $parent_id) {
	//Preparetions...
	if (!$parent_id) $parent_id = '0';
	var $modal_selector = '#' + $modal_id;
	var $form_selector = $modal_selector + ' form ';
//	var $url = $($form_selector+'._0').html().replace('-id-',$item_id).replace('-parent-',$parent_id);

	//Form Placement...
//	if($item_id=='0')
//		$($modal_selector + '-title').html($($form_selector+'._2').html());
//	else
//		$($modal_selector + '-title').html($($form_selector+'._1').html());

	//Form Load...
//	$($form_selector + 'div.modal-body').html('....').load($url , function() {
//		$('.selectpicker').selectpicker();
//	});
	$($modal_selector).modal();

}


function gridSelector($mood, $id) {
	switch ($mood) {
		case 'tr' :
			$('#gridSelector-' + $id).prop('checked', !$('#gridSelector-' + $id).is(":checked"));

		case 'selector' :
			if ($('#gridSelector-' + $id).is(":checked"))
				$('#tr-' + $id).addClass('warning');
			else
				$('#tr-' + $id).removeClass('warning');
			gridSelector('buttonActivator');
			break;

		case 'all' :
			if ($('#gridSelector-all').is(':checked')) {
				$('.gridSelector').prop('checked', true);
				$('tr.grid').addClass('warning');
			}
			else {
				$('.gridSelector').prop('checked', false);
				$('tr.grid').removeClass('warning');
			}
			gridSelector('buttonActivator');
			break;

		case 'count':
			var $count = 0;
			$(".gridSelector:checked").each(function () {
				$count++;
			});
			return $count;

		case 'get' :
			var $list = '';
			var $count = 0;
			$(".gridSelector:checked").each(function () {
				$id = $(this).attr('data-value');
				$list += $id + ',';
				$count++;
			});
			$('input[name=ids]').val($list);
			$('#txtCount').val(forms_pd($count + ' مورد '));
			break;

		case 'buttonActivator' :
			if (gridSelector('count') > 0)
				$('#action0').prop('disabled', false);
			else
				$('#action0').prop('disabled', true);
	}
}

function downstreamPhotoSelected($input_selector) {
	$($input_selector).val($($input_selector).val().replace(url(), ''));
}

function downstreamPhotoPreview($input_selector) {
	$url = $($input_selector).val();
	if ($url)
		window.open(url($url));
}


function sidebarToggle($speed) {
	if (!$speed) $speed = 0;
	$current_sitation = localStorage.getItem('sidebar');
	if (!$current_sitation) $current_sitation = "shown";

	if ($current_sitation == "shown") {
		//hide command:
		$(".sidebar").hide();
		$("#sidebarHandle").removeClass('fa-chevron-right').addClass('fa-chevron-left');
		localStorage.setItem('sidebar', 'hidden');
		$("#page-wrapper").animate({
			"margin-right": 0,
		}, $speed);
	}
	else {
		//show command:
		$("#page-wrapper").animate({
			"margin-right": 200,
		}, $speed, function () {
			$(".sidebar").show();
			$("#sidebarHandle").removeClass('fa-chevron-left').addClass('fa-chevron-right');
		});
		localStorage.setItem('sidebar', 'shown');
	}

	return localStorage.getItem('sidebar');
}

function sidebarInitiate() {
	$current_sitation = localStorage.getItem('sidebar');
	if ($current_sitation == 'hidden') {
		localStorage.setItem('sidebar', 'shown');
		return sidebarToggle(0);
	}
}

/**
 * used in "roles.one.blade"
 *
 * @param role_id
 * @returns {null}
 */
function roleAttachmentEffect(role_id) {
	var new_status = $("#cmbStatus-" + role_id).val();
	var $button = $("#btnRoleSave-" + role_id);
	$button.removeClass('btn-warning btn-primary btn-danger');

	switch (new_status) {
		case 'ban' :
			$button.addClass('btn-warning');
			break;
		case 'detach' :
			$button.addClass('btn-danger');
			break;
		default :
			$button.addClass('btn-primary');
			break;
	}
	$button.fadeIn('fast');

	return null;
}

/**
 * used in "roles.one.blade"
 *
 * @param user_id
 * @param role_id
 * @param role_slug
 */
function roleAttachmentSave(user_id, role_id, role_slug , user_hashid) {
	let new_status = $("#cmbStatus-" + role_id).val();
	let $button = $("#btnRoleSave-" + role_id);

//	forms_log('user_id: ' + user_id + '| role_slug: ' + role_slug + '| new_status: ' + new_status ) ;

	$.ajax({
		url     : url('manage/users/save/role/' + user_id + '/' + role_slug + '/' + new_status),
		dataType: "json",
		cache   : false
	})
		.done(function (result) {
			divReload("divRole-" + role_id);
			rowUpdate('tblUsers', user_hashid);
		});

	return null;

}

function permitClick($this, new_value) {
	var clicked_on = $this.attr('for');

	//Find Out new_value ...
	var current_value = $this.attr('value');
	switch (new_value) {
		case '0' :
			new_value = 0;
			break;
		case '1' :
			new_value = 2;
			break;
		case '2' :
			new_value = 2;
			break;
		default :
			if (current_value == '2') {
				new_value = 0;
			}
			else {
				new_value = 2;
			}

	}

	//Action if clicked on a locale...
	if (clicked_on == 'locale') {
		permitUpdate($this.attr('checker'), new_value);
	}

	//Action if clicked on a permit without locale...
	if (clicked_on == 'permit' && $this.attr('hasLocale') == '0') {
		permitUpdate($this.attr('checker'), new_value);
	}

	//Action if clicked on a permit with locales...
	if (clicked_on == 'permit' && $this.attr('hasLocale') == '1') {
		$(".-" + $this.attr('module') + "-" + $this.attr('permit') + "-locale").each(function () {
			permitUpdate($(this).attr('checker'), new_value);
		});
	}

	//Action if clicked on a module...
	if (clicked_on == 'module') {
		$(".-" + $this.attr('module') + "-permit").each(function () {
			permitClick($(this), new_value.toString());
		});
	}

	//Spread...
	permitSpread();
//		forms_log(clicked_on);

}

function permitUpdate(string, new_value) {
	var $input = $('#txtPermissions');

	//Add...
	if (new_value > 0) {
		var permission = $input.val();

		if (permission.search(string) < 0) {
			permission = permission + " " + string;
			$input.val(permission);
		}

	}

	//Remove...
	else {
		$input.val($input.val().replaceAll(string, ''));

	}
}

function permitSpread() {
	var permission = $('#txtPermissions').val();

	var icon_checked = "fa-check-circle-o";
	var icon_unchecked = "fa-circle-o";
	var icon_semichecked = "fa-dot-circle-o";

	var text_checked = "text-success";
	var text_unchecked = "text-darkgray";
	var text_semichecked = "text-violet";

	//Reset all links...
	$('.-permit-link').removeClass(text_checked).removeClass(text_unchecked).removeClass(text_semichecked).children('.fa').removeClass(icon_checked).removeClass(icon_unchecked).removeClass(icon_semichecked);

	//‌‌Spread check marks...
	$(".-module").each(function () {
			var module = $(this).attr('module');
			var counter = 0;
			var checked = 0;

			$(".-" + module + "-permit").each(function () {
					var permit = $(this).attr('permit');
					var counter2 = 0;
					var checked2 = 0;

					//When Has Locales...
					if ($(this).attr('hasLocale') == 1) {

						$(".-" + module + "-" + permit + "-locale").each(function () {
							var locale = $(this).attr('locale');
							counter++;
							counter2++;

							if (permission.search(module + "." + permit + "." + locale) >= 0) {
								$(this).children('.-locale-handle').addClass(icon_checked);
								$(this).addClass(text_checked).attr('value', '2');
								checked++;
								checked2++;
							}
							else {
								$(this).children('.-locale-handle').addClass(icon_unchecked);
								$(this).addClass(text_unchecked).attr('value', '0');
							}

						});

						// Permissions:
						if (checked2 == counter2) {
							$(this).children('.-permit-handle').addClass(icon_checked);
							$(this).addClass(text_checked).attr('value', '2');
						}
						else if (checked2 == 0) {
							$(this).children('.-permit-handle').addClass(icon_unchecked);
							$(this).addClass(text_unchecked).attr('value', '1');
						}
						else {
							$(this).children('.-permit-handle').addClass(icon_semichecked);
							$(this).addClass(text_semichecked).attr('value', '0');
						}

					}
					//When Doesn't have locales...
					else {
						counter++;
						if (permission.search(module + "." + permit) >= 0) {
							$(this).children('.-permit-handle').addClass(icon_checked);
							$(this).addClass(text_checked).attr('value', '2');
							checked++;
						}
						else {
							$(this).children('.-permit-handle').addClass(icon_unchecked);
							$(this).addClass(text_unchecked).attr('value', '0');
						}
					}
				}
			);


			// Module:
			if (checked == counter) {
				$(this).children('.-module-handle').addClass(icon_checked);
				$(this).addClass(text_checked).attr('value', '2');
			}
			else if (checked == 0) {
				$(this).children('.-module-handle').addClass(icon_unchecked);
				$(this).addClass(text_unchecked).attr('value', '1');
			}
			else {
				$(this).children('.-module-handle').addClass(icon_semichecked);
				$(this).addClass(text_semichecked).attr('value', '0');
			}

		}
	)
	;

}

