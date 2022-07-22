<?php

/**
 * Liner Hu functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://developer.wordpress.org/plugins/
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if (!isset($content_width)) {
	$content_width = 625;
}

/**
 * Liner Hu setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Liner Hu supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *  custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Liner Hu 1.0
 */
function liner_setup()
{
	/*
	 * Makes Liner Hu available for translation.
	 *
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/liner
	 * If you're building a theme based on Liner Hu, use a find and replace
	 * to change 'liner' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('liner');

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load regular editor styles into the new block-based editor.
	add_theme_support('editor-styles');

	// Load default block styles.
	add_theme_support('wp-block-styles');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	// Add support for custom color scheme.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __('Blue', 'liner'),
				'slug'  => 'blue',
				'color' => '#21759b',
			),
			array(
				'name'  => __('Dark Gray', 'liner'),
				'slug'  => 'dark-gray',
				'color' => '#444',
			),
			array(
				'name'  => __('Medium Gray', 'liner'),
				'slug'  => 'medium-gray',
				'color' => '#9f9f9f',
			),
			array(
				'name'  => __('Light Gray', 'liner'),
				'slug'  => 'light-gray',
				'color' => '#e6e6e6',
			),
			array(
				'name'  => __('White', 'liner'),
				'slug'  => 'white',
				'color' => '#fff',
			),
		)
	);

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	// This theme supports a variety of post formats.
	add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status'));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu('primary', __('Primary Menu', 'liner'));
	register_nav_menu('hamburger', __('Hamburger Menu', 'liner'));
	register_nav_menu('informations', __('Hamburger Menu', 'liner'));
	register_nav_menu('fontos', __('Fontos', 'liner'));

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'e6e6e6',
		)
	);

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support('post-thumbnails');
	
	
	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'liner_setup');

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Liner Hu 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function liner_get_font_url()
{
	$font_url = '';

	/*
	 * translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ('off' !== _x('on', 'Open Sans font: on or off', 'liner')) {
		$subsets = 'latin,latin-ext';

		/*
		 * translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x('no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'liner');

		if ('cyrillic' === $subset) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ('greek' === $subset) {
			$subsets .= ',greek,greek-ext';
		} elseif ('vietnamese' === $subset) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family'  => urlencode('Open Sans:400italic,700italic,400,700'),
			'subset'  => urlencode($subsets),
			'display' => urlencode('fallback'),
		);
		$font_url   = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Liner Hu 1.0
 */
function liner_scripts_styles()
{
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script('liner-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20141205', true);

	// define global variables for the theme
	wp_localize_script('liner-navigation', 'liner_global', array(
		'baseUrl' => get_template_directory_uri(),
		
	));

	$font_url = liner_get_font_url();
	if (!empty($font_url)) {
		wp_enqueue_style('liner-fonts', esc_url_raw($font_url), array(), null);
	}

	// Loads our main stylesheet.
	wp_enqueue_style('liner-style', get_stylesheet_uri(), array(), '20190507');

	// Theme block stylesheet.
	wp_enqueue_style('liner-block-style', get_template_directory_uri() . '/css/blocks.css', array('liner-style'), '20190406');

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style('liner-ie', get_template_directory_uri() . '/css/ie.css', array('liner-style'), '20150214');
	$wp_styles->add_data('liner-ie', 'conditional', 'lt IE 9');
}
add_action('wp_enqueue_scripts', 'liner_scripts_styles');

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Liner Hu 2.6
 */
function liner_block_editor_styles()
{
	// Block styles.
	wp_enqueue_style('liner-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20190406');
	// Add custom fonts.
	wp_enqueue_style('liner-fonts', liner_get_font_url(), array(), null);
}
add_action('enqueue_block_editor_assets', 'liner_block_editor_styles');

/**
 * Add preconnect for Google Fonts.
 *
 * @since Liner Hu 2.2
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function liner_resource_hints($urls, $relation_type)
{
	if (wp_style_is('liner-fonts', 'queue') && 'preconnect' === $relation_type) {
		if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '>=')) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter('wp_resource_hints', 'liner_resource_hints', 10, 2);

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses liner_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Liner Hu 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function liner_mce_css($mce_css)
{
	$font_url = liner_get_font_url();

	if (empty($font_url)) {
		return $mce_css;
	}

	if (!empty($mce_css)) {
		$mce_css .= ',';
	}

	$mce_css .= esc_url_raw(str_replace(',', '%2C', $font_url));

	return $mce_css;
}
add_filter('mce_css', 'liner_mce_css');

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Liner Hu 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function liner_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed()) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo('name', 'display');

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page())) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if (($paged >= 2 || $page >= 2) && !is_404()) {
		/* translators: %s: Page number. */
		$title = "$title $sep " . sprintf(__('Page %s', 'liner'), max($paged, $page));
	}

	return $title;
}
add_filter('wp_title', 'liner_wp_title', 10, 2);

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Liner Hu 1.0
 */
function liner_page_menu_args($args)
{
	if (!isset($args['show_home'])) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter('wp_page_menu_args', 'liner_page_menu_args');

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Liner Hu 1.0
 */
function liner_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Main Sidebar', 'liner'),
			'id'            => 'sidebar-1',
			'description'   => __('Appears on posts and pages except the optional Front Page template, which has its own widgets', 'liner'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __('First Front Page Widget Area', 'liner'),
			'id'            => 'sidebar-2',
			'description'   => __('Appears when using the optional Front Page template with a page set as Static Front Page', 'liner'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Second Front Page Widget Area', 'liner'),
			'id'            => 'sidebar-3',
			'description'   => __('Appears when using the optional Front Page template with a page set as Static Front Page', 'liner'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action('widgets_init', 'liner_widgets_init');

if (!function_exists('liner_content_nav')) :
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Liner Hu 1.0
	 */
	function liner_content_nav($html_id)
	{
		global $wp_query;

		if ($wp_query->max_num_pages > 1) : ?>
			<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e('Post navigation', 'liner'); ?></h3>
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'liner')); ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'liner')); ?></div>
			</nav><!-- .navigation -->
			<?php
					endif;
				}
			endif;

			if (!function_exists('liner_comment')) :
				/**
				 * Template for comments and pingbacks.
				 *
				 * To override this walker in a child theme without modifying the comments template
				 * simply create your own liner_comment(), and that function will be used instead.
				 *
				 * Used as a callback by wp_list_comments() for displaying the comments.
				 *
				 * @since Liner Hu 1.0
				 */
				function liner_comment($comment, $args, $depth)
				{
					$GLOBALS['comment'] = $comment;
					switch ($comment->comment_type):
						case 'pingback':
						case 'trackback':
							// Display trackbacks differently than normal comments.
							?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e('Pingback:', 'liner'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'liner'), '<span class="edit-link">', '</span>'); ?></p>
				<?php
							break;
						default:
							// Proceed with normal comments.
							global $post;
							?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<header class="comment-meta comment-author vcard">
							<?php
										echo get_avatar($comment, 44);
										printf(
											'<cite><b class="fn">%1$s</b> %2$s</cite>',
											get_comment_author_link(),
											// If current post author is also comment author, make it known visually.
											($comment->user_id === $post->post_author) ? '<span>' . __('Post author', 'liner') . '</span>' : ''
										);
										printf(
											'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
											esc_url(get_comment_link($comment->comment_ID)),
											get_comment_time('c'),
											/* translators: 1: Date, 2: Time. */
											sprintf(__('%1$s at %2$s', 'liner'), get_comment_date(), get_comment_time())
										);
										?>
						</header><!-- .comment-meta -->

						<?php
									$commenter = wp_get_current_commenter();
									if ($commenter['comment_author_email']) {
										$moderation_note = __('Your comment is awaiting moderation.', 'liner');
									} else {
										$moderation_note = __('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'liner');
									}
									?>

						<?php if ('0' == $comment->comment_approved) : ?>
							<p class="comment-awaiting-moderation"><?php echo $moderation_note; ?></p>
						<?php endif; ?>

						<section class="comment-content comment">
							<?php comment_text(); ?>
							<?php edit_comment_link(__('Edit', 'liner'), '<p class="edit-link">', '</p>'); ?>
						</section><!-- .comment-content -->

						<div class="reply">
							<?php
										comment_reply_link(
											array_merge(
												$args,
												array(
													'reply_text' => __('Reply', 'liner'),
													'after'      => ' <span>&darr;</span>',
													'depth'      => $depth,
													'max_depth'  => $args['max_depth'],
												)
											)
										);
										?>
						</div><!-- .reply -->
					</article><!-- #comment-## -->
			<?php
						break;
				endswitch; // End comment_type check.
			}
		endif;

		if (!function_exists('liner_entry_meta')) :
			/**
			 * Set up post entry meta.
			 *
			 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
			 *
			 * Create your own liner_entry_meta() to override in a child theme.
			 *
			 * @since Liner Hu 1.0
			 */
			function liner_entry_meta()
			{
				/* translators: Used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list(__(', ', 'liner'));

				/* translators: Used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list('', __(', ', 'liner'));

				$date = sprintf(
					'<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
					esc_url(get_permalink()),
					esc_attr(get_the_time()),
					esc_attr(get_the_date('c')),
					esc_html(get_the_date())
				);

				$author = sprintf(
					'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
					esc_url(get_author_posts_url(get_the_author_meta('ID'))),
					/* translators: %s: Author display name. */
					esc_attr(sprintf(__('View all posts by %s', 'liner'), get_the_author())),
					get_the_author()
				);

				if ($tags_list && !is_wp_error($tags_list)) {
					/* translators: 1: Category name, 2: Tag name, 3: Date, 4: Author display name. */
					$utility_text = __('This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'liner');
				} elseif ($categories_list) {
					/* translators: 1: Category name, 3: Date, 4: Author display name. */
					$utility_text = __('This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'liner');
				} else {
					/* translators: 3: Date, 4: Author display name. */
					$utility_text = __('This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'liner');
				}

				printf(
					$utility_text,
					$categories_list,
					$tags_list,
					$date,
					$author
				);
			}
		endif;

		/**
		 * Extend the default WordPress body classes.
		 *
		 * Extends the default WordPress body class to denote:
		 * 1. Using a full-width layout, when no active widgets in the sidebar
		 *    or full-width template.
		 * 2. Front Page template: thumbnail in use and number of sidebars for
		 *    widget areas.
		 * 3. White or empty background color to change the layout and spacing.
		 * 4. Custom fonts enabled.
		 * 5. Single or multiple authors.
		 *
		 * @since Liner Hu 1.0
		 *
		 * @param array $classes Existing class values.
		 * @return array Filtered class values.
		 */
		function liner_body_class($classes)
		{
			$background_color = get_background_color();
			$background_image = get_background_image();

			if (!is_active_sidebar('sidebar-1') || is_page_template('page-templates/full-width.php')) {
				$classes[] = 'full-width';
			}

			if (is_page_template('page-templates/front-page.php')) {
				$classes[] = 'template-front-page';
				if (has_post_thumbnail()) {
					$classes[] = 'has-post-thumbnail';
				}
				if (is_active_sidebar('sidebar-2') && is_active_sidebar('sidebar-3')) {
					$classes[] = 'two-sidebars';
				}
			}

			if (empty($background_image)) {
				if (empty($background_color)) {
					$classes[] = 'custom-background-empty';
				} elseif (in_array($background_color, array('fff', 'ffffff'), true)) {
					$classes[] = 'custom-background-white';
				}
			}

			// Enable custom font class only if the font CSS is queued to load.
			if (wp_style_is('liner-fonts', 'queue')) {
				$classes[] = 'custom-font-enabled';
			}

			if (!is_multi_author()) {
				$classes[] = 'single-author';
			}

			return $classes;
		}
		add_filter('body_class', 'liner_body_class');

		/**
		 * Adjust content width in certain contexts.
		 *
		 * Adjusts content_width value for full-width and single image attachment
		 * templates, and when there are no active widgets in the sidebar.
		 *
		 * @since Liner Hu 1.0
		 */
		function liner_content_width()
		{
			if (is_page_template('page-templates/full-width.php') || is_attachment() || !is_active_sidebar('sidebar-1')) {
				global $content_width;
				$content_width = 960;
			}
		}
		add_action('template_redirect', 'liner_content_width');

		/**
		 * Register postMessage support.
		 *
		 * Add postMessage support for site title and description for the Customizer.
		 *
		 * @since Liner Hu 1.0
		 *
		 * @param WP_Customize_Manager $wp_customize Customizer object.
		 */
		function liner_customize_register($wp_customize)
		{
			$wp_customize->get_setting('blogname')->transport         = 'postMessage';
			$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
			$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

			if (isset($wp_customize->selective_refresh)) {
				$wp_customize->selective_refresh->add_partial(
					'blogname',
					array(
						'selector'            => '.site-title > a',
						'container_inclusive' => false,
						'render_callback'     => 'liner_customize_partial_blogname',
					)
				);
				$wp_customize->selective_refresh->add_partial(
					'blogdescription',
					array(
						'selector'            => '.site-description',
						'container_inclusive' => false,
						'render_callback'     => 'liner_customize_partial_blogdescription',
					)
				);
			}
		}
		add_action('customize_register', 'liner_customize_register');

		/**
		 * Render the site title for the selective refresh partial.
		 *
		 * @since Liner Hu 2.0
		 *
		 * @see liner_customize_register()
		 *
		 * @return void
		 */
		function liner_customize_partial_blogname()
		{
			bloginfo('name');
		}

		/**
		 * Render the site tagline for the selective refresh partial.
		 *
		 * @since Liner Hu 2.0
		 *
		 * @see liner_customize_register()
		 *
		 * @return void
		 */
		function liner_customize_partial_blogdescription()
		{
			bloginfo('description');
		}

		/**
		 * Enqueue JavaScript postMessage handlers for the Customizer.
		 *
		 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
		 *
		 * @since Liner Hu 1.0
		 */
		function liner_customize_preview_js()
		{
			wp_enqueue_script('liner-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array('customize-preview'), '20141120', true);
		}
		add_action('customize_preview_init', 'liner_customize_preview_js');

		/**
		 * Modifies tag cloud widget arguments to display all tags in the same font size
		 * and use list format for better accessibility.
		 *
		 * @since Liner Hu 2.4
		 *
		 * @param array $args Arguments for tag cloud widget.
		 * @return array The filtered arguments for tag cloud widget.
		 */
		function liner_widget_tag_cloud_args($args)
		{
			$args['largest']  = 22;
			$args['smallest'] = 8;
			$args['unit']     = 'pt';
			$args['format']   = 'list';

			return $args;
		}
		add_filter('widget_tag_cloud_args', 'liner_widget_tag_cloud_args');

		if (!function_exists('wp_body_open')) :
			/**
			 * Fire the wp_body_open action.
			 *
			 * Added for backward compatibility to support pre-5.2.0 WordPress versions.
			 *
			 * @since Liner Hu 3.0
			 */
			function wp_body_open()
			{
				/**
				 * Triggered after the opening <body> tag.
				 *
				 * @since Liner Hu 3.0
				 */
				do_action('wp_body_open');
			}
		endif;


		function disable_emoji_feature()
		{

			// Prevent Emoji from loading on the front-end
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');

			// Remove from admin area also
			remove_action('admin_print_scripts', 'print_emoji_detection_script');
			remove_action('admin_print_styles', 'print_emoji_styles');

			// Remove from RSS feeds also
			remove_filter('the_content_feed', 'wp_staticize_emoji');
			remove_filter('comment_text_rss', 'wp_staticize_emoji');

			// Remove from Embeds
			remove_filter('embed_head', 'print_emoji_detection_script');

			// Remove from emails
			remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

			// Disable from TinyMCE editor. Currently disabled in block editor by default
			add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

			/** Finally, prevent character conversion too
			 ** without this, emojis still work
			 ** if it is available on the user's device
			 */
			// Disable emojis
			add_filter('option_use_smilies', '__return_false');
		}
		function disable_emojis_tinymce($plugins)
		{
			if (is_array($plugins)) {
				$plugins = array_diff($plugins, array('wpemoji'));
			}
			return $plugins;
		}

		add_action('init', 'disable_emoji_feature');

		add_filter('wp_get_object_terms', function ($terms, $object_ids, $taxonomies, $args) {

			// Don't mess with admin stuff
			if (is_admin()) {
				return $terms;
			}

			// Category slugs to exclude
			$exclude = array('x');

			// Loop through terms and remove items
			if ($terms) {
				foreach ($terms as $key => $term) {
					if (
						is_object($term)
						&& $term->taxonomy == 'news_cat'
						&& in_array($term->slug, $exclude)
					) {
						unset($terms[$key]);
					}
				}
			}

			// Return terms
			return $terms;
		}, PHP_INT_MAX, 4);

		// Custom Code featured image thumbnails in WordPress RSS Feeds
		function liner_post_thumbnails_in_feeds($content)
		{
			global $post;
			if (has_post_thumbnail($post->ID)) {
				$content = '<p>' . get_the_post_thumbnail($post->ID) . '</p>' . $content;
			}
			return $content;
		}

		add_filter('the_content_feed', 'liner_post_thumbnails_in_feeds');


		/**
		 * Custom functions that act independently of the theme templates.
		 */
		require_once get_template_directory() . '/inc/custom-function.php';


		/*********************************************************************/
		/* Add featured post checkbox
/********************************************************************/
		add_action('add_meta_boxes', 'add_promoted_checkbox_function');
		function add_promoted_checkbox_function()
		{
			add_meta_box('promoted_checkbox_id', 'Cikközi promó', 'promoted_checkbox_callback_function', 'linernews', 'side', 'high');
		}
		function promoted_checkbox_callback_function($post)
		{
			global $post;
			$is_promoted = get_post_meta($post->ID, 'is_promoted', true);
			?>

			<input type="checkbox" name="is_promoted" value="yes" <?php echo (($is_promoted == 'yes') ? 'checked="checked"' : ''); ?> />Promo box
		<?php
		}

		add_action('save_post', 'save_featured_post');
		function save_featured_post($post_id)
		{
			global $wpdb;
			if (isset($_POST['is_promoted']) && $_POST['is_promoted'] != '') {
				$table = $wpdb->prefix . 'postmeta';
				$wpdb->delete($table, array('meta_key' => 'is_promoted'));

				update_post_meta($post_id, 'is_promoted', $_POST['is_promoted']);
			}
		}

		add_shortcode('cikk_promo', 'wp_promoted_post_func');
		function wp_promoted_post_func($args)
		{
			global $wpdb;
			$postmeta = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'is_promoted' LIMIT 1"));
			$html = '';
			if (!empty($postmeta)) {
				$post_data = get_post($postmeta->post_id);

				$html .= '<div class="liner-grid">
			<article class="liner-promo">
		
			<a class="liner-promo__link" href="' . get_the_permalink($post_data->ID) . '" >
			<div class="liner-promo__image" style="background-image: url(' . get_the_post_thumbnail_url($postmeta->post_id) . ')">
			</div><div class="liner-promo__content">
			<h3 class="liner-promo__title">' . $post_data->post_title . '</h3> <p class="liner-promo__lead">' . substr($post_data->post_content, 0, 150) . '</p>
			</div> </a>
			</article></div>';
			}

			return $html;
		}


		add_action('wp_get_currencies', 'wp_get_currencies_func');

		function wp_get_currencies_func()
		{
			// request api
			$usd_url = 'https://api.currencyapi.com/v3/latest?apikey=vsAKQVd2VbDSbuhKvCCeDp0YMkNigJRViarqYaae&currencies=HUF';
			// use curl to get the data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $usd_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

			// assign the data to an array
			$data_usd = json_decode($result, true);
			// add data to custom option
			update_option('usd_currency', $data_usd);

			// request api
			$eur_url = 'https://api.currencyapi.com/v3/latest?apikey=vsAKQVd2VbDSbuhKvCCeDp0YMkNigJRViarqYaae&currencies=HUF&base_currency=EUR';
			// use curl to get the data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $eur_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

			// assign the data to an array
			$data_eur = json_decode($result, true);
			// add data to custom option
			update_option('eur_currency', $data_eur);

			// request api
			$gbp_url = 'https://api.currencyapi.com/v3/latest?apikey=vsAKQVd2VbDSbuhKvCCeDp0YMkNigJRViarqYaae&currencies=HUF&base_currency=GBP';
			// use curl to get the data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $gbp_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

			// assign the data to an array
			$data_gbp = json_decode($result, true);
			// add data to custom option
			update_option('gbp_currency', $data_gbp);

			// request api
			$btc_url = 'https://api.currencyapi.com/v3/latest?apikey=vsAKQVd2VbDSbuhKvCCeDp0YMkNigJRViarqYaae&currencies=USD&base_currency=BTC';
			// use curl to get the data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $btc_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

			// assign the data to an array
			$data_btc = json_decode($result, true);
			// add data to custom option
			update_option('btc_currency', $data_btc);
		}
		add_action('wp_get_old_currencies', 'wp_get_old_currencies_func');

		function wp_get_old_currencies_func()
		{
			update_option('usd_currency_old', get_option('usd_currency'));

			update_option('eur_currency_old', get_option('eur_currency'));

			update_option('gbp_currency_old', get_option('gbp_currency'));

			update_option('btc_currency_old', get_option('btc_currency'));
		}

		add_action('wp_get_weather', 'wp_get_weather_func');

		function wp_get_weather_func()
		{
			// request api
			$url = 'https://api.openweathermap.org/data/2.5/group?id=3054643,721472,715429,717582,3045190&appid=1ea50bd98e863f8d95cad4fae3ae5c08&units=metric';
			// use curl to get the data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

			// assign the data to an array
			$data = json_decode($result, true);
			// add data to custom option
			update_option('weather', $data);
		}



		//Insert ads after second paragraph of single post content.


		add_filter('the_content', 'prefix_insert_post_ads');

		function prefix_insert_post_ads($content)
		{
			global $post;
			$home_top_content = '';
			if (!get_post_meta($post->ID, 'home_top', true)) {
				$args = array(
					'post_type'              => 'linernews',
					'post_status'            => 'publish',
					'posts_per_page'         => 1,
					'no_found_rows'      => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'meta_query'    => array(
						array(
							'key'   => 'home_top',
							'value' => '1',
						)
					)
				);
				$the_query = new WP_Query($args);

				if ($the_query->have_posts()) {
					while ($the_query->have_posts()) {
						$the_query->the_post();
						$home_top_content .= '
				<span class="ao-article-banner">
					<span>Soron kívül</span>
					<span>
						<a target="_blank" href="' . get_permalink() . '">' . get_the_title() . '</a>
					</span>
				</span>
				';
					}
				}
			}

			if (is_single() && !is_admin()) {
				return prefix_insert_after_paragraph($home_top_content, 1, $content);
			}

			return $content;
		}

		// Parent Function that makes the magic happen

		function prefix_insert_after_paragraph($insertion, $paragraph_id, $content)
		{
			$closing_p = '</p>';
			$paragraphs = explode($closing_p, $content);
			foreach ($paragraphs as $index => $paragraph) {

				if (trim($paragraph)) {
					$paragraphs[$index] .= $closing_p;
				}

				if ($paragraph_id == $index + 1) {
					$paragraphs[$index] .= $insertion;
				}
			}

			return implode('', $paragraphs);
		}

		function wpb_lastvisit_set_cookie()
		{

			if (is_admin()) return;
			$current = current_time('timestamp');
			if (!isset($_COOKIE['lastvisit'])) {

				$expire = $current + 31536000;

				setcookie('lastvisit', $current, $expire, COOKIEPATH, COOKIE_DOMAIN);
			}
		}

		add_action('init', 'wpb_lastvisit_set_cookie');

		function getCategoryByPostIdd($id)
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
			$output = '<a href="' . $parentLink . '" class="tag-slug">' . $parentCategory . '</a>';

			if ($childCategory != '') {
				$output .= '<span class="ml-1 tag-slug">/</span><a href="' . $childLink . '" class="mx-1 tag-slug">' . $childCategory . '</a>';
			}
			return $output;
		}
		function wptrc_query_vars($query_vars)
		{
			$query_vars[] = 'date';
			return $query_vars;
		}
		add_filter('query_vars', 'wptrc_query_vars');
