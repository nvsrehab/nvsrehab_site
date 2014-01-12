<?php get_header(); ?>

<?php if(have_posts()) while(have_posts()): the_post(); ?>

<div id="pagetitle" class="pagetitle">
	<div class="container">
		<?php cpotheme_breadcrumb(); ?>
		<h1 class="title"><?php the_title(); ?></h1>
	</div>
</div>
		
<div id="main" class="main">
	<div class="container">
		<section id="content" class="content <?php cpotheme_sidebar_position(); ?>">
			<?php get_template_part('element', 'blog'); ?>
			<?php if(get_the_author_meta('description')) cpotheme_post_authorbio(); ?>
			<?php comments_template('', true); ?>
		</section>
		<?php get_sidebar('blog'); ?>
	</div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>