<?php

/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title('|', true, 'right'); ?></title>
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
	<link rel="shortcut icon" href="/fav.png">
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. 
	?>
	<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js?ver=3.7.0" type="text/javascript"></script>
<![endif]-->
	<script>
		var adsQueue = window.adsQueue || [];

		function noAB(a) {
			window.adsQueue.push(a);
		}
		var activateBanner = window.activateBanner || noAB;
	</script>
	<script src="<?php echo 'https://cdn.atmedia.hu/liner.hu.js?v=' . date('Ymd'); ?>/js/html5.js?ver=3.7.0" type="text/javascript" async></script>
	<script src="<?php echo 'https://cdn.atmedia.hu/liner.hu.infinite.js?v=' . date('Ymd'); ?>/js/html5.js?ver=3.7.0" type="text/javascript" async></script>

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-M59DBH2');
	</script>
	<!-- End Google Tag Manager -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M59DBH2" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php
	//for age verfication
	$pID = get_the_ID();
	if ($pID) {
		$age_verify = get_field('age_verify', $pID);
		$age_leave = isset($_POST['age_leave']) ? $_POST['age_leave'] : '';
		if (isset($age_leave) and $age_leave == 'yes') {
			wp_redirect(home_url());
		}
		$age_enter = isset($_POST['age_enter']) ? $_POST['age_enter'] : '';
		if (isset($age_enter) and $age_enter == 'yes') {
			$age_verify = 0; //age vefifed
		}

		if ($age_verify) {
			echo get_template_part('age', 'verify');
		}

		$lastvisit = isset($_COOKIE['lastvisit']) ? $_COOKIE['lastvisit'] : 0;
		$date = date('Y/m/d H:i:s', $lastvisit);
		if ($lastvisit) {
			$last_visit_args = array(
				'post_type' => 'linernews',
				'post_status' => 'publish',
				'posts_per_page' => 15,
				'orderby' => 'date',
				'order' => 'DESC',
				'date_query' => array(
					array(
						'after' => $date,
						'inclusive' => true,
					)
				),

			);

			$last_visit_query = new WP_Query($last_visit_args);
		} else {
			$last_visit_args = array(
				'post_type' => 'not_found',
				'post_status' => 'publish',
				'posts_per_page' => 15,
				'orderby' => 'date',
				'order' => 'DESC',
				'date_query' => array(
					array(
						'after' => $date,
						'inclusive' => true,
					)
				),

			);

			$last_visit_query = new WP_Query($last_visit_args);
		}
	}
	?>
	<script>
		/** dark mode switch button **/
		jQuery(document).ready(function($) {
			// add count of posts to title of browser
			var title = document.title;
			var count = <?php echo count($last_visit_query->posts); ?>;
			if (count > 0) {
				document.title = '(' + count + ') ' + title;
			}


			$(".dm_checkbox").click(function(e) {
				if ($(this).is(':checked')) {
					<?php $v = isset($_COOKIE['dark_mode']) ? 'no' : 'yes'; ?>
					var v = '<?php echo $v; ?>';
					$('#dark_mode_form_submitted_val').val(v);
					$('#dark_mode_submit_btn').click();
				} else {
					$('#dark_mode_form_submitted_val').val('no');
					$('#dark_mode_submit_btn').click();
				}
			});

			$('.mobile li a.search_btn').click(function(e) {
				$('.mobile li .search_panle').slideToggle();
				e.preventDefault();
			});
			if ($('.notification-articles').length) {

				$('.notification-articles.active').click(function(e) {
					e.preventDefault();
					$('.last-visit-modal').toggleClass('active');

				});

				$('.close-visit-modal').click(function(e) {
					e.preventDefault();
					document.cookie = 'lastvisit=' + <?php echo current_time('timestamp'); ?> + '; path=/';
					$('.notification-articles span').text('0');
					$('.last-visit-modal').removeClass('active');
					$('.last-visit-modal').html('');
					document.title = title;
				});

			}
		});
	</script>
	<div class="site_page">
		<?php do_action('breaking_bar'); ?>





		<!-- <header class="header desktop">
      <div class="container">

         <div class="headerContainer auto_float">
          <nav class="navbar navbar-expand-lg">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">

			<?php
			$logo_src = esc_url(get_theme_mod('site_logo'));

			if (isset($_COOKIE['dark_mode'])) {
				$dark_mode = true;
			}
			if (isset($dark_mode)) {

				$logo_src = get_bloginfo("template_url") . '/images/logo_dark.png';
			}
			?>


			<?php if (get_theme_mod('site_logo')) : ?>
			<img src='<?php echo $logo_src; ?>' class="img-responsive" alt=""><?php endif; ?>

			</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <i class="fa fa-bars" aria-hidden="true"></i>

            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">

            	<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'navbar-nav ml-auto menu_1ul', 'container' => '')); ?>
            </div>
          </nav>
         </div>
      </div>
  </header> -->

		<header>
			<div class="container">
				<div class="top-nav d-flex justify-content-between align-items-center">
					<div class="d-flex align-items-center">
						<button class="button-nav-toggle mr-1 mr-lg-3">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</button>
						<div class="currnet-date">
							<?php
							// echo date('Y.m.d, l');
							// echo date with another Hungarian language
							setlocale(LC_ALL, 'hu_HU.UTF-8');
							echo strftime('%Y.%m.%d, %A');


							?>
						</div>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo navbar-brand" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
							<?php if (get_theme_mod('site_logo')) : ?>
								<img src='<?php echo $logo_src; ?>' class="img-responsive" alt=""><?php endif; ?>
						</a>
					</div>

					<div class="d-flex align-items-center">
						<a href="https://liner.hu/" class="top-nav-link">
							<img src="https://frontend.hirertek.hu/app/assets/images/logo/linhurlogo.png" width="16px" class="d-inline-block w-auto">
							LINER.HU</a>
						<a href="https://motorsport.hu/" class="top-nav-link">
							<img src="https://frontend.hirertek.hu/app/assets/images/logo/ms_logo.png" width="23px" class="d-inline-block w-auto">
							MOTORSPORT.HU</a>
						<button class="notification-articles active mobile" type="button">
							<div class="position-relative" style="height:30px">
								<img src="<?php echo get_template_directory_uri(); ?>/images/wall-clock.png" alt="clock" class="img-fluid" width="32">
								<span>
									<?php
									echo count($last_visit_query->posts);

									?>
								</span>
							</div>
						</button>
						<div class="menu_1ul position-relative">
							<li class="nav-item search_boxLi" style="list-style:none;">
								<a href="#" class="nav-link search_btn"><i class="fa fa-search fa-lg" aria-hidden="true"></i></a>
								<div class="search_panle">
									<div class="frm_grp">
										<div class="input-group mb-3">
											<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url(); ?>">
												<div>
													<label class="screen-reader-text" for="s">Keresés:</label>
													<input type="text" value="" name="s" id="s">
													<input type="submit" id="searchsubmit" value="Keresés">
												</div>
											</form>
										</div>
									</div>
								</div>
							</li>
						</div>
					</div>
				</div>

				<?php
				$logo_src = esc_url(get_theme_mod('site_logo'));

				if (isset($_COOKIE['dark_mode'])) {
					$dark_mode = true;
				}
				if (isset($dark_mode)) {

					$logo_src = get_bloginfo("template_url") . '/images/logo_dark.png';
				}

				$weather = get_option('weather');
				$usd_currency = get_option('usd_currency')['data']['HUF']['value'];
				$eur_currency = get_option('eur_currency')['data']['HUF']['value'];
				$gbp_currency = get_option('gbp_currency')['data']['HUF']['value'];
				$btc_currency = get_option('btc_currency')['data']['BTC']['value'];

				wp_localize_script('liner-navigation', 'weather', array($weather));
				wp_enqueue_script('liner-navigation');
				?>




				<div class="mid-nav justify-content-between align-items-center">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo navbar-brand" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php if (get_theme_mod('site_logo')) : ?>
							<img src='<?php echo $logo_src; ?>' class="img-responsive" alt=""><?php endif; ?>
					</a>
					<div class="d-flex">
						<div class="currency d-flex align-items-center currency-gap">
							<div class="item">
								<div class="icon">
									<img src="<?php echo get_template_directory_uri(); ?>/images/american.png" alt="dollar" class="img-fluid" width="32">

								</div>
								<div class="info">
									<div class="top">
										<span class="title">Dollár</span>
										<span class="change up"></span>
									</div>
									<span class="value">
										<?php echo $usd_currency; ?>
									</span>
								</div>
							</div>
							<div class="item">
								<div class="icon">
									<img src="<?php echo get_template_directory_uri(); ?>/images/coin.png" alt="pound" class="img-fluid" width="32">
								</div>
								<div class="info">
									<div class="top"><span class="title">Euró</span> <span class="change up"></span></div>
									<span class="value"><?php echo $eur_currency; ?></span>
								</div>
							</div>
							<div class="item">
								<div class="icon">
									<img src="<?php echo get_template_directory_uri(); ?>/images/pound.png" alt="pound" class="img-fluid" width="32">
								</div>
								<div class="info">
									<div class="top"><span class="title">Font</span> <span class="change up"></span>
									</div>
									<span class="value">
										<?php echo $gbp_currency; ?>
									</span>
								</div>
							</div>
							<div class="item">
								<div class="icon">
									<img src="<?php echo get_template_directory_uri(); ?>/images/bitcoin.png" alt="bitcoin" class="img-fluid" width="32">
								</div>
								<div class="info">
									<div class="top"><span class="title">Bitcoin</span> <span class="change up"></span>
									</div>
									<span class="value"><?php echo $btc_currency; ?></span>
								</div>
							</div>
						</div>
						<!-- <div id="ikasgela-ikonoa">
							<div style="text-align:center;padding-bottom:0;margin-bottom:0;">
								<p class="bola azal_bila" style="margin-bottom:.275em;">
									<a title="Liner.hu"><span class="hide">Liner.hu</span></a>
								</p>
							</div>
							<p class="data text-center" style="margin-bottom:0;padding-bottom:0;font-family:'lft-etica',sans-serif;font-style:normal;font-weight:300;font-size:.750em;">
								<a title="Liner.hu" class="bola-title"><span class="graduak">Liner.hu</span></a>
							</p>
						</div> -->

						<button class="notification-articles active" type="button">
							<div class="position-relative" style="height:38px">
								<img src="<?php echo get_template_directory_uri(); ?>/images/wall-clock.png" alt="clock" class="img-fluid" width="32">
								<span>
									<?php
									echo count($last_visit_query->posts);

									?>
								</span>
							</div>
						</button>

						<div id="estilo-ikonoa">
							<div style="text-align:center;padding-bottom:0;margin-bottom:0;">
								<p class="bola azal_bila" style="margin-bottom:.275em;">
									<a href="https://dev.liner.hu" class="bola-title" title=Liner.hu">
										<span class="fa fa-book" aria-hidden="true">
											<span class="hide">Liner.hu</span>
										</span>
									</a>
								</p>
							</div>
							<p class="data text-center" style="margin-bottom:0;padding-bottom:0;font-family:'lft-etica',sans-serif;font-style:normal;font-weight:300;font-size:.750em;">
								<a href="https://dev.liner.hu" class="bola-title" title="Liner.hu">
									<span>Liner.hu</span>
								</a>
							</p>
						</div>
						<div class="weather-widget d-flex flex-column align-items-center justify-content-center">
							<img style="margin-top:-8px; width:50px;height:50px;" src="https://openweathermap.org/img/wn/01d@2x.png" alt="Clouds" title="Clouds" width="50" height="50">
							<span class="title"><strong>Budapest</strong></span>
							<span class="graduak">
								<span class="value">21</span>
								<small>℃</small>
							</span>
						</div>
					</div>
				</div>
				<div class="bot-nav">

					<div>
						<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'ml-auto main-header d-flex', 'container' => '')); ?>
					</div>
				</div>
			</div>
		</header>
		<?php
		// get list of categories with child
		$categories = get_categories(array(
			'orderby' => 'name',
			'order' => 'ASC',
			'parent' => 0,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'taxonomy' => 'news_cat',
			'pad_counts' => false,
		));
		?>
		<div class="ham-menu">
			<div class="container">
				<div class="row">
					<?php foreach ($categories as $category) { ?>
						<ul class="main-list col-lg-3">
							<?php if ($category->name !== '#X') :
									$child_categories = get_categories(array(
										'orderby' => 'name',
										'order' => 'ASC',
										'parent' => $category->term_id,
										'hide_empty' => 0,
										'hierarchical' => 1,
										'exclude' => '',
										'include' => '',
										'taxonomy' => 'news_cat',
										'pad_counts' => false,
									));
									?>
								<li class="parent-category-item">
									<a href="<?php echo get_category_link($category->term_id) ?>" class="parent-category">
										<?php echo str_replace('#', '', $category->name) ?>
									</a>
									<?php if (count($child_categories) > 0) : ?>
										<button class="open-child-category">
											<i class="fa fa-angle-right" aria-hidden="true"></i>
										</button>
									<?php else : ?>
										<div style="width:40px;height:33px;"></div>
									<?php endif; ?>
									<ul class="child-category-menu">
										<?php foreach ($child_categories as $child_category) { ?>
											<li class="child-category-item">
												<a href="<?php echo get_category_link($child_category->term_id) ?>" class="child-category">
													<?php echo $child_category->name ?>
												</a>
											</li>
										<?php } ?>
									</ul>
								</li>
							<?php endif; ?>
						</ul>
					<?php } ?>
				</div>

				<div class="currency d-flex d-lg-none align-items-center currency-gap mt-5 flex-wrap">
					<div class="item">
						<div class="icon">
							<img src="<?php echo get_template_directory_uri(); ?>/images/american.png" alt="dollar" class="img-fluid" width="32">

						</div>
						<div class="info">
							<div class="top">
								<span class="title">Dollár</span>
								<span class="change up"></span>
							</div>
							<span class="value">
								<?php echo $usd_currency; ?>
							</span>
						</div>
					</div>
					<div class="item">
						<div class="icon">
							<img src="<?php echo get_template_directory_uri(); ?>/images/coin.png" alt="pound" class="img-fluid" width="32">
						</div>
						<div class="info">
							<div class="top"><span class="title">Euró</span> <span class="change up"></span></div>
							<span class="value"><?php echo $eur_currency; ?></span>
						</div>
					</div>
					<div class="item">
						<div class="icon">
							<img src="<?php echo get_template_directory_uri(); ?>/images/pound.png" alt="pound" class="img-fluid" width="32">
						</div>
						<div class="info">
							<div class="top"><span class="title">Font</span> <span class="change up"></span>
							</div>
							<span class="value">
								<?php echo $gbp_currency; ?>
							</span>
						</div>
					</div>
					<div class="item">
						<div class="icon">
							<img src="<?php echo get_template_directory_uri(); ?>/images/bitcoin.png" alt="bitcoin" class="img-fluid" width="32">
						</div>
						<div class="info">
							<div class="top"><span class="title">Bitcoin</span> <span class="change up"></span>
							</div>
							<span class="value"><?php echo $btc_currency; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php
		if (is_home() || is_front_page()) {
			$postnot = array();
			global $postnot;
		}


		?>

		<div class="main_wrapper">
			<?php
			if (is_single()) {
				function categoryByID($id)
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

					if ($childCategory == '') {
						$output = '<a href="' . $parentLink . '" class="article-category">' . $parentCategory . '</a>';
					} else {
						$output .= '<a href="' . $childLink . '" class="article-category mx-1">' . $childCategory . '</a>';
					}
					return $output;
				}

				echo '<nav class="related-articles">
					<div class="container"><div class="articles d-flex">';
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
							// $postlinks[] = get_the_permalink($the_query->post->ID);
							$image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), '');
							?>

							<div class="related-article" data-slug="<?php echo get_post_field('post_name', $the_query->post->ID); ?>">
								<img src="<?php echo $image_attributes[0] ?>" class="img-fluid">
								<div class="align-self-center">
									<a href="#" class="article-category">
										<?php echo categoryByID($the_query->post->ID) ?>
									</a>
									<a href="<?php echo get_the_permalink($the_query->post->ID); ?>">
										<h4 class="article-title">
											<?php the_title(); ?>
										</h4>
									</a>
								</div>
							</div>


					<?php

								endwhile;
							endif;
						}
						echo '</div></div></nav>';
					}

					if ($last_visit_query->have_posts()) {
						echo '<div class="last-visit-modal">
						<div class="container">
							<div class="text-right">
							<button class="close-visit-modal mt-4 px-3 bg-transparent">
								<i class="fa fa-times"></i>
							</button>
							</div>
						';
						while ($last_visit_query->have_posts()) {
							$last_visit_query->the_post();
							$image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($last_visit_query->post->ID), '');

							$poplr = get_field('most_popular_news', $last_visit_query->post->ID);
							$brknews = get_field('breaking_news', $last_visit_query->post->ID);

							if ($poplr == 1) {
								$popular = '';
							} else {
								$popular = '';
							}

							if ($brknews == 1) {
								$breaknews = '';
								$popular = '';
							} else {
								$breaknews = '';
							}

							?>

					<div class="news-item d-flex align-items-center">
						<span class="post-tagline mt-0 mr-4 font-weight-bold"><?php echo get_post_time('H:i'); ?></span>
						<div>
							<div class="news-item-title mt-0 mb-0">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
						</div>
					</div>
			<?php }
				echo '</div></div>';
			}
			?>