<?php
/*
Plugin Name: SuperSlider-Image
Plugin URI: http://superslider.daivmowbray.com/superslider/superslider-image/
Description: Take control your photos and image display. Shortcode image installer, provides a global control over post images, an easy way to change image properties globally at any time, can also add a randomly selected image to any post without an image attached. 
Author: Daiv Mowbray
Author URI: http://www.daivmowbray.com
Version: 2.0

*/

if (!class_exists("ssImage")) {
	class ssImage {
    
    	/**
		* @var names used in this class.
		*/
	var $defaultAdminOptions;
	var $AdminOptionsName = 'ssImage_options';
	var $ssImageOpOut;
	var $plugin_name = 'superslider-image';
	
    	/**
		*     PHP 4 Constructor
		*/
    function ssImage() {
			
		ssImage::superslider_image();

		}
				
		/**
		*     PHP 5 Constructor
		*/		
	function __construct(){
		
		self::superslider_image();
	
	    }
    	/**
	    *	This is the function that sets up all the actions.
	    */
	function superslider_image() {
		
		register_activation_hook(__FILE__, array(&$this,'ssImage_init') );
		register_deactivation_hook( __FILE__, array(&$this,'options_deactivation') );
		
		add_action ( "init", array(&$this,"ssImage_init" ) );		
		add_action ( "init", array(&$this,"ssImage_add_shortcode" ) );
		add_action ( "init", array(&$this,"ss_mce_init" ) );
		add_action ( "admin_menu", array(&$this,"ss_setup_optionspage" ) );
		
	   }
	   
	  function ss_all_sizes() {
        // get a list of the actual pixel dimensions of each possible intermediate version of this image
        global $wp_version;    
        // is not version 3+
         if (version_compare($wp_version, "3", "<")) {
            $size_names = array('thumbnail' => 'thumbnail', 'medium' => 'medium', 'large' => 'large', 'full' => 'full',);
            if (function_exists('add_theme_support')) $size_names['post-thumbnail'] = 'post-thumbnail'; 
            if (class_exists("ssShow")) { $size_names['slideshow'] = 'slideshow'; $size_names['minithumb'] = 'minithumb';}
            if (class_exists("ssExcerpt")) $size_names['excerpt'] = 'excerpt'; 
            if (class_exists("ssPnext")) $size_names['prenext'] = 'prenext'; 
     
       } else {       
            $size_names =  get_intermediate_sizes();// this only works with WP version 3+
            $size_names[] = 'full'; // adds original / full sized image to list
       }
       return $size_names;
    }
	   /**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_admin_options() {
		
		$defaultAdminOptions = array(
		        'order'      => 'ASC', 
			    'orderby'    => 'menu_order',
				'size'        => "medium",
				'image_link'     => "on",
				'link_type'     => "large",
				'caption'  => "on",
				'lightbox' => "on",
				'limit' => "1",
				'align' => 'center',
				'image_frame' => 'on',
				'random' => 'on',
			    'random_cat' => 'on',
				'add_text_editor' => 'on',
				'text_editor_content' => '[image]',
				'image_class' => '',
				'link_class' => '',
				'delete_options' => '');
		
		$defaultOptions = get_option($this->AdminOptionsName);
		if (!empty($defaultOptions)) {
			foreach ($defaultOptions as $key => $option) {
				$defaultAdminOptions[$key] = $option;
			}
		}
		update_option($this->AdminOptionsName, $defaultAdminOptions);
		$this->ssImageOpOut = get_option($this->AdminOptionsName);
	}
    		/**
		* Load admin options page
		*/
	function Image_options_ui() {		
		global $base_over_ride;
		global $ssImage_domain;
		include_once 'admin/superslider-image-ui.php';
		
	}
    		/**
		* Initialize the admin panel, Add the plugin options page, loading it in from superslider-image-ui.php
		*/
	function ss_setup_optionspage() {
		if (  function_exists('add_options_page') ) {
			if (  current_user_can('manage_options') ) {
				$plugin_page = add_options_page(__('SuperSlider Image'),__('SuperSlider-Image'), 'manage_options', 'superslider-image', array(&$this, 'Image_options_ui'));
				add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_settings_link'), 10, 2 );				
				add_action('admin_print_scripts-'.$plugin_page, array(&$this,'ss_admin_style'));
				add_action('admin_print_scripts-'.$plugin_page, array(&$this,'ss_admin_script'));
			}					
		}
	}

	function filter_settings_link($links, $file) {
		 static $this_plugin;
			if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if (  $file == $this_plugin )
			$settings_link = '<a href="admin.php?page=superslider-image">'.__('Settings').'</a>';
			array_unshift( $links, $settings_link ); //  before other links
			return $links;
	}
	function ssImage_init() {
		$this->defaultAdminOptions = $this->set_default_admin_options();
		if($this->ssImageOpOut['add_text_editor'] == 'on')
		add_filter( 'default_content', array(&$this, 'ss_editor_content') );
		
		$jsAdminPath = WP_PLUGIN_URL.'/'. plugin_basename(dirname(__FILE__)) . '/admin/js/';
			
		wp_register_script( 'superslider-admin-tool', $jsAdminPath.'superslider-admin-tool.js', array( 'jquery-tooltip' ), '2', false);

		$cssAdminPath = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)) .'/admin/'; 
			
		wp_register_style('superslider_admin', $cssAdminPath.'ss_admin_style.css');
		wp_register_style('superslider_admin_tool', $cssAdminPath.'ss_admin_tool.css');
		
		add_action( 'admin_enqueue_scripts', array(&$this, 'image_quicktags'));

	 }
	 	 
	function image_quicktags($hook) {

		if(('post-new.php' == $hook) || ('post.php' == $hook)) {

			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			   return;
			wp_enqueue_script('image_quicktags',plugin_dir_url( __FILE__ ) . 'js/image-quicktags.js', array( 'quicktags' ));

		}
	}	
	
	function ss_mce_init() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'ss_add_mce_plugin') );
			add_filter( 'mce_buttons', array(&$this, 'ss_register_button') );
		}
	}
	function ss_register_button($buttons) {
		array_push( $buttons, "|", "ss_image" );	
		return $buttons;
	}
	
	function ss_add_mce_plugin($plugin_array) {
		$plugin_array['ss_image'] =  plugin_dir_url(__FILE__).'admin/tinymce/plugins/ss-image/ss_image.js';
		return $plugin_array;
	}
	function options_deactivation() {
		if($this->ssImageOpOut['delete_options'] == true){
		  delete_option($this->AdminOptionsName);
        }
	}
	function ss_admin_style() {		
				wp_enqueue_style( 'superslider_admin');
				wp_enqueue_style( 'superslider_admin_tool');    	
	}	
	function ss_admin_script(){	
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-tabs' );	
				wp_enqueue_script( 'jquery-tooltip' );
				wp_enqueue_script( 'superslider-admin-tool' );					
	}
    
    function ss_editor_content( $content ) {
        $content = $this->ssImageOpOut['text_editor_content'];
        return $content;
    }
	function ssImage_add_shortcode() {		
    	add_shortcode ( 'image' , array(&$this, 'ssImage_shortcode_out') );
	}
	
    function print_format_array($array_name) { 
			echo 'this array contains: ';
	 		 echo '<pre>'; 
	  		ksort($array_name); 
	  		print_r($array_name); 
	  		echo '</pre>'; 
	  		echo '--- end array listing ----';
     }
		/**
		* get the images for the post.
		*/	
	function ssImage_shortcode_out( $atts ) {
		global $post;
		$image_id ='';
		$atts = shortcode_atts(array(
			'order'      => 'ASC', 
			'orderby'    => 'menu_order',
			'size' => '',
			'image_link'     => '',
			'link_type' => '',			
			'caption'  => '',
			'lightbox' => '',
			'limit' => '',
			'align' => '',
			'random' => '',
			'random_cat' => '',
			'image_frame' => '',
			'image_class' => '',
			'link_class' => '',
			'image_id' => ''), $atts);

		// opdate options array if any changes with shortcode
		if ($atts !='') $this->ss_change_options($atts);
		
	   extract($this->ssImageOpOut);
	   if ($limit == '@') {$n = 50;}else{$n = $limit;}

	   $all_attachments = array();// pre define the master array
       	   
	   if($image_id == '') $all_attachments = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );			

        /* no attached and no image id as yet, lets get the featured image */
       if ( $image_id == '' && empty($all_attachments) && function_exists( 'get_the_post_thumbnail' )) $image_id = get_post_thumbnail_id( $post->ID);

           /* there are no attached images so get a random image
              this searches for all attachments of image type from this posts category,*/
	   if ( empty($all_attachments) && !$image_id && $random == 'on') {  
	       if ( $random_cat == 'on') {  
                $cat = get_the_category($post->ID);
                $cat = $cat[0]->term_id;
 
                $args = array('category' => $cat,'post_type' => 'post', 'post_status' => 'publish','numberposts' => 20, 'offset'=> 1);  
                $posts = get_posts($args);

                if ($posts) {
                   // remove the active post from the list
                   $this_post_id = $post->ID;
                   foreach( $posts as $key => $obj)  {
                       if ( $obj->ID == $this_post_id)
                        unset($posts[$key]);
                    } 

                   shuffle($posts);// shake up the array 
                   reset($posts); // reset index
 				   $e = count($posts);
 				   $i = 0;
 				   
                   do { if(isset($posts[$i]) && is_object($posts[$i])) {
                   		$post_id = $posts[$i]->ID; 
                   		}
                        $all_attachments = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit',  'order' => $order, 'orderby' => $orderby, 'post_type' => 'attachment','numberposts' => $n, 'post_mime_type' => 'image','output' => 'ARRAY_A') );
                           $i++;
                    } while ( ($i <= $e) ) ; 

                	// the active category doesnt have any attchments in its posts so fall back to random from site
                	if ( empty($all_attachments)) {
                		
                		$args = array('orderby' => 'rand','post_mime_type' => 'image','post_type' => 'attachment','numberposts' => $n);
            			$all_attachments = get_children( $args );
            		}            		
               	}
                
	        } else { 
	        // $random_cat id off and random site is on so get random sitewide
	        if ($limit == '@') {$n = 50;}else{$n = $limit;}

	        $args = array('orderby' => 'rand','post_mime_type' => 'image','post_type' => 'attachment','numberposts' => $n);
            $all_attachments = get_children( $args );
     
           }
           // Nope, skipped all that and came straight here, shortcode has an image id, is it a list?
	     } elseif (strpos($image_id,',')) {	
            $idz = explode(',', $image_id);

			foreach ($idz as $id) {	
			    $image = array();
				$image[] = get_post($id);
				$all_attachments = array_merge((array)$all_attachments, (array)$image);
			}
			// nope lets just get our attached images
	     } elseif ($image_id !== '') { 
            $all_attachments[0] = get_post($image_id);  
	     }
		// we have all the images now to cut the list down
		if ($random == 'on') shuffle($all_attachments);    
        if($limit !== '@' && (count($all_attachments) > $limit))$all_attachments = array_slice($all_attachments, 0, $limit);
        
        // this is for a feed call
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $all_attachments as $attachment )
				$output .= wp_get_attachment_image($attachment->ID, $size);
			return $output;
		}
        // now lets get that image
        $output = '';
        foreach ( $all_attachments as $attachment ) {

		    // get some image info
			$image = wp_get_attachment_image_src($attachment->ID, $size);
			$att_image = wp_get_attachment_image_src($attachment->ID, $link_type);
            $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);            
            $a_rel = '';
            $image_align ='align'.$align;
            $image_caption = $attachment->post_excerpt;
            
          if ( $link_type !== 'attachment_page' ) {
                    $linkto = ' href="'.$att_image[0].'"';
                } else {
                    $linkto = ' href="'.get_permalink($attachment->ID).'"'; 
                }
		  if ($link_type !== 'attachment_page' && $lightbox == 'on')$a_rel = ' rel="lightbox:'.$post->ID.'"';		  
		  if ($image_alt == '') $image_alt = $post->post_title;	  
		  
		  if ($image_frame == 'on') $output .= '<div class="wp-caption '.$image_align.'" id="attachment_'.$attachment->ID.'"> ';
          if ($image_link == 'on')  $output .= '<a '.$linkto.$a_rel.' class="image_link '.$link_class.'" title="'.$attachment->post_title.'" > ';
		  if ($image_frame == 'on') $image_align = '';     
            
            $output .= '<img class="size-'.$size.' wp-image-'.$attachment->ID.' '.$image_class.' '.$image_align.'" id="image-'.$attachment->ID.'" src="'.$image[0].'" alt="'.$image_alt.'" width="'.$image[1].'" height="'.$image[2].'" />';
		 
          if ($image_link == 'on') $output .= "</a>"."\n";

          if ($caption == 'on' && $image_caption !== '') $output .=   '<p class="wp-caption-text">'.$image_caption.'</p>';
          if ($image_frame == 'on') $output .= '</div>'."\n";  

       }
       if (count($all_attachments) > 1) $output .= '<br style="clear:both; height: 0px;"/>';
        return do_shortcode($output);
	}

    function ss_change_options( $atts ){
            $this->ssImageOpOut = get_option($this->AdminOptionsName);
			$this->ssImageOpOut = array_merge($this->ssImageOpOut, array_filter($atts));
  			return $this->ssImageOpOut;
	}
	
}	//end class
} //End if Class ssImage

/**
*instantiate the class
*/	
$myssImage = new ssImage();

?>