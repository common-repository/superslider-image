=== SuperSlider-Image ===
Contributors: Daiv
Plugin URI: http://superslider.daivmowbray.com/superslider/superslider-image/
Donate link: http://superslider.daivmowbray.com/support-me/donate/
Tags:  superslider, superslider-image, image, random, random image, images, photo, photos, attachments, admin, enhancement, photo-blogging, image-size, shortcode
Requires at least: 3
Tested up to: 3.5
Stable tag: 2.0

== Description ==

Take control your photos and image display. Add an attached image/images or randomly selected image to any post without an image. Provides a shortcode for inserting an attached image or featured image into your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size. Changing any default option in the admin/settings/superslider-image page will change that property for all photos or images inserted with the [image] shortcode.  


**Features**

* Provides the shortcode [image] to insert an image into your posts / page.
* Automatically inserts the shortcode [image] into your posts / page.
* Checks for attached image, then featured image then if none is found it shows a random image.
* Inserts a randomly selected image into any post without an image attached.
* Option to display a different image each time a post is viewed
This allows you to set a default image code setup. Avoids the hard coded
image in your post. Each inserted [image] shortcode can be customized with
properties which stay fixed. Changing a default option in the 
admin/settings/superslider-image page will change that property for all images 
inserted with the [image] shortcode. This works for one or more images attached 
to this post, or any image id from your media library. ie: [image image_id="129"] 
where 129 is the image id available in your media manager list.


**Demos**

See screen shot of admin panel. This plugin can be seen in use here:

* [Demo 1](http://superslider.daivmowbray.com/2010/superslider-image-demo-1 "Demo 1")


**Support**

If you have any problems or suggestions regarding this plugin [please speak up](http://wordpress.org/support/plugin/superslider-image "support forum")

**Other Plugins**
Download These SuperSlider Plugins here:

* [SuperSlider](http://wordpress.org/extend/plugins/superslider/ "SuperSlider")
* [Superslider-PostsinCat](http://wordpress.org/extend/plugins/superslider-postsincat/ "Superslider-PostsinCat")
* [SuperSlider-Show](http://wordpress.org/extend/plugins/superslider-show/ "SuperSlider-Show")
* [SuperSlider-Login](http://wordpress.org/extend/plugins/superslider-login/ "SuperSlider-Login")

**NOTICE**

* The downloaded folder's name should be superslider-image


== Screenshots ==

1. ![SuperSlider-Image options](screenshot-2.png "SuperSlider-Image options")


== Installation ==

The Easy Way

    In your WordPress admin, go to 'Plugins' and then click on 'Add New'.
    In the search box, type in 'SuperSlider-Image' and hit enter. This plugin should be the first and likely the only result.
    Click on the 'Install' link.
    Once installed, click the 'Activate this plugin' link.

The Hard Way

    Download the .zip file containing the plugin, unzip.
    Upload the Superslider-Image folder into your /wp-content/plugins/ directory 
    Find the Superslider-Image plugin in the WordPress admin on the 'Plugins' page and click 'Activate'
       
== Upgrade Notice == 

  * Changes in options from version 1.* to 2.0 - be sure to resave your settings/options after upgradeing


== USAGE ==

If you are not sure how this plugin works you may want to read the following.

* Example shortcode to over ride global options: [image size="thumbnail" image_link="on" link_type="large" image_caption="on" lightbox="on" limit="1" align="right" image_frame="on" image_id="159"]


== OPTIONS AND CONFIGURATIONS ==

	* 'order'     = 'ASC', 
	* 'orderby'   = 'menu_order',
	* 'size'       = "medium",
	* 'image_link'    = "on",
	* 'link_type'    = "large",
	* 'caption' = "on",
	* 'lightbox'= "on",
	* 'limit'= "1",
	* 'random'= "on",
	* 'align'= 'center',
	* 'image_frame'= 'on',
	* 'image_id'= '234',
	* 'add_text_editor'= 'on'

== To Do ==

* Open to suggestions
			

== Report Bugs Request / Options / Functions ==

* Please use the support system at the WordPress.org support forums

== Frequently Asked Questions ==	

**None at this time**

>* To ask your questions see support.



== Changelog ==

* 2.0 (2012/12/24)

  * fixed image select lists in settings page

* 1.9 (2012/12/20)

  * updated to work with WordPress 3.5

* 1.8 (2012/11/26)

  * added tinymce plugin button with pop over shortcode builder
  * fixed an endless loop error bug

* 1.6 (2012/11/19)

  * fixed php notices
  * improved code speed
  * added a clear break after multiple images
  * added  option to insert class to your image
  * added option to insert class to image link
  * added quicktag to the html view tab
  
* 1.5.3 (2012/01/14)

  * Fatal error when no featured image fixed
  
* 1.5.2 (2012/01/13)

  * added check for featured image
  
* 1.5.1 (2012/01/13)

  * fixed a captions bug

* 1.5 (2012/01/13)

  * Corrected some bugs related to caption inclusion
  * Added  the random image from site for posts with no image
  * Added the random image from this post category function for posts with no image
  * general code cleaning
  
* 1.4 (2010/06/27)

  * Fixed issues with multiple images and image size.


* 1.3 (2010/06/24)

  * Fixed shortcode issues : no captions was failing

  
* 1.2 (2010/06/22)

  * Fixed shortcode issues when adding numerous images
  * Changed some of the shortcode option names
    
    * which_image is now image_id
    * image_link_on is now image_link
    * caption_on is now caption
    * image_lightbox is now lightbox
    * image_frame_on is now image_frame
    

* 1.1 (2010/06/02)

  * fixed link to settings page
  * added save options upon deactivation option

* 1.0 (2010/05/26)

    * first public beta launch

---------------------------------------------------------------------------