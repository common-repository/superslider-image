<?php
/*
Copyright 2008 daiv Mowbray

This file is part of SuperSlider-Image

SuperSlider-Image is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

SuperSlider-Image is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	
   
	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider-image' ) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('ssImage_options');
			$ssmOldOptions = array(
			 	'order'      => 'ASC', 
			    'orderby'    => 'menu_order',
				'size'        => "medium",
				'image_link'     => "on",
				'link_type'     => "large",
				'caption'  => "on",
				'lightbox' => "on",
				'limit' => "1",
				'align' => 'center',
				'random' => 'on',
			    'random_cat' => 'on',
				'image_frame' => 'on',
				'add_text_editor' => 'on',
				'text_editor_content' => '[image]',
				'image_class' => '',
				'link_class' => '',
				'delete_options' => '');
			update_option('ssImage_options', $ssmOldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Image Default Options reloaded.', 'SuperSlider-Image' ) . '</strong></p></div>';
			
		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'update' ) {
			
			check_admin_referer('ssImage_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Image Options saved.', 'SuperSlider-Image' ) . '</strong></p></div>';
			
			$ssmNewOptions = array(
				'size'      => $_POST['op_size'],
				'image_link' => isset($_POST['op_image_link']) ? $_POST["op_image_link"] : "",
				
				'order'	=> $_POST['op_order'],
				'orderby'	=> $_POST['op_orderby'],
				'link_type'	=> $_POST['op_link_type'],
				'caption' => isset($_POST['op_caption']) ? $_POST["op_caption"] : "",
				'lightbox' => isset($_POST['op_lightbox']) ? $_POST["op_lightbox"] : "",
				'limit'		=> $_POST['op_limit'],
				'align'     => $_POST['op_align'],
				'random' => isset($_POST['op_random']) ? $_POST["op_random"] : "",
				
				'lightbox' => isset($_POST['op_lightbox']) ? $_POST["op_lightbox"] : "",
				'random_cat' => isset($_POST['op_random_cat']) ? $_POST["op_random_cat"] : "",
				'image_frame' => isset($_POST['op_image_frame']) ? $_POST["op_image_frame"] : "",				
				'add_text_editor' => isset($_POST['op_add_text_editor']) ? $_POST["op_add_text_editor"] : "",				
				'text_editor_content' => $_POST['op_text_editor_content'],
				'image_class'         => $_POST['op_image_class'],
				'link_class'          => $_POST['op_link_class'],
				'delete_options' => isset($_POST['op_delete_options']) ? $_POST["op_delete_options"] : ""
			);	

        update_option('ssImage_options', $ssmNewOptions);
		
		// from here		
		}elseif (isset($_POST['proaction']) && $_POST['proaction'] == 'updatepro' ) {
			
			check_admin_referer('ssPro_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Pro Options saved.', 'superslider' ) . '</strong></p></div>';
			
			
			$ssPro_newOptions = array(				
				'pro_code' => isset($_POST['op_pro_code']) ? $_POST["op_pro_code"] : ""
				);
			update_option('ssPro_options', $ssPro_newOptions);
	
		}

		$ssPro_newOptions = get_option('ssPro_options'); 
		$ispro = '';
		if($ssPro_newOptions['pro_code'] == "We are all beautiful creative people")$ispro = true;

		$ssmNewOptions = get_option('ssImage_options');   

	/**
	*	Let's get some variables for multiple instances
	*/
    //$trans_type = attribute_escape(get_option('ssm_trans_type'));
    
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
	$plugin_name = 'superslider-image';

    global $wp_version;    
        // is not version 3+
         if (version_compare($wp_version, '3', "<")) {
            $size_names = array('thumbnail' => 'thumbnail', 'medium' => 'medium', 'large' => 'large', 'full' => 'full');
            if (function_exists('add_theme_support')) $size_names['post-thumbnail'] = 'post-thumbnail'; 
            if (class_exists("ssShow")) { $size_names['slideshow'] = 'slideshow'; $size_names['minithumb'] = 'minithumb';}
            if (class_exists("ssExcerpt")) $size_names['excerpt'] = 'excerpt'; 
            if (class_exists("ssPnext")) $size_names['prenext'] = 'prenext'; 
 /*
    * This is where you'd add any other image sizes for pre WP 3.0
    */      
       } else {    
            $size_names =  get_intermediate_image_sizes();// this only works with WP version 3+

            $size_names[] = 'full'; // adds original / full sized image to list

       }

?>

<div class="wrap">
<div class="ss_column1">
    
<form name="ssImage_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssImage_options'); echo "\n"; ?>
		
<div style="">

<a href="http://superslider.daivmowbray.com/">
<img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-image/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Image Options</h2>
    
</div>
 <br style="clear:both;" />
 
 <script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function ($) {

	$(function() {
        $( "#ssslider" ).tabs();
    });
});	
// ]]>
</script>
 
<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">
        
        <li class="ui-tabs-selected"><a href="#fragment-1"><span><?php _e('Shortcode',$plugin_name); ?></span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-2"><span><?php _e('Links',$plugin_name); ?></span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-3"><span><?php _e('Random',$plugin_name); ?></span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-4"><span><?php _e('Display',$plugin_name); ?></span></a></li>
  		<li class="ui-tabs-selected"><a href="#fragment-5"><span><?php _e('Shortcode Info',$plugin_name); ?></span></a></li>
  		
    </ul>
    
    <div id="fragment-1" class="ss-tabs-panel">
	<h3 class="title">Options</h3>
    
        <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- ToolTip options start -->
   <legend><b><?php _e('Image Options',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    
    <li>
    	<label for="op_add_text_editor"><input type="checkbox" 
    	<?php if($ssmNewOptions['add_text_editor'] == "on") echo $checked; ?> name="op_add_text_editor" id="op_add_text_editor"/>
    	<?php _e('New posts will have the [image] shortcode added to the text editor automatically.'); ?></label>
    </li>
    <li>        
    <table style="margin: 20px 0px;">
	<tr>
		<td style="width:120px;"><label for="op_text_editor_content" ><?php _e('Text editor content',$plugin_name); ?>:</label></td>
		<td><input type="text" name="op_text_editor_content" id="op_text_editor_content" size="30" maxlength="200" 
     value="<?php echo ($ssmNewOptions['text_editor_content']); ?>"/>
     <small><?php _e('content to appear in new posts. eg: [image ]',$plugin_name); ?></small></td>
	</tr>
	<tr>
		<td><label for="op_image_class" ><?php _e('Extra image class',$plugin_name); ?>:</label> </td>
		<td><input type="text" name="op_image_class" id="op_image_class" size="30" maxlength="200" 
     value="<?php echo ($ssmNewOptions['image_class']); ?>"/>
     <small><?php _e('Add an extra class to your image.',$plugin_name); ?></small></td>
	</tr>
	<tr>
		<td><label for="op_link_class" ><?php _e('Extra link class',$plugin_name); ?>:</label> </td>
		<td><input type="text" name="op_link_class" id="op_link_class" size="30" maxlength="200" 
     value="<?php echo ($ssmNewOptions['link_class']); ?>"/>
     <small><?php _e('Add a class to your link.',$plugin_name); ?></small></td>
	</tr>
    </table>
         
     </li>
    </ul>

</div><!-- close frag 1 -->  

    <div id="fragment-2" class="ss-tabs-panel">
	<h3 class="title">Link Options</h3>
    
        <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   <legend><b><?php _e('Image Link Options',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">

    <li>
    	<label for="op_image_link"><input type="checkbox" 
    	<?php if($ssmNewOptions['image_link'] == "on") echo $checked; ?> name="op_image_link" id="op_image_link"/>
    	<?php _e('Image link on. Adds a link to the image.',$plugin_name); ?></label>
    </li>
    
    <li>
    	<label for="op_caption"><input type="checkbox" 
    	<?php if($ssmNewOptions['caption'] == "on") echo $checked; ?> name="op_caption" id="op_caption"/>
    	<?php _e('Image caption on. Adds the caption to a p tag bellow the image.',$plugin_name); ?></label>
    </li>
    
    <li>
    	<label for="op_lightbox"><input type="checkbox" 
    	<?php if($ssmNewOptions['lightbox'] == "on") echo $checked; ?> name="op_lightbox" id="op_lightbox"/>
    	<?php _e('Image lightbox on. Adds rel="lightbox:post-ID" to the image link.',$plugin_name); ?></label>
    </li>
        <li>
    	<label for="op_image_frame"><input type="checkbox" 
    	<?php if($ssmNewOptions['image_frame'] == "on") echo $checked; ?> name="op_image_frame" id="op_image_frame"/>
    	<?php _e('Image frame on. Wraps a div around the image and caption.',$plugin_name); ?></label>
    </li>
    </ul>
    </fieldset>
</div><!-- close frag 2 -->  

    <div id="fragment-3" class="ss-tabs-panel">
	<h3 class="title">Random Image Options</h3>
   
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   <legend><b><?php _e('Random Image Options',$plugin_name); ?>:</b></legend>
    <ul>
    <li>
    	<label for="op_random"><input type="checkbox" 
    	<?php if($ssmNewOptions['random'] == "on") echo $checked; ?> name="op_random" id="op_random"/>
    	<?php _e('Load a random image if your post has no image.<br /> (your post still needs the [image] shortcode, and this random selects from the whole site)',$plugin_name); ?></label>
    </li>
    <li>
    	<label for="op_random_cat"><input type="checkbox" 
    	<?php if($ssmNewOptions['random_cat'] == "on") echo $checked; ?> name="op_random_cat" id="op_random_cat"/>
    	<?php _e('Limit random image to this posts category. (otherwise the random image is site wide.)',$plugin_name); ?></label>
    </li>
    </ul>
    </div><!-- close frag 3 -->  
    
    <div id="fragment-4" class="ss-tabs-panel">
	<h3 class="title">Display Options</h3>
    
        <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- ToolTip options start -->
   <legend><b><?php _e('Image Display Options',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    
    <li>
    
    <table style="margin: 20px 0px;">
	<tr>
		<td style="width:120px;"><label for="op_limit"><?php _e('Limit to',$plugin_name); ?>:</label> </td>
		<td><input type="text" name="op_limit" id="op_limit" size="6" maxlength="6" 
     value="<?php echo ($ssmNewOptions['limit']); ?>"/>
     <small><?php _e('the number of images to be shown. (enter @ to show all images.)',$plugin_name); ?></small></td>
	</tr>
	<tr>
		<td><label for="op_size"><?php _e('Image size.',$plugin_name); ?></label></td>
		<td><select name="op_size" id="op_size">   
   <?php foreach ( $size_names as $value => $name ) { 
		$myScale = '';
		$width = get_option($name.'_size_w');
		$height = get_option($name.'_size_h'); ;
		$myScale = ' - '.$width.' x '.$height;

   ?>
     
     <option <?php if($ssmNewOptions['size'] == "$name") echo $selected; ?> id="op_size" value='<?php echo $name; ?>'><?php echo "$name $myScale"; ?></option>
     
    <?php }?>     
    </select>
    <small><?php _e('which image should be rendered by default.',$plugin_name); ?></small>
	</td>
	</tr>
	<tr>
		<td> <label for="op_link_type"><?php _e('Link to.',$plugin_name); ?></label></td>
		<td>    <select name="op_link_type" id="op_link_type">   
   <?php 
   $size_names[] = 'attachment_page';
   foreach ( $size_names as $value => $name  ) { 
     	$myScale = '';
		$width = get_option($name.'_size_w');
		$height = get_option($name.'_size_h'); ;
		$myScale = ' - '.$width.' x '.$height;
	?>	
     <option <?php if($ssmNewOptions['link_type'] == "$name") echo $selected; ?> id="op_link_type" value='<?php echo $name; ?>'><?php echo "$name $myScale"; ?></option>

    <?php }?>     
    </select>
    <small><?php _e('which link should be rendered by default.',$plugin_name); ?></small></td>
	</tr>
		<tr>
		<td> <label for="op_order"><?php _e('order.',$plugin_name); ?></label></td>
		<td>    <select name="op_order" id="op_order">    
			 <option <?php if($ssmNewOptions['order'] == "ASC") echo $selected; ?> id="ASC" value='ASC'>Ascendent</option>
			 <option <?php if($ssmNewOptions['order'] == "DSC") echo $selected; ?> id="DSC" value='DSC'>Descendent</option>
    
    </select>
   </td>
	</tr>
		<tr>
		<td> <label for="op_orderby"><?php _e('orderby.',$plugin_name); ?></label></td>
		<td>    <select name="op_orderby" id="op_orderby">       
			 <option <?php if($ssmNewOptions['orderby'] == "name") echo $selected; ?> id="name" value='name'>name</option>
			 <option <?php if($ssmNewOptions['orderby'] == "title") echo $selected; ?> id="title" value='title'>title</option>
			 <option <?php if($ssmNewOptions['orderby'] == "ID") echo $selected; ?> id="ID" value='ID'>ID</option>
			 <option <?php if($ssmNewOptions['orderby'] == "rand") echo $selected; ?> id="rand" value='rand'>rand</option>
			 <option <?php if($ssmNewOptions['orderby'] == "date") echo $selected; ?> id="date" value='date'>date</option>
			 <option <?php if($ssmNewOptions['orderby'] == "menu_order") echo $selected; ?> id="menu_order" value='menu_order'>menu_order</option>   
    </select>
   </td>
	</tr>
</table>

     </li>
 
 
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_align"><?php _e('Default Image Align.',$plugin_name); ?></label>
     <?php
        $alignOption = $ssmNewOptions['align'];
        $check = 'checked = "checked"';
        $alignSet = array(
            0 => 'none',
            1 => 'left',
            2 => 'center',
            3 => 'right',
        );
        foreach ( $alignSet as $align ) {
            $check = '';
            if($alignOption == $align) $check = ' checked = "checked" ';
            echo '<input type="radio" '.$check.' value="'.$align.'" id="image-align-'.$align.'" name="op_align"><label style="margin: 0px 8px 0px 4px;" class="align image-align-'.$align.'-label" for="image-align-'.$align.'">'.$align.'</label>';  
         }
     ?>
     <small><?php _e('which alignment by default.',$plugin_name); ?></small>
     </li>
    </ul>

</div><!-- close frag 4 -->   

<div id="fragment-5" class="ss-tabs-panel">
	<h3 class="title">Shortcode Info</h3>

<p><?php _e('Example shortcode to over ride global options: ',$plugin_name); ?>[image size="thumbnail" image_link="on" link_type="large" caption="on" lightbox="on" limit=3 align="right" image_frame="on" image_id=159] <br />
    <ul><li>    order      = ASC or DESC</li> 
		<li>	orderby    = <?php _e('menu_order, name, title, ID, rand, date',$plugin_name); ?></li> 
		<li>	size = <?php _e('All available sizes: thumbnail, medium, large, full etc.',$plugin_name); ?></li> 
		<li>	image_link     = (on, off) <?php _e('To add a link around the image or not.',$plugin_name); ?></li> 
		<li>	link_type = <?php _e('What to link to: attachment_page, thumbnail, medium, large, full, etc.',$plugin_name); ?></li> 
		<li>	caption  = (on, off) <?php _e('To add the caption or not.',$plugin_name); ?></li> 
		<li>	lightbox = (on, off) <?php _e('To add rel="lightbox:post-number" to the image link.',$plugin_name); ?></li> 
		<li>	limit = <?php _e('To limit the number of images to be shown, @ is equal to all images.',$plugin_name); ?></li> 
		<li>	align = <?php _e('over ride global align option: none, left, center, right.',$plugin_name); ?></li> 
		<li>	image_frame = (on, off) <?php _e('To wrap the caption and image in a div, or not.',$plugin_name); ?></li> 
		<li>	image_id = <?php _e('Add a comma seperated list of ids or single id number of any other image in your media library.',$plugin_name); ?></li> 
			</ul></p>
</div><!-- close frag 5 -->  

</div><!--  close tabs -->

<p> <?php _e('Note: changes to these options will effect all posts with the [image] shortcode.<br /> Where you have over riden the global options such as [image align="right"] will not be changed.',$plugin_name); ?></p>
<p>
<label for="op_delete_options">
		      <input type="checkbox" <?php if($ssmNewOptions['delete_options'] == "on") echo $checked; ?> name="op_delete_options" id="op_delete_options" />
		      <?php _e('Remove options. ',$plugin_name); ?></label>	
		 <br /><span class="setting-description"><?php _e('Select to have the plugin options removed from the data base upon deactivation.',$plugin_name); ?></span>
		 <br />
</p>
<p class="submit">
		<input type="submit" class="button" name="set_defaults" value="<?php _e('Reload Default Options',$plugin_name); ?> &raquo;" />
		<input type="submit" id="update" class="button-primary" value="<?php _e('Update options',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div><!-- close column1 -->


<div class="ss_column2">

<?php if( $ispro !== true) { ?>

	<div class="ss_donate ss_admin_box"> 
		<h2><span class="promo"><?php _e('Spread the Word!', $plugin_name); ?></span></h2>
		<p><?php _e('Want to help make this plugin even better? All donations are used to improve and maintain this plugin, so donate $5, $10, $20 or $50! We\'ll both be glad you did. Thanx. ', $plugin_name); ?></p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="N2F3EUVHPYY5G">
            <input type="image" class="paypal_button" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
       </form>
       
       
       <p><?php _e('Better yet, if you would like to join the exclusive pro members club,', $plugin_name); ?> <a href="http://superslider.daivmowbray.com/superslider-pro/"><?php _e('learn more'); ?></a><?php _e('or upgrade now!'); ?> </p>
       <h2><span class="promo">SuperSlider Pro</span></h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="83HF3CEUD4976">
			<input type="image" class="paypal_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

       <p><?php _e('Or if you find this plugin useful you could :'); ?></p><ul>
       	<li><a href="http://wordpress.org/extend/plugins/<?php echo $plugin_name; ?>/"><?php _e('Rate the plugin 5 stars on WordPress.org', $plugin_name); ?></a></li>
       	<li><a href="http://superslider.daivmowbray.com/superslider/<?php echo $plugin_name; ?>/"><?php _e('Blog about it &amp; link to the plugin page', $plugin_name); ?></a></li>
       	<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $plugin_name; ?>"><?php _e('Post a glowing review on WordPress.org, that would be really nice.', $plugin_name); ?></a></li>
       	<li><a href="http://amzn.com/w/2GUXZ71357NX9"><?php _e('or buy me a gift from my wishlist ...', $plugin_name); ?></a></li></ul>
       
    </div>
    <div class="ss_admin_box" id="sitereview">
		<h2><?php _e('Improve your Site!', $plugin_name); ?></h2>
		<p><?php _e('Don\'t know where to start? Order a ', $plugin_name); ?><a href="http://superslider.daivmowbray.com/services/website-review/#order"><?php _e('website review', $plugin_name); ?></a> from SuperSlider!
		<a href="http://superslider.daivmowbray.com/services/website-review/"> Read more ... </a></p>	
	</div>

 
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please talk about them in the', $plugin_name); ?> <a href="http://wordpress.org/support/plugin/<?php echo $plugin_name; ?>/">Support forums</a>.</p>	
		</div>

 <?php 
 } else { ?>
	
		<div class="ss_donate ss_admin_box"> <h2><span class="promo">SuperSlider Pro</span></h2> </div>
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please contact me directly via this contact form', $plugin_name); ?><br /><a href="http://superslider.daivmowbray.com/pro-support/">Pro Support</a>.</p>	
		</div>
<?php }?>

	<h2><?php _e('More SuperSlider Plugins', $plugin_name); ?></h2>
	<p><?php _e('There are 11 different SuperSlider plugins. All are free to use. Take a minute and learn what each one can do for you. They save you time and money, while making a better web site.', $plugin_name); ?></p>
	 <div class="ss_plugins_list
	 <?php if (class_exists('ssBase') && class_exists('ssShow') &&  class_exists('ssMenu') && class_exists('ssMenu') && class_exists('ssImage') && class_exists('ssExcerpt') && class_exists('ssMediaPop') && class_exists('perpost_code') && class_exists('ssPnext') && class_exists('ss_postsincat_widget') && class_exists('ssLogin') && class_exists('ssSlim')) { echo "all-installed" ; } ?>
	 "> 
	 
		<div class="ss_plugin <?php if (class_exists('ssBase')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider/" title="visit this plugin at WordPress.org to learn more">SuperSlider</a>	
		<a href="#ss_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="ss_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider base, is a global admin plugin for all SuperSlider plugins and comes stocked full of eye candy in the form of modules.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssShow')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-show/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Show</a>
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-show&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMenu')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-menu/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Menu</a>		
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-menu&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssImage')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-image/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Image</a>
		<a href="#image_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-image&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="image_tips_info" class="info_box" style="display:none;">
		<p>Take control your photos and image display. Can add a randomly selected image to any post without an image. Provides a shortcode for adding a photo or image to your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssExcerpt')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-excerpt/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Excerpt</a>
		<a href="#excerpt_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-excerpt&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="excerpt_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMediaPop')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-media-pop/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Media-Pop</a>	
		<a href="#media_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-media-pop&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="media_tips_info" class="info_box" style="display:none;">
		<p>Soda pop for your media. Take control of your media. Access all size versions of your uploaded image for insert. SuperSlider-Media-Pop adds numerous image enhancements to your admin panels. Displays all attached files to this post/page in post listing screen. It adds image sizes to the Upload/Insert image screen, making all image sizes available to be inserted and adding to the image link field options. Insert any image size and link to any image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('perpost_code')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-perpost-code/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Perpost-Code</a>
		<a href="#code_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-perpost-code&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="code_tips_info" class="info_box" style="display:none;">
		<p>Write css and javascript code directly on your post edit screen on a per post basis. Meta boxes provide a quick and easy way to enter custom code to each post. It then loads the code into your frontend theme header if the post has custom code. You may also display your custom code directly into your post with the custom_css or custom_js shortcode.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssPnext')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-previousnext-thumbs/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Previousnext-Thumbs</a>
		<a href="#pnext_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-previousnext-thumbs&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pnext_tips_info" class="info_box" style="display:none;">
		<p>Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or after post content or both. Or you can manually insert into your single post theme file.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ss_postsincat_widget')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-postsincat/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Postsincat</a>
		<a href="#pinc_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-postsincat&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pinc_tips_info" class="info_box" style="display:none;">
		<p>This widget dynamically creates a list of posts from the active category. Displaying the first image and title. It will display the first image in your post as a thumbnail,it looks first for an attached image, then an embedded image then if it finds the image, it grabs the thumbnail version. Oh, and by the way, it's an animated vertical scroller, way cool.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssLogin')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-login/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Login</a>
		<a href="#login_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-login&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="login_tips_info" class="info_box" style="display:none;">
		<p>A tabbed slide in login panel. Theme based, animated, automatic user detection.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssSlim')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://superslider.daivmowbray.com/superslider/superslider-slimbox/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Slimbox</a>
		<a href="#slim_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-slimbox&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="slim_tips_info" class="info_box" style="display:none;">
		<p>Another pop over light box. Theme based, animated, automatic linking, autoplay show built with slimbox2 , uses mootools 1.4.5 java script</p>
		</div></div>
	
		<br style="clear:both;" />
	 </div>
 <h3><?php _e('Services', $plugin_name); ?></h3>
		<p><?php _e('Custom plugins, custom themes, custom solutions: I\'ve been developing WordPress Themes and plugins for many years. If you need a custom solution or simply some help with your set up I am avaiable at reasonable rates. ', $plugin_name); ?><a href="http://www.daivmowbray.com/contact"><?php _e('Just send a note to me, Daiv Mowbray, through this contact form', $plugin_name); ?></a>.</p>

<?php  if( $ispro !== true) { ?>

	<div class="promo_code_form" style="text-align: center;">
	<form name="ssPro_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
	<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssPro_options'); echo "\n"; 
		?>
    		<label for="op_pro_code">
               <input type="text" class="span-text" name="op_pro_code" id="op_pro_code" size="30" maxlength="200"
			 value="<?php echo ($ssPro_newOptions['pro_code']); ?>" />
               <br /> <?php _e('Enter your SuperSlider Pro code.',$plugin_name); ?></label>	
    <p class="margin-top: 5px;">
	
		<input type="submit" id="updatePro" class="button-primary" value="<?php _e('Enter',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="proaction" id="proaction" value="updatepro" />
		
 	</p>
 	</form>
 	</div>
<?php  } ?> 

</div><!-- close column2   --> 
</div><!-- close wrap to here --> 

<?php
	echo "";
?>