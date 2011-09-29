<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
	
    <?php 
	$data = get_option(OPTIONS);
	$slides = $data['homepage_slider'];
	foreach ($slides as $slide => $value) {
		if (!empty ($value['url'])) {
	?>
	<h3>Title: <?php echo $value['title']; ?></h3>
	
	<img src="<?php echo $value['url']; ?>" />
	
	<h3>Link: <a href="<?php echo $value['link']; ?>"><?php echo $value['title']; ?></a></h3>
	
	<h3>Description:</h3> 
	<p><?php echo $value['description']; ?></p>

	<?php } // if no url, don't show anything.
	} ?>
	
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
