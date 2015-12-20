<?php
/*
  Plugin Name: Newsletter+ Widget
  Description: A Simple yet powerfull Widget to allow users to subscribe to your newsletter via Newsletter+ Software
  Author: Plus Software
  Author URI: http://psoftware.net/
  Plugin URI: http://newsletterplus.net/main/wordpress
  Version: 1.0
  Tested up to: 4.2.2

 */

/*

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


add_action('widgets_init', 'register_Newsletter_widget');

function register_Newsletter_widget() {
    register_widget('Newsletter_Widget');
}

/**
 * Adds Newsletter_Widget widget.
 */
class Newsletter_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'newsletter_widget', // Base ID
                'Newsletter+ Widget', // Name
                array('description' => __('A simple Widget to integrate Newsletter+ Software', 'newsletterwidget'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        if (preg_match('/https/', $instance['npsurl'])) {
            $action_url = 'https://' . str_replace('//', '/', str_replace('https://', '', $instance['npsurl']) . '/forms/subscribe/' . $instance['formid']);
        } else {
            $action_url = 'http://' . str_replace('//', '/', str_replace('http://', '', $instance['npsurl']) . '/forms/subscribe/' . $instance['formid']);
        }
        
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>

        <script type="text/javascript">


            function validate_nps_form() {

                var email_id = document.getElementById('subscriber-email').value;

                var filter = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

                valid = String(email_id).search(filter) != -1;

                if (!valid) {

                    alert('Please enter a valid email address');

                    return false;
                }
                else {
                    return true;
                }
            }


        </script>

        <form id="subscribe-form" onsubmit="return  validate_nps_form()" action="<?php echo $action_url; ?>" method="POST" accept-charset="utf-8">
		<p class="newsletter-description">Subscribe to the DiRocco newsletter to receive exclusive shop news, announcements and updates.</p>
            <!--<?php if ($instance['hidename'] != 'on') { ?>
            <input type="text" name="fname" id="subscriber-name"/>
            <?php } ?>-->
            <input type="text" name="email" id="subscriber-email"/>
            <!--<input type="submit" name="sub-submit" value="Subscribe"  id="sub-submit"/>-->
            <div class="resp"></div>
        </form>




        <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['npsurl'] = strip_tags($new_instance['npsurl']);
        $instance['formid'] = strip_tags($new_instance['formid']);
        $instance['hidename'] = strip_tags($new_instance['hidename']);

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __(' ', 'newsletterwidget');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Heading:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p><p>
            <label for="<?php echo $this->get_field_id('npsurl'); ?>"><?php _e('Newsletter+ Url:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('npsurl'); ?>" name="<?php echo $this->get_field_name('npsurl'); ?>" type="text" value="<?php echo esc_attr($instance['npsurl']); ?>" />
        </p><p>
            <label for="<?php echo $this->get_field_id('formid'); ?>"><?php _e('Form ID:'); ?></label>
            <input class="text" id="<?php echo $this->get_field_id('formid'); ?>" name="<?php echo $this->get_field_name('formid'); ?>" type="text" value="<?php echo esc_attr($instance['formid']); ?>" />
        </p><p>

            <input class="checkbox" id="<?php echo $this->get_field_id('hidename'); ?>" name="<?php echo $this->get_field_name('hidename'); ?>" type="checkbox"  <?php echo ($instance['hidename'] == 'on') ? 'checked="checked"' : ''; ?>  />
            <label for="<?php echo $this->get_field_id('hidename'); ?>"><?php _e('Hide Name'); ?></label>

        </p>
        <?php
    }

}

// class Newsletter_Widget


