<?php
/**
 * Template Name: Author Page Template 2
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */
get_header(); ?>
<?php
$metavalue= '';
	$author = $_GET['a'] ? $_GET['a'] : '';
	if(!empty($author)){
		$metavalue= $author;
	}
?>
<section class="tax_section">
	<div class="container">
	  <div class="before_ads" id="liner_nyito_fekvo_1"><script type="text/javascript">activateBanner('liner_nyito_fekvo_1');</script></div>
		<div class="row">
<!--	on author page  template 2-->
				<?php
				//$term = $queried_object = get_queried_object();
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

				echo '<div class="col-sm-12"><h1 class="page_title">'.$metavalue.'</h1></div>';
				$args = array (
								'post_type'              => 'linernews',
								'post_status'            => 'publish',
								'posts_per_page'         => 10,
								'paged'         => $paged,
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

			?>

			<?php
			  $big = 999999999; // need an unlikely integer
			  echo '<div class="page-links page cat aut pull-right">';
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $the_query->max_num_pages
				) );
				echo '</div>';

			/* wp_link_pages(
				array(
					'before' => '<div class="page-links">',
					'after'  => '</div>',
					'nextpagelink'  => '>',
					'previouspagelink'  => '<',
					'next_or_number'  => 'number',
				)
			); */

	?>

			<?php
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
