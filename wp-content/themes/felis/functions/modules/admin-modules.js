jQuery(document).ready(function($){

	function sg_set_metaboxes(){
		var tpl = $('#page_template').find('option:selected').val();
		if (tpl) {
			tpl = tpl.replace('pg-', '');
			tpl = tpl.replace('.php', '');
			$('.postbox .inside div.sg-meta-container').parent().parent().hide();
			$('.postbox .inside div.' + tpl).parent().parent().show();
		} else {
			$('.postbox .inside div.sg-meta-container').parent().parent().show();
		}
		if ($('.postbox .inside div.no-editor').parent().parent().is(':visible')) {
			$('#postdivrich').hide();
		} else {
			$('#postdivrich').show();
		}
	}
	
	$('.sg-meta-sidebar').parent().parent().parent().find('.inside').addClass('sg-set-sidebar');

	$('.postbox .inside div.sg-meta-container').parent().parent().map(function() {
			$('#' + this.id + '-hide').parent().remove();
			return true;
		}).get();

	sg_set_metaboxes();

	$('#page_template').live('change', function(){
		sg_set_metaboxes();
	});

	var ms = $('.sg-meta-sidebar ul li:first-child');
	if (ms.hasClass('sg-meta-tab')) {
		ms.next('li').addClass('active');
	} else {
		ms.addClass('active');
	}
	
	$('.sg-meta-content .sg-meta-section:first-child').siblings('.sg-meta-section').hide();

	$('.sg-meta-sidebar ul li a').click(function(e){
		e.preventDefault();
		var section_id = $(this).attr('href');
		$(section_id).show().siblings('.sg-meta-section').hide();
		$(this).parents('li').addClass('active').siblings('.active').removeClass('active');
	});

	$('.postbox .inside div.sg-meta-container').show();
	
	function sg_media_upload_SI() {
		var win = window.dialogArguments || opener || parent || top;
		var name = win.sg_slider_btn_name;
		$('<input type="submit" value="' + name + '" class="button sg-post-thumbnail">').insertBefore('a.del-link');
		$(".sg-post-thumbnail").click(function() {
			var nonce = win.sg_post_nonce;
			var id = $(this).parent().find('input:first').attr("id");
			id = id.replace('send[', '');id = id.replace(']', '');
			jQuery.post(win.sg_slider_ajaxurl, {
				post_id: post_id, thumbnail_id: id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
			}, function(str){
				if (str == '0') {
					alert(setPostThumbnailL10n.error);
				} else {
					win.SGSetSlideHTML(str, id);
					win.SGTbRemove();
				}
			});
			return false;
		});
	}
	
	function sg_media_upload_PP() {
		var win = window.dialogArguments || opener || parent || top;
		var name = win.sg_pattern_btn_name;
		$('<input type="submit" value="' + name + '" class="button sg-post-thumbnail">').insertBefore('a.del-link');
		$(".sg-post-thumbnail").click(function() {
			var nonce = win.sg_post_nonce;
			var id = $(this).parent().find('input:first').attr("id");
			id = id.replace('send[', '');id = id.replace(']', '');
			jQuery.post(win.sg_pattern_ajaxurl, {
				post_id: post_id, thumbnail_id: id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
			}, function(str){
				if (str == '0') {
					alert(setPostThumbnailL10n.error);
				} else {
					win.SGSetPatternHTML(str, id);
					win.SGTbRemove();
				}
			});
			return false;
		});
	}
	
	function sg_media_upload_PI() {
		var win = window.dialogArguments || opener || parent || top;
		var name = win.sg_media_upload_btn_name;
		$('<input type="submit" value="' + name + '" class="button sg-post-thumbnail">').insertBefore('a.del-link');
		$(".sg-post-thumbnail").click(function() {
			var nonce = win.sg_post_nonce;
			var id = $(this).parent().find('input:first').attr("id");
			id = id.replace('send[', '');id = id.replace(']', '');
			jQuery.post(ajaxurl, {
				action:"set-post-thumbnail", post_id: post_id, thumbnail_id: id, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
			}, function(str){
				if (str == '0') {
					alert(setPostThumbnailL10n.error);
				} else {
					win.SGSetThumbnailHTML(str);
					win.SGTbRemove();
				}
			});
			return false;
		});
	}
	
	function sg_media_upload_LFI() {
		var win = window.dialogArguments || opener || parent || top;
		var name = win.sg_media_upload_btn_name;
		$('.savesend .button').val(name);
	}
	
	var get = location.search;
	if(get.indexOf('custom-media-upload=SI') + 1) {
		$('body').addClass('sg_load_box_ha');
		$('body').addClass('sg_load_box_hb');
		$('<input type="hidden" value="SI" name="custom-media-upload">').insertBefore('input[name=post_id]');
		$('#image-form').attr('action', $('#image-form').attr('action') + '&custom-media-upload=SI');
		$('#image-form').bind('ajaxComplete', sg_media_upload_SI);
		sg_media_upload_SI();
	}
	if(get.indexOf('custom-media-upload=PP') + 1) {
		$('body').addClass('sg_load_box_ha');
		$('body').addClass('sg_load_box_hb');
		$('<input type="hidden" value="PP" name="custom-media-upload">').insertBefore('input[name=post_id]');
		$('#image-form').attr('action', $('#image-form').attr('action') + '&custom-media-upload=PP');
		$('#image-form').bind('ajaxComplete', sg_media_upload_PP);
		sg_media_upload_PP();
	}
	if(get.indexOf('custom-media-upload=PI') + 1) {
		$('body').addClass('sg_load_box_ha');
		$('body').addClass('sg_load_box_hb');
		$('<input type="hidden" value="PI" name="custom-media-upload">').insertBefore('input[name=post_id]');
		$('#image-form').attr('action', $('#image-form').attr('action') + '&custom-media-upload=PI');
		$('#image-form').bind('ajaxComplete', sg_media_upload_PI);
		sg_media_upload_PI();
	}
	if(get.indexOf('custom-media-upload=LFI') + 1) {
		$('body').addClass('sg_load_box_ha');
		$('<input type="hidden" value="LFI" name="custom-media-upload">').insertBefore('input[name=post_id]');
		$('#image-form').attr('action', $('#image-form').attr('action') + '&custom-media-upload=LFI');
		$('#image-form').bind('ajaxComplete', sg_media_upload_LFI);
		sg_media_upload_LFI();
	}
	
	SGSetSlideHTML = function(html, id){
		var cur = window.sg_current_upload_slide;
		var name = $('#' + cur).attr("rel");
		$('#' + cur).find('.sg-slide-img').html($(html).find('a').html() + '<input type="hidden" name="' + name + '[img]" value="' + id + '" />');
	};
	
	SGSetPatternHTML = function(html, id){
		var cur = window.sg_current_upload_slide;
		var name = $('#' + cur).attr("rel");
		var iname = name.split('[');
		var input = '<input type="radio" class="sg-pattern-top" value="' + id + '" name="' + iname[0] + '[value]">';
		input += '<input type="radio" class="sg-pattern-btm" value="' + id + '" name="' + iname[0] + '[value2]">';
		input += '<input type="hidden" name="' + name + '[img]" value="' + id + '" />';
		$('#' + cur).find('.sg-slide-img').html(html + input);
		$('#' + cur).find('.sg-slide-img').unbind('click');
		$('#' + cur).find('.sg-slide-img').removeClass().addClass('sg-slide-img-p');
		$('#' + cur).find('.sg-slide-img-p').click(function(e){
			var y = e.pageY - $(this).offset().top;
			if (y <= 90) {
				$(this).find('.sg-pattern-top').attr('checked', 'checked');
			} else {
				$(this).find('.sg-pattern-btm').attr('checked', 'checked');
			}
		});
	};
	
	SGTbRemove = function() {
		tb_remove();
	};
	
	SGSetThumbnailHTML = function(html){
		$('#' + window.sg_current_uid + '_img').html($(html).find('a').html());
		$('#' + window.sg_current_uid + '_clear').show();
	};

	SGRemoveThumbnail = function(){
		var nonce = window.sg_post_nonce;
		$.post(ajaxurl, {
			action:"set-post-thumbnail", post_id: $('#post_ID').val(), thumbnail_id: -1, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
		}, function(str){
			if (str == '0') {
				alert(setPostThumbnailL10n.error);
			} else {
				$('#' + window.sg_current_uid + '_img').html('');
			}
		}
		);
	};

});