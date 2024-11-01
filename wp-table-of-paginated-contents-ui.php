<?php
$plugin_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__));
$plugin_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__));
$q=explode('&',$_SERVER['QUERY_STRING']);
$purl='http'.((!empty($_SERVER['HTTPS'])) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$q[0];
global $WPtopc, $echo;
$WPtopc->wptopc_page_action();
$wptopc_data=get_option('wptopc_data');
//print_r($wptopc_data);
?>
<div id="wptopc-page" class="wrap">
	<h2>Wp Table of Paginated Contents</h2>
	<?php 
	if(!current_user_can("administrator")) {
		echo '<p>'.__('Please log in as admin','wp-table-of-paginated-contents').'</p>';
		return;
		}
	?>
	
	<!-- SIDEBAR START -->
	
	<div id="wptopc-sidebar">
		<div class="wptopc-section">
			<div class="wptopc-section-title stuffbox">
				<!--<div title="Click to toggle" class="handlediv" style="background:url('<?php bloginfo("wpurl")?>/wp-admin/images/menu-bits.gif') no-repeat scroll left -111px transparent"><br></div>-->
				<h3><?php _e('About this Plugin', 'wp-table-of-paginated-contents'); ?></h3>
			</div>
			<div class="wptopc-inputs">
				<ul>
					<li><a href="http://antonioandra.de/"><img height ="16" width="16" src="<?php echo $plugin_url ?>/images/antonioandra.de_favicon.png"> Author Homepage</a></li>
					<li><a href="http://wordpress.org/extend/plugins/"><img src="<?php echo $plugin_url ?>/images/favicon.ico"> Plugin at WordPress.org </a></li>
					<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=antonio%40antonioandra%2ede&lc=US&item_name=WP%20Table%20of%20Paginated%20Contents%20%28Antonio%20Andrade%29&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest"><img width="16" src="<?php echo $plugin_url ?>/images/pp_favicon_x.ico"> Donate with Paypal</a></li>
				</ul>
			</div>
		</div>
        <!--
		<div class="wptopc-section">
			<div class="wptopc-section-title stuffbox">
				<h3><?php _e('Latest donations', 'wp-table-of-paginated-contents'); ?></h3>
			</div>

			<div class="wptopc-inputs">
				<iframe src="http://antonioandra.de/wp-table-of-paginated-contents-donations/" width="220"></iframe>
			</div>
		</div>
        -->
		<p id="foot">WP Table of Paginated Contents <?php _e('by', 'wp-table-of-paginated-contents'); ?> António Andrade</p>
	</div>
	
	<!-- SIDEBAR END -->
	
	<div id="wptopc-main">
		<form method="post" action="<?php echo $purl?>">
			<?php if($echo!=''){?>
				<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204);"><p><?php echo $echo;?></p></div>
			<?php }
			# Donation Message
			if(!isset($wptopc_data['donation_hidden_time']) || ($wptopc_data['donation_hidden_time']&&$wptopc_data['donation_hidden_time']<time())){?>
				<div class="updated">
					<p>
						<strong>Is this plugin useful? Consider making a donation encouraging me to continue supporting it!</strong>
						<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=antonio%40antonioandra%2ede&lc=US&item_name=WP%20Table%20of%20Paginated%20Contents%20%28Antonio%20Andrade%29&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest"><img alt="Donate" border="0" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png"></a>
						<span><a href="<?php echo $purl?>&action=hide_donation_message">Hide this message</a></span>
					</p>
				</div>
			<?php }?>
			
			<!-- Custom Author Permalink -->
			<div class="wptopc-section permanently-open">
				<div class="wptopc-section-title stuffbox">
					<h3><?php _e('Table of Paginated Contents', 'wp-table-of-paginated-contents');?></h3>
				</div>
				<table class="form-table wptopc-inputs">
					<tr valign="top">
						<th scope="row" style="width:18%;"><?php _e('Instructions', 'wp-table-of-paginated-contents'); ?></th>
						<td >
							<p class="description"><?php _e('This plugin provides two main methods to be used within <a href="http://codex.wordpress.org/The_Loop">the loop</a>.', 'wp-table-of-paginated-contents'); ?></p>
							<p class="description"><?php _e('To echo the table of contents:', 'wp-table-of-paginated-contents'); ?></p>
							<p><code>&lt;?php wptopc($format="list|select", $prepend="", $append=""); ?&gt;</code></p>
							<p class="description"><?php _e('To echo the next/prev navigation links:', 'wp-table-of-paginated-contents'); ?></p>
							<p><code>&lt;?php wptopc_pagination_links($prepend="", $append=""); ?&gt;</code></p>
							
							<h4><?php _e('Usage Examples', 'wp-table-of-paginated-contents'); ?></h4>
							<p class="description"><?php _e('To output the Table of Contents use the following snippet, inside your post loop:', 'wp-table-of-paginated-contents'); ?></p>
							<p><code>&lt;?php if( function_exists( &#39;wptopc&#39; ) ){ wptopc(); } ?&gt;</code></p>
							<p class="description"><?php _e('Alternatively you may output the Table of Contents as a drop down menu using the snippet:', 'wp-table-of-paginated-contents'); ?></p>
							<p><code>&lt;?php if( function_exists( &#39;wptopc&#39; ) ){ wptopc("select", "The Post Table of Contents"); } ?&gt;</code></p>
							<p class="description"><?php _e('To output a next/prev navigation with the section titles, use the following snippet, inside your post loop:', 'wp-table-of-paginated-contents'); ?></p>
							<p><code>&lt;?php if( function_exists( &#39;wptopc_pagination_links&#39; ) ){ wptopc_pagination_links(); } ?&gt;</code></p>
							<p class="description"><img src="<?php echo $plugin_url; ?>/images/WPtopc.png"/> <?php _e('Use this TinyMCE editor button to title your sections/pages.', 'wp-table-of-paginated-contents'); ?></p>
							<p class="description"><?php _e('To store the output of these functions prefix them with "get_", like in ', 'wp-table-of-paginated-contents'); ?><code>get_wptopc()</code> <?php _e('or', 'wp-table-of-paginated-contents'); ?> <code>get_wptopc_pagination_links()</code>.</p>
							<p class="description"><?php _e('Suggestions are welcome!', 'wp-table-of-paginated-contents'); ?></p>
						</td>
					</tr>
				</table>
			</div>
			
			<?php wp_nonce_field('wptopc_settings'); ?>
			<input type="hidden" name="action" value="update" />
			<div class="wptopc-menu">
				<!--<a class="button-secondary" href="<?php echo wp_nonce_url($purl."&action=reset_rules", 'wptopc_reset_settings'); ?>"><?php _e('Reset all rules', 'wp-table-of-paginated-contents'); ?></a>
				<input type="submit" class="button-primary" value="<?php _e('Save all changes', 'wp-table-of-paginated-contents'); ?>" />-->
			</div>
		</form>
	</div>
</div>
