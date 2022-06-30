<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header(); ?>


	<section class="tax_section"><div class="container">
			<div class="before_ads" id="liner_nyito_fekvo_1"><script type="text/javascript">activateBanner('liner_nyito_fekvo_1');</script></div>
			<div class="row">
			<div class="col-sm-12">
			<h1 class="page-title page_title">
				<?php
				/* translators: %s: Search query. */
				printf( __( 'Keresési találatok: %s', 'liner' ), '<span>' . get_search_query() . '</span>' );
				?>
				</h1>
				</div>
		<?php
				$term = $queried_object = get_queried_object();
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;



				$s = ( get_query_var( 's' ) ) ? get_query_var( 's' ) : 1;
				//echo '<div class="col-sm-12"><h1 class="page_title">'.$term->name.'</h1></div>';
				echo '<div class="col-sm-12" style="height:50px"></div>';

				$args = array (
								'post_type'              => 'linernews',
								'post_status'            => 'publish',

								'posts_per_page'         => 10,
								'paged' 				=>	 $paged,
								//'page' 				=>	 $paged	,
								's'         => $s


							);

				$the_query = new WP_Query( $args );

				$count = $the_query->found_posts;
				$last='';
				$i=1;

			 if ( $the_query->have_posts() ) {
			 	echo '<div class="col-sm-8">';

			/* Start the Loop */
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				//if (strlen($the_query->post->post_excerpt) > 120){
					//$excpt = substr($the_query->post->post_excerpt, 0, 120) . ' ...';
				//}else {
					$excpt = $the_query->post->post_excerpt;
				//}

				if($i==$count){
					$last=' last';
				}else{
					$last='';
				}


				echo '<div class="sponsorchildbox_wrapper'.$last.'">';


				?>
				<div class='box_left_side'>
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
				//echo '<a href="'.get_the_permalink($the_query->post->ID).'" class="btn btn-default">Continue</a>';
				?>
				</div>

				<?php

				echo '</div>';


				$i++;
			}



			 $big = 999999999; // need an unlikely integer
			  echo '<div class="page-links page cat aut pull-right">';
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $the_query->max_num_pages
				) );
				echo '</div>';



			echo '</div>';
		}else{ ?>
			<div class="col-md-8 col-sm-12">


			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'liner' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'liner' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

			</div>



		<?php } ?>

		<div class="col-md-4 col-sm-12"><?php if(is_active_sidebar( 'sidebar-5' )) : ?><div class="news_sidebar"><?php dynamic_sidebar( 'sidebar-5' ); ?></div><?php endif; ?>
		<div class="sdbrstcky_post">
			<?php echo do_shortcode('[sidebar-sticky]');?>
		</div></div>

		</div></div>
	</section>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
