<div class="home-section-news">
	<header class="news-header">
		<h2 class="section-title">Recent News and Announcements</h2>
	</header>

	<?php query_posts('posts_per_page=5'); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<section class="news-post">
		<header>
			<time><?php echo get_the_date('n.j.y'); ?></time>
			<h5><?php the_title(); ?> &nbsp;<a href="<?php the_permalink(); ?>">learn more</a></h5>
		</header>
	</section>

	<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_query(); ?>

	<div class="news-footer">
		<?php 
			$posts_page_id = get_option('page_for_posts');
	    	$posts_page_url = get_page_uri($posts_page_id);
		?>
		<a href="<?php echo home_url( $posts_page_url ); ?>">All News &amp; Announcements &gt;</a>
	</div>
</div>