<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#ss_image_dlg.title}</title>
	<script type="text/javascript" src="../../../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<!--script type="text/javascript" src="../../../../../../../wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script type="text/javascript" src="../../../../../../../wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script type="text/javascript" src="../../../../../../../wp-includes/js/tinymce/utils/validate.js"></script>
	<script type="text/javascript" src="../../../../../../../wp-includes/js/tinymce/utils/editable_selects.js"></script-->
	<script type="text/javascript" src="js/dialog.js"></script>

<style type="text/css" title="text/css">
#action_panel li {
	margin: 0px;
	padding: 5px 0px;
	text-align: right;
}
.mceActionPanel {
    text-align: right;
}
ul {
list-style-type: none;padding:0px;margin:0px;
}
.ss-half {
width: 45%; float:left;
border-bottom:1px solid #cdcdcd;
}
</style>	
</head>
<body id="ssImage" role="application" aria-labelledby="app_title">
<?php
// all the way up 
require( '../../../../../../../wp-load.php' );

$ssMoptions = get_option('ssImage_options');
$size_names =  get_intermediate_image_sizes();// this only works with WP version 3+
$size_names[] = 'full'; // adds original / full sized image to list
$checked = ' checked="checked"';
$selected = ' selected="selected"';
$plugin_name = 'superslider-image';
?>

<div id="action_panel" class="panel current">
<form onsubmit="ssImageDialog.insert();return false;" action="">

    <div id="fragment-1" class="ss-tabs-panel">
    
   <fieldset style="border:1px solid grey;margin:10px 0px;padding:10px;">
   <legend><b>Image Display Options:</b></legend>
   <ul>
    
    <li>
    	<label for="image_id" ><?php _e('image id list(optional)',$plugin_name); ?>:</label> 
		<input type="text" name="image_id" id="image_id" size="30" maxlength="200" 
     value="<?php // This might hold the list of attached images in id form echo ($ssMoptions['image_id']); ?>"/>
     
    </li>
    <li>
    	<label for="order" ><?php _e('Order',$plugin_name); ?>:</label> 		
     	<select name="order" id="order">
			 <option <?php if($ssMoptions['order'] == "ASC") echo $selected; ?> id="ASC" value='ASC'>Ascendent</option>
			 <option <?php if($ssMoptions['order'] == "DSC") echo $selected; ?> id="DSC" value='DSC'>Descendent</option>
			</select>
    </li>
    <li>
      <label for="orderby" ><?php _e('orderby',$plugin_name); ?>:</label> 
       <select name="orderby" id="orderby">
			 <option <?php if($ssMoptions['orderby'] == "name") echo $selected; ?> id="name" value='name'>name</option>
			 <option <?php if($ssMoptions['orderby'] == "title") echo $selected; ?> id="title" value='title'>title</option>
			 <option <?php if($ssMoptions['orderby'] == "ID") echo $selected; ?> id="ID" value='ID'>ID</option>
			 <option <?php if($ssMoptions['orderby'] == "rand") echo $selected; ?> id="rand" value='rand'>rand</option>
			 <option <?php if($ssMoptions['orderby'] == "date") echo $selected; ?> id="date" value='date'>date</option>
			 <option <?php if($ssMoptions['orderby'] == "menu_order") echo $selected; ?> id="menu_order" value='menu_order'>menu_order</option>
			</select>
     
    </li>
    <li><div class="ss-half"><ul>
		 <li>
			<label for="image_frame" ><?php _e('image_frame',$plugin_name); ?>:</label> 
			<input type="checkbox" 
			<?php if($ssMoptions['image_frame'] == "on") echo $checked; ?> name="image_frame" id="image_frame"/>
		</li>
		 <li>
			<label for="random" ><?php _e('random',$plugin_name); ?>:</label> 
			<input type="checkbox" 
			<?php if($ssMoptions['random'] == "on") echo $checked; ?> name="random" id="random"/>
		</li>
		  <li>
			<label for="random_cat" ><?php _e('random_cat',$plugin_name); ?>:</label> 
			<input type="checkbox" 
			<?php if($ssMoptions['random_cat'] == "on") echo $checked; ?> name="random_cat" id="random_cat"/>
		</li>
		</ul></div>
		<div class="ss-half">
		<ul>
		<li>
			<label for="image_link">
			<?php _e('Image link on.',$plugin_name); ?></label>
			<input type="checkbox" 
			<?php if($ssMoptions['image_link'] == "on") echo $checked; ?> name="image_link" id="image_link"/>
			
		</li>
		
		<li>
			<label for="caption"><?php _e('Image caption on.',$plugin_name); ?></label>
			<input type="checkbox" 
			<?php if($ssMoptions['caption'] == "on") echo $checked; ?> name="caption" id="caption"/>
			
		</li>
		
		<li>
			<label for="lightbox"><?php _e('Image lightbox on.',$plugin_name); ?></label>
			<input type="checkbox" 
			<?php if($ssMoptions['lightbox'] == "on") echo $checked; ?> name="lightbox" id="lightbox"/>
			
		</li>
		</ul></div><br style="clear:both;" />
	</li>
    <li>
    	<label for="image_class" ><?php _e('Extra image class',$plugin_name); ?>:</label> 
		<input type="text" name="image_class" id="image_class" size="30" maxlength="200" 
     value="<?php echo ($ssMoptions['image_class']); ?>"/>
     
    </li>
    
    <li style="border-bottom:1px solid #cdcdcd;">
    	<label for="link_class" ><?php _e('Extra link class',$plugin_name); ?>:</label> 
		<input type="text" name="link_class" id="link_class" size="30" maxlength="200" 
     value="<?php echo ($ssMoptions['link_class']); ?>"/>
     
    </li>
    
    <li>
		<label for="limit">Limit number of images:</label>
		<input type="text" name="limit" id="limit" size="6" maxlength="6" 
			 value="<?php echo ($ssMoptions['limit']); ?>"/>
			 <small>(enter @ to show all images.)</small></td>
	</li>
	<li>
		<label for="size">Image size.</label>
		<select name="size" id="size">   
		   <?php foreach ( $size_names as $size ) { ?>
			 
			 <option <?php if($ssMoptions['size'] == "$size") echo $selected; ?> id="size" value='<?php echo $size; ?>'><?php echo $size; ?></option>
			 
			<?php }?>     
			</select>

	</li>
	<li>
		<label for="link_type">Link to.</label>
		<select name="link_type" id="link_type">   
		   <?php 
		   $size_names[] = 'attachment_page';
		   foreach ( $size_names as $size ) { ?>
			 
			 <option <?php if($ssMoptions['link_type'] == "$size") echo $selected; ?> id="link_type" value='<?php echo $size; ?>'><?php echo $size; ?></option>
			 
			<?php }?>     
			</select>

	</li>
 
    <li style="border-bottom:1px solid #cdcdcd;">
     <label for="align">Default Image Align.</label>
     <?php
        $alignOption = $ssMoptions['align'];
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
            echo '<input type="radio" '.$check.' value="'.$align.'" id="image-align-'.$align.'" name="align"><label style="margin: 0px 8px 0px 4px;" class="align image-align-'.$align.'" for="image-align-'.$align.'">'.$align.'</label>';  
         }
     ?>

     </li>
    </ul>

</div>


	<div class="mceActionPanel">
		<input type="button" id="insert" name="insert" value="{#insert}" onclick="ssImageDialog.insert();" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
</form>
</div>

	
</body> 
</html> 
