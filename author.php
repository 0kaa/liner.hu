<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */


get_header(); ?>
<?php
$metavalue= '';
	//$author = $_GET['a'];
	$author = isset($_GET['a']) ? $_GET['a'] : '';
	if(!empty($author)){
		$metavalue= $author;
		$metavalue=  get_the_author();
	}
	$metavalue=  get_the_author();
?>
<section class="tax_section">
	<div class="container">
	  <div class="page_banner">
			<div class="before_ads" id="liner_nyito_fekvo_1"><script type="text/javascript">activateBanner('liner_nyito_fekvo_1');</script></div>
		</div>
		<div class="row">
	
				<?php
				//$term = $queried_object = get_queried_object();
				echo '<div class="col-sm-12"><h1 class="page_title">'.$metavalue.'</h1></div>';
				$args = array (
								'post_type'              => 'linernews',
								'post_status'            => 'publish',
								'posts_per_page'         => 10,
								'meta_query' 			 => array(
																array(
																	'key'   	=>'news_author',
                      												'value' 	=> $metavalue,
																	'operator'	=>'IN'
																)
															)
							);

				$the_query = new WP_Query( $args );

				$count = $the_query->found_posts;
				$last='';
				$i=1;

			 if ( $the_query->have_posts() ) {
			 	echo '<div class="col-md-8 col-sm-12">';

			/* Start the Loop */
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
					$excpt = $the_query->post->post_excerpt;
				if($i==$count){
					$last=' last';
				}else{
					$last='';
				}
				echo '<div class="sponsorchildbox_wrapper'.$last.'">';

?><div class='box_left_side'>
	<img src="<?php bloginfo('template_url')?>/images/news_box.png" class="box-left-img" />
	<div class='line-left'> </div>
</div>
<div class='box_right_side'>
<div class='datebox'>
<?php echo get_the_date('Y.m.d', $the_query->post->ID); ?>

</div>
<div class='line-top'> </div>
<?php

				echo '<h3> <a href="'.get_the_permalink($the_query->post->ID).'" >'.$the_query->post->post_title.'</a></h3>';
				echo '<p >'.$excpt.'</p>';
				?>
				</div>

				<?php
				echo '</div>';
				$i++;
			}
			echo '</div>';
		}else{ ?>
			<div class="col-md-8 col-sm-12"><h3 class="text-uppercase text-center">not found</h3></div>
		<?php } ?>

		<div class="col-md-4 col-sm-12"><?php if(is_active_sidebar( 'sidebar-5' )) : ?><div class="news_sidebar"><?php dynamic_sidebar( 'sidebar-5' ); ?></div><?php endif; ?>
		<div class="sdbrstcky_post">
			<?php echo do_shortcode('[sidebar-sticky]');?>
		</div></div>

	</div></div>
</section>

<?php get_footer(); ?>

<?php
get_header(); ?>

you ae here

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
				/*
				 * Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<header class="archive-header">
				<h1 class="archive-title">
				<?php
				/* translators: Author display name. */
				printf( __( 'Author Archives: %s', 'liner' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
				?>
				</h1>
			</header><!-- .archive-header -->

			<?php
				/*
				 * Since we called the_post() above, we need
				 * to rewind the loop back to the beginning.
				 * That way we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php liner_content_nav( 'nav-above' ); ?>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) :
				?>
			<div class="author-info">
				<div class="author-avatar">
					<?php
					/**
					 * Filters the author bio avatar size.
					 *
					 * @since Liner Hu 1.0
					 *
					 * @param int $size The height and width of the avatar in pixels.
					 */
					$author_bio_avatar_size = apply_filters( 'liner_author_bio_avatar_size', 68 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2>
					<?php
					/* translators: Author display name. */
					printf( __( 'About %s', 'liner' ), get_the_author() );
					?>
					</h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
				?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php liner_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
