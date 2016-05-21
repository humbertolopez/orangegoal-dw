<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); ?>
	<title>orangegoal's Digital Waiter — Serve the hungriest digital customers</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body>
<div class="head-bar block">
	<div class="wrapper">
		<ul>
			<li class="phones"><span>CALL US</span> (713) 239-1457 <span>/</span> (281) 990 2911 <span>FAX </span>(713) 238-1458</li>
			<li class="rrss"><a href="https://www.facebook.com/Orangegoal-191623731221163/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/fb.png"></a><a href="https://twitter.com/orange_goal/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/tw.png"></a><a href="https://plus.google.com/107227599284932738595/posts"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/gp.png"></a><a href="http://orangegoal.blogspot.mx/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/bg.png"></a><a href="https://es.pinterest.com/orangegoal/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/pn.png"></a><a href="https://www.flickr.com/photos/141020161@N07/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/fr.png"></a><a href="https://www.linkedin.com/company/orangegoal"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/lk.png"></a><a href="https://www.instagram.com/orange_goal/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/in.png"></a><a href="https://www.behance.net/orangegoalmarketing/"><img src="<?php echo get_template_directory_uri(); ?>/img/rrss/be.png"></a>
			</li>
			<li class="session-button">
				<?php if(is_user_logged_in()) {
					?><a href="<?php echo bloginfo('url'); ?>/my-account/customer-logout/">LOGOUT</a><?php
				} else {
					?><a href="<?php echo home_url('member-login'); ?>">LOGIN</a><?php
				} ?>
			</li>
		</ul>
	</div>
</div>
<?php if(is_home()) {
	?>
		<header>
			<a href="<?php bloginfo('url'); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		</header>		
	<?php
	} elseif(is_page('member-login')) {
	?>
		<header>
			<a href="<?php bloginfo('url'); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		</header>
	<?php

	} elseif(is_page('my-account')) {
	?>
		<header>
			<a href="<?php bloginfo('url'); ?>/my-account/edit-account">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		</header>
		<section id="toolbar" class="block">
			<ul class="wrapper block">
				<li class="user-info">
					<?php global $current_user; get_currentuserinfo(); ?>
						<p>Hello, <strong><?php echo $current_user->display_name; ?></strong>!</p>
						<?php $businessname = get_the_author_meta('businessname',$current_user->ID);
							if(isset($businessname)){
								?> <p class="user-info-p">Business name: <?php echo get_the_author_meta('businessname',$current_user->ID); ?></p> <?php
							}
						?>
					<p class="user-info-p"><a href="<?php echo wc_customer_edit_account_url(); ?>">Edit your restaurant info.</a></p>
					<p class="logout-link"><a href="<?php echo wc_get_endpoint_url('customer-logout'); ?>">Logout and come back later!</a></p>
				</li>
				<?php
					$querydiagnosticos = new WP_Query(array(
							'post_type' => 'product',
							'product_cat' => 'diagnostics',
							'posts_per_page' => -1,
						));
				?>
				<?php if($querydiagnosticos->have_posts()) : while($querydiagnosticos->have_posts()) : $querydiagnosticos->the_post(); ?>
				<li id="<?php echo $post->post_name; ?>" class="product-item">
					<?php the_post_thumbnail(); ?>
					<p><?php the_title(); ?></p>
				</li>
				<?php endwhile; endif; ?>
			</ul>
		</section>
	<?php
	}
?>