<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); ?>
	<title>orangegoal's Digital Waiter — Serve the hungriest digital customers</title>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body>
<header>
	<?php if(is_home()) {
		?>
			<a href="<?php bloginfo('url'); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		<?php
		} elseif(is_page('member-login')) {
		?>
			<a href="<?php bloginfo('url'); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		<?php

		} else {
		?>
			<a href="<?php bloginfo('url'); ?>/my-account/edit-account">
				<img src="<?php echo get_template_directory_uri(); ?>/img/orangegoal-logo.png">
			</a>
		<?php
		}
	?>
</header>