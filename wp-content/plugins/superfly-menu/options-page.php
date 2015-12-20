<div id="sf-options-wrap" class="widefat" style="opacity:0;">
	<script>
		var colorscheme = [
			'#c0392b',
			'a3503c',
			'925873',
			'927758',
			'589272',
			'588c92',
			'2bb1c0',
			'2b8ac0',
			'e96701',
			'c02b74'
		]
	</script>
<?php
function custom_do_settings_sections($page) {
	global $wp_settings_sections, $wp_settings_fields;

	if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
		return;

	foreach( (array) $wp_settings_sections[$page] as $section ) {
		echo "<div class='postbox' id='{$section['id']}'><h3 class='hndle'><span>{$section['title']}</span></h3>\n";
		call_user_func($section['callback'], $section);
		if ( !isset($wp_settings_fields) ||
			!isset($wp_settings_fields[$page]) ||
			!isset($wp_settings_fields[$page][$section['id']]) )
			continue;
		echo '<div class="settings-form-wrapper '. $section['id'] . '">';
		custom_do_settings_fields($page, $section['id']);
		echo "<input name='Submit' type='submit' id='sbmt_{$section['id']}' class='button-primary' value='Save Changes' />";
		echo '<div class="sbmt-bg"></div></div></div>';
	}
}

function custom_do_settings_fields($page, $section) {
	global $wp_settings_fields;

	if ( !isset($wp_settings_fields) ||
		!isset($wp_settings_fields[$page]) ||
		!isset($wp_settings_fields[$page][$section]) )
		return;

	foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
		if (!empty($field['args']['chapter'])) {
		   echo	'<h1>' . $field['args']['chapter'] . '</h1>';
		}
		echo '<div class="settings-form-row'. (!empty($field['args']['hidden']) ? ' hidden-row' : '') . ' ' . $field['id'] .'">';
		if ( !empty($field['args']['label_for']) ) {
			echo '<label for="' . $field['args']['label_for'] . '">' . $field['title'] . '</label><br />';
		}
		else {
			echo '<p class="field-title">' . $field['title'] . '</p>';
		}
		call_user_func($field['callback'], $field['args']);
		echo '</div>';
	}
}
screen_icon();
?>
<h2 class="form-title"><img src="<?php echo plugins_url('/img/', __FILE__); ?>logo.png" alt=""> Superfly 2 Settings </h2>
<form method="post" action="options.php" enctype="multipart/form-data">
	<ul id="tabs-copy" class="section-tabs"></ul>
	<ul id="tabs" class="section-tabs"></ul>
<?php settings_fields('sf_options'); ?>
<?php custom_do_settings_sections('sf'); ?>

</form>
	<div id="fade-overlay">
		<div class="svg-wrapper">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100px" height="120px" viewBox="0 0 100 120" style="enable-background:new 0 0 50 50;" xml:space="preserve">
    <rect x="0" y="0" width="10" height="35" fill="#333" transform="translate(0 19.2561)">
	    <animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 25; 0 0" begin="0" dur="0.6s" repeatCount="indefinite"></animateTransform>
    </rect>
				<rect x="20" y="0" width="10" height="35" fill="#333" transform="translate(0 5.92276)">
					<animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 25; 0 0" begin="0.2s" dur="0.6s" repeatCount="indefinite"></animateTransform>
				</rect>
				<rect x="40" y="0" width="10" height="35" fill="#333" transform="translate(0 7.41058)">
					<animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 25; 0 0" begin="0.4s" dur="0.6s" repeatCount="indefinite"></animateTransform>
				</rect>
  </svg>
		</div>

	</div>
		<a class="la" href="http://www.looks-awesome.com/"> <!--by Looks Awesome--></a>
</div>
<script type="text/javascript">

	    (function(){
		    var $ = window.jQuery;
		    var current;
		    var $tabs;
		    var $active;
		    var $content;
		    var $wrap;
		    var $saved;
		    var $sbmt;
		    var offset;
		    var $win;
		    var isLS = 'sessionStorage' in window && window['sessionStorage'] !== null;

		    if($ != null) {

			    $wrap = $('#sf-options-wrap')
			    $tabs = $('#tabs');
			    $win = $(window);

			    $(function(){

				    var map = {
					    'sf_source': 'display',
					    'sf_appearance': 'see',
					    'sf_menu_items': 'bars2',
					    'sf_label': 'diamonds',
					    'sf_advanced': 'more-2'
				    }

				    $('#sf-options-wrap .postbox').each(function(i ,el) {
					    var $t = $(this);
					    var id = $t.attr('id');
					    var txt = $t.find('h3').text();
					    var icon = '<i class="flaticon-' + map[id] + '"></i>';
					    var active = isLS && sessionStorage.getItem('sf-section') && id === sessionStorage.getItem('sf-section').replace('for_', '') ? 'active' : '';
					    $tabs.append('<li id="for_'+  id + '" class="'+ active + '">' + icon + ' <span data-hover="'+txt+'">' + txt + '</span></li>');
				    });

				    $tabs.append('<li id="save-tab"><span>Save Changes</span> <i class="flaticon-paperplane"></i></li>')


				    if (isLS) {

					    current = sessionStorage.getItem('sf-section');

					    $active = current ? $('#tabs li#' + current) : $('#tabs li:first');
					    $content = $wrap.find('#' + $active.attr('id').replace('for_', ''))

					    $content.add($active).addClass('active');

					    // chrome fix
//					    setTimeout(function(){$wrap.height($content.outerHeight() + 210)}, 500)

					    current = sessionStorage.getItem('sf-section-scroll');

					    if (current) {
						    $('html, body').scrollTop(current)
					    }

				    }

				    $tabs.find('li').not('#save-tab').click(function () {
					    var $t = $(this);
					    var $content = $('#sf-options-wrap #' + $t.attr('id').replace('for_', ''));

					    if ($saved) $saved.hide();

					    $wrap.find('.postbox, #tabs li' ).removeClass('active');
					    $t.add($content).addClass('active');

					    if (isLS) {
						    sessionStorage.setItem('sf-section', $t.attr('id'));
					    }

				    })

				    /*var lastFocusTextarea = false;

				    $wrap.find('textarea').focus(function (e) {
					    $(this).addClass('focus');
					    var c = $wrap.height()
					    if (!lastFocusTextarea) $wrap.height(c + 240)
					    lastFocusTextarea = true;
				    }).blur(function () {
					    var $t = $(this);
					    setTimeout(function () {
						    var target = document.activeElement;

						    if ($(document.activeElement).is('button')) return;

						    var c = $wrap.height()
						    if (!lastFocusTextarea) $wrap.height(c - 240);
						    lastFocusTextarea = true;
						    $t.removeClass('focus');

						    if (!$(target).is('textarea')) {
							    var c = $wrap.height()
							    $wrap.height(c - 240);
							    lastFocusTextarea = false
						    }
					    }, 1);
				    })*/

				    if (isLS) {
					    $(window).unload(function (e) {
						    sessionStorage.setItem('sf-section-scroll', $('body').scrollTop() || $('html').scrollTop());
					    });

					    $wrap.find(':submit').click(function(){
						    sessionStorage.setItem('sf-section-submit', $(this).attr('id'));
					    });

					    if (sessionStorage.getItem('sf-section-submit')) {
						    //$saved = $('<div id="saved"> Saved!</div>');
						    $sbmt = $('#' + sessionStorage.getItem('sf-section-submit'));

						    if ($sbmt.length) {
							    //$('body').append($saved);
							    //offset = $sbmt.offset();
							   // setTimeout(function(){$saved.addClass('hide')}, 1000);

							   // $saved.css({top: offset.top + 5, left: $sbmt.outerWidth() + offset.left + 10})

						    }
						    sessionStorage.setItem('sf-section-submit', '');

					    }

				    }

				    $wrap.css('opacity', 1);

			    });

		    } else {
			    document.getElementById('sf-options-wrap').style.opacity = 1;
		    }
	    }())
</script>
