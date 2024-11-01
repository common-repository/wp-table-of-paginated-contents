=== Plugin Name ===
Author: António Andrade
Author URI: http://antonioandra.de/
Plugin URI: http://antonioandra.de/
Contributors: antonioandra.de, luc7v
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=antonio%40antonioandra%2ede&lc=US&item_name=WP%20Table%20of%20Paginated%20Contents%20%28Antonio%20Andrade%29&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest
Tags: table of contents, navigation, pagination, post pagination, page pagination, content
Requires at least: 2.7
Tested up to: 4.4
Stable tag: 2.1

Handles naming of each post page through a TinyMCE button and produces a Table of Contents for the said post.

== Description ==

**WP Table of Paginated Contents** handles naming of each post page and produces a Table of Contents.
It uses the native `<!--nextpage-->` tag but adds a shortcode to store section titles.

Check the screenshots for a clearer idea.

**Features:**

* **Naming of each post page**;
* Output or generation of a **Table of Contents** (using a list or a drop down menu);
* Output or generation of **next/prev post pages navigation**, using the section titles.

Suggestions are welcome and please report any bugs found!

== Installation ==

1. Download **WP Table of Paginated Contents**;
1. Extract its content;
1. Upload the **wp-table-of-paginated-contents** folder to **wp-content/plugins**;
1. Activate it under **Plugins**;

== Usage ==

This plugin provides two main methods to be used within the loop (http://codex.wordpress.org/The_Loop).

To echo the table of contents:
`<?php wptopc($format="list|select", $prepend="", $append="", $left='« ', $right=' »', $separator=' | '); ?>`

To echo the next/prev navigation links:
`<?php wptopc_pagination_links($prepend="", $append="", $left='« ', $right=' »', $separator=' | '); ?>`

**Usage Examples**

To output the Table of Contents use the following snippet, inside your post loop:

`<?php if( function_exists( 'wptopc' ) ){ wptopc(); } ?>`

Alternatively you may output the Table of Contents as a drop down menu using the snippet:

`<?php if( function_exists( 'wptopc' ) ){ wptopc("select", "The Post Table of Contents"); } ?>`

To output a next/prev navigation with the section titles, use the following snippet, inside your post loop:

`<?php if( function_exists( 'wptopc_pagination_links' ) ){ wptopc_pagination_links(); } ?>`

To store the output of these functions prefix them with "get_", like in:
`get_wptopc()`
or
`get_wptopc_pagination_links()`


== Screenshots ==

1. The TinyMCE button.
1. The naming prompt.
1. The outputs (check the usage section).

== Changelog ==

= 2.1 (19/12/2015) =
* Added 3 parameters to link functions to allow more customization.

= 1.3 (19/04/2014) =
* Fixed TinyMCE plugin;
* Tested under 3.9.

= 1.2 (01/07/2012) =
* Added prepend and append options;
* Tested under 3.4.1.

= 1.1.1 (25/04/2012) =
* Tested under 3.3.2.

= 1.1 (25/04/2012) =
* Feature: added 'get_' alternative methods, providing the ability to store outputs (without echoing).

= 1.0.1 (03/04/2012) =
* Images and donators list included (no longer remotely loaded).

= 1.0 (26/03/2012) =
* Initial release.
