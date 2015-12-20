jQuery(function($){

	var $win = $(window);
	var $body = $('body');

	$('#sf_font').after($('#sf_uppercase_chooser')).after($('#sf_font_weight_chooser')).after($('#sf_alignment_chooser')).after($('#sf_font_size'))

	$('#sf_font_size').after('<span style="margin-left: 5px">px</span><br>');

	$('.sf_font').find('p:empty').remove();

	$('.switcher').each(function(){
		$(this).after('<div><div></div></div>')
	})

	$('.postbox select').each(function(){
		var id = this.id
		$(this).wrap('<div class="select-wrapper" id="'+id+'-wrapper"></div>')
	})

	$('[id*=sf_width_panel_]').each(function(){
		var ind = this.id.replace('sf_width_panel_', '');
		var cl = $('#sf_color_panel_' + ind);
		var scl = $('#sf_scolor_panel_' + ind);
		var bg = $('#sf_bg_color_panel_' + ind)
		$(this).parent().append(bg).append(cl).append(scl);
		bg.before('<span>Background</span>');
		cl.before('<span>Text color</span>');
		scl.before('<span>Subheader color</span>');
	})

	$('#sf_sidebar_style').change(function(){
		var val = $(this).val();
		var $w = $(this).closest('.settings-form-row');

		$w.find('p[data-notice]').hide().end().find('[data-notice='+val+']').show();
	}).change()


	$('#sf-options-wrap form').on('submit', function(e){
		var p = $('.sf_display');
		var current = p.find('.loc_popup')
		var hidden = p.find('input:hidden');
		var user = current.find('select[id*=user_status]').val();
		var rule = current.find('select[id*=display_rule]').val();
		var desktop = current.find('select[id*=display_desktop]').val();
		var mobile = current.find('select[id*=display_mobile]').val();
		var ids = current.find('[id*=display_ids]').val();

		var resulted = {
			'user' : {
				'everyone' : user === 'everyone' ? 1 : 0,
				'loggedin' : user === 'loggedin' ? 1 : 0,
				'loggedout' : user === 'loggedout' ? 1 : 0
			},
			'desktop' : {
				'yes' : desktop === 'yes' ? 1 : 0,
				'no' : desktop === 'no' ? 1 : 0
			},
			'mobile' : {
				'yes' : mobile === 'yes' ? 1 : 0,
				'no' : mobile === 'no' ? 1 : 0
			},

			'rule' : {
				'include' : rule === 'include' ? 1 : 0,
				'exclude' : rule === 'exclude' ? 1 : 0
			},
			'location' : {
				'pages' : traversePages(current.find('input[id*=display_page]')),
				'cposts' : traversePages(current.find('input[id*=display_cpost]')),
				'cats' : traversePages(current.find('input[id*=display_cat]')),
				'taxes' : {},
				'langs' : traversePages(current.find('input[id*=display_lang]')),
				'wp_pages' : traversePages(current.find('input[id*=display_wp_page]')),
				'ids': ids.split(',')
			}
		};
		hidden.val(JSON.stringify(resulted));
		showLoadingView()
	})

	function traversePages(pages) {
		var res = {};

		pages.each(function(i, el){
			var t = $(el);
			var val = t.val();
			if (t.is(':checked')) res[val] = 1;
		});

		return res
	}

	function showLoadingView () {
		$('#fade-overlay').addClass('loading');
	}

	$body.addClass('page-loaded');

	function isScrolledIntoView($elem, elemTop, elemBottom, rule) {
		var docViewTop = $win.scrollTop();
		var docViewBottom = docViewTop + $win.height();

		return rule === 'after' ? docViewBottom > elemBottom + 50 : (elemBottom <= docViewBottom && elemTop >= docViewTop - 25) || (elemBottom > docViewBottom && elemTop < docViewTop - 25);
	}

	var state = 'in';
	var $tabs = $('#tabs-copy');
	var $or = $('#tabs');
	var $form = $('#sf-options-wrap form')

	$win.scroll(function(){

		var elemTop = $tabs.offset().top;
		var elemBottom = elemTop + $tabs.height();
		if (isScrolledIntoView($tabs,elemTop,elemBottom, 'in'))  {
			if (state !== 'in') {
				state = 'in';
				$or.removeClass('transition-in');
				setTimeout(function(){
					$body.removeClass('fixed-nav');
					$or.css({'width': '', left: ''});
				}, 50)
      }
		} else {
			if (state !== 'out') {
				state = 'out';
				$body.addClass('fixed-nav');
				$or.css({'width': $tabs.width(), left: $form.offset().left});
				setTimeout(function(){
					$or.addClass('transition-in');
				}, 100)
			}
		}

	});

	$win.resize(function(){
		if ($body.is('.fixed-nav')) {
			$or.css({'width': $tabs.width(), left: $form.offset().left})
		}
	})

	$or.find('li').not('#save-tab').click(function(){
		$('html,body').animate({
			scrollTop: 0
		}, 300);
	})

	$('#save-tab').click(function(){
		$(this).closest('form').submit();
	})


})