<?php

/** * The Template for displaying all single posts * * @package
WordPress * @subpackage Liner_Hu * @since Liner Hu 1.0 */

get_header(); ?>
<!--<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/all.js#xfbml=1&version=v9.0" nonce="lxEL1L0D"></script>-->

<div class="container">
	<div class="single_news">
		<div class="row">
			<div class="col-12 mb-4">
				<?php
				while (have_posts()) :
					the_post();
					// asign global id to the post
					global $article_id;
					$article_id = get_the_ID();
					?>
					<div>
						<?php
							$id = get_the_id();
							$terms = get_the_terms($id, 'news_cat');
							?>
						<!-- breadcrumb -->
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo get_home_url(); ?>">HOMEPAGE</a></li>
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
					<h1 class="page_title mt-4"><?php the_title(); ?></h1>
				<?php endwhile; ?>
			</div>
			<div class="col-lg-8">
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
	        		$child_thumb = wp_get_attachment_image_src( $simage['id'],'slidesingle-thumb' );
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
							$child_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'singlepagebanner-thumb');

							if ($child_thumb) {
								$image_cap = wp_get_attachment_caption(get_post_thumbnail_id($post->ID));
								if (!empty($image_cap)) {
									$caption = '<span class="test">
							<img style="width:15px;margin-top: 5px;" src="' . get_bloginfo("template_url") . '/images/foto.png"  />
							
							' . $image_cap . '</span>';
								} else {
									$caption = '';
								}
								echo '<img src="' . $child_thumb[0] . '" class="img-responsive" />' . $caption;
							} else {
								echo '<img src="' . get_bloginfo("template_url") . '/images/slide.jpg" class="img-responsive" />';
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
						<div class="author-detail d-flex align-items-center justify-content-between flex-wrap">
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
									<p><?php echo  get_the_date('Y. F j. - H:i'); ?></p>
								</div>
							</div>
							<?php
								$website = get_field('website-url', $post->ID);
								//$facebooklink = get_field('facebook-url',$post->ID);
								$twitterlink = get_field('twitter-url', $post->ID);
								?>
							<ul class="author-social">
								<li><a class="google d-flex align-items-center" target="_blank" href="https://news.google.com/publications/CAAqBwgKMKulmQswy6-xAw?hl=hu&amp;gl=HU&amp;ceid=HU%253Ahu" style="font-weight: 600;">Google hírek
										<img style="width:30px;margin-left:10px;object-fit:cover;" src="<?php echo get_bloginfo("template_url"); ?>/images/google_news.png" />
									</a></li>
								<li>
									<a class="facebook d-flex align-items-center p-0" target="_blank" href="#">
										<img style="max-height:37px;" src="<?php echo get_bloginfo("template_url"); ?>/images/facebook_2.png" />
									</a>
								</li>
							</ul>

						</div>
						<div class="row">
							<div class="col-lg-1 order-2 order-lg-0 d-none d-lg-block">
								<!-- share -->
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
										Homepage
									</a>
								</div>
							</div>
							<div class="col-lg-11 overflow-hidden">
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
								<!--liner_cikk_roadblock_1-->
								<div class="content_ads1" id="liner_cikk_roadblock_1">
									<script type="text/javascript">
										activateBanner('liner_cikk_roadblock_1');
									</script>
								</div>
								<!--liner_cikk_roadblock_1-->
								<div class="editor_content">
									<?php the_content();

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
								<div class="mobile-share align-items-center justify-content-between share-parent d-lg-none">
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
										Homepage
									</a>
								</div>

								<div class="col-12 d-lg-none">
									<div class="next-article-section">
										<div class="next-article-section-title">
											<img src="<?php echo get_bloginfo("template_url"); ?>/images/arrow.png" style="width:30px" />
											<p>Next Article</p>
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
														echo '<a class="next-article-link" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
													endwhile;
												endif;
											}

											?>
									</div>
								</div>


								<?php echo do_shortcode('[fwdevp preset_id="Liner v_1" video_path="{source:\'https://liner.hu/wp-content/uploads/2022/02/orosz_ukran_2.mp4\', label:\'previd\', videoType:\'normal\', isPrivate:\'no\'}" start_at_video="1" playback_rate_speed="1" vast="{source:\'https://pubads.g.doubleclick.net/gampad/ads?iu=/22652647,22588056191/liner_instream&description_url=https%3A%2F%2Fliner.hu%2F&tfcd=0&npa=0&sz=640x360&gdfp_req=1&ad_rule=1&output=vmap&vid_d=30&allcues=15000&unviewed_position_start=1&env=vp&impl=s&correlator=&vad_type=linear\'}"]'); ?>




								<!--liner_cikk_roadblock_2-->
								<div class="content_ads2" id="liner_cikk_roadblock_2">
									<script type="text/javascript">
										activateBanner('liner_cikk_roadblock_2');
									</script>
								</div>



								<!--liner_cikk_roadblock_2-->

								<div class="related_post">
									<?php //echo do_shortcode( '[crp limit=2 heading=1]' ); 
										?>
									<?php //removed this for query count echo do_shortcode( '[recommended_articles]' );
										?>
								</div>
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
				?>

			</div>
			<div class="col-lg-4 col-sm-12">
				<?php if (is_active_sidebar('sidebar-5')) : ?>
					<div class="news_sidebar">
						<?php dynamic_sidebar('sidebar-5'); ?>
					</div>
				<?php endif; ?>
				<!--Liner_cikk_jobb_1-->
				<div class="siderbar_ads1" id="liner_cikk_jobb_1">
					<script type="text/javascript">
						activateBanner('liner_cikk_jobb_1');
					</script>
				</div>
				<!--Liner_cikk_jobb_1-->
				<div class="sdbrstcky_post">
					<?php echo do_shortcode('[sidebar-sticky]'); ?>
				</div>
				<div class="van-sztorid-widget">
					<div class="sztorid-img">
						<img src="<?php echo get_template_directory_uri() ?>/images/sztorid.png" alt="ads" class="img-fluid">
					</div>
					<h1 class="sztorid-title">Van egy sztorid?</h1>
					<p class="sztorid-paragraph">Szemtanúja voltál valaminek, vagy épp van egy olyan történeted, melyet szívesen megosztanál másokkal?</p>
					<p class="sztorid-paragraph">Küldd el nekünk, és amennyiben érdekesnek találjuk, úgy közzétesszük azt oldalunkon.</p>
					<?php $url = get_permalink(get_page_by_title('Sztori Bekuldes')); ?>
					<div class="sztorid-button">
						<a href="<?php echo $url; ?>" class="sztori-btn">Beküldés</a>
					</div>
				</div>
				<!--Liner_cikk_jobb_2-->
				<div class="siderbar_ads2 mb-4" id="liner_cikk_jobb_2">
					<script type="text/javascript">
						activateBanner('liner_cikk_jobb_2');
					</script>
				</div>
				<!--Liner_cikk_jobb_2-->
			</div>
			<div class="col-12 d-none d-lg-block">
				<div class="next-article-section">
					<div class="next-article-section-title">
						<img src="<?php echo get_bloginfo("template_url"); ?>/images/arrow.png" style="width:30px" />
						<p>Next Article</p>
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
								echo '<a class="next-article-link" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
							endwhile;
						endif;
					}

					?>
				</div>
			</div>
			<div class="strossle-widget"></div>
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
				'terms' 	 => $relterms_links,

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
	<div class="load_more">
		<?php // echo do_shortcode('[ajax_load_more post_type="linernews" posts_per_page="1" post_format="standard" offset="3" taxonomy="news_cat" taxonomy_terms="'.join(',',$relterms_links).'" taxonomy_operator="IN" post__not_in="'.$post->ID.'"]');
		?>
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
			//prefill			: true,
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
				$('.copy-message').text('URL másolva!');
				$('.copy-message').fadeIn(500).delay(1000).fadeOut(500);
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
			$('.load_more #single_' + window.adsInfinityIndex).find('.before_ads').html('').attr('id', 'liner_fekvo_infinite_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.siderbar_ads1').html('').attr('id', 'liner_jobb_1_infinite_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.siderbar_ads2').html('').attr('id', 'liner_jobb_2_infinite_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.content_ads1').html('').attr('id', 'liner_roadblock_1_infinite_' + window.adsInfinityIndex);
			$('.load_more #single_' + window.adsInfinityIndex).find('.content_ads2').html('').attr('id', 'liner_roadblock_2_infinite_' + window.adsInfinityIndex);

			//player_infinite
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
					console.log('old player paused 1 :' + pid);
					break;
				case 2:
					fwdevpPlayer2.pause();
					console.log('old player paused 2:' + pid);
					break;
				case 3:
					fwdevpPlayer3.pause();
					console.log('old player paused 3:' + pid);
					break;
				case 4:
					fwdevpPlayer4.pause();
					console.log('old player paused 4:' + pid);
					break;
				case 5:
					fwdevpPlayer5.pause();
					console.log('old player paused 5:' + pid);
					break;
				default:
					fwdevpPlayer0.pause();
					console.log('old player paused d :' + pid);
			}

			console.log('new id easy player fwdevpDiv' + count);
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
						source: home_url + '/wp-content/uploads/2022/02/orosz_ukran_2.mp4',
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
					volume: 0.8,
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
					vastSource: 'https://pubads.g.doubleclick.net/gampad/ads?iu=/22652647,22588056191/liner_instream&description_url=https%3A%2F%2Fliner.hu%2F&tfcd=0&npa=0&sz=640x360&gdfp_req=1&ad_rule=1&output=vmap&vid_d=30&allcues=15000&unviewed_position_start=1&env=vp&impl=s&correlator=&vad_type=linear',
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
				console.log('inside window ga');
				console.log(window.ga)
				// get domain with http://
				var domain = window.location.protocol + '//' + window.location.hostname;
				var currentPath = path.replace(domain + '/', '');
				// remove / from the end of the path
				currentPath = currentPath.replace(/\/$/, '');
				$('.related-article').removeClass('active');
				$('.related-article[data-slug="' + currentPath + '"]').addClass('active');
				window.ga.getAll()[0].set('page', path);
				window.ga.getAll()[0].send('pageview')
			}
			//ajax page view count
			var data = {
				'action': 'liner_ajax_page_count',
				'whatever': 1234,
				'page_url': path
			};

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