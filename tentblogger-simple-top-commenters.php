<?php
/*
Plugin Name: TentBlogger Simple Top Commenters
Plugin URI: http://tentblogger.com/top-commenters/
Description: Want to show a list of the top commenters on your blog? This lightweight, simple, and customizable plugin is it!
Version: 2.3
Author: TentBlogger
Author URI: http://tentblogger.com
Author Email: info@tentblogger.com
License:

    Copyright 2011 - 2012 TentBlogger (info@tentblogger.com)

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


class TentBlogger_Simple_Top_Blog_Commenters extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
	function TentBlogger_Simple_Top_Blog_Commenters() {
	
		$widget_opts = array (
			'classname' => 'tentblogger-top-commenters',
			'description' => __('Want to show a list of the top commenters on your blog? This lightweight, simple, and customizable plugin is it!', 'tentblogger-simple-top-commenters')
		);		
		
		$this->WP_Widget('tentblogger-top-commenters', __('TentBlogger Top Commenters', 'tentblogger-top-commenters'), $widget_opts);
		load_plugin_textdomain('tentblogger-top-commenters', false, dirname(plugin_basename( __FILE__ ) ) . '/lang/' );
		$this->register_scripts_and_styles();
		
	} // end constructor

	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance
	 */
	function widget($args, $instance) {
	
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		
		$widget_title = empty($instance['widget_title']) ? '' : apply_filters('widget_title', $instance['widget_title']);
		$hyperlink_commenter = empty($instance['hyperlink_commenter']) ? '' : apply_filters('hyperlink_commenter', $instance['hyperlink_commenter']);
		$display_gravatar = empty($instance['display_gravatar']) ? '' : apply_filters('display_gravatar', $instance['display_gravatar']);
		$hide_comment_count = empty($instance['hide_comment_count']) ? '' : apply_filters('hide_comment_count', $instance['hide_comment_count']);
		$date_range = empty($instance['date_range']) ? '' : apply_filters('widget_title', $instance['date_range']);
			
		if($date_range == 'monthly') {
			$date_range = "DATE_FORMAT(comment_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
		} else if($date_range == 'weekly') {
			$date_range = "DATE_FORMAT(comment_date, '%Y-%v') = DATE_FORMAT(CURDATE(), '%Y-%v')";
		} else if($date_range == 'alltime') {
			$date_range = "1=1";
		} else {
			$date_range = "1=1";
		} // end if/else
		
		$commenters = $this->query_for_commenters($date_range);
		
		// Grab the HTML content for the widget
		include(WP_PLUGIN_DIR . '/tentblogger-simple-top-blog-commenters/views/widget.php');
		
		echo $after_widget;
		
	} // end widget
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		
		$instance['widget_title'] = $this->strip($new_instance, 'widget_title');
		$instance['hyperlink_commenter'] = $this->strip($new_instance, 'hyperlink_commenter');
		$instance['display_gravatar'] = $this->strip($new_instance, 'display_gravatar');
		$instance['hide_comment_count'] = $this->strip($new_instance, 'hide_comment_count');
		$instance['date_range'] = $this->strip($new_instance, 'date_range');
		
		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {
	
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'widget_title' => '',
				'date_range' => 'alltime',
				'hyperlink_commenter' => '',
				'display_gravatar' => '',
				'hide_comment_count' => ''
			)
		);
	
		$widget_title = $this->strip($instance, 'widget_title');
		$date_range = $this->strip($instance, 'date_range');
		$hyperlink_commenter = $this->strip($instance, 'hyperlink_commenter');
		$display_gravatar = $this->strip($instance, 'display_gravatar');
		$hide_comment_count = $this->strip($instance, 'hide_comment_count');
		
		// Grab the HTML content for the form
		include(WP_PLUGIN_DIR . '/tentblogger-simple-top-blog-commenters/views/admin.php'); 
		
	} // end form
	
	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/
	
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if(is_admin()) {
			$this->load_file('tentblogger-top-commenters', '/tentblogger-simple-top-blog-commenters/css/admin.css');
		} else { 
			$this->load_file('tentblogger-top-commenters', '/tentblogger-simple-top-blog-commenters/css/widget.css');
		} // end if/else
	} // end register_scripts_and_styles

	/**
	 * Helper function for registering and loading scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {
		$url = WP_PLUGIN_URL . $file_path;
		$file = WP_PLUGIN_DIR . $file_path;
		if(file_exists($file)) {
			if($is_script) {
				wp_register_script($name, $url);
				wp_enqueue_script($name);
			} else {
				wp_register_style($name, $url);
				wp_enqueue_style($name);
			} // end if
		} // end if
	} // end load_file
	
	/**
	 * Convenience method for stripping tags and slashes from the content
	 * of a form input.
	 *
	 * @obj			The instance of the argument array
	 * @title		The title of the element from which we're stripping tags and slashes.
	 */
	private function strip($obj, $title) {
		return strip_tags(stripslashes($obj[$title]));
	} // end strip
	
	/**
	 * Queries the database to return the top commenters.
	 * 
	 * @date_range	The range of dates from which to pull commenters
	 * @commenters	The array of commenters.
	 */
	private function query_for_commenters($date_range) {
		
		$commenters = null;
		
		$author_names = 
			"'" . get_the_author_meta('user_login') . "', " .
			"'" . get_the_author_meta('user_login') . "', " .
			"'" . get_the_author_meta('display_name') . "', " .
			"'" . get_the_author_meta('user_firstname') . "', " .
			"'" . get_the_author_meta('user_lastname') . "'";
			
		global $wpdb;
		$commenters = $wpdb->get_results("
			select count(comment_author) as comment_comments, comment_author,
			comment_author_url, comment_author_email
			from $wpdb->comments
			where comment_type != 'pingback'
			and comment_author != ''
			and comment_author not in ($author_names)
			and comment_approved = '1'
			and $date_range
			group by comment_author
			order by comment_comments desc, comment_author
		");
		
		return $commenters;
		
	} // end query_for_commenters
	
} // end class
add_action('widgets_init', create_function('', 'register_widget("TentBlogger_Simple_Top_Blog_Commenters");'));
?>