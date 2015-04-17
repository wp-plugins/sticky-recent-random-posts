<?php

/*
Plugin Name: Sticky Recent Random Posts
Plugin URI: http://www.offersday.in
Description: This plugin will show random recent post as sticky bar. you can customize color and other properties of sticky bar.
Version: 1.0
Author: Mahavir Nahata
Author URI: www.offersday.in
License: GPL2
*/

/*  Copyright 2015  Mahavir Nahata (email : mahavirnahata@gmail.com)

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

function mn_plugin_activation()
{
  $default_options=array("mn_wrapper_background_color"=>"#000000","mn_wrapper_border_color"=>"#24B6AC","mn_wrapper_background_color_opacity"=>"0.6","mn_title_text_color"=>"#ffffff","mn_trending_now_text"=>"Trending Now : ","mn_trending_now_text_color"=>"#ff8b02","mn_open_link_in"=>"_blank","mn_number_of_posts"=>"10","mn_post_types"=>array('post'=>'post'));
  update_option('mn_sticky_recent_posts', serialize($default_options));
}
register_activation_hook(__FILE__,'mn_plugin_activation');

function mn_add_menu_to_settings()
{
	add_options_page( 'Sticky Recent Random Posts', 'Sticky Random Recent Posts', 'manage_options', 'mn-customize-random-posts', 'mn_display_custom_page_content' );
}

function mn_display_custom_page_content()
{
	if(isset($_POST) && isset($_POST['mn_post_data']))
	{
		$intermediate_data=serialize($_POST);
		update_option('mn_sticky_recent_posts', $intermediate_data);
		echo "<div id='mn_message'>Options upated successfully.!!</div>";
	}
	$get_saved_data=get_option('mn_sticky_recent_posts');
	$get_saved_data=unserialize($get_saved_data);
	$available_post_types=get_post_types(array('public'=>true,'_builtin' => false));
	?>
	<form method="post" id="mn_settings_form">	
	<legend>Update Sticky Recent Random Posts Settings From Here.</legend>
	<table>	
	<input type="hidden" name="mn_post_data">
		<tr class="mn_individual_block">
			<td><label for="mn_wrapper_background_color">Select Background Color : </label></td><td> <input type="text" class="mn_color_picker" name="mn_wrapper_background_color" value="<?php echo $get_saved_data['mn_wrapper_background_color'];?>" id="mn_wrapper_background_color"></td>
		</tr>	

		<tr class="mn_individual_block">
			<td><label for="mn_wrapper_border_color">Select Top Border Color : </label> </td><td><input type="text" class="mn_color_picker" name="mn_wrapper_border_color" value="<?php echo $get_saved_data['mn_wrapper_border_color'];?>" id="mn_wrapper_border_color"></td>
		</tr>			

		<tr class="mn_individual_block">
			<td><label for="mn_wrapper_background_color_opacity">Select Background Color Opacity(Between 0.00 To 1.0) : </label></td><td> <input type="text" name="mn_wrapper_background_color_opacity" value="<?php echo $get_saved_data['mn_wrapper_background_color_opacity'];?>" id="mn_wrapper_background_color_opacity"></td>
		</tr>	

		<tr class="mn_individual_block">
			<td><label for="mn_title_text_color">Select Title Text Color : </label></td><td> <input type="text" class="mn_color_picker" name="mn_title_text_color" value="<?php echo $get_saved_data['mn_title_text_color'];?>" id="mn_title_text_color"></td>
		</tr>		

		<tr class="mn_individual_block">
			<td><label for="mn_trending_now_text">Type Trending Now Text : </label></td><td> <input type="text" name="mn_trending_now_text" value="<?php echo $get_saved_data['mn_trending_now_text'];?>" id="mn_trending_now_text"></td>
		</tr>		
		
		<tr class="mn_individual_block">
			<td><label for="mn_trending_now_text_color">Trending Now Text Color : </label></td><td> <input type="text" class="mn_color_picker"  name="mn_trending_now_text_color" value="<?php echo $get_saved_data['mn_trending_now_text_color'];?>" id="mn_trending_now_text_color"></td>
		</tr>	

		<tr class="mn_individual_block">
			<td><label for="mn_open_link_in">Open Link In : </label></td><td> <select name="mn_open_link_in" id="mn_open_link_in">
				<option <?php if($get_saved_data['mn_open_link_in']=='_blank') echo "selected";?> value="_blank">New Window</option>
				<option <?php if($get_saved_data['mn_open_link_in']=='_self') echo "selected";?> value="_self">Self</option>
			</select></td>
		</tr>	

		<tr class="mn_individual_block">
			<td><label for="mn_number_of_posts">Number Of Posts To Shuffle : </label></td><td> <input type="text" name="mn_number_of_posts" value="<?php echo $get_saved_data['mn_number_of_posts'];?>" id="mn_number_of_posts"></td>
		</tr>

		<tr class="mn_individual_block">
			<td><label for="mn_post_type">Select Post Type To Include : </label> </td>
			<td><input type="checkbox" name="mn_post_types[post]" value="post" id="mn_post_type_post" <?php if($get_saved_data["mn_post_types"]["post"]=="post") echo "checked";?> > <label for="mn_post_type_post">post</label>

				<?php foreach($available_post_types as $pt ) { ?>
				<input type="checkbox" name="mn_post_types[<?php echo $pt;?>]" value="<?php echo $pt;?>" id="mn_post_type_<?php echo $pt;?>" <?php if($get_saved_data["mn_post_types"]["{$pt}"]=="{$pt}") echo "checked";?> > <label for="mn_post_type_<?php echo $pt;?>"><?php echo $pt;?></label>
			<?php }?>
			</td>
		</tr>
		<tr  class="mn_individual_block">
		<td colspan="2"><input type="submit" value="Update Options" id="mn_submit_form"></td>
		</tr>

		</table>
	</form>

<?php }
add_action('admin_menu','mn_add_menu_to_settings');

add_action( 'admin_enqueue_scripts', 'mn_add_color_picker' );

function mn_add_color_picker( $hook ) {
		wp_enqueue_style('mn_arp_style',plugins_url('sticky-recent-random-posts.css',__FILE__)); 
        wp_enqueue_style('wp-color-picker'); 
        wp_enqueue_script('mn_arp_script', plugins_url('sticky-recent-random-posts.js', __FILE__ ),array('wp-color-picker'),false,true); 
}

function mn_add_sticky_to_footer() {
	$get_saved_data=get_option('mn_sticky_recent_posts');
	$get_saved_data=unserialize($get_saved_data);

$suffle_number=$get_saved_data["mn_number_of_posts"]-1;

$mn_offset=rand(0,$suffle_number);
$mn_query_args = array(
    'numberposts' => 1,
    'offset'=>$mn_offset,
    'orderby' => 'post_date',
    'order' => 'DESC',			
    'post_type' => $get_saved_data["mn_post_types"],	
    'post_status' => 'publish',
    'suppress_filters' => true );

$mn_recent_posts = wp_get_recent_posts($mn_query_args,ARRAY_A);
if(!empty($mn_recent_posts))
{
$mn_title_url=get_permalink($mn_recent_posts[0]["ID"]);
$mn_message='<span id="mn_trending_now_container">'.$get_saved_data["mn_trending_now_text"].'</span> <span id="mn_random_post_title">'.$mn_recent_posts[0]["post_title"].'</span>';

$html_str=<<<MKN
 <style type="text/css">
    #mn_sticky_bar_wrapper
    {
    	  background-color: {$get_saved_data["mn_wrapper_background_color"]};
    	  opacity: {$get_saved_data["mn_wrapper_background_color_opacity"]};
		  position: fixed;
		  width: 100%;
		  bottom: 0px;
		  left: 0%;
		  height: auto;
		  text-align: center;
		  padding: 6px 3px;
		  border-top: 2px solid {$get_saved_data["mn_wrapper_border_color"]};
		  z-index: 999999;
    }
    #mn_sticky_bar_title_anchor {
	  color: {$get_saved_data["mn_title_text_color"]};
	  text-align: center;
	  font-size: 20px;
	  font-weight: bold;
	  text-decoration: none !important;
	}
	#mn_trending_now_container
	{
		color: {$get_saved_data["mn_trending_now_text_color"]};
	}
	    </style>
	     <div id="mn_sticky_bar_wrapper">
		<a href="{$mn_title_url}" target="{$get_saved_data['mn_open_link_in']}" id="mn_sticky_bar_title_anchor">{$mn_message}</a>
	</div>
MKN;
echo $html_str;	
}
}
add_action('wp_footer', 'mn_add_sticky_to_footer');
?>