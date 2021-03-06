=== Plugin Name ===
Contributors: drosendo
Donate link: https://goo.gl/EPQAsA
Tags: WooCommerce, images variations, gallery, woocommerce variations, woocommerce variations images, woocommerce images
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: 1.4.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a WooCommerce extension plugin, that allows the user to add any number of images to the product images gallery and be used as variable product variations images in a very simple and quick way, without having to insert images p/variation.

== Description ==

By default WooCommerce will only swap the main variation image when you select a product variation, not the gallery images below it. 

This extension allows visitors to your online store to be able to swap different gallery images when they select a product variation. 
Adding this feature will let visitors see different images of a product variation all in the same colour and style.

This extension will allow the use of multiple images per variation, and simplifies it! How?
Instead of upload one image per variation, upload all the variation images to the product gallery and for each image choose the corresponding slug of the variation on the dropdown.
As quick and simple as that!

<strong>Read the FAQ and Screenshots before posting in support!</strong>

Check out a demo at: http://www.rosendo.pt/en/product/demo-smart-variations-images/

<strong>Please give your review!</strong>

If you like the plugin donate!

Take a look at the Screenshots section on how to work with it!


== Installation ==

1. Upload the entire `smart-variations-images` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. On your product assign the product attributes and save
4. Go to Product Gallery and upload/choose your images
5. Assing the slugs to be used for the variation images for each of the image and save.
6. Good luck with sales :)


== Frequently Asked Questions ==

= The plugin doesnt work with my theme =

Themes that follow the default WooCommerce implementation will usually work with this plugin. However, some themes use an unorthodox method to add their own lightbox/slider, which breaks the hooks this plugin needs.

= The plugin works but messes up the styling of the images =

You can try several options here.

1. Go to WooCommerce > Configuration > Products Tab > (Smart Variations Images) and activate or deactivate the option "Enable WooCommerce default product image"
2. Disable other plugins that change the Product image default behavior.
3. Read the Support Threads.


= How do I configure it to work? =

1. Assign your product Atrributes and click "Save atributes"
2. Create the variations you need, and click "Publish" or "Save as draft"
3. Go to Product Gallery and upload/choose the images you are going to use
4. For each image assing the slugs to be used for the variation images swap
5. Publish you product

You can skip steps 1 and 2 if your product is already setup with Atributes and Variations.

== Screenshots ==

1. Add images to your Product Gallery
2. Choose the images to be used and select the "slug" of the variation in the "Variation Slug" field.
3. Hides all other images that dont match the variation, and show only the default color, if no default is choosen, the gallery is hidden.
4. On change the variation, images in the gallery also change to match the variation. The image in the gallery when click should show in the bigger image(above).
4. Lens Zoom in action (activate it in WooCommerce > Configuration > Products Tab > (Smart Variations Images)

== Changelog ==

= 1.4.3.1 =
* Minor issue with class naming of thumbnails, first and last class.

= 1.4.3 =
* Fixed issue with thumbnails when not in order of appearence in product gallery update the swap with primary would not work correctly, thanks to @jamblo for reporting
* Speed improvements due to fix

= 1.4.2.1 =
* Fixed minor issue with thumbnail swap with primary not changing link for prettyPhoto Zoom, thanks to @wzshop for reporting

= 1.4.2 =
* Fixed issue with variation descriptions not showing up, thanks to @jamblo and @Sandeepy02 for reporting

= 1.4.1 =
* Fixed issue with CSS not loading if woocommerce.css not found, messing up the CSS of the images.
* Code cleaning

= 1.4 =
* Added support for "Custom product attributes".

= 1.3.4 =
* Fixed issue with not showing images to swap on products with no variations. Thanks to parasomnias for alerting.

= 1.3.3 =
* Fixed issue with Safari when when switch the variation image the image doesn't render properly.

= 1.3.2 =
* Fixed issue with Lens Zoom not working, due to missing initialization.

= 1.3.1 =
* Fixed load of images recurring to cache
* Fixed swaping iamge when not using WOOSVI

= 1.3 =
* Complete reconstrution of JS to better handle changes.
* Fixed, no more flickering on "WooCommerce default product image"

= 1.2.1 =
* Bug fixed, if user has multiple variations and is not using one of them, variation slug in the image would not show up.
* Added, when user clicks "Clear Selection", update gallery.
* Speacial thank to @max_Q, for reporting issue and supplying some solution.

= 1.2 =
* Added option to prevent conflit with other plugins that maybe Removing/Adding action woocommerce_before_single_product_summary and woocommerce_product_thumbnails to insert their own gallery.
* User can choose to "Enable WooCommerce default product image", SVI will work but may see some flickering when images change, this option is deactivated by default.

= 1.1 =
* Stable Version
* Fixed flickering when swapping images
* Added Lens Zoom Option (activate it in WooCommerce > Configuration > Products Tab > Smart Variations Images)

= 1.0.1 =
Revert State, missing files to commit. working version.

= 1.0 =
This is a big release. Fixed flickering of images when swaping images. Added a new option for Lens Zoom, activate this option in WooCommerce > Configuration > Products Tab > Smart Variations Images

= 0.2.2 =
Fixed issue where variation would not chagne in Chrome, also if no image variation exist, dont change image.

= 0.2.1 =
Fixed Warning message from appearing if WP_DEBUG was true preventing images from showing.

= 0.2 =
No longer use of caption field for Variation, new field has been added to replace the caption.
Javascript will search for new tag and loop the gallery.

= 0.1 =
Just released into the wild.