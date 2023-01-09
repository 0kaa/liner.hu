<?php

/** * The Template for displaying all single posts * * @package
WordPress * @subpackage Liner_Hu * @since Liner Hu 1.0 */

get_header();
// get slug
$post = get_post();
$slug = $post->post_name;

?>
<!--<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/all.js#xfbml=1&version=v9.0" nonce="lxEL1L0D"></script>-->

<div class="container">
	<div class="single_news" data-slug="<?php echo $slug; ?>">
		<div class="single_news_wrapper">
			<div class="mb-4">
				<?php
				global $article_id;
				while (have_posts()) :
					the_post();
					// asign global id to the post
					$article_id = get_the_ID();

					?>
					<div class="liner_v">

					</div>
					<div>

						<?php
							$id = get_the_id();
							$terms = get_the_terms($id, 'news_cat');
							?>

						<!--liner_cikk_fekvo_1
<div class="before_ads">
	<div id="liner_cikk_fekvo_1">
	</div>
</div> 
liner_cikk_fekvo_1-->





						<!-- breadcrumb -->
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>">KEZDŐLAP</a></li>
								<?php if ($terms && count($terms) > 0) : ?>
									<li class="breadcrumb-item">
										<a href="<?php $term = $terms[0];
															echo get_term_link($term->term_id); ?>">
											<?php echo str_replace('#', '', $term->name); ?>
										</a>
									</li>
								<?php endif; ?>
								<?php if ($terms && count($terms) > 1) : ?>
									<li class="breadcrumb-item">
										<a href="<?php $term = $terms[1];
															echo get_term_link($term->term_id); ?>">
											<?php echo str_replace('#', '', $term->name); ?>
										</a>
									</li>
								<?php endif; ?>
							</ol>
						</nav>
					</div>
					<h1 class="page_title mt-4 mb-5"><?php the_title(); ?></h1>
					
					<!-- tags -->
					<div class="single-tags">
						<?php
							$tags = [];
							$terms = get_the_terms($post->ID, 'newstag');
							if ($terms && !is_wp_error($terms)) :
								foreach ($terms as $term) {
									if ($term->count >= 10 && ($term->slug !== 'orosz-ukran-haboru-fontosabb-tortenesek' && $term->slug !== 'orosz-ukran-rovid')) {
										$tags[] = array(
											'name' => $term->name,
											'slug' => $term->slug
										);
									}
								}
							endif;

							?>
						<?php if (count($tags) > 0) : ?>
							<div class="liner_tags d-flex align-items-center">
								<div class="liner-tags-title">TÉMÁK:</div>
								<?php foreach ($tags as $tag) : ?>
									<a href="<?php echo get_term_link($tag['slug'], 'newstag'); ?>" class="liner_tag m-0">#<?php echo $tag['name']; ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

					</div>



				<?php endwhile; ?>
			</div>
			<div class="article-date d-lg-none mt-4"><?php echo  get_the_date('Y. F j. - H:i'); ?></div>
			<div class="d-flex wrap-mobile" style="gap:15px;">
				<div class="article-content-wrapper">
					<?php
					while (have_posts()) :

						// echo get_the_category_rss($type);

						the_post();
						//$child_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full' );
						// key notes
						$key_notes = get_field('key_notes', $post->ID);
						//$newstype = get_field('news_type',$post->ID);
						//$vdolnk = get_field('video_url',$post->ID);
						//$sldrimg = acf_photo_gallery('slider_images',$post->ID);

						/* if($newstype == 'video'){
              $sldrimg = '';
            }elseif($newstype == 'slider'){
              $vdolnk = '';
            }else{
              $vdolnk = '';
              $sldrimg = '';
            } */
						?>



						<div class="page_banner">
							<?php
								/*
		if($newstype == 'video'){
          echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'.$vdolnk.'"></iframe></div>';
        }elseif($newstype == 'slider'){
          $vdolnk = '';
	        if( count($sldrimg) ){
	        	echo '<div class="owl-carousel owl-theme" id="slider-'.$post->ID.'">';
	        	foreach($sldrimg as $simage){
	        		$child_thumb = wp_get_attachment_image_src( $simage['id'],'large' );
	        		echo '<div class="item"><img src="'.$child_thumb[0].'" class="img-responsive" /></div>';
	        	}
	        	echo '</div>';
	        }

	        echo '<script>
			jQuery(function($){
			  $("#slider-'.$post->ID.'").owlCarousel({
					loop:false,
					items:1,
					margin:0,
					nav:true,
					navText:[\'<i class="fa fa-angle-left"></i>\',\'<i class="fa fa-angle-right"></i>\'],
					dots:false,
					smartSpeed:800,
					autoplay:false,
			  });
			})
			</script>';

        }else{
			*/
								$vdolnk = '';
								$sldrimg = '';
								$caption = '';
								$child_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'cikkoldali');
								// get article terms newstag
								$tags = [];
								$terms = get_the_terms($post->ID, 'newstag');
								foreach ($terms as $term) {
									$tags[] = $term->slug;
								}
								$has_orosz = in_array('orosz-ukran-rovid', $tags);
								$defaultClass = '';
								if ($has_orosz == 1) {
									$defaultClass = 'd-none';
								} else {
									$defaultClass = '';
								}
								if ($child_thumb) {
									$image_cap = wp_get_attachment_caption(get_post_thumbnail_id($post->ID));
									if (!empty($image_cap)) {
										$caption = '<span class="test">
									<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0">
									<g clip-path="url(#clip0_22_131)">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M12.7372 2L13.7917 3.58175C14.07 3.9995 14.538 4.25 15.0397 4.25H17.9872V17H-0.0127563V4.25H4.43474C4.93649 4.25 5.40449 3.9995 5.68274 3.58175L6.73724 2H12.7372ZM15.0397 5C14.2852 5 13.5862 4.625 13.1677 3.99725L12.336 2.75H7.13849L6.30674 3.998C5.88899 4.625 5.18924 5 4.43474 5H0.737244V16.25H17.2372V5H15.0397ZM9.74999 5.75C12.2332 5.75 14.25 7.76675 14.25 10.25C14.25 12.7332 12.2332 14.75 9.74999 14.75C7.26674 14.75 5.24999 12.7332 5.24999 10.25C5.24999 7.76675 7.26674 5.75 9.74999 5.75ZM9.74999 6.5C11.82 6.5 13.5 8.18 13.5 10.25C13.5 12.32 11.82 14 9.74999 14C7.67999 14 5.99999 12.32 5.99999 10.25C5.99999 8.18 7.67999 6.5 9.74999 6.5ZM9.74999 8C10.992 8 12 9.008 12 10.25C12 11.492 10.992 12.5 9.74999 12.5C8.50799 12.5 7.49999 11.492 7.49999 10.25C7.49999 9.008 8.50799 8 9.74999 8ZM9.74999 8.75C10.578 8.75 11.25 9.422 11.25 10.25C11.25 11.078 10.578 11.75 9.74999 11.75C8.92199 11.75 8.24999 11.078 8.24999 10.25C8.24999 9.422 8.92199 8.75 9.74999 8.75ZM3.74999 7.25C3.74999 6.836 3.41474 6.5 2.99999 6.5C2.58524 6.5 2.24999 6.836 2.24999 7.25C2.24999 7.664 2.58524 8 2.99999 8C3.41474 8 3.74999 7.664 3.74999 7.25ZM1.49999 2.75H3.75074V3.5H1.49999V2.75Z" fill="black"/>
									</g>
									<defs>
									<clipPath id="clip0_22_131">
									<rect width="18" height="18" fill="white" transform="translate(0 0.5)"/>
									</clipPath>
									</defs>
									</svg>									
							
							' . $image_cap . '</span>';
									} else {
										$caption = '';
									}
									echo '<img src="' . $child_thumb[0] . '" class="img-responsive mob-image6" />' . $caption;
								} else {
									echo '<img src="' . get_bloginfo("template_url") . '/images/slide.jpg" class="img-responsive ' . $defaultClass . '" />';
								}

								/*  } */
								?>
							<!-- <div class="news_sidebar">
				</div> -->
						</div>
						<!--liner_cikk_fekvo_1-->
						<!-- <div class="before_ads" id="liner_cikk_fekvo_1">
				<script type="text/javascript">
					activateBanner('liner_cikk_fekvo_1');
				</script>
			</div> -->
						<!--liner_cikk_fekvo_1-->
						<div class="child_content">
							<div class="author-detail wrap-mobile">
								<div class="subcategory-with-date">
									<?php
										$terms = get_the_terms($post->ID, 'news_cat');
										if ($terms && !is_wp_error($terms)) :
											$subCat = '';
											$cat = '';
											foreach ($terms as $term) {
												if ($term->parent != 0 && ($term->slug !== 'orosz-ukran-rovid' && $term->slug !== 'orosz-ukran-haboru-fontosabb-tortenesek')) {
													$subCat = $term->name;
												} else {
													if ($term->slug !== 'orosz-ukran-rovid' && $term->slug !== 'orosz-ukran-haboru-fontosabb-tortenesek') {
														$cat = $term->name;
													}
												}
											}

											?>
										<div class="subcat">
											<?php echo ($subCat ? str_replace('#', '', $subCat) : str_replace('#', '', $cat)); ?>
										</div>
									<?php endif; ?>
									<div class="article-date"><?php echo  get_the_date('Y. F j. - H:i'); ?></div>
								</div>

								<div class="d-flex align-items-center justify-content-between flex-fill pl-lg-4">
									<div class="d-flex align-items-center">
										<div class="author-img">
											<!--img src="<?php echo get_bloginfo("template_url"); ?>/images/avtar.jpg"-->
											<?php
												//Assuming $post is in scope
												if (function_exists('mt_profile_img')) {
													$author_id = $post->post_author;
													mt_profile_img(
														$author_id,
														array(
															'size' => 'thumbnail',
															'attr' => array('alt' => 'not image '),
															'echo' => true
														)
													);
												}
												?>
										</div>
										<div class="author-desc">
											<h3><?php the_field('news_author'); ?></h3>
											<div class="author-job">Szerkesztő</div>
										</div>
									</div>

									<?php
										$website = get_field('website-url', $post->ID);
										//$facebooklink = get_field('facebook-url',$post->ID);
										$twitterlink = get_field('twitter-url', $post->ID);
										?>
									<ul class="author-social">

										<!-- <li>
									<a class="facebook d-flex align-items-center p-0" target="_blank" href="#">
										<img style="max-height:37px;" src="<?php echo get_bloginfo("template_url"); ?>/images/facebook_2.png" />
									</a>
								</li> -->
										<li class="share-content" style="margin:0 !important; top:0; position:relative; z-index:5;">
											<!-- <a class="facebook d-flex align-items-center p-0" target="_blank" href="#">
										<img style="max-height:37px;" src="<?php echo get_bloginfo("template_url"); ?>/images/facebook_2.png" />
									</a> -->
											<a href="#" class="copy-link" id="copylink_<?php echo $post->ID ?>" style="width:38px;">
												<!-- <img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" /> -->
												<svg width="24" height="22" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_97_79)">
														<path d="M22 7V25.6667H6V7H22ZM24 4.66667H4V28H24V4.66667ZM0 24.5V0H21V2.33333H2V24.5H0Z" fill="black" />
													</g>
													<defs>
														<clipPath id="clip0_97_79">
															<rect width="24" height="28" fill="white" />
														</clipPath>
													</defs>
												</svg>

											</a>
											<div class="copy-message">
												URL másolva
											</div>
										</li>
										<li><a class="google d-flex align-items-center" target="_blank" href="https://news.google.com/publications/CAAqBwgKMKulmQswy6-xAw?hl=hu&amp;gl=HU&amp;ceid=HU%253Ahu" style="font-weight: 600;">
												<!-- <img style="width:30px;margin-left:0px;object-fit:cover;" src="<?php echo get_bloginfo("template_url"); ?>/images/google_news.png" /> -->
												<svg width="30" height="22" viewBox="0 0 43 26" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M42.6483 24.6981C42.6483 25.2995 42.0439 25.772 41.2747 25.772H1.98898C1.21975 25.772 0.615356 25.2995 0.615356 24.6981V1.50246C0.615356 0.901093 1.21975 0.428589 1.98898 0.428589H41.2197C41.989 0.428589 42.5934 0.901093 42.5934 1.50246V24.6981H42.6483Z" fill="black" />
													<path d="M36.8379 8.95873H23.6099V5.49719H36.8379C37.2088 5.49719 37.5178 5.80626 37.5178 6.17714V8.27879C37.5178 8.64966 37.2088 8.95873 36.8379 8.95873Z" fill="white" />
													<path d="M36.8379 22.1866H23.6099V18.7251H36.8379C37.2088 18.7251 37.5178 19.0342 37.5178 19.405V21.5067C37.5178 21.8776 37.2088 22.1866 36.8379 22.1866Z" fill="white" />
													<path d="M38.9395 15.5729H23.6099V12.1113H38.9395C39.3104 12.1113 39.6195 12.4204 39.6195 12.7913V14.8929C39.6195 15.2638 39.3104 15.5729 38.9395 15.5729Z" fill="white" />
													<path d="M11.8036 12.4204V15.5728H16.316C15.9451 17.489 14.2761 18.8489 11.8036 18.8489C9.08381 18.8489 6.85854 16.5618 6.85854 13.7802C6.85854 11.0605 9.08381 8.71157 11.8036 8.71157C13.0399 8.71157 14.1525 9.14426 15.0179 9.94783L17.4286 7.53712C16.0069 6.17723 14.0907 5.37366 11.8654 5.37366C7.22942 5.37366 3.52063 9.08245 3.52063 13.7184C3.52063 18.3544 7.22942 22.0632 11.8654 22.0632C16.625 22.1868 19.7775 18.7871 19.7775 14.0275C19.7775 13.4712 19.7157 12.9767 19.6539 12.4204H11.8036Z" fill="white" />
												</svg>

											</a></li>
									</ul>

								</div>
							</div>
							<?php
								$tags = [];
								$terms = get_the_terms($post->ID, 'newstag');
								if ($terms && !is_wp_error($terms)) :
									foreach ($terms as $term) {
										if ($term->count >= 10 && ($term->slug !== 'orosz-ukran-haboru-fontosabb-tortenesek' && $term->slug !== 'orosz-ukran-rovid')) {
											$tags[] = array(
												'name' => $term->name,
												'slug' => $term->slug
											);
										}
									}
								endif;

								?>
							<?php if (count($tags) > 0) : ?>
								<div class="single-tags-mob">
									<div class="liner-tags-title">TÉMÁK</div>
									<div class="mob-tags">
										<?php foreach ($tags as $tag) : ?>
											<a href="<?php echo get_term_link($tag['slug'], 'newstag'); ?>" class="liner_tag m-0">#<?php echo $tag['name']; ?></a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
							<div class="d-flex" style="gap:15px;">
								<div class="next-articles-col flex-shrink-0">
									<div class="next-articles">
										<div class="next-articles-title">
											KÖVETKEZŐ CIKKEK
										</div>
										<?php


											echo '<nav class="next">
												<div class=""><div class="">';
											$postlinks = array();
											$relterms_links = array();
											$relterms = get_the_terms($post->ID, 'news_cat');
											if ($relterms && !is_wp_error($relterms)) {

												foreach ($relterms as $relterm) {
													$relterms_links[] = $relterm->slug;
												}


												//$postlinks[] = get_the_permalink(get_the_ID());
												$args = array(
													'post__not_in' 			 => array($post->ID),
													'post_type'              => 'linernews',
													'post_status'            => 'publish',
													'posts_per_page'         => 4,
													'tax_query'         	 => array(
														array(
															'taxonomy' => 'news_cat',
															'field' 	 => 'slug',
															'terms' 	 => $relterms[0]->slug,

														)
													)
												);

												$related_articles = new WP_Query($args);

												if ($related_articles->have_posts()) : ?>
												<div class="related-article active" data-slug="<?php echo get_post_field('post_name', $post->ID); ?>">
													<div class="align-self-center">
														<a href="#">
															<div class="divbar"></div>
															<?php the_title(); ?>
														</a>
													</div>
												</div>
												<?php
															while ($related_articles->have_posts()) :
																$related_articles->the_post();
																// $postlinks[] = get_the_permalink($related_articles->post->ID);
																$image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($related_articles->post->ID), 'medium');
																?>

													<div class="related-article" data-slug="<?php echo get_post_field('post_name', $related_articles->post->ID); ?>">
														<div class="align-self-center">
															<a href="<?php echo get_the_permalink($related_articles->post->ID); ?>">
																<div class="divbar"></div>
																<?php the_title(); ?>
															</a>
														</div>
													</div>


										<?php

													endwhile;
												endif;
												wp_reset_postdata();
											}
											echo '</div></div></nav>';

											?>
										<div class="mt-5">
											<div class="next-articles-title">
												MEGOSZTÁS
											</div>
											<div>
												<a href="#" class="copy-link" id="copylink_<?php echo $post->ID ?>">
													<!-- <img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" /> -->
													<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M26.6077 13.909V30.0706H14.4688V13.909H26.6077ZM28.125 11.8888H12.9514V32.0908H28.125V11.8888ZM9.91669 29.0605V7.84839H25.849V9.86859H11.434V29.0605H9.91669Z" fill="black" />
														<rect x="0.5" y="0.5" width="39" height="39" stroke="black" />
													</svg>
													<div class="flex-fill">
														URL MÁSOLÁSA
													</div>

												</a>

												<div class="copy-message">
													URL másolva
												</div>

												<a href="<?php echo esc_url(home_url('/')); ?>" class="home-page-button" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
													VISSZA A KEZDŐLAPRA
												</a>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="col-lg-1 order-2 order-lg-0 d-none d-lg-block">
								
								<div class="d-flex align-items-start justify-content-between share-parent h-100">
									<div class="share-content mt-4">
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="facebook-share-icon">
											<img src="<?php echo get_bloginfo("template_url"); ?>/images/Facebook-share.png" style="width:30px" />
										</a>
										<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" target="_blank">
											<img src="<?php echo get_bloginfo("template_url"); ?>/images/Twitter-share.png" style="width:30px" />
										</a>
										<a href="#" class="copy-link" id="copylink_<?php echo $post->ID ?>">
											<img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" />
										</a>

										<div class="copy-message">
											URL másolva
										</div>

									</div>
									<a href="<?php echo esc_url(home_url('/')); ?>" class="home-page-button" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
										VISSZA A KEZDŐLAPRA
									</a>
								</div>
							</div> -->
								<div class="overflow-hidden">
									<div class="excerpt-content">
										<?php the_excerpt(); ?>
									</div>

									<!-- key notes starts -->
									<?php if ($key_notes) { ?>
										<div class="row key-notes">
											<div class="col-md-1 col-sm-2">
												<h3><strong> Előzmény: </strong></h3>
												<?php ?>
											</div>
											<div class="col-md-10 col-sm-12 key-notes-content">
												<?php echo $key_notes; ?>
											</div>
										</div>
									<?php } ?>
									<!-- key notes ends -->

									<div class="editor_content article-textbody">
										<?php

											echo the_content();

											wp_link_pages(
												array(
													'before' => '<div class="page-links">',
													'after'  => '</div>',
													'nextpagelink'  => '>',
													'previouspagelink'  => '<',
													'next_or_number'  => 'number',
												)
											);

											?>
										<?php //get_template_part( 'content', get_post_format() ); 
											?>
									</div>

									<!-- Mappa section -->
									<?php

										$folder = get_field('folder_section');
										$folder_args = array(
											'post_type'              => 'linernews',
											'post_status'            => 'publish',
											'posts_per_page' 		 => 4,
											'post__not_in' 			 => array($post->ID),
											'meta_query' 		 	 => array(
												array(
													'key' => 'folder_section',
													'value' => $folder->term_id,
												)
											)
										);

										$folder_query = new WP_Query($folder_args);
										$tagterm = get_term_by('slug', $folder->slug, 'newstag');
										$folder_link = '/mappa/' . $folder->slug;
										?>
									<?php if ($folder && $folder_query->have_posts()) : ?>
										<div class="folder-section">
											<div class="d-flex align-items-center justify-content-between folder-header">
												<div class="d-flex align-items-center">
													<h3 class="folder-title mb-0 flex items-center">
														<span class="mr-3">
															<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.6373 6.25L9.37012 3.125H0V26.875H30V6.25H12.6373ZM1.25 25.625V4.375H8.86841L12.1356 7.5H28.75V25.625H1.25Z" fill="black" />
																<path d="M26.25 22.5H11.875V23.75H26.25V22.5Z" fill="black" />
																<path d="M26.25 19.375H18.125V20.625H26.25V19.375Z" fill="black" />
															</svg>
														</span>
														<span class="">
															<?php echo $folder->name; ?>
														</span>
													</h3>
												</div>
												<a href="<?php echo $folder_link; ?>" class="d-lg-none">
													<svg width="16" height="16" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M8.50914 17.7259C8.26502 17.9912 8.14533 18.3346 8.15005 18.678C8.15478 19.0215 8.28235 19.3616 8.53434 19.6204L8.55323 19.64C8.80207 19.8841 9.12021 20.0029 9.43677 19.998C9.75333 19.9931 10.0683 19.8646 10.3109 19.6123C13.0922 16.7379 15.8436 13.8164 18.6076 10.9209C18.6186 10.9127 18.6281 10.9046 18.6375 10.8948C18.8816 10.6295 19.0013 10.2829 18.9966 9.93944C18.9919 9.59601 18.8627 9.25421 18.6108 8.99543L18.5682 8.95311C15.8168 6.09829 13.0686 3.23371 10.3093 0.383771C10.0683 0.13312 9.75333 0.00453906 9.43677 -0.000343749C9.12021 -0.00522656 8.80207 0.113589 8.55323 0.359357L8.52961 0.383771C8.28235 0.640932 8.15478 0.979474 8.15005 1.32127C8.14533 1.66307 8.26502 2.00812 8.50914 2.27342L15.946 9.9671L8.50914 17.7259ZM0.355705 17.4004C0.113165 17.664 -0.00495473 18.0075 -0.00022993 18.3493C0.00449487 18.6927 0.132064 19.0329 0.384054 19.2916L0.402953 19.3112C0.650218 19.5553 0.969929 19.6741 1.28649 19.6709C1.60305 19.666 1.91961 19.5374 2.16058 19.2851C4.88364 16.471 7.69647 13.7041 10.4558 10.9241C10.4668 10.916 10.4778 10.9062 10.4888 10.8965C10.7329 10.6312 10.8526 10.2845 10.8479 9.94106C10.8432 9.59764 10.714 9.25584 10.4621 8.99705C7.70749 6.23826 4.93876 3.48924 2.1779 0.733706L2.159 0.712547C1.91804 0.461896 1.60305 0.334943 1.28649 0.33006C0.969929 0.325177 0.651793 0.443992 0.402953 0.688133L0.379329 0.712547C0.132064 0.969708 0.00449487 1.30988 -0.00022993 1.65005C-0.00495473 1.99184 0.11474 2.3369 0.358855 2.6022L7.78939 9.96548L0.355705 17.4004Z" fill="#000" />
													</svg>
												</a>
											</div>
											<div class="folder-body">

												<?php while ($folder_query->have_posts()) : $folder_query->the_post(); ?>

													<div class="folder-item">
														<div class="folder-item-title">
															<a href="<?php the_permalink(); ?>" class="mappa">
																<?php the_title(); ?>
															</a>
														</div>
													</div>

												<?php endwhile;
														wp_reset_postdata();
														?>
												<a href="<?php echo $folder_link; ?>" class="d-none d-lg-block folder-all">
													<span> További hírek</span>
													<svg width="16" height="16" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M8.50914 17.7259C8.26502 17.9912 8.14533 18.3346 8.15005 18.678C8.15478 19.0215 8.28235 19.3616 8.53434 19.6204L8.55323 19.64C8.80207 19.8841 9.12021 20.0029 9.43677 19.998C9.75333 19.9931 10.0683 19.8646 10.3109 19.6123C13.0922 16.7379 15.8436 13.8164 18.6076 10.9209C18.6186 10.9127 18.6281 10.9046 18.6375 10.8948C18.8816 10.6295 19.0013 10.2829 18.9966 9.93944C18.9919 9.59601 18.8627 9.25421 18.6108 8.99543L18.5682 8.95311C15.8168 6.09829 13.0686 3.23371 10.3093 0.383771C10.0683 0.13312 9.75333 0.00453906 9.43677 -0.000343749C9.12021 -0.00522656 8.80207 0.113589 8.55323 0.359357L8.52961 0.383771C8.28235 0.640932 8.15478 0.979474 8.15005 1.32127C8.14533 1.66307 8.26502 2.00812 8.50914 2.27342L15.946 9.9671L8.50914 17.7259ZM0.355705 17.4004C0.113165 17.664 -0.00495473 18.0075 -0.00022993 18.3493C0.00449487 18.6927 0.132064 19.0329 0.384054 19.2916L0.402953 19.3112C0.650218 19.5553 0.969929 19.6741 1.28649 19.6709C1.60305 19.666 1.91961 19.5374 2.16058 19.2851C4.88364 16.471 7.69647 13.7041 10.4558 10.9241C10.4668 10.916 10.4778 10.9062 10.4888 10.8965C10.7329 10.6312 10.8526 10.2845 10.8479 9.94106C10.8432 9.59764 10.714 9.25584 10.4621 8.99705C7.70749 6.23826 4.93876 3.48924 2.1779 0.733706L2.159 0.712547C1.91804 0.461896 1.60305 0.334943 1.28649 0.33006C0.969929 0.325177 0.651793 0.443992 0.402953 0.688133L0.379329 0.712547C0.132064 0.969708 0.00449487 1.30988 -0.00022993 1.65005C-0.00495473 1.99184 0.11474 2.3369 0.358855 2.6022L7.78939 9.96548L0.355705 17.4004Z" fill="#000" />
													</svg>
												</a>
											</div>
										</div>
									<?php endif; ?>
									<!-- Mappa section vége -->


									<div class="player">
										<!-- video player -->
										<?php echo do_shortcode('[fwdevp preset_id="Liner v_1" video_path="{source:\'https://liner.hu/wp-content/uploads/2022/10/04.mp4\', label:\'previd\', videoType:\'normal\', isPrivate:\'no\'}" start_at_video="1" playback_rate_speed="1" vast="{source:\'https://pubads.g.doubleclick.net/gampad/ads?iu=/22652647,22830954724/liner_instream&description_url=https%3A%2F%2Fliner.hu%2F&tfcd=0&npa=0&sz=640x360&gdfp_req=1&ad_rule=1&output=vmap&vid_d=30&allcues=15000&unviewed_position_start=1&env=vp&impl=s&correlator=&vad_type=linear\'}"]'); ?>
									</div>
									<div class="col-12 d-lg-none mt-5">
										<div class="next-article-section">
											<div class="next-article-section-title">
												<img src="<?php echo get_bloginfo("template_url"); ?>/images/arrow.png" style="width:30px" />
												<p>Következő cikk</p>
												<img src="<?php echo get_bloginfo("template_url"); ?>/images/arrow.png" style="width:30px" />
											</div>
											<?php
												$postlinks = array();
												$relterms_links = array();
												$relterms = get_the_terms($article_id, 'news_cat');
												if ($relterms && !is_wp_error($relterms)) {

													foreach ($relterms as $relterm) {
														$relterms_links[] = $relterm->slug;
													}
													$args_args = array(
														'post__not_in' 			 => array($article_id),
														'post_type'              => 'linernews',
														'post_status'            => 'publish',
														'posts_per_page'         => 1,
														'tax_query'         	 => array(
															array(
																'taxonomy' => 'news_cat',
																'field' 	 => 'slug',
																'terms' 	 => $relterms_links,

															)
														)
													);

													$next_query = new WP_Query($args_args);

													if ($next_query->have_posts()) :
														while ($next_query->have_posts()) :
															$next_query->the_post();
															echo '<a class="next-article-link" href="' . get_the_permalink() . '">' . $next_query->post->post_title . '</a>';
														endwhile;
													endif;
												}

												?>
										</div>
									</div>

									<div class="mobile-share align-items-center justify-content-between share-parent d-lg-none">
										<div class="share-content mt-4">
											<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="facebook-share-icon">
												<img src="<?php echo get_bloginfo("template_url"); ?>/images/Facebook-share.png" style="width:30px" />
											</a>
											<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" target="_blank">
												<!-- <img src="<?php echo get_bloginfo("template_url"); ?>/images/Twitter-share.png" style="width:30px" /> -->
												<svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_106_140)">
														<path d="M32 12.557C31.117 12.949 30.168 13.213 29.172 13.332C30.189 12.723 30.97 11.758 31.337 10.608C30.386 11.172 29.332 11.582 28.21 11.803C27.313 10.846 26.032 10.248 24.616 10.248C21.437 10.248 19.101 13.214 19.819 16.293C15.728 16.088 12.1 14.128 9.671 11.149C8.381 13.362 9.002 16.257 11.194 17.723C10.388 17.697 9.628 17.476 8.965 17.107C8.911 19.388 10.546 21.522 12.914 21.997C12.221 22.185 11.462 22.229 10.69 22.081C11.316 24.037 13.134 25.46 15.29 25.5C13.22 27.123 10.612 27.848 8 27.54C10.179 28.937 12.768 29.752 15.548 29.752C24.69 29.752 29.855 22.031 29.543 15.106C30.505 14.411 31.34 13.544 32 12.557V12.557Z" fill="black" />
													</g>
													<rect x="0.5" y="0.5" width="39" height="39" stroke="black" />
													<defs>
														<clipPath id="clip0_106_140">
															<rect width="24" height="24" fill="white" transform="translate(8 8)" />
														</clipPath>
													</defs>
												</svg>

											</a>
											<a href="#" class="copy-link" id="copylink_<?php echo $post->ID ?>">
												<!-- <img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" /> -->
												<svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M26.6077 13.909V30.0706H14.4688V13.909H26.6077ZM28.125 11.8888H12.9514V32.0908H28.125V11.8888ZM9.91669 29.0605V7.84839H25.849V9.86859H11.434V29.0605H9.91669Z" fill="black" />
													<rect x="0.5" y="0.5" width="39" height="39" stroke="black" />
												</svg>

											</a>

											<div class="copy-message">
												URL másolva
											</div>

										</div>
										<a href="<?php echo esc_url(home_url('/')); ?>" class="home-page-button" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
											VISSZA A KEZDŐLAPRA
										</a>
									</div>


									<div class="strossle-widget"></div>


									<!--<div class="related_post">
									<?php //echo do_shortcode( '[crp limit=2 heading=1]' ); 
										?>
									<?php //removed this for query count echo do_shortcode( '[recommended_articles]' );
										?>
								</div>-->
									<div class="comment_content"><?php comments_template('', true); ?></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="missit-sec">
								<div class="title">
									<!--h3>Ne Hagyd Ki </h3-->
								</div>
								<?php //echo do_shortcode('[section-3 tag="macron"]');
									//reomved this for query count echo do_shortcode('[dontmiss_news]');
									?>

							</div>
						</div>


					<?php endwhile; // end of the loop. 
					wp_reset_postdata();
					?>

				</div>
				<div class="article-sidebar-wrapper">
					<div class="single-article-ad">
						<img src="<?php echo get_bloginfo("template_url"); ?>/images/ED.png" />
					</div>
					<?php if (is_active_sidebar('sidebar-single')) : ?>
						<div class="news_sidebar category-sidebar" style="margin-top:-10px">
							<?php dynamic_sidebar('sidebar-single'); ?>
						</div>
					<?php endif; ?>
					<!--Liner_cikk_jobb_1-->
					<div class="siderbar_ads1">
						<div id="liner_cikk_jobb_1">
						</div>
					</div>
					<!--Liner_cikk_jobb_1-->
					<div class="sdbrstcky_post">
						<?php echo do_shortcode('[sidebar-sticky]'); ?>
					</div>
					<div class="van-sztorid-widget">
						<div class="sztorid-img">
							<img src="<?php echo get_template_directory_uri() ?>/images/sztorid.png" alt="ads" class="img-fluid">
						</div>
						<h3 class="sztorid-title">Van egy sztorid?</h3>
						<p class="sztorid-paragraph">Szemtanúja voltál valaminek, vagy épp van egy olyan történeted, melyet szívesen megosztanál másokkal?</p>
						<p class="sztorid-paragraph">Küldd el nekünk, és amennyiben érdekesnek találjuk, úgy közzétesszük azt oldalunkon.</p>
						<?php $url = get_permalink(get_page_by_title('Sztori Bekuldes')); ?>
						<div class="sztorid-button">
							<a href="<?php echo $url; ?>" class="sztori-btn">Beküldés</a>
						</div>
					</div>
					<!--Liner_cikk_jobb_2-->
					<div class="siderbar_ads2 mb-4">
						<div id="liner_cikk_jobb_2">
						</div>
					</div>
					<!--Liner_cikk_jobb_2-->
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$postlinks = array();
$relterms_links = array();
$relterms = get_the_terms($article_id, 'news_cat');
if ($relterms && !is_wp_error($relterms)) {

	foreach ($relterms as $relterm) {
		$relterms_links[] = $relterm->slug;
	}


	//$postlinks[] = get_the_permalink(get_the_ID());
	$args = array(
		'post__not_in' 			 => array($article_id),
		'post_type'              => 'linernews',
		'post_status'            => 'publish',
		'posts_per_page'         => 4,
		'tax_query'         	 => array(
			array(
				'taxonomy' => 'news_cat',
				'field' 	 => 'slug',
				'terms' 	 => $relterms[0]->slug,

			)
		)
		/*,
			'meta_query'			 => array(
											array(
												'key'     => 'long_form',
												'compare' => 'NOT EXISTS',
											),
										)*/
	);

	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) :
		while ($the_query->have_posts()) :
			$the_query->the_post();
			$postlinks[] = get_the_permalink($the_query->post->ID);
		endwhile;
	endif;
}

?>
<div class="container">
	<div class="d-lg-flex" style="gap:15px;">
		<div class="single-sidebar-left flex-shrink-0"></div>
		<div class="load_more">
			<?php // echo do_shortcode('[ajax_load_more post_type="linernews" posts_per_page="1" post_format="standard" offset="3" taxonomy="news_cat" taxonomy_terms="'.join(',',$relterms_links).'" taxonomy_operator="IN" post__not_in="'.$post->ID.'"]');
			?>
		</div>
	</div>
</div>
<div class="page-load-status">
	<div class="loader-ellips infinite-scroll-request text-center">
		<img style="margin-bottom:25px;" src="<?php bloginfo('template_url') ?>/images/ajax-loading.gif" />
	</div>
	<p class="infinite-scroll-last" style="display: none;">End of content</p>
	<p class="infinite-scroll-error" style="display: none;">No more pages to load</p>
</div>




<script type="text/javascript">
	var home_url = '<?php echo home_url(); ?>';
	var nextPenSlugs = <?php echo json_encode($postlinks); ?>;

	function getPenPath() {
		var slug = nextPenSlugs[this.loadCount];
		if (slug) {
			return slug;
		}
	}

	//-------------------------------------//
	// init Infinte Scroll
	jQuery(function($) {
		$('.load_more').infiniteScroll({
			path: getPenPath,
			append: '.single_news',
			scrollThreshold: 10,
			prefill: true,
			history: 'push',
			historyTitle: true,
			status: '.page-load-status',
			// 		debug       : 'false',
		});

		$('.load_more').on('append.infiniteScroll', function(event, response, path, items) {
			var $temp = $("<input>");
			//var $url = path;
			$('.author-detail ul.author-social li button.btn').on('click', function() {
				var $url = $(location).attr('href');
				$("body").append($temp);
				$temp.val($url).select();
				document.execCommand("copy");
				$temp.remove();
				$(this).text('Link kimásolva!');
				$('button.btn').not(this).text('Link másolása');
			});

			$('.post-social ul.social-sharing li button.btn').on('click', function() {
				var $url = $(location).attr('href');
				$("body").append($temp);
				$temp.val($url).select();
				document.execCommand("copy");
				$temp.remove();
				$(this).text('Link kimásolva!');
				$('button.btn').not(this).text('Link másolása');
			});

			$('.copy-link').on('click', function(e) {
				e.preventDefault();
				var $url = $(location).attr('href');
				$("body").append($temp);
				$temp.val($url).select();
				document.execCommand("copy");
				$temp.remove();
				$(this).next().text('URL másolva!');
				$(this).next().fadeIn(500).delay(1000).fadeOut(500);
				// select next element

			});

			//$( ".related_post").clone().insertAfter( ".editor_content > *:eq(3)" );

		});
		var infScroll = window.adsInfinityIndex; // ajanlas szerint
		$('.load_more').on('append.infiniteScroll', function(event, response, path, items) {
			//ajanlas szerint
			var count = window.adsInfinityIndex;
			console.log('window index');
			console.log(count);
			$('.load_more .single_news:last-child').attr('id', 'single_' + count);
			$('.load_more #single_' + window.adsInfinityIndex).find('.article-textbody').removeClass('article-textbody').addClass(`article-textbody_inf_${window.adsInfinityIndex}`);
			$('.load_more #single_' + window.adsInfinityIndex).find('.before_ads').html('').attr('id', 'liner_cikk_fekvo_1_inf_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.siderbar_ads1').html('').attr('id', 'liner_cikk_jobb_1_inf_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.siderbar_ads2').html('').attr('id', 'liner_cikk_jobb_2_inf_' + window.adsInfinityIndex);
			//$('.load_more #single_' + window.adsInfinityIndex).find('.code-block').html('').attr('id', 'liner_code_block_2_inf_' + window.adsInfinityIndex);
			$('.load_more .single_news:last-child').attr('data-slug', path.replace(home_url + '/', '').replace(/\/$/, ''));
			//player_infinite
			//$('#fwdevpDiv0').attr('id', 'fwdevpDiv' + count);
			$('.load_more #single_' + count).find('#fwdevpDiv0').attr('id', 'fwdevpDiv' + count);
			//pause old page video

			console.log('page index');
			var playerIndex = infScroll;
			var pid = count - 2;
			switch (pid) {
				case -1:

					console.log('old player paused -1 :' + pid);
					break;
				case 1:
					fwdevpPlayer1.pause();
					//console.log('old player paused 1 :'+pid);
					break;
				case 2:
					fwdevpPlayer2.pause();
					//console.log('old player paused 2:'+pid);
					break;
				case 3:
					fwdevpPlayer3.pause();
					//console.log('old player paused 3:'+pid);
					break;
				case 4:
					fwdevpPlayer4.pause();
					//console.log('old player paused 4:'+pid);
					break;
				case 5:
					fwdevpPlayer5.pause();
					//console.log('old player paused 5:'+pid);
					break;
				default:
					fwdevpPlayer0.pause();
					//console.log('old player paused d :'+pid);
			}

			//console.log('new id easy player fwdevpDiv' + count);
			var playerid_l = 'fwdevpDiv' + count;

			//check if div exists
			var $pDiv = $('#' + playerid_l);
			if ($pDiv.length) {
				//player instance
				FWDEVPlayer.videoStartBehaviour = 'default';
				FWDEVPUtils.checkIfHasTransofrms();
				new FWDEVPlayer({
					instanceName: 'fwdevpPlayer' + count,
					initializeOnlyWhenVisible: 'yes',
					openDownloadLinkOnMobile: 'no',
					preloaderBackgroundColor: '#ffffff',
					preloaderFillColor: '#000000',
					fillEntireVideoScreen: 'no',
					useHEXColorsForSkin: 'no',
					stickyOnScroll: 'no',
					stickyOnScrollShowOpener: 'yes',
					contextMenuType: 'default',
					showScriptDeveloper: 'no',
					contextMenuBackgroundColor: '#1f1f1f',
					contextMenuBorderColor: '#1f1f1f',
					contextMenuSpacerColor: '#333333',
					contextMenuItemNormalColor: '#888888',
					contextMenuItemSelectedColor: '#ffffff',
					contextMenuItemDisabledColor: '#444444',
					stickyOnScrollWidth: 700,
					stickyOnScrollHeight: 394,
					showDefaultControllerForVimeo: 'yes',
					normalHEXButtonsColor: '#ff0000',
					parentId: 'fwdevpDiv' + count,
					mainFolderPath: home_url + '/wp-content/plugins/fwdevp/content',
					videoSource: [{
						source: home_url + '/wp-content/uploads/2022/10/04.mp4',
						label: 'Termszet',
						videoType: 'normal',
						isPrivate: 'no'
					}],
					startAtVideoSource: 0,
					useVectorIcons: 'no',
					startAtTime: '',
					stopAtTime: '',
					popupCommercialAdsSource: [],
					privateVideoPassword: '428c841430ea18a70f7b06525d4b748a',
					posterPath: '',
					skinPath: 'minimal_skin_dark',
					aopwSource: '',
					aopwTitle: 'Advertisement',
					aopwWidth: 400,
					aopwHeight: 240,
					aopwBorderSize: 6,
					useResumeOnPlay: 'no',
					redirectURL: '',
					redirectTarget: '',
					googleAnalyticsTrackingCode: '',
					aopwTitleColor: '#ffffff',
					showErrorInfo: 'yes',
					playsinline: 'yes',
					displayType: 'responsive',
					disableDoubleClickFullscreen: 'no',
					executeCuepointsOnlyOnce: 'no',
					showPreloader: 'yes',
					addKeyboardSupport: 'yes',
					autoScale: 'yes',
					autoPlay: 'yes',
					autoPlayText: 'Click To Unmute',
					loop: 'no',
					maxWidth: 980,
					maxHeight: 551,
					volume: 1,
					audioVisualizerLinesColor: '#000000',
					audioVisualizerCircleColor: '#ffffff',
					isLoggedIn: 'yes',
					goFullScreenOnButtonPlay: 'no',
					playVideoOnlyWhenLoggedIn: 'no',
					loggedInMessage: "Please loggin to view this video.",
					backgroundColor: '#000000',
					fillEntireScreenWithPoster: 'no',
					showSubtitleButton: 'no',
					subtitlesOffLabel: 'Subtitle off',
					startAtSubtitle: 0,
					posterBackgroundColor: '#000000',
					showControllerWhenVideoIsStopped: 'yes',
					showController: 'no',
					useChromeless: 'no',
					showPlaybackRateButton: 'no',
					defaultPlaybackRate: 1,
					showScrubberWhenControllerIsHidden: 'yes',
					useWithoutVideoScreen: 'no',
					showVolumeScrubber: 'yes',
					showVolumeButton: 'yes',
					showTime: 'yes',
					showQualityButton: 'yes',
					showShareButton: 'yes',
					showDownloadButton: 'no',
					showChromecastButton: 'no',
					showEmbedButton: 'yes',
					showRewindButton: 'yes',
					showFullScreenButton: 'yes',
					repeatBackground: 'yes',
					controllerHeight: 41,
					controllerHideDelay: 3,
					startSpaceBetweenButtons: 7,
					spaceBetweenButtons: 9,
					scrubbersOffsetWidth: 4,
					mainScrubberOffestTop: 14,
					timeOffsetLeftWidth: 5,
					timeOffsetRightWidth: 3,
					volumeScrubberWidth: 80,
					volumeScrubberOffsetRightWidth: 0,
					timeColor: '#888888',
					youtubeQualityButtonNormalColor: '#888888',
					showPopupAdsCloseButton: 'yes',
					youtubeQualityButtonSelectedColor: '#ffffff',
					showLogo: 'no',
					hideLogoWithController: 'yes',
					logoPosition: 'topRight',
					logoPath: home_url + '/wp-content/plugins/fwdevp/content/logo.png',
					logoLink: 'http://www.webdesign-flash.ro/',
					cuepoints: [],
					logoMargins: 5,
					vastSource: 'https://pubads.g.doubleclick.net/gampad/ads?iu=/22652647,22830954724/liner_instream&description_url=https%3A%2F%2Fliner.hu%2F&tfcd=0&npa=0&sz=640x360&gdfp_req=1&ad_rule=1&output=vmap&vid_d=30&allcues=15000&unviewed_position_start=1&env=vp&impl=s&correlator=&vad_type=linear',
					vastLinearStartTime: '00:00:00',
					vastClickTroughTarget: '_blank',
					embedWindowCloseButtonMargins: 15,
					borderColor: '#333333',
					mainLabelsColor: '#ffffff',
					closeLightBoxWhenPlayComplete: 'no',
					lightBoxBackgroundColor: '#000000',
					lightBoxBackgroundOpacity: .6,
					secondaryLabelsColor: '#a1a1a1',
					showOpener: 'yes',
					verticalPosition: 'bottom',
					horizontalPosition: 'center',
					showPlayerByDefault: 'yes',
					animatePlayer: 'yes',
					showOpenerPlayPauseButton: 'yes',
					openerAlignment: 'right',
					mainBackgroundImagePath: home_url + '/wp-content/plugins/fwdevp/content/minimal_skin_dark/main-background.png',
					openerEqulizerOffsetTop: -1,
					openerEqulizerOffsetLeft: 3,
					offsetX: 0,
					offsetY: 0,
					shareAndEmbedTextColor: '#5a5a5a',
					inputBackgroundColor: '#000000',
					inputColor: '#ffffff',
					openNewPageAtTheEndOfTheAds: 'no',
					adsSource: [],
					adsButtonsPosition: 'right',
					skipToVideoText: 'You can skip to video in:',
					skipToVideoButtonText: 'Skip add',
					showMainScrubberToolTipLabel: 'yes',
					scrubbersToolTipLabelFontColor: '#5a5a5a',
					scrubbersToolTipLabelBackgroundColor: '#ffffff',
					useAToB: 'no',
					atbTimeBackgroundColor: 'transparent',
					atbTimeTextColorNormal: '#888888',
					atbTimeTextColorSelected: '#ffffff',
					atbButtonTextNormalColor: '#888888',
					atbButtonTextSelectedColor: '#ffffff',
					atbButtonBackgroundNormalColor: '#ffffff',
					atbButtonBackgroundSelectedColor: '#000000',
					adsTextNormalColor: '#777777',
					thumbnailsPreview: '',
					thumbnailsPreviewWidth: 196,
					thumbnailsPreviewHeight: 110,
					thumbnailsPreviewBackgroundColor: '#000000',
					thumbnailsPreviewBorderColor: '#666666',
					thumbnailsPreviewLabelBackgroundColor: '#666666',
					thumbnailsPreviewLabelFontColor: '#ffffff',
					adsTextSelectedColor: '#ffffff',
					adsBorderNormalColor: '#444444',
					adsBorderSelectedColor: '#ffffff'
				})
			} else {
				console.warn('player div not found');
				console.warn('player id:' + playerid_l);
			}
			/************************* player alatti beállítások ***************/
			ads_addContent();

		});
		//send ga on virtal page view
		$('.load_more').on('history.infiniteScroll', function(event, title, path) {
			if (window.ga) {

				// get domain with http://
				// var domain = window.location.protocol + '//' + window.location.hostname;
				// var currentPath = path.replace(domain + '/', '');
				// // remove / from the end of the path
				// currentPath = currentPath.replace(/\/$/, '');
				// $('.related-article').removeClass('active');
				// $('.related-article[data-slug="' + currentPath + '"]').addClass('active');
				window.ga.getAll()[0].set('page', path);
				window.ga.getAll()[0].send('pageview')
			}
			//ajax page view count
			var data = {
				'action': 'liner_ajax_page_count',
				'whatever': 1234,
				'page_url': path
			};
			if (ajaxurl == undefined) {
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			}
			jQuery.post(ajaxurl, data, function(response) {
				console.log('ajax recevieved count');
				console.log('Got this from the server: ' + response);
			});
		});
	});
	jQuery(window).load(function($) {
		var gad1 = jQuery(".content-ad").innerHtml;
		//alert(gad1);
	});
</script>
<?php get_footer(); ?>