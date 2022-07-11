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
?>

<section class="tax_section">
	<div class="container">
		<div class="before_ads mb-5" id="liner_nyito_fekvo_1">
			<script type="text/javascript">
				activateBanner('liner_nyito_fekvo_1');
			</script>
		</div>
		<div class="row">
			<div class="col-lg-8 category-wide-section">
				<?php
				$term = $queried_object = get_queried_object();
				$sub_categories = get_terms(array(
					'taxonomy' => 'news_cat',
					'parent' => $term->term_id,
				));
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if ($term->parent !== 0) :
					echo '<div class="col-sm-12">
					<div class="tax-title">
						<h1 class="page_title">' . str_replace('#', '', $term->name) . '</h1>
					</div>
			</div>';
					echo '<div class="col-sm-12" style="height:50px"></div>';
				endif;

				$args = array(
					'post_type'              => 'linernews',
					'post_status'            => 'publish',
					'posts_per_page'         => count($sub_categories) ? 4 : 10,
					//'page' 				=>	 $paged		,
					'paged' 				=>	 $paged,
					'tax_query' 			 => array(
						array(
							'taxonomy' 	=> 'news_cat',
							'field'    	=> 'slug',
							'terms'    	=> $term->slug,
						)
					)
				);

				$the_query = new WP_Query($args);

				$count = $the_query->found_posts;
				$last = '';
				$i = 1;
				global $postnot;

				if ($the_query->have_posts()) {
					echo '<div class="col-sm-12">';

					/* Start the Loop */
					while ($the_query->have_posts()) {
						$the_query->the_post();

						//if (strlen($the_query->post->post_excerpt) > 120){
						//$excpt = substr($the_query->post->post_excerpt, 0, 120) . ' ...';
						//}else {
						$excpt = $the_query->post->post_excerpt;
						//}

						$image_attribute = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'singlepagebanner-thumb');

						if ($i == $count) {
							$last = ' last';
						} else {
							$last = '';
						}
						$ttln = $the_query->post->post_title;

						$poplr = get_field('most_popular_news', $the_query->post->ID);
						$brknews = get_field('breaking_news', $the_query->post->ID);

						if ($poplr == 1) {
							$popular = ' post-background-green px-2';
						} else {
							$popular = '';
						}

						if ($brknews == 1) {
							$breaknews = ' post-background-yellow px-2';
							$popular = '';
						} else {
							$breaknews = '';
						}


						// echo '<div class="sponsorchildbox_wrapper' . $last . '">';


						?>
						<?php if ($i == 1) :  ?>
							<div class="top-section d-flex">
								<div class="article-image" style="max-width:40%;">
									<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'full')[0] ?>" alt="image" class="img-fluid w-100 h-100" style="object-fit:cover;">
								</div>
								<div class="w-full top-right-section <?php echo $popular . $breaknews ?>">
									<?php echo getCategoryOrSub($the_query->post->ID) ?>
									<span><?php echo get_post_time('H:i') ?></span>
									<h6 class="title post-title1">
										<a href="<?php echo get_the_permalink($the_query->post->ID) ?>" class="text-body"><?php echo $ttln ?></a>
									</h6>
									<p class="text-body"><?php echo $excpt ?></p>
								</div>
							</div>
							<div class="row mb-5" style="row-gap:20px;">
							<?php endif; ?>
							<?php if ($i > 1 && $i <= count($the_query->posts)) : ?>
								<div class="col-lg-4 col-12">
									<div>
										<div class="article-image" style="max-width:100%;">
											<img src="<?php echo $image_attribute[0] ?>" alt="image" class="img-fluid w-100 h-100" style="object-fit:cover;">
										</div>
										<div class="pt-2 <?php echo $popular . $breaknews; ?>">
											<div class="d-flex">
												<?php echo getCategoryOrSub($the_query->post->ID) ?>
												<span><?php echo get_post_time('H:i') ?></span>
											</div>

											<h6 class="title post-title2">
												<a href="<?php echo get_the_permalink($the_query->post->ID) ?>" class="text-body"><?php echo $ttln ?></a>
											</h6>
										</div>
									</div>
								</div>
							<?php endif; ?>
							<?php if ($i == count($the_query->posts)) : echo '</div>';
									endif; ?>
						<?php

								// echo '</div>';

								$postnot[] = $the_query->post->ID;
								$i++;
							}

							if (count($sub_categories) < 1) :
								$big = 999999999; // need an unlikely integer
								echo '<div class="text-center">';
								echo '<div class="page-links page cat aut">';
								echo paginate_links(array(
									'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
									'format' => '?paged=%#%',
									'current' => max(1, get_query_var('paged')),
									'total' => $the_query->max_num_pages
								));
								echo '</div>';
								echo '</div>';
							endif;

							echo '</div>';
						} else { ?>
						<div class="col-md-8 col-sm-12">
							<h3 class="text-uppercase text-center">not found</h3>
						</div>
					<?php } ?>



					<div class="row">
						<?php
						wp_reset_postdata();
						wp_reset_query();

						foreach ($sub_categories as $category) :
							$cat_id = $category->term_id;
							$cat_name = $category->name;
							$cat_args = array(
								'post_type'              => 'linernews',
								'post_status'            => 'publish',
								'posts_per_page'         => 4,
								'post__not_in'           => $postnot,
								'tax_query' 			 => array(
									array(
										'taxonomy' 	=> 'news_cat',
										'field'    	=> 'slug',
										'terms'    	=> $category->slug,
									)
								)
							);

							$query = new WP_Query($cat_args);
							if ($query->have_posts()) : ?>
								<div class="row">
									<div class="col-sm-12">
										<div class="tax-title">
											<h1 class="page_title"><?php echo str_replace('#', '', $cat_name) ?></h1>
										</div>
									</div>
									<div class="col-sm-12" style="height:50px"></div>
									<div class="w-full">
										<?php
												$c = 1;
												while ($query->have_posts()) : $query->the_post();


													$excpt = $query->post->post_excerpt;


													$image_attribute = wp_get_attachment_image_src(get_post_thumbnail_id($query->post->ID), 'singlepagebanner-thumb');

													if ($i == $count) {
														$last = ' last';
													} else {
														$last = '';
													}
													$ttln = $query->post->post_title;

													$poplr = get_field('most_popular_news', $query->post->ID);
													$brknews = get_field('breaking_news', $query->post->ID);

													if ($poplr == 1) {
														$popular = ' post-background-green px-2';
													} else {
														$popular = '';
													}

													if ($brknews == 1) {
														$breaknews = ' post-background-yellow px-2';
														$popular = '';
													} else {
														$breaknews = '';
													}

													if ($c == 1) :  ?>
												<div class="top-section d-flex">
													<div class="article-image" style="max-width:40%;">
														<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($query->post->ID), 'full')[0] ?>" alt="image" class="img-fluid w-100 h-100" style="object-fit:cover;">
													</div>
													<div class="w-full top-right-section <?php echo $popular . $breaknews ?>">
														<?php echo getCategoryOrSub($query->post->ID) ?>
														<span><?php echo get_post_time('H:i') ?></span>
														<h6 class="title post-title1">
															<a href="<?php echo get_the_permalink($query->post->ID) ?>" class="text-body"><?php echo $ttln ?></a>
														</h6>
														<p class="text-body"><?php echo $excpt ?></p>
													</div>
												</div>
											<?php endif; ?>
											<?php if ($c == 2) : ?>
												<div class="row mb-5">
												<?php endif; ?>
												<?php if ($c > 1 && $c <= count($query->posts)) : ?>
													<div class="col-lg-4 col-12">
														<div>
															<div class="article-image" style="max-width:100%;">
																<img src="<?php echo $image_attribute[0] ?>" alt="image" class="img-fluid w-100 h-100" style="object-fit:cover;">
															</div>
															<div class="pt-2 <?php echo $popular . $breaknews; ?>">
																<div class="d-flex">
																	<?php echo getCategoryOrSub($query->post->ID) ?>
																	<span><?php echo get_post_time('H:i') ?></span>
																</div>

																<h6 class="title post-title2">
																	<a href="<?php echo get_the_permalink($query->post->ID) ?>" class="text-body"><?php echo $ttln ?></a>
																</h6>
															</div>
														</div>
													</div>
												<?php endif; ?>
											<?php if ($c == count($query->posts) && $c > 1) : echo '</div>';
														endif;


														$postnot[] = $query->post->ID;
														$c++;
													endwhile; ?>
												</div>
									</div>


							<?php
								endif;
							endforeach; ?>
								</div>

					</div>
					<div class="col-lg-4 col-sm-12 category-wide-sidebar">

						<div class="news_sidebar">

							<?php
							$output = '';
							$ttln = '';



							// The Loop
							$posts = PVC_GET_MOST_VIEWED_POSTS(array(
								'post_type'              => 'linernews',
								'post_status'            => 'publish',
								'posts_per_page'         => 6,
								'post__not_in'           => $postnot,
								'tax_query' 			 => array(
									array(
										'taxonomy' 	=> 'news_cat',
										'field'    	=> 'slug',
										'terms'    	=> $term->slug,
									)
								),
							));

							if ($posts) {
								$output .= '<div class="justin_single" style="padding-top:60px">
								<div class="sidebar-img">
								<img src="' . get_template_directory_uri() . '/images/24_liner.png" class="img-responsive">
								</div>
								<ul>';
								foreach ($posts as $post) {

									$ttln = $post->post_title;
									$poplr = get_field('most_popular_news', $post->ID);
									$brknews = get_field('breaking_news', $post->ID);

									if ($poplr == 1) {
										$popular = 'fontos';
									} else {
										$popular = '';
									}

									if ($brknews == 1) {
										$breaknews = 'fontos';
										$popular = '';
									} else {
										$breaknews = '';
									}

									$output .= '<li>          
								  <span>
								  
									<span>' . get_post_time('H:i') .  '</span>
									';
									if ($poplr == 1 || $brknews == 1) {
										$output .= '<img class="fontos-img" src="' . get_bloginfo("template_url") . '/images/fontos.png" style="width:15px" />';
									}
									$output .= '            
								  </span>
								  <h6>
									<a href="' . get_the_permalink($post->ID) . '">' . $ttln . '</a>
								  </h6>
								</li>';
								}
								$output .= '</ul></div>';
							}

							// Restore original Post Data
							echo $output;

							?>
						</div>
						<div class="sdbrstcky_post">
							<?php echo do_shortcode('[sidebar-sticky]'); ?>
						</div>
						<div>
							<img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;">
						</div>
						<div class="mt-4">
							<img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;">
						</div>
					</div>
							</div>
			</div>
</section>

<?php get_footer(); ?>