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

	<script src="<?php echo 'https://cdn.atmedia.hu/liner.hu.js?v=' . date('Ymd'); ?>/js/html5.js?ver=3.7.0" type="text/javascript" async></script>

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
<!-- dark mode -->

<body <?php body_class(isset($_COOKIE['darkmode']) && $_COOKIE['darkmode'] == 'true' ? 'darkmode' : '') ?>>
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
				'posts_per_page' => 99,
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

			$last_visit_query = array();
		}
	}
	?>
	<script>
		/** dark mode switch button **/
		jQuery(document).ready(function($) {
			// add count of posts to title of browser
			var title = document.title;
			var count = <?php if (isset($last_visit_query) && is_object($last_visit_query)) {
							echo $last_visit_query->post_count;
						} else {
							echo 0;
						} ?>;
			if (count > 0) {
				setTimeout(() => {
					document.title = '(' + count + ') ' + title;
				}, 2000);
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

			if (isset($_COOKIE['darkmode'])) {
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
						<button class="mr-1 button-nav-toggle mr-lg-3">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</button>

						<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo navbar-brand" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
							<?php if (get_theme_mod('site_logo')) : ?>
								<img src='<?php echo $logo_src; ?>' class="img-responsive" alt=""><?php endif; ?>
						</a>
						<div class="ml-2 d-flex align-items-center">
							<a href="<?php echo get_permalink(get_page_by_title('Friss hirek')); ?>" class="top-nav-link font-weight-bold text-uppercase">Friss hírek</a>
							<a href="<?php echo get_permalink(get_page_by_title('Sztori Bekuldes')); ?>" class="top-nav-link font-weight-bold text-uppercase">Sztori beküldése</a>
							<a href="https://liner.hu/" class="top-nav-link">LINER.HU</a>
							<a href="https://motorsport.hu/" class="top-nav-link">MOTORSPORT.HU</a>
						</div>

					</div>
					<div class="d-flex align-items-center">
						<button class="notification-articles active mobile" type="button">
							<div class="position-relative" style="height:30px">
								<img src="<?php echo get_template_directory_uri(); ?>/images/wall-clock.png" alt="clock" class="img-fluid" width="32">
								<span>
									<?php
									if (isset($last_visit_query) && is_object($last_visit_query)) {
										echo count($last_visit_query->posts);
									} else {
										echo '0';
									}
									?>
								</span>
							</div>
						</button>
						<div class="switcher d-lg-none">
							<div class="mode-switcher">
								<i class="fa fa-moon-o" aria-hidden="true"></i>
							</div>
							<div class="switcher-list">
								<button class="switch-button" data-switch="auto">
									<i class="fa fa-sun-o" aria-hidden="true"></i>
									<span>
										Automatic
									</span>
								</button>
								<button class="switch-button" data-switch="dark">
									<i class="fa fa-moon-o" aria-hidden="true"></i>
									<span>
										Dark mode
									</span>
								</button>
								<button class="switch-button" data-switch="light">
									<i class="fa fa-lightbulb-o" aria-hidden="true"></i>
									<span>
										Bright mode
									</span>
								</button>
							</div>
						</div>
					</div>
					<div class="d-none d-lg-flex align-items-center">

						<div class="weather-widget d-flex align-items-center justify-content-center">
							<img style="margin-right:10px;object-fit: cover;height: 25px;" src="https://liner.hu/wp-content/themes/liner/images/09.png" alt="Clouds" title="Clouds" width="30" height="30">

							<div class="d-flex flex-column" style="min-width:100%;">
								<span class="graduak">
									<span class="value">21</span>
									<small>℃</small>
								</span>
								<span class="title">Budapest</span>
							</div>
						</div>
						<div class="switcher">
							<div class="mode-switcher mr-3">
								<i class="fa fa-moon-o" aria-hidden="true"></i>
							</div>
							<div class="switcher-list">
								<button class="switch-button" data-switch="auto">
									<i class="fa fa-sun-o" aria-hidden="true"></i>
									<span>
										Automatic
									</span>
								</button>
								<button class="switch-button" data-switch="dark">
									<i class="fa fa-moon-o" aria-hidden="true"></i>
									<span>
										Dark mode
									</span>
								</button>
								<button class="switch-button" data-switch="light">
									<i class="fa fa-lightbulb-o" aria-hidden="true"></i>
									<span>
										Bright mode
									</span>
								</button>
							</div>
						</div>
						<div class="top-social d-flex align-items-center">
							<a href="https://www.facebook.com/linerhungary" target="_blank" class="mr-3 rss-icon">
								<!-- facebook -->
								<i class="fa fa-facebook" aria-hidden="true"></i>
							</a>
							<a href="/feed" target="_blank" class="mr-3 rss-icon">
								<i class="fa fa-rss" aria-hidden="true"></i>
							</a>
							<a href="/kapcsolat" target="_blank" class="rss-icon">
								<!-- mail -->
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</a>
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
				$usd_currency_old = get_option('usd_currency_old')['data']['HUF']['value'];
				$eur_currency = get_option('eur_currency')['data']['HUF']['value'];
				$eur_currency_old = get_option('eur_currency_old')['data']['HUF']['value'];
				$gbp_currency = get_option('gbp_currency')['data']['HUF']['value'];
				$gbp_currency_old = get_option('gbp_currency_old')['data']['HUF']['value'];
				$btc_currency = get_option('btc_currency')['data']['USD']['value'];
				$btc_currency_old = get_option('btc_currency_old')['data']['USD']['value'];

				wp_localize_script('liner-navigation', 'weather', array($weather));
				wp_enqueue_script('liner-navigation');
				?>




				<div class="mid-nav justify-content-between align-items-center">
					<div class="d-flex align-items-center">
						<a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo navbar-brand" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
							<?php if (get_theme_mod('site_logo')) : ?>
								<img src='<?php echo $logo_src; ?>' class="img-responsive" alt=""><?php endif; ?>
						</a>
						<button class="ml-4 mr-5 notification-articles active" type="button">
							<div class="position-relative d-flex align-items-center" style="height:38px">
								<img src="<?php echo get_template_directory_uri(); ?>/images/wall-clock.png" alt="clock" class="img-fluid" width="32">
								<span><?php
										if (isset($last_visit_query) && is_object($last_visit_query)) {
											echo count($last_visit_query->posts);
										} else {
											echo '0';
										}
										?></span>
							</div>
						</button>
						<?php wp_nav_menu(array('theme_location' => 'fontos', 'menu_class' => 'fontos-menu mb-0', 'container' => '')); ?>
					</div>
					<div class="d-flex">
						<div class="currency d-flex align-items-center currency-gap">
							<div class="item">
								<div class="info">
									<div class="top">
										<span class="title">Dollár</span>
									</div>
									<span class="value">
										<?php echo number_format($usd_currency, 2, ',', ' '); ?> Ft
									</span>
								</div>
								<?php if ($usd_currency_old !== $usd_currency) : ?>
									<span class="change <?php echo ($usd_currency_old > $usd_currency) ? 'down' : 'up'; ?>"></span>
								<?php endif; ?>
							</div>
							<div class="item">
								<div class="info">
									<div class="top">
										<span class="title">Euró</span>
									</div>
									<span class="value"><?php echo number_format($eur_currency, 2, ',', ' '); ?> Ft</span>
								</div>
								<?php if ($eur_currency_old !== $eur_currency) : ?>
									<span class="change <?php echo ($eur_currency_old > $eur_currency) ? 'down' : 'up'; ?>"></span>
								<?php endif; ?>
							</div>
							<div class="item">
								<div class="info">
									<div class="top">
										<span class="title">Font</span>
									</div>
									<span class="value"><?php echo number_format($gbp_currency, 2, ',', ' '); ?> Ft</span>
								</div>
								<?php if ($gbp_currency_old !== $gbp_currency) : ?>
									<span class="change <?php echo ($gbp_currency_old > $gbp_currency) ? 'down' : 'up'; ?>"></span>
								<?php endif; ?>
							</div>
							<?php if ($btc_currency >= 1) : ?>
								<div class="item">
									<div class="info">
										<div class="top">
											<span class="title">Bitcoin</span>
										</div>
										<span class="value"><?php echo number_format($btc_currency); ?> $</span>
									</div>
									<?php if ($btc_currency_old !== $btc_currency) : ?>
										<span class="change <?php echo ($btc_currency_old > $btc_currency) ? 'down' : 'up'; ?>"></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="bot-nav">

					<div class="d-flex align-items-center justify-content-between w-100">
						<div>
							<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'ml-auto main-header d-flex', 'container' => '')); ?>
						</div>
						<div class="currnet-date">
							<?php
							// echo date('Y.m.d, l');
							// echo date with another Hungarian language
							setlocale(LC_ALL, 'hu_HU.UTF-8');
							echo strftime('%Y.%m.%d, %A');


							?>
						</div>
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
				<div class="mb-3 input-group">
					<form role="search" method="get" id="searchform" class="searchform w-100" action="<?php echo home_url(); ?>">
						<div>
							<label class="screen-reader-text" for="s">Keresés:</label>
							<input type="text" placeholder="Keresés a Liner.hu-n" value="" name="s" id="s" class="w-100 ham-search">
						</div>
					</form>
				</div>
				<div class="row">
					<?php wp_nav_menu(array('theme_location' => 'hamburger', 'menu_class' => 'hamburger-menu-items', 'container_class' => 'col-lg-8 menu-hamburger-menu-container')); ?>
					<div class="col-lg-4">
						<div class="mb-5 information-menu-section">
							<h3 class="informac-title d-block">INFORMÁCIÓK</h3>
							<?php wp_nav_menu(array('theme_location' => 'informations', 'menu_class' => 'informations-menu')); ?>
						</div>
						<div class="mb-5">
							<h3 class="informac-title">ÁRFOLYAM</h3>
							<div class="d-flex">
								<div class="currency d-flex align-items-center currency-gap">
									<div class="item">
										<div class="info">
											<div class="top">
												<span class="title">Dollár</span>
											</div>
											<span class="value">
												<?php echo number_format($usd_currency, 2, ',', ' '); ?> Ft
											</span>
										</div>
										<?php if ($usd_currency_old !== $usd_currency) : ?>
											<span class="change <?php echo ($usd_currency_old > $usd_currency) ? 'down' : 'up'; ?>"></span>
										<?php endif; ?>
									</div>
									<div class="item">
										<div class="info">
											<div class="top">
												<span class="title">Euró</span>
											</div>
											<span class="value"><?php echo number_format($eur_currency, 2, ',', ' '); ?> Ft</span>
										</div>
										<?php if ($eur_currency_old !== $eur_currency) : ?>
											<span class="change <?php echo ($eur_currency_old > $eur_currency) ? 'down' : 'up'; ?>"></span>
										<?php endif; ?>
									</div>
									<div class="item">
										<div class="info">
											<div class="top">
												<span class="title">Font</span>
											</div>
											<span class="value"><?php echo number_format($gbp_currency, 2, ',', ' '); ?> Ft</span>
										</div>
										<?php if ($gbp_currency_old !== $gbp_currency) : ?>
											<span class="change <?php echo ($gbp_currency_old > $gbp_currency) ? 'down' : 'up'; ?>"></span>
										<?php endif; ?>
									</div>
									<div class="item">
										<div class="info">
											<div class="top">
												<span class="title">Bitcoin</span>
											</div>
											<span class="value"><?php echo number_format($btc_currency); ?> $</span>
										</div>
										<?php if ($btc_currency_old !== $btc_currency) : ?>
											<span class="change <?php echo ($btc_currency_old > $btc_currency) ? 'down' : 'up'; ?>"></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div>
							<h3 class="informac-title">TOVÁBBI LAPOK</h3>
							<div class="d-flex align-items-center justify-content-between">
								<a href="https://tesztauto.hu/" class="external-link" target="_blank">TESZTAUTO.HU</a>
								<a href="https://motorsport.hu/" class="external-link" target="_blank">MOTORSPORT.HU</a>
							</div>
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


			if (isset($last_visit_query) && is_object($last_visit_query)) {
				echo '<div class="last-visit-modal">
						<div class="container">
							<div class="d-flex align-items-center justify-content-between my-4 ">
							<h2 class="egy-header-title">Mióta itt jártál:</h2>
							<button class="px-3 bg-transparent close-visit-modal">
								<i class="fa fa-times"></i>
							</button>
							</div>
							<div class="last-visit-modal-content" style="max-height: 460px;overflow: auto;box-shadow: 0 0 10px #00000026;padding: 20px;">
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
						<span class="mt-0 mr-4 post-tagline font-weight-bold"><?php echo get_post_time('H:i'); ?></span>
						<div>
							<div class="mt-0 mb-0 news-item-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
						</div>
					</div>
			<?php }
				echo '</div></div></div>';
			}
			?>