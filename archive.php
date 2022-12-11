<?php

/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Liner Hu already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header();

function getCategoryOrSub($id)
{
	$categories = wp_get_post_terms($id, 'news_cat', array('fields' => 'all'));
	$parentCategory = '';
	$childCategory = '';
	$parentLink = '';
	$childLink = '';
	foreach ($categories as $category) {
		if ($category->parent == 0) {
			$parentCategory = $category->name;
			$parentCategory = str_replace('#', '', $parentCategory);
			$parentLink = get_term_link($category->slug, 'news_cat');
		}
		if ($category->parent != 0) {
			$childCategory = $category->name;
			$childCategory = str_replace('#', '', $childCategory);
			$childLink = get_term_link($category->slug, 'news_cat');
		}
	}


	if ($childCategory != '') {
		$output = '<a href="' . $childLink . '" class="tag-slug mr-2 mb-1">' . $childCategory . '</a>';
	} else {
		$output = '<a href="' . $parentLink . '" class="tag-slug mr-2 mb-1">' . $parentCategory . '</a>';
	}
	return $output;
}
$term = get_queried_object();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_type'              => 'linernews',
	'post_status'            => 'publish',
	'posts_per_page'         => 5,
	'paged' 				=>	 $paged,
	'tax_query' 			 => array(
		array(
			'taxonomy' 	=> 'newstag',
			'field'    	=> 'slug',
			'terms'    	=> $term->slug,
		)
	)
);

$the_query = new WP_Query($args);
global $postnot;

?>


<section class="tax_section category-page">
	<div class="container">
		<div class="before_ads mb-5" id="liner_nyito_fekvo_1">
			<script type="text/javascript">
				activateBanner('liner_nyito_fekvo_1');
			</script>
		</div>
		<div class="row">
		<?php if ($term->slug == 'vb-2022') : ?>
				<div class="col-lg-12">
					<div class="d-flex align-items-center justify-content-between world-cup-header mt-4">
						<div class="d-flex align-items-center">
							<h3 class="world-cup-title mb-0">
								<svg width="159" height="26" viewBox="0 0 159 26" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M68.5232 16.2846C67.4134 16.2846 66.939 14.8138 66.939 10.7674C66.939 8.66486 67.9697 8.14161 70.901 8.14161C71.6713 8.14161 72.2862 8.14703 72.8766 8.15652C71.9413 11.0195 70.687 16.2846 68.5246 16.2846M62.5802 13.5246C62.5802 14.5955 62.6824 15.5092 62.8692 16.2846H47.3619C45.3004 16.2846 43.982 15.8101 43.982 13.9177V8.66621H48.8657C49.2652 7.48551 49.527 6.40511 49.6592 5.25287H43.9834C44.0065 3.63295 44.1252 2.18519 44.2451 0.524609C42.3964 1.18071 40.9443 1.94119 39.7541 3.2561V5.25422H37.2441C37.0341 6.67351 37.0341 7.74849 36.9809 8.66757H39.7541V14.1834C39.7541 18.0441 42.106 19.7006 45.3277 19.7006H66.4086C68.9909 19.7006 70.976 17.5941 72.882 12.8306V19.6993H77.1086V5.25422C75.2067 5.09562 73.4615 4.98989 71.5609 4.98989C66.3309 4.98989 62.5775 7.14525 62.5775 13.526M84.7696 11.9237V10.5057C84.7696 8.66621 84.6359 7.08968 84.3742 5.25287H80.2785C80.4108 7.08968 80.543 8.66621 80.543 10.5057V19.6979H84.7696C84.7696 14.5481 86.4329 8.69062 90.8435 9.32367C90.8435 8.40323 90.7113 6.30073 90.4481 4.98853C87.2291 5.26642 85.6517 8.08738 84.7696 11.9223M26.5454 16.2846C25.4356 16.2846 24.9598 14.8138 24.9598 10.7674C24.9598 8.66621 25.9919 8.14161 28.9219 8.14161C29.6922 8.14161 30.3071 8.14703 30.8988 8.15652C29.9621 11.0195 28.7105 16.2846 26.5454 16.2846M20.6024 13.5233C20.6024 17.8841 22.1867 19.9595 24.2999 19.9595C26.8904 19.9595 28.9587 17.6795 30.9056 12.8211V19.6966H35.1322V5.25422C33.2302 5.09562 31.4864 4.98989 29.5831 4.98989C24.3531 4.98989 20.6024 7.14525 20.6024 13.526M158.34 6.82941C158.34 3.2317 155.83 1.05057 151.339 1.05057C148.858 1.05057 147.035 1.57518 145.925 2.1025C145.291 2.99447 145.001 4.02065 144.602 5.64599C146.293 4.98989 147.932 4.46663 150.415 4.46663C152.396 4.46663 153.983 5.30709 153.983 7.61835C153.983 10.1099 152.423 11.9237 143.943 16.8092C143.943 17.3351 143.97 18.3844 144.207 19.6993H158.207C158.605 18.5172 158.868 17.468 159 16.2859H147.084C153.036 14.2607 158.34 12.1473 158.34 6.82941ZM10.6509 15.6637L10.4328 15.5471C7.89955 14.2092 4.48968 12.1623 4.48968 8.43034C4.48968 5.01429 6.71203 3.41199 9.37748 3.41199C12.3374 3.41199 14.133 5.48603 14.133 9.11491C14.133 11.6119 12.7492 13.8147 10.6509 15.6637M18.755 19.9609L11.7975 16.271C15.7364 14.8477 18.6254 12.0416 18.6254 8.06163C18.6254 2.70302 14.5816 0 9.37885 0C4.59876 0 0 3.04463 0 8.92784C0 13.892 3.80389 16.8593 7.97727 19.0405L21.3959 26C21.3959 22.9283 21.0278 21.166 18.755 19.9595M117.66 18.3816C116.474 18.3816 112.772 15.9918 112.772 9.5853C112.772 6.43087 114.624 4.46392 117.66 4.46392C120.698 4.46392 122.549 6.43087 122.549 9.5853C122.549 15.9918 118.851 18.383 117.66 18.383M117.66 1.04786C112.378 1.04786 108.414 4.19958 108.414 9.32231C108.414 16.0189 114.887 19.9595 117.66 19.9595C120.435 19.9595 126.904 16.0189 126.904 9.32231C126.904 4.19823 122.945 1.04786 117.66 1.04786ZM117.719 8.20938C116.809 8.85707 115.995 9.62975 115.303 10.5044C115.996 11.3783 116.809 12.1509 117.719 12.7994C118.628 12.1494 119.442 11.377 120.138 10.5044C119.443 9.63113 118.63 8.85866 117.72 8.20938M141.967 6.82669C141.967 3.22899 139.456 1.04786 134.963 1.04786C132.482 1.04786 130.659 1.57247 129.549 2.09979C128.917 2.99176 128.625 4.01794 128.227 5.64327C129.92 4.98717 131.559 4.46392 134.042 4.46392C136.021 4.46392 137.608 5.30438 137.608 7.61564C137.608 10.1072 136.05 11.921 127.569 16.8065C127.569 17.3324 127.597 18.3816 127.834 19.6966H141.836C142.23 18.5145 142.495 17.4653 142.627 16.2832H130.711C136.665 14.258 141.967 12.1446 141.967 6.82669M106.3 6.82669C106.3 3.22899 103.794 1.04786 99.3034 1.04786C96.8193 1.04786 94.9964 1.57247 93.8894 2.09979C93.254 2.99176 92.9622 4.01794 92.5669 5.64327C94.2575 4.98717 95.8963 4.46392 98.379 4.46392C100.359 4.46392 101.944 5.30438 101.944 7.61564C101.944 10.1072 100.385 11.921 91.907 16.8065C91.907 17.3324 91.9329 18.3816 92.1715 19.6966H106.174C106.569 18.5145 106.832 17.4653 106.963 16.2832H95.0469C100.998 14.258 106.302 12.1446 106.302 6.82669" fill="#EEEEE4" />
								</svg>
							</h3>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="col-lg-12">
				<?php
				if ($the_query->have_posts()) :
					$i = 1;
					while ($the_query->have_posts()) :
						$the_query->the_post();
						$excpt = $the_query->post->post_excerpt;
						$ttln = $the_query->post->post_title;
						$poplr = get_field('most_popular_news', $the_query->post->ID);
						$brknews = get_field('breaking_news', $the_query->post->ID);

						if ($poplr == 1) {
							$popular = ' post-background-green';
						} else {
							$popular = '';
						}

						if ($brknews == 1) {
							$breaknews = ' post-background-yellow';
							$popular = '';
						} else {
							$breaknews = '';
						}
						if ($i == 1) : ?>
							<section class="full desktop-only mb-5">
								<div class="immersive-break-2 d-lg-flex align-items-center">
									<div class="w-50 h-100 image-part">
										<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
									</div>
									<div class="w-50 p-5 text-part">
										<h1 class="mb-4 post-title" style="font-size:32px;">
											<a href="<?php echo get_the_permalink($the_query->post->ID) ?>" class="title-slug">
												<?php echo $ttln ?>
											</a>
										</h1>
										<p class="post-description text-white"><?php echo $excpt ?></p>
										<!-- <a href="' . $link . '" class="tovabb-btn-2">Tovább</a> -->
									</div>
								</div>
							</section>
						<?php endif;
								if ($i == 2) : echo '<div class="row">';
								endif;
								if ($i > 1 && $i <= 5) : ?>
							<div class="mb-4 col-12 col-lg-3 d-flex flex-column justify-content-between">
								<div class="h-100" style="padding:0 !important;">
									<div>
										<img class="w-100 mob-image3" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] ?>">
									</div>
									<div class=" <?php echo $popular . $breaknews ?>">
										<div>
											<p class="post-tagline">
												<?php echo getCategoryOrSub($the_query->post->ID) ?>
												<span>|</span>
												<span><?php echo get_post_time('H:i') ?></span>
											</p>
										</div>
										<h2 class="post-title post-title2">
											<a class="title-slug" href="<?php echo get_the_permalink($the_query->post->ID) ?>">
												<?php echo $ttln ?>
											</a></h2>
										<p class="post-description section1-description">
											<?php echo $excpt ?>
										</p>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($i == 5) : echo '</div>';
								endif; ?>
				<?php
						$postnot[] = $the_query->post->ID;
						$i++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			<div class="col-lg-8 category-wide-section">
				<?php
				$args = array(
					'post_type'              => 'linernews',
					'post_status'            => 'publish',
					'posts_per_page'         => 10,
					'post__not_in'           => $postnot,
					'paged' 				=>	 $paged,
					'tax_query' 			 => array(
						array(
							'taxonomy' 	=> 'newstag',
							'field'    	=> 'slug',
							'terms'    	=> $term->slug,
						)
					)
				);

				$the_query = new WP_Query($args);
				if ($the_query->have_posts()) {
					echo '<h2 class="egy-header-title single text-uppercase">További Hírek</h2>';
					/* Start the Loop */
					while ($the_query->have_posts()) {
						$the_query->the_post();

						$excpt = $the_query->post->post_excerpt;


						$image_attribute = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');


						$ttln = $the_query->post->post_title;

						$poplr = get_field('most_popular_news', $the_query->post->ID);
						$brknews = get_field('breaking_news', $the_query->post->ID);

						if ($poplr == 1) {
							$popular = ' post-background-green d-flex flex-column justify-content-center w-100';
						} else {
							$popular = '';
						}

						if ($brknews == 1) {
							$breaknews = ' post-background-yellow d-flex flex-column justify-content-center w-100';
							$popular = '';
						} else {
							$breaknews = '';
						}

						if ($brknews == 1 || $poplr == 1) {
							$normal = '';
						} else {
							$normal = 'ml-4';
						}
						?>

						<div class="cat-article-card mt-5">
							<div class="">
								<img class="w-100" src="<?php echo $image_attribute[0]; ?>">
							</div>
							<div class="<?php echo $popular . $breaknews . $normal; ?>">
								<div>
									<p class="post-tagline">
										<?php echo getCategoryOrSub($the_query->post->ID) ?>
										<span>|</span>
										<span><?php echo get_post_time('H:i') ?></span>
									</p>
								</div>
								<h2 class="post-title post-title1">
									<a class="title-slug" href="<?php echo get_the_permalink($the_query->post->ID) ?>">
										<?php echo $ttln ?>
									</a></h2>
								<p class="post-description section1-description mb-0">
									<?php echo $excpt ?>
								</p>
							</div>
						</div>

				<?php $postnot[] = $the_query->post->ID;
						$i++;
					}

					
						$big = 999999999; // need an unlikely integer
						echo '<div class="text-center mt-5">';
						echo '<div class="page-links page cat aut">';
						echo paginate_links(array(
							'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format' => '?paged=%#%',
							'current' => max(1, get_query_var('paged')),
							'total' => $the_query->max_num_pages
						));
						echo '</div>';
						echo '</div>';
					
					echo '</div>';
				}  ?>
				<?php if ($the_query->have_posts()) { ?>
				<div class="col-lg-4 col-sm-12 category-wide-sidebar">

					<?php if (is_active_sidebar('sidebar-5')) : ?><div class="news_sidebar category-sidebar" style="margin-top:-4px;"><?php dynamic_sidebar('sidebar-5'); ?></div><?php endif; ?>
					<div class="sdbrstcky_post">
						<?php echo do_shortcode('[sidebar-sticky]'); ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
</section>




<?php //get_sidebar(); 
?>
<?php get_footer(); ?>