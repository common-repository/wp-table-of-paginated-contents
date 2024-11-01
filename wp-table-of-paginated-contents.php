<?php
/*
Plugin Name: WP Table of Paginated Contents
Plugin URI: http://antonioandra.de/
Description: Handles naming of each post page through a TinyMCE button and produces a Table of Contents for the said post.
Version: 2.1
Author: António Andrade
Author URI: http://antonioandra.de
License: GPL2
*/
/*  Copyright 2012-2016  António Andrade  (email : antonio@antonioandra.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("WPtopc")) {
	class WPtopc {
		function WPtopc() {
			}
		function init(){
			# set locale
			/*$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/lang/wp-table-of-paginated-contents-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('wp-htaccess-control', $moFile);
				}*/
			}
		function check_first_run(){

			}
		function section_title_sortcode( $atts ) {
			extract( shortcode_atts( array('title' => ''), $atts ) );
			return;
			}
		function get_current_page(){
			global $wp_query;
			return $wp_query->query_vars['page'];
			}
		function get_section_titles(){
			global $post;
			$first_divider=strpos( $post->post_content, '<!--nextpage-->' );
			if($first_divider>0){
				preg_match_all('/<!--nextpage-->\s*\[section_title title\="?([^"]*)"?\]|(<!--nextpage-->)/', substr( $post->post_content, $first_divider), $page_dividers);

				$first_section=Array();
				if(count($page_dividers)){
					preg_match('/\[section_title title\="?([^"]*)"?\]/', substr( $post->post_content, 0, $first_divider), $first_title);
					$first_section[0]=empty($first_title[1])?__('Intro','WPtopc'):trim($first_title[1]);
					}

				return array_merge($first_section, $page_dividers[1]);
				}
			}
		function get_post_page_link($page){
			preg_match('/href\=\"(.*)\"/', _wp_link_page($page), $l);
			return $l[1];
			}
		function the_table($format, $prepend="", $append=""){
			echo $this->get_the_table($format, $prepend, $append);
			}
		function get_the_table($format, $prepend="", $append=""){
			global $post;

			$output="";

			$current_page=$this->get_current_page();
			$page_dividers=$this->get_section_titles();
			if(count($page_dividers)){
				$output=$prepend;
				switch($format){
					case "select":
						$output .= "<select class='table-of-paginated-contents' onchange='document.location.href=this.value'>";
						foreach($page_dividers as $k=>$title){
							$page_link=$post->permalink;
							if($current_page==($k+1)||($current_page==0&&$k==0)){
								$class="class='current_page' selected='selected'";
								}
							else{
								unset($class);
								}
							$output .= "<option value='".$this->get_post_page_link($k+1)."' ".$class.">".(trim($title)!=""?$title:__("Page","WPtopc")." ".($k+1))."</option>";
							}
						$output .= '</select>';
						break;
					case "list":
					default:
						$output .= '<ul class="table-of-paginated-contents">';
						foreach($page_dividers as $k=>$title){
							$page_link=$post->permalink;
							if($current_page==($k+1)||($current_page==0&&$k==0)){
								$class="class='current_page'";
								}
							else{
								unset($class);
								}
							$output .= "<li><a href='".$this->get_post_page_link( $k+1 )."' ".$class.">".(trim($title)!=""?$title:__("Page","WPtopc")." ".($k+1))."</a></li>";
							}
						$output .= '</ul>';
					}
				$output.=$append;
				}
			return $output;
			}
		function pagination_links($prepend='', $append='', $left='« ', $right=' »', $separator=' | '){echo $this->get_pagination_links($prepend, $append, $left, $right, $separator);}
		function get_pagination_links($prepend='', $append='', $left='« ', $right=' »', $separator=' | '){

			$output='';

			$current_page=$this->get_current_page();
			$page_dividers=$this->get_section_titles();

			if(count($page_dividers)){
				$output=$prepend;
				if($current_page>1){
					$prev=$current_page-1;
					$output .= substr(_wp_link_page( $prev ),0,-1).' class="previous-link">'.$left.($page_dividers[$prev-1]!=''?$page_dividers[$prev-1]:__('Page','WPtopc').' '.($prev)).'</a>';
					}
				if($current_page>1 && $current_page<count($page_dividers)){
					$output .= $separator;
					}
				if($current_page<count($page_dividers)){
					$next=$current_page+1==1?2:$current_page+1;
					$output .= substr(_wp_link_page( $next ),0,-1).' class="next-link">'.($page_dividers[$next-1]!=''?$page_dividers[$next-1]:__('Page','WPtopc').' '.($next)).$right.'</a>';
					}
				$output.=$append;
				}
			return $output;
			}
		function add_tiny_mce_btn() {
		   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
				return;
		   if ( get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array(&$this,'add_tiny_mce_plugin'));
				add_filter('mce_buttons', array(&$this,'register_tiny_mce_btn'));
				}
			}
		function register_tiny_mce_btn($buttons) {
			array_push($buttons, "|", "WPtopc");
			return $buttons;
			}
		function add_tiny_mce_plugin($plugin_array) {
			$plugin_array['WPtopc'] =  plugin_dir_url( __FILE__ ). '/wp-table-of-paginated-contents-tinyMCE-plugin.js';
			return $plugin_array;
			}
		function configure_menu(){
			if(current_user_can("administrator")){
				$page=add_submenu_page("options-general.php","WP Table of Paginated Contents", "Table of Paginated Contents", 6, __FILE__, array('WPtopc','wptopc_page'));
				add_action('admin_print_scripts-'.$page, array('WPtopc','wptopc_page_script'));
				add_action('admin_print_styles-'.$page, array('WPtopc','wptopc_page_style'));
				}
			}
		function wptopc_page_script(){
			wp_enqueue_script("table-of-paginated-contents-js", WP_PLUGIN_URL . '/wp-table-of-paginated-contents/wp-table-of-paginated-contents-ui.js');
			}
		function wptopc_page_style(){
			wp_enqueue_style("table-of-paginated-contents-css", WP_PLUGIN_URL . '/wp-table-of-paginated-contents/wp-table-of-paginated-contents-ui.css');
			}
		function wptopc_page(){
			include (dirname (__FILE__).'/wp-table-of-paginated-contents-ui.php');
			}
		function wptopc_page_action(){
			$this->check_first_run();
			$action=$_REQUEST['action'];
			global $echo;
			if(isset($action)){
				$WPtopc_data=get_option('WPtopc_data');
				switch($action){
					case 'hide_donation_message':
						$WPtopc_data['donation_hidden_time']=time()+ 90 * 24 * 60 * 60;
						update_option('WPtopc_data',$WPtopc_data);
						break;
					default:
						break;
					}
				}
			}
		}
	}
if (class_exists("WPtopc")) {
	$WPtopc = new WPtopc();
	}
if (isset($WPtopc)) {
	add_action('init', array($WPtopc,'init'));
	add_action('init', array($WPtopc,'add_tiny_mce_btn'));
	add_shortcode( 'section_title', array($WPtopc,'section_title_sortcode') );
	add_action('wptopc', array($WPtopc,'the_table'),10,3);
	add_action('wptopc_pagination_links', array($WPtopc,'pagination_links'),10,2);
	add_action('admin_menu', array($WPtopc,'configure_menu'));

	function wptopc($format='', $prepend='', $append='') {
		do_action('wptopc', $format, $prepend, $append);
		}
	function get_wptopc($format="", $prepend='', $append='') {
		$topc=new WPtopc();
		return $topc->get_the_table($format, $prepend, $append);
		}
	function wptopc_pagination_links($prepend='', $append='', $left='« ', $right=' »', $separator=' | ') {
		do_action('wptopc_pagination_links', $prepend, $append, $left, $right, $separator);
		}
	function get_wptopc_pagination_links($prepend='', $append='', $left='« ', $right=' »', $separator=' | ') {
		$topc=new WPtopc();
		return $topc->get_pagination_links($prepend, $append, $left, $right, $separator);
		}
	}

?>
