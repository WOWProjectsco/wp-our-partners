=== Our Partners by WOWDevShop ===
Contributors: XicoOfficial, wowdevshop
Donate link: http://wowdevshop.com/
Tags: partners, company partners, partner category, widget, organization partners
Requires at least: 3.8
Tested up to: 4.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin registers the 'partner' post type, it let's you manage your company partner profiles.

== Description ==

= Organization Partners Management =

"Our Partners by WOWDevShop" is a clean and easy-to-use organization partners management system for WordPress. Load in your partners and display them on a page as posts, with their own categories.

= Support =

Looking for a helping hand? [View plugin documentation](http://docs.wowdevshop.com/wordpress/our-partners).

= Get Involved =

Looking to contribute code to this plugin? Go ahead and [fork the repository over at GitHub](https://github.com/wowdevshop/wp-our-partners).
(submit pull requests to the latest "release-" tag)

== Usage ==

To display your organization partners via a theme or a custom plugin, please use the following code:

Define your custom post type name in the arguments

`$args = array('post_type' => 'partners');`

Define the loop based on arguments

`$loop = new WP_Query( $args );`
 Display the contents


== Usage Examples ==

`<?php
$args = array('post_type' => 'bios');
$loop = new WP_Query( $args );

while ( $loop->have_posts() ) : $loop->the_post();
?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
<?php the_content(); ?>
</div>
<?php endwhile;?>`

== Installation ==

Installing "Our Partners by WOWDevShop" can be done either by searching for "Our Partners by WOWDevShop" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org.
1. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= The plugin looks unstyled when I activate it. Why is this? =

"Our Partners by WOWDevShop" is a lean plugin that aims to keep it's purpose as clean and clear as possible. Thus, we don't load any preset CSS styling, to allow full control over the styling within your theme or child theme.
You can add a basic styling by coping and pasting the following code into your style.css on your theme. [css code](https://gist.github.com/xicoofficial/51fb6f8db3cf4e6ff461).

= How do I contribute? =

We encourage everyone to contribute their ideas, thoughts and code snippets. This can be done by forking the [repository over at GitHub](https://github.com/wowdevshop/wp-our-partners).

== Screenshots ==

1. The organization partner management screen within the WordPress admin.

2. The organization partners options on the settings menu.

3. The organization partners posted.

== Changelog ==

= 1.1.1 =
* Fix bugs for using the functions of twentysixteen theme :S
* Add the email and website links to the single template
* Remove support for custom fields

= 1.1.0 =
* Custom Archive template
* Custom Single template
* Custom General template
* Add default partner logo when no picture is uploaded
* Add support for page attributes: Parent and order
* Add support for custom fields

== Upgrade Notice ==
= 1.1.1 =
* Updating and fixing bugs

= 1.1.0 =
* IMPORTANT! The field 'description' on release v1.0.0 is replaced by the text editor on a default post type. Be sure tu have all your partner descriptions, otherwise you will lost them after the upgrade.

= 1.0.0 =
* Initial release. Yeah!
