<?php get_header(); ?>
<?php if(is_home())
	{
	?>
		<section id="welcome" class="block">
			<div class="block">
				<div class="waiter-window">
					
				</div>
				<div class="waiter-title">
					<h1>Hi! We are Orangegoal Digital Marketing and we'll serve you today.</h1>
					<h3>This is our services menu. Check it out! We'll give you a minute.</h3>
				</div>
				<div class="waiter-title">
					<p> Here you can take a look to our specialties and pick the professional marketing diagnostic that interest you the most. Take this opportunity and get your first diagnostic for</p>
					<div class="free-title">
						<p>Free</p>
					</div>
					<div class="regular-price">
						<p>from regular price of $89.99</p>
					</div>
				</div>
			</div>
		</section>
		<section id="diagnostics">
			<h2>Choose between any of our appetizing digital services</h2>
			<ul class="block">
				<?php
					$querydiagnosticos = new WP_Query(array(
						'post_type' => 'product',
						'product_cat' => 'diagnostics',
						'posts_per_page' => -1
					));
				?>
				<?php if($querydiagnosticos->have_posts()) : while($querydiagnosticos->have_posts()) : $querydiagnosticos->the_post(); ?>
					<li id="<?php echo $post->post_name; ?>">
						<?php the_post_thumbnail(); ?>
						<h3><?php the_title(); ?></h3>
						<p><?php the_content(); ?></p>
						<p class="free"><a href="#great-choice" class="click-<?php echo $post->post_name; ?>">FREE diagnostic</a></p>
					</li>
				<?php endwhile; endif; ?>
			</ul>
		</section>
		<section id="great-choice" class="block">
			<div class="wrapper">
				<div class="title">
					<h1>Great choice!</h1>
					<h2>Now, we have to ask you to login.</h2>
					<p>You need to create an account in order to have access to our diagnostics, results and suggestions. If you already have a facebook account, you can use it to log in or you can create your own with an e-mail and password.</p>
					<p class="to-login"><a href="#login">Login</a></p>
				</div>
				
			</div>
		</section>
		<section id="login" class="block login-home">
			<div class="register-form block">
				<?php echo do_shortcode('[custom-orangegoal-register]'); ?>
			</div>
		</section>
	<?php
	} else if (is_page('register-to-orangegoal')){
		?>
			<section id="login" class="block">				
				<div class="register-form block">
					<?php echo do_shortcode('[custom-orangegoal-register]'); ?>
				</div>
			</section>	
		<?php
	} else if (is_page('member-login')){
		?>
			<section id="login" class="block">
				<div class="register-form block">
					<?php echo do_shortcode('[login-orangegoal-form]'); ?>
				</div>
			</section>	
		<?php
	} else {
		if(have_posts()) : while(have_posts()) : the_post();

		the_content();

		endwhile; endif;
	}
?>
<?php get_footer(); ?>