<?php

/**
 * Implement an optional custom function for Liner Hu
 *
 * See http://codex.wordpress.org/Custom_Function
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */
?>
<?php
//Add Image Size
// add_image_size('top-thumb', 224, 126, true);
// add_image_size('topads-thumb', 1000, 233, true);
// add_image_size('contentads-thumb', 681, 385, true);
// add_image_size('sidebarads-thumb', 308, 681, true);
// add_image_size('singlepagebanner-thumb', 1000, 550, true);
add_image_size('medium', 350, 350, false);
add_image_size('cikkoldali', 1200, 800, false);
// ADD Script
function theme_scripts()
{
  wp_enqueue_style('font-awesome-style', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '', false);
  wp_enqueue_script('jquery');
  //wp_enqueue_script( 'popper-script', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array(), '', true );
  //wp_enqueue_script( 'popper-script', get_template_directory_uri() .'/js/popper.min.js', array(), '', true );
  //wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array(), '', true );
  wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '', true);
  wp_enqueue_script('site-script', get_template_directory_uri() . '/js/custom-script.js', array(), '1.0.59', false);


  if (is_singular('linernews')) {
    //wp_enqueue_style('owl-theme-style', get_template_directory_uri() . '/css/owl.theme.css', array(), '', false);
    //wp_enqueue_style('owl-carousel-style', get_template_directory_uri() . '/css/owl.carousel.css', array(), '', false);
    //wp_enqueue_script('owl-carousel-script', get_template_directory_uri() . '/js/owl.carousel.js', array(), '', true);
    wp_enqueue_script('infiniteScroll-script', get_template_directory_uri() . '/js/infinite-scroll.pkgd.min.js', array(), '', true);
    //wp_enqueue_script( 'ads1-script','https://cdn.atmedia.hu/liner.hu.js?v='.date('Ymd'), array(), '', true );
    //wp_enqueue_script( 'ads2-script','https://cdn.atmedia.hu/liner.hu.infinite.js?v='.date('Ymd'), array(), '', true );

  }
}
add_action('wp_enqueue_scripts', 'theme_scripts');
// ADD CSS
function load_css_files()
{
  //wp_deregister_style( 'dashicons' );
  //wp_deregister_style( 'cnss_font_awesome_v4_shims' );
  //wp_enqueue_style( 'bootstrap-css','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '', false );
  wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '', false);
  wp_enqueue_style('gfont-style', 'https://fonts.googleapis.com/css?family=Bai+Jamjuree:300,400,500,600,700|Poppins:100,200,300,400,500,600,700,800,900|Roboto:300,400,500,700,900&display=swap', array(), '', false);
  wp_enqueue_style('custom-style', get_template_directory_uri() . '/custom-style.css', array(), '1.0.74', false);
}
add_action('wp_enqueue_scripts', 'load_css_files');
// Register logo section
function site_theme_customizer($wp_customize)
{
  $wp_customize->add_panel('theme_panel', array(
    'title' => __('Theme Settings', 'site'),
    'description' => 'Edit Theme Settings',
    'priority' => 32,
  ));
  $wp_customize->add_section('site_section', array(
    'title'       => __('Header', 'site'),
    'priority'    => 1,
    'description' => 'Header Settings',
    'panel' => 'theme_panel',
  ));

  $wp_customize->add_setting('site_logo');
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
    'label'    => __('Logo', 'site'),
    'section'  => 'site_section',
    'settings' => 'site_logo',
    'description' => 'Upload a logo to replace the default site name and description in the header',
  )));
}
add_action('customize_register', 'site_theme_customizer');

//login screen css
function liner_login_admin_screen()
{
  wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/login-screen-style.css?lnr=' . time(), array(), '', false);
}
add_action('login_enqueue_scripts', 'liner_login_admin_screen');

//update login logo url
function liner_login_headerurl($login_header_url)
{
  $login_header_url = home_url();
  return $login_header_url;
}
add_filter('login_headerurl', 'liner_login_headerurl');


// Shortcodes within a WordPress Text widget
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');



function font_admin_init()
{
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
}
add_action('admin_init', 'font_admin_init');
function custom_post_css()
{
  echo "<style type='text/css' media='screen'>
			#adminmenu .menu-icon-linernews div.wp-menu-image:before {
				font-family:  FontAwesome !important;
				content: '\\f085'; // this is where you enter the fontaweseom font code
			}
     </style>";
}
add_action('admin_head', 'custom_post_css');


function get_the_content_with_formatting($more_link_text = '(more...)', $stripteaser = 0, $more_file = '')
{
  $content = get_the_content($more_link_text, $stripteaser, $more_file);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
function pippin_get_image_id($image_url)
{
  global $wpdb;
  $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
  return $attachment[0];
}

// Add custom widget area
function footer_widgets_init()
{
  register_sidebar(array(
    'name' => __('Footer Sidebar', 'liner'),
    'id' => 'sidebar-4',
    'description' => __('Appears on posts and pages footer', 'liner'),
    'before_widget' => '<aside id="%1$s" class="widget col-md-4 col-sm-12 col-xs-12 %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="hidden widget-title">',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => __('News Sidebar', 'liner'),
    'id' => 'sidebar-5',
    'description' => __('Appears on Single News Page and Category Page', 'liner'),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title category-sidebar-title egy-header-title">',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('Single Sidebar', 'liner'),
    'id' => 'sidebar-single',
    'description' => __('Appears on Single', 'liner'),
    'before_widget' => '<aside id="%1$s" class="widget single-widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<div class="single-widget-title"><span class="single-widget-title-before"></span>',
    'after_title' => '<span class="single-widget-title-after"></span></div>',
  ));
}
add_action('widgets_init', 'footer_widgets_init');

// add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
function add_admin_link($items, $args)
{
  if ($args->theme_location == 'primary') {
    $items .= '<li class="nav-item search_boxLi"><a href="#" class="nav-link search_btn"><i class="fa fa-search" aria-hidden="true"></i></a><div class="search_panle">
                      <div class="frm_grp">
                        <div class="mb-3 input-group"><form role="search" method="get" id="searchform" class="searchform" action="https://liner.hu/">
				<div>
					<label class="screen-reader-text" for="s">Keresés:</label>
					<input type="text" value="" name="s" id="s">
					<input type="submit" id="searchsubmit" value="Keresés">
				</div>
			</form></div>
                      </div>
                  </div></li>';
  }
  return $items;
}

// Create Custom Post type for News
add_action('init', 'news_register');
function news_register()
{
  $labels = array(
    'name' => _x('Cikkek', 'linernews'),
    'singular_name' => _x('Cikkek', 'linernews'),
    'add_new' => _x('Új hozzáadása', 'linernews'),
    'add_new_item' => _x('Új hozzáadása', 'linernews'),
    'edit_item' => _x('Edit News', 'linernews'),
    'new_item' => _x('New New', 'linernews'),
    'view_item' => _x('View News', 'linernews'),
    'search_items' => _x('Search News', 'linernews'),
    'not_found' => _x('Nothing found', 'linernews'),
    'not_found_in_trash' => _x('Nothing found in Trash', 'linernews'),
    'parent_item_colon' => _x('Parent News List:', 'linernews'),
    'menu_name' => _x('Cikkek', 'linernews'),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'News Lists filterable by Category',
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 30,
    'menu_icon' => '',
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    //'rewrite'   => array( 'slug' => '/','with_front' => false ),
    'capability_type' => 'post'
  );
  register_post_type('linernews', $args);
}


// remove cpt slug from permalinks
function remove_cpt_slug($post_link, $post, $leavename)
{

  if ($post->post_type != 'linernews') {
    return $post_link;
  } else {
    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    return $post_link;
  }
}
add_filter('post_type_link', 'remove_cpt_slug', 10, 3);


// instruct wordpress on how to find posts from the new permalinks
//https://wordpress.stackexchange.com/a/388749
function parse_request_remove_cpt_slug($query_vars)
{

  // return if admin dashboard 
  if (is_admin()) {
    return $query_vars;
  }

  // return if pretty permalink isn't enabled
  if (!get_option('permalink_structure')) {
    return $query_vars;
  }

  $cpt = 'linernews';

  // store post slug value to a variable
  if (isset($query_vars['pagename'])) {
    $slug = $query_vars['pagename'];
  } elseif (isset($query_vars['name'])) {
    $slug = $query_vars['name'];
  } else {
    global $wp;

    $path = $wp->request;

    // use url path as slug
    if ($path && strpos($path, '/') === false) {
      $slug = $path;
    } else {
      $slug = false;
    }
  }

  if ($slug) {
    $post_match = get_page_by_path($slug, 'OBJECT', $cpt);

    if (!is_admin() && $post_match) {

      // remove any 404 not found error element from the query_vars array because a post match already exists in cpt
      if (isset($query_vars['error']) && $query_vars['error'] == 404) {
        unset($query_vars['error']);
      }

      // remove unnecessary elements from the original query_vars array
      unset($query_vars['pagename']);

      // add necessary elements in the the query_vars array
      $query_vars['post_type'] = $cpt;
      $query_vars['name'] = $slug;
      $query_vars[$cpt] = $slug; // this constructs the "cpt=>post_slug" element
    }
  }

  return $query_vars;
}
add_filter('request', "parse_request_remove_cpt_slug", 1, 1);


/** 
 * remove news_cat from url for example 
 * https://liner.hu/news_cat/hazai/ 
 * to https://liner.hu/hazai/
 */
function build_news_tax_slugs($url, $term, $taxonomy)
{

  // Add the slugs of those taxonomies which you want to remove from url.
  //$options        = get_option( 'rtu_basics' );
  $taxonomy_slugs = array('news_cat' => 'news_cat');
  foreach ($taxonomy_slugs as $taxonomy_slug) {
    if (stripos($url, $taxonomy_slug) === true || $taxonomy == $taxonomy_slug) {
      $url = str_replace('/' . $taxonomy_slug, '', $url);
    }
  }

  return $url;
}
add_filter('term_link', 'build_news_tax_slugs', 10, 3);
/** 
 * remove news_cat from url for example 
 * Helping funtion 
 * 
 */
function remove_news_tax_slugs($query_vars)
{

  // Add the slugs of those taxonomies which you want to remove from url.
  //$options   = get_option( 'rtu_basics' );
  $tax_slugs = array('news_cat' => 'news_cat');

  if (isset($query_vars['attachment']) ? $query_vars['attachment'] : null) :
    $include_children = true;
    $name             = $query_vars['attachment'];
  else :
    if (isset($query_vars['name']) ? $query_vars['name'] : null) {
      $include_children = false;
      $name             = $query_vars['name'];
    }
  endif;
  if (isset($name)) :
    foreach ($tax_slugs as $slug) {
      $term = get_term_by('slug', $name, $slug);
      if ($term && !is_wp_error($term)) :
        if ($include_children) {
          unset($query_vars['attachment']);
          $parent = $term->parent;
          while ($parent) {
            $parent_term = get_term($parent, $slug);
            $name        = $parent_term->slug . '/' . $name;
            $parent      = $parent_term->parent;
          }
        } else {
          unset($query_vars['name']);
        }
        $query_vars[$slug] = $name;
      endif;
    }
  endif;

  return $query_vars;
}
add_filter('request', 'remove_news_tax_slugs', 1, 1);
// Create News Taxonomy
function create_news_taxonomies()
{
  $labels = array(
    'name'              => _x('News Category', 'taxonomy general name'),
    'singular_name'     => _x('Category', 'taxonomy singular name'),
    'search_items'      => __('Search Category'),
    'all_items'         => __('All Category'),
    'parent_item'       => __('Parent Category'),
    'parent_item_colon' => __('Parent Category'),
    'edit_item'         => __('Edit Category'),
    'update_item'       => __('Update Category'),
    'add_new_item'      => __('Add New Category'),
    'new_item_name'     => __('New Category Name'),
    'menu_name'         => __('Categories'),
  );
  $args = array(
    'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
    'labels'            => $labels,
    'show_in_rest'     => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => true,
    // 'rewrite'           => array( 'slug' => 'news_category' ),
  );
  register_taxonomy('news_cat', array('linernews'), $args);
}
add_action('init', 'create_news_taxonomies', 0);

// Create News Tag
function create_news_tag()
{
  $labels = array(
    'name'              => _x('Tags', 'taxonomy general name'),
    'singular_name'     => _x('Tag', 'taxonomy singular name'),
    'search_items'      => __('Search Tags'),
    'all_items'         => __('All Tag'),
    'parent_item'       => __('Parent Tag'),
    'parent_item_colon' => __('Parent Tag'),
    'edit_item'         => __('Edit Tag'),
    'update_item'       => __('Update Tag'),
    'add_new_item'      => __('Add New Tag'),
    'new_item_name'     => __('New Tag Name'),
    'menu_name'         => __('Tags'),
  );
  $args = array(
    'hierarchical'      => false, // Set this to 'false' for non-hierarchical taxonomy (like tags)
    'labels'            => $labels,
    'show_in_rest'     => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array('slug' => 'tema'),
  );
  register_taxonomy('newstag', array('linernews'), $args);
}
add_action('init', 'create_news_tag', 0);

function liner_rewrite_rules()
{
  news_register();

  flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'liner_rewrite_rules');



function sidebar_sticky_post($atts, $content)
{
  if (!is_front_page()) {
    return '';
  }

  extract(shortcode_atts(array(
    'per_page' => '-1',
    'title' => 'Soron kívül',
  ), $atts));

  $shortcode_id = rand(0, 99999);
  $output = '';
  $selectpost = '';
  global $post;

  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 1,
    //'post__in' 				 => array( $selectpost ),
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


  while ($the_query->have_posts()) {
    $the_query->the_post();
    $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'full');
    $author_id = $the_query->post->post_author;
    $custom_author = get_field('news_author', $the_query->post->ID);

    $output .= '<div class="stcky_pst">';
    if ($title) {
      $output .= '<h3><span>' . $title . ' </span></h3>';
    }
    $output .= '<div class="stcky_pstimg"><img src="' . $image_attributes[0] . '" class="img-responsive" alt=""></div><div class="stcky_pstcontent"><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></div></div>';
  }

  // Restore original Post Data
  wp_reset_postdata();
  return $output;
}
add_shortcode('sidebar-sticky', 'sidebar_sticky_post');

/*function section1_shortcode( $atts, $content ) {
    extract(shortcode_atts(array(
		'per_page' => '-1',
        ), $atts));

	$shortcode_id = rand(0,99999);
	$output = '';

	$selectpost = get_field('select_news', $post->ID);
	$the_query = get_post( $selectpost );
	// The Loop
	if( $selectpost ) {


	    $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->ID), 'top-thumb' );
		$author_id= $the_query->post_author;
      	$custom_author = get_field('news_author',$the_query->ID);


		$output.= '<section class="section_1">
         <div class="section1_container auto_float clr">
             <div class="left_1Content">
                  <span><img src="'.$image_attributes[0].'" class="img-responsive" alt=""></span>
             </div>
             <div class="right1_content">
                  <h6><a href="'.get_the_permalink($the_query->ID).'">'.$the_query->post_title.'</a></h6>
                  <p>'.$the_query->post_excerpt.'</p>
                  <ul>
                      <li><a href="'.home_url('/szerzo/').'?a='.$custom_author.'" class="athr_lnk">'.$custom_author.'</a> |</li>
                      <li>'.get_the_date( 'd M', $the_query->ID ).'</li>
                  </ul>
             </div>
         </div>

  </section>';




	}

	// Restore original Post Data
	wp_reset_postdata();
	return $output;
}
add_shortcode( 'section-1', 'section1_shortcode' );*/
/*---VB_2022---*/
function section0_shortcode($atts, $content)
{
  extract(shortcode_atts(array(
    'tag' => '',
  ), $atts));

  $shortcode_id = rand(0, 99999);
  $output = '';
  $tag_ar = explode(',', $tag);

  $i = 1;
  $relpost = array();
  global $postnot;

  $tagterm = get_term_by('slug', $tag, 'newstag');

  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 4,
    'post__not_in'       => $postnot,
    'no_found_rows'      => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'tax_query'        => array(
      array(
        'taxonomy' => 'newstag',
        'field' => 'slug',
        'terms' => $tag_ar,
        'operator' => 'IN'
      )
    )
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) {
    $output .= '<section class="world-cup-section auto_float">
      <div class="d-flex align-items-center justify-content-between world-cup-header">
        <div class="d-flex align-items-center">
        <h3 class="world-cup-title mb-0">
          <svg width="159" height="26" viewBox="0 0 159 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M68.5232 16.2846C67.4134 16.2846 66.939 14.8138 66.939 10.7674C66.939 8.66486 67.9697 8.14161 70.901 8.14161C71.6713 8.14161 72.2862 8.14703 72.8766 8.15652C71.9413 11.0195 70.687 16.2846 68.5246 16.2846M62.5802 13.5246C62.5802 14.5955 62.6824 15.5092 62.8692 16.2846H47.3619C45.3004 16.2846 43.982 15.8101 43.982 13.9177V8.66621H48.8657C49.2652 7.48551 49.527 6.40511 49.6592 5.25287H43.9834C44.0065 3.63295 44.1252 2.18519 44.2451 0.524609C42.3964 1.18071 40.9443 1.94119 39.7541 3.2561V5.25422H37.2441C37.0341 6.67351 37.0341 7.74849 36.9809 8.66757H39.7541V14.1834C39.7541 18.0441 42.106 19.7006 45.3277 19.7006H66.4086C68.9909 19.7006 70.976 17.5941 72.882 12.8306V19.6993H77.1086V5.25422C75.2067 5.09562 73.4615 4.98989 71.5609 4.98989C66.3309 4.98989 62.5775 7.14525 62.5775 13.526M84.7696 11.9237V10.5057C84.7696 8.66621 84.6359 7.08968 84.3742 5.25287H80.2785C80.4108 7.08968 80.543 8.66621 80.543 10.5057V19.6979H84.7696C84.7696 14.5481 86.4329 8.69062 90.8435 9.32367C90.8435 8.40323 90.7113 6.30073 90.4481 4.98853C87.2291 5.26642 85.6517 8.08738 84.7696 11.9223M26.5454 16.2846C25.4356 16.2846 24.9598 14.8138 24.9598 10.7674C24.9598 8.66621 25.9919 8.14161 28.9219 8.14161C29.6922 8.14161 30.3071 8.14703 30.8988 8.15652C29.9621 11.0195 28.7105 16.2846 26.5454 16.2846M20.6024 13.5233C20.6024 17.8841 22.1867 19.9595 24.2999 19.9595C26.8904 19.9595 28.9587 17.6795 30.9056 12.8211V19.6966H35.1322V5.25422C33.2302 5.09562 31.4864 4.98989 29.5831 4.98989C24.3531 4.98989 20.6024 7.14525 20.6024 13.526M158.34 6.82941C158.34 3.2317 155.83 1.05057 151.339 1.05057C148.858 1.05057 147.035 1.57518 145.925 2.1025C145.291 2.99447 145.001 4.02065 144.602 5.64599C146.293 4.98989 147.932 4.46663 150.415 4.46663C152.396 4.46663 153.983 5.30709 153.983 7.61835C153.983 10.1099 152.423 11.9237 143.943 16.8092C143.943 17.3351 143.97 18.3844 144.207 19.6993H158.207C158.605 18.5172 158.868 17.468 159 16.2859H147.084C153.036 14.2607 158.34 12.1473 158.34 6.82941ZM10.6509 15.6637L10.4328 15.5471C7.89955 14.2092 4.48968 12.1623 4.48968 8.43034C4.48968 5.01429 6.71203 3.41199 9.37748 3.41199C12.3374 3.41199 14.133 5.48603 14.133 9.11491C14.133 11.6119 12.7492 13.8147 10.6509 15.6637M18.755 19.9609L11.7975 16.271C15.7364 14.8477 18.6254 12.0416 18.6254 8.06163C18.6254 2.70302 14.5816 0 9.37885 0C4.59876 0 0 3.04463 0 8.92784C0 13.892 3.80389 16.8593 7.97727 19.0405L21.3959 26C21.3959 22.9283 21.0278 21.166 18.755 19.9595M117.66 18.3816C116.474 18.3816 112.772 15.9918 112.772 9.5853C112.772 6.43087 114.624 4.46392 117.66 4.46392C120.698 4.46392 122.549 6.43087 122.549 9.5853C122.549 15.9918 118.851 18.383 117.66 18.383M117.66 1.04786C112.378 1.04786 108.414 4.19958 108.414 9.32231C108.414 16.0189 114.887 19.9595 117.66 19.9595C120.435 19.9595 126.904 16.0189 126.904 9.32231C126.904 4.19823 122.945 1.04786 117.66 1.04786ZM117.719 8.20938C116.809 8.85707 115.995 9.62975 115.303 10.5044C115.996 11.3783 116.809 12.1509 117.719 12.7994C118.628 12.1494 119.442 11.377 120.138 10.5044C119.443 9.63113 118.63 8.85866 117.72 8.20938M141.967 6.82669C141.967 3.22899 139.456 1.04786 134.963 1.04786C132.482 1.04786 130.659 1.57247 129.549 2.09979C128.917 2.99176 128.625 4.01794 128.227 5.64327C129.92 4.98717 131.559 4.46392 134.042 4.46392C136.021 4.46392 137.608 5.30438 137.608 7.61564C137.608 10.1072 136.05 11.921 127.569 16.8065C127.569 17.3324 127.597 18.3816 127.834 19.6966H141.836C142.23 18.5145 142.495 17.4653 142.627 16.2832H130.711C136.665 14.258 141.967 12.1446 141.967 6.82669M106.3 6.82669C106.3 3.22899 103.794 1.04786 99.3034 1.04786C96.8193 1.04786 94.9964 1.57247 93.8894 2.09979C93.254 2.99176 92.9622 4.01794 92.5669 5.64327C94.2575 4.98717 95.8963 4.46392 98.379 4.46392C100.359 4.46392 101.944 5.30438 101.944 7.61564C101.944 10.1072 100.385 11.921 91.907 16.8065C91.907 17.3324 91.9329 18.3816 92.1715 19.6966H106.174C106.569 18.5145 106.832 17.4653 106.963 16.2832H95.0469C100.998 14.258 106.302 12.1446 106.302 6.82669" fill="#EEEEE4"/>
          </svg>          
          </h3>
        </div>
        <a href="' . get_term_link($tagterm->term_id) . '" class="tovabb-btn">
        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.50914 17.7259C8.26502 17.9912 8.14533 18.3346 8.15005 18.678C8.15478 19.0215 8.28235 19.3616 8.53434 19.6204L8.55323 19.64C8.80207 19.8841 9.12021 20.0029 9.43677 19.998C9.75333 19.9931 10.0683 19.8646 10.3109 19.6123C13.0922 16.7379 15.8436 13.8164 18.6076 10.9209C18.6186 10.9127 18.6281 10.9046 18.6375 10.8948C18.8816 10.6295 19.0013 10.2829 18.9966 9.93944C18.9919 9.59601 18.8627 9.25421 18.6108 8.99543L18.5682 8.95311C15.8168 6.09829 13.0686 3.23371 10.3093 0.383771C10.0683 0.13312 9.75333 0.00453906 9.43677 -0.000343749C9.12021 -0.00522656 8.80207 0.113589 8.55323 0.359357L8.52961 0.383771C8.28235 0.640932 8.15478 0.979474 8.15005 1.32127C8.14533 1.66307 8.26502 2.00812 8.50914 2.27342L15.946 9.9671L8.50914 17.7259ZM0.355705 17.4004C0.113165 17.664 -0.00495473 18.0075 -0.00022993 18.3493C0.00449487 18.6927 0.132064 19.0329 0.384054 19.2916L0.402953 19.3112C0.650218 19.5553 0.969929 19.6741 1.28649 19.6709C1.60305 19.666 1.91961 19.5374 2.16058 19.2851C4.88364 16.471 7.69647 13.7041 10.4558 10.9241C10.4668 10.916 10.4778 10.9062 10.4888 10.8965C10.7329 10.6312 10.8526 10.2845 10.8479 9.94106C10.8432 9.59764 10.714 9.25584 10.4621 8.99705C7.70749 6.23826 4.93876 3.48924 2.1779 0.733706L2.159 0.712547C1.91804 0.461896 1.60305 0.334943 1.28649 0.33006C0.969929 0.325177 0.651793 0.443992 0.402953 0.688133L0.379329 0.712547C0.132064 0.969708 0.00449487 1.30988 -0.00022993 1.65005C-0.00495473 1.99184 0.11474 2.3369 0.358855 2.6022L7.78939 9.96548L0.355705 17.4004Z" fill="#EEEEE4"/>
        </svg>        
        </a>
      </div>
      <div class="world-cup-body">
        <div class="row">
    ';

    while ($the_query->have_posts()) {
      $the_query->the_post();

      $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
      $output .= '
        <div class="col-lg-3 world-cup-article">
          <div>
            <img src="' . $image_attributes[0] . '" class="w-100 img-fluid mob-image-world-cup" alt="image">
          </div>
          <h2 class="post-title post-title2 mt-lg-3">
            <a class="title-slug vb2022" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . get_the_title() . '
            </a>
          </h2>
        </div>
      ';
      $postnot[] = $the_query->post->ID;
      $i++;
    }

    $output .= '</div></div>
    <div class="world-cup-end-section"></div>
    </section>';
  }


  return $output;
}
add_shortcode('section-0', 'section0_shortcode');
/*---VB_2022_vége---*/

function section1_shortcode($atts, $content)
{
  //if(!is_front_page()){return '';} // it will help to decrease queries on inner page 
  extract(shortcode_atts(array(
    'per_page' => '-1',
  ), $atts));

  $shortcode_id = rand(0, 99999);
  $output = '';
  $selectpost = '';
  global $post;

  /* if(isset($post)){
		if(isset($post->ID)){
			$selectpost = get_field('select_news', $post->ID);
		}
	} */

  //$selectpost = get_field('select_news', $post->ID);

  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 1,
    //'post__in' 				 => array( $selectpost ),
    'no_found_rows'      => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'meta_query'    => array(
      array(
        'key'   => 'home_top',
        'value' => '1',
      )
    ) /*,
      	'tax_query'         	 => array(
									array(
									  'taxonomy' => 'news_cat',
									  'field' => 'slug',
									  'terms' => array('style','sport'),
									  'operator' =>'Not IN'
									)
								  ) */
  );

  $the_query = new WP_Query($args);
  //$the_query = get_post( $selectpost );
  // The Loop
  //if( $selectpost ) {

  while ($the_query->have_posts()) {
    $the_query->the_post();
    $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
    $author_id = $the_query->post->post_author;
    $custom_author = get_field('news_author', $the_query->post->ID);


    $output .= '<section class="section_1">
         <div class="section1_container auto_float clr">
             <div class="left_1Content">
                  <span><img src="' . $image_attributes[0] . '" class="img-responsive" alt=""></span>
             </div>
             <div class="right1_content">
                  <h6><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></h6>
                  <p>' . $the_query->post->post_excerpt . '</p>
                  <ul>
                      <!--li><a href="' . get_author_posts_url($author_id) . '" class="athr_lnk">' . $custom_author . '</a> |</li-->
                      <li>' . getCategoryByPostId($the_query->post->ID) . '</li>
                      <li>|</li>
                      <li>' . get_the_date('Y. F. d. H:i', $the_query->post->ID) . '</li>
                      
                  </ul>
             </div>
         </div>

  </section>';
  }

  //}

  // Restore original Post Data
  wp_reset_postdata();
  return $output;
}
add_shortcode('section-1', 'section1_shortcode');

function get_latest_news_blocks($postnot_in = 0)
{
  global $postnot;

  //news loop latest 5 news 2 -1-1-1
  $largs = array(
    'post_type'         => 'linernews',
    'post_status'       => 'publish',

    'posts_per_page'     => 1,
    'post__not_in'  => array($postnot_in),
    'tax_query'         => array(
      array(
        'taxonomy' => 'news_cat',
        'field' => 'slug',
        'terms' => array('style'),
        'operator' => 'NOT IN'
      ),
      array(
        'taxonomy' => 'newstag',
        'field' => 'slug',
        'terms' => array('orosz-ukran-haboru-fontosabb-tortenesek', 'orosz-ukran-rovid'),
        'operator' => 'NOT IN'
      )
    )
  );
  $latest_news = new WP_Query($largs);
  $output_latest_news_block_1 = '';
  $output_latest_news_block = [];

  $i = 1;
  while ($latest_news->have_posts()) {
    $latest_news->the_post();
    // 		$output_latest_news_block[$i] = '<label><a href="'.get_the_permalink($latest_news->post->ID).'" class="home_latest_news">'.get_the_title().'</a></label>';

    $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($latest_news->post->ID), 'medium_large');
    $custom_author = get_field('news_author', $latest_news->post->ID);
    $poplr = get_field('most_popular_news', $latest_news->post->ID);
    $brknews = get_field('breaking_news', $latest_news->post->ID);

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


    $output_latest_news_block[$i] = '
        <div class="d-flex">            
            <div style="width: 140px;height: 80px;min-width: 140px;">
                <img class="w-100 h-100" style="object-fit:cover;" src="' . $image_attributes[0] . '">
            </div>            
            <div class="second-article' . $popular . $breaknews . ' d-flex flex-column justify-content-center ml-3" >
                <div>
                    <div class="mt-0 post-tagline">
                        ' . getCategoryByPostId($latest_news->post->ID) . '
                        <span>|</span>					    
                        <span>' . get_the_date('Y. F. d. H:i', $latest_news->post->ID) . '</span>
              
                    </div>
                </div>
                <h2 class="post-title post-title2">
                    <a class="title-slug" href="' . get_the_permalink($latest_news->post->ID) . '">
                    ' . get_the_title() . '
                    </a>
                </h2>
            </div>
        </div>
		<hr>
        ';
    $i++;
    $postnot[] = $latest_news->post->ID;
  }

  return $output_latest_news_block;
}

function get_latest_news_blocks_two($postnot_in = 0)
{
  global $postnot;

  //news loop latest 5 news 2 -1-1-1
  $largs = array(
    'post_type'         => 'linernews',
    'post_status'       => 'publish',
    'offset'            => 1,
    'posts_per_page'     => 2,
    'post__not_in'  => array($postnot_in),
    'tax_query'         => array(
      array(
        'taxonomy' => 'news_cat',
        'field' => 'slug',
        'terms' => array('style'),
        'operator' => 'NOT IN'
      ),
      array(
        'taxonomy' => 'newstag',
        'field' => 'slug',
        'terms' => array('orosz-ukran-haboru-fontosabb-tortenesek', 'orosz-ukran-rovid', 'vb-2022'),
        'operator' => 'NOT IN'
      )
    )
  );
  $latest_news = new WP_Query($largs);
  $output_latest_news_block_1 = '';
  $output_latest_news_block = [];


  $i = 1;
  while ($latest_news->have_posts()) {
    $latest_news->the_post();
    $poplr = get_field('most_popular_news', $latest_news->post->ID);
    $brknews = get_field('breaking_news', $latest_news->post->ID);

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
    $output_latest_news_block[$i] = '
    <div class="col-12 col-md-6 col-lg-6">
      <div class="' . $popular . $breaknews . '">
        <div>
          <div class="mt-0 post-tagline">
            ' . getCategoryByPostId($latest_news->post->ID) . '
            <span>|</span>            
            <span>' . get_the_date('Y. F. d. H:i', $latest_news->post->ID) . '</span>
          </div>
        </div>
        <h2 class="post-title post-title4">
          <a class="title-slug" href="' . get_the_permalink($latest_news->post->ID) . '">' . get_the_title() . '</a>
        </h2>
      </div>
    </div>
    ';

    $i++;
    $postnot[] = $latest_news->post->ID;
  }

  return $output_latest_news_block;
}

function section2_shortcode($atts, $content)
{
  extract(shortcode_atts(array(
    'per_page' => '-1',
  ), $atts));

  $shortcode_id = rand(0, 99999);
  $output = '';
  $type = '';
  global $postnot;
  /* old commented 
	$args = array (
		'post_type'              => 'linernews',
		'post_status'            => 'publish',
		'posts_per_page'         => 1,
   // 'post__not_in'	=> $postnot,
		'no_found_rows' 		 => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
      	'tax_query'         => array(
                    array(
                      'taxonomy' => 'news_cat',
                      'field' => 'slug',
                      'terms' => array('x'),
                      'operator' =>'IN'
					  //'terms' => array('style'),
              //        'operator' =>'NOT IN'
                    )
                  )
	);*/
  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 1,
    'post__not_in'  => $postnot,
    'no_found_rows'      => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'meta_query'    => array(
      array(
        'key'   => 'kiemelt_cikk',
        'value' => '1',
      )
    )
  );

  $the_query = new WP_Query($args);

  //loop for main new on home page only 1 post
  if ($the_query->have_posts()) {


    $output .= '<section class="nc_section2 auto_float">
          <div class="nc_container auto_float">';
    while ($the_query->have_posts()) {
      $the_query->the_post();

      $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
      $author_id = $the_query->post->post_author;
      $custom_author = get_field('news_author', $the_query->post->ID);
      $news_type = get_field('news_type', $the_query->post->ID);



      if ($news_type == 'video') {
        $type = ' type_video';
      } elseif ($news_type == 'slider') {
        $type = ' type_slider';
      } else {
        $type = '';
      }

      $output .= '<div class="row"><div class="col-sm-12 div_nc_left_title"><h2><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></h2></div></div>';
      $output .= '<div class="row"><div class="col-12 col-md-6 col-lg-6"><div class="nc_videoDiv">';
      if (empty($type)) {
        $output .= '<a href="' . get_the_permalink($the_query->post->ID) . '" class="simplenews"><img style="max-height: 360px;object-fit: cover;" src="' . $image_attributes[0] . '"></a>';
      } else {
        $output .= '<img src="' . $image_attributes[0] . '"><a href="' . get_the_permalink($the_query->post->ID) . '" class="btn' . $type . '">Link</a>';
      }


      $output .= '</div><div class="nc_imgContent">
      ' . getCategoryByPostId($the_query->post->ID) . '
					<span>|</span>
					<span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                    <p>' . $the_query->post->post_excerpt . '</p>' .
        '<hr style="margin-inline:0;">';


      //$output .= '2 news will be here';
      $output_latest_news_block = get_latest_news_blocks($the_query->post->ID);
      $output_latest_news_block_two = get_latest_news_blocks_two($the_query->post->ID);
      $output .= '<div class="crp_related crp_related_shortcode ">';
      $output .= $output_latest_news_block[1];
      $output .= '<div class="row">';
      $output .= $output_latest_news_block_two[1];
      $output .= $output_latest_news_block_two[2];
      $output .= '</div>';
      $output .= '</div>';
      $output .= ' </div></div>';
      $postnot[] = $the_query->post->ID;
    }
  }

  // Restore original Post Data
  wp_reset_postdata();




  $ttln = '';

  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 9,
    //'offset'				  => 3,
    'post__not_in'  => $postnot,
    'no_found_rows' => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'tax_query'         => array(
      array(
        'taxonomy' => 'news_cat',
        'field' => 'slug',
        'terms' => array('style'),
        'operator' => 'Not IN'
      ),
      array(
        'taxonomy' => 'newstag',
        'field' => 'slug',
        'terms' => array('orosz-ukran-haboru-fontosabb-tortenesek', 'orosz-ukran-rovid', 'vb-2022'),
        'operator' => 'NOT IN'
      )
    )
  );

  $the_query = new WP_Query($args);
  $z = 1;
  if ($the_query->have_posts()) {

    $output .= '<div class="col-12 col-md-6 col-lg-6"><div class="row">';
    while ($the_query->have_posts()) {
      $the_query->the_post();


      $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
      $custom_author = get_field('news_author', $the_query->post->ID);
      //if(strlen($the_query->post->post_title) > 40){
      //$ttln= substr($the_query->post->post_title, 0, 40) . '...';
      //}else{
      $ttln = $the_query->post->post_title;
      //}
      $poplr = get_field('most_popular_news', $the_query->post->ID);
      $brknews = get_field('breaking_news', $the_query->post->ID);

      if ($poplr == 1) {
        $popular = ' post-background-green mb-2';
      } else {
        $popular = '';
      }

      if ($brknews == 1) {
        $breaknews = ' post-background-yellow mb-2';
        $popular = '';
      } else {
        $breaknews = '';
      }

      if ($z == 1) {
        $output .= '
      <div class="col-12 col-md-7 col-lg-7">
            <div>
                <div>
                  <img class="w-100 mob-image7" src="' . $image_attributes[0] . '">
                </div>
            <div class="article-card-body second-article ' . $popular . $breaknews . '">
              <div>
              <p class="post-tagline">
                ' . getCategoryByPostId($the_query->post->ID) . '
                <span>|</span>
                <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
              </p>
          </div>
          <h2 class="post-title post-title2">
            <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . $ttln . '
            </a>
          </h2>
          <p class="post-description section1-description">
            ' . $the_query->post->post_excerpt . '
          </p>
            </div>
      </div>';
      } elseif ($z <= 5) {
        $output .= '        
            <div class="my-2 row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="article-card-body' . $popular . $breaknews . '">
                    <p class="post-tagline">
                      ' . getCategoryByPostId($the_query->post->ID) . '
                      <span>|</span>
                      <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                    </p>
                    <h2 class="post-title post-title4">
                      <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                      ' . $ttln . '
                      </a>
                    </h2>
                </div>
              </div>
            </div>';
      }
      if ($z == 5) {
        $output .= '</div>
      <div class="col-12 col-md-5 col-lg-5">';
      }

      if ($z > 5 && $z <= 7) {
        $output .= '
              <div class="my-2">
                <div class="article-card-body ' . $popular . $breaknews . '">
                   <div>
                      <p class="post-tagline">
                      ' . getCategoryByPostId($the_query->post->ID) . '
                        <span>|</span>
                        <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                      </p>
                    </div>
                    <h2 class="post-title post-title4">
                      <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                        ' . $ttln . '
                      </a>
                    </h2>
                  </div>
                </div>

              ';
      }

      if ($z > 7) {
        $output .= '
                <div class="my-2">
                  <div>
                    <div>
                      <img class="w-100 mob-image" src="' . wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] . '">
                    </div>
                    <div>
                     <div class="article-card-body ' . $popular . $breaknews . '">
                           <p class="post-tagline">
                        ' . getCategoryByPostId($the_query->post->ID) . '
                          <span>|</span>
                          <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                        </p>
                     
                      <h2 class="post-title post-title4">
                        <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                          ' . $ttln . '
                        </a>
                      </h2> 
                      </div>
                    </div>
                     
                    </div>
                  </div>

                ';
      }

      if ($z == 9) {
        $output .= '</div>';
      }
      $postnot[] = $the_query->post->ID;
      $z++;
    }

    $output .= '</div></div></div></div></section>';
  }

  // Restore original Post Data
  wp_reset_postdata();
  return $output;
}
add_shortcode('section-2', 'section2_shortcode');


function section3_shortcode($atts, $content)
{
  //echo"hi";
  extract(shortcode_atts(array(
    'tag' => '',
  ), $atts));

  $shortcode_id = rand(0, 99999);
  $output = '';
  $i = 1;
  global $postnot;
  $livetextPage = get_permalink(get_page_by_title('orosz ukran haboru elo kozvetites'));

  $args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 8,
    // 'post__not_in'       => $postnot,
    'no_found_rows'      => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'tax_query'        => array(
      array(
        'taxonomy' => 'newstag',
        'field' => 'slug',
        'terms' => array('orosz-ukran-haboru-fontosabb-tortenesek'),
        'operator' => 'IN'
      )
    )
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    $output .= '
    <section class="uk-war-section auto_float">    
      <a href="' . $livetextPage . '" class="d-flex align-items-center uk-war-title">
        <span style="width: 0.75rem;height: 0.75rem;position: relative;margin-right: 0.75rem;" class="relative w-3 h-3 mr-3 live_icon"></span> 
        OROSZ-UKRÁN HÁBORÚ
      </a>
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
    ';

    while ($the_query->have_posts()) : $the_query->the_post();
      $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
      if ($i <= 2) {
        $output .= '<div class="col-lg-6">
          <img class="w-100 img-fluid mob-image9" src="' . $image_attributes[0] . '">
          <div>
            <p class="post-tagline">
            ';
        if ($i == 1) {
          $output .= '<span class="live-badge">ÉLŐ</span>';
        }
        $output .= '' . getCategoryByPostId($the_query->post->ID) . '
              <span>|</span>
              <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
            </p>
            <h2 class="post-title post-title2">';
        if ($i == 1) {
          $output .= '<a class="title-slug" href="' . $livetextPage . '">';
        } else {
          $output .= '<a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">';
        }
        $output .= '' . get_the_title() . '
              </a>
            </h2>
          </div>
        </div>';
      }
      if ($i == 2) {
        $output .= '</div></div><div class="col-lg-6"><div class="row"><div class="col-lg-6">';
      }
      if ($i > 2 && $i <= 5) {
        $output .= '<div class="border-dashed-parent">
        <div class="border-dashed-bottom">
          <p class="post-tagline">' . getCategoryByPostId($the_query->post->ID) . '
            <span>|</span>
            <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
          </p>
          <h2 class="post-title post-title2">
            <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . get_the_title() . '
            </a>
          </h2>
        </div>
        </div>';
      }
      if ($i == 5) {
        $output .= '</div><div class="col-lg-6">';
      }
      if ($i > 5 && $i <= 8) {
        $output .= '<div class="border-dashed-parent">
        <div class="border-dashed-bottom">
          <p class="post-tagline">' . getCategoryByPostId($the_query->post->ID) . '
            <span>|</span>
            <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
          </p>
          <h2 class="post-title post-title2">
            <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . get_the_title() . '
            </a>
          </h2>
        </div>
        </div>';
      }
      if ($i == 8) {
        $output .= '</div></div></div>';
      }
      ?>

    <?php $postnot[] = $the_query->post->ID;
          $i++;
        endwhile;
        $output .= '</div></section>';
      endif;

      // Restore original Post Data
      wp_reset_postdata();
      $tag_ar = explode(',', $tag);

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 4,
        'post__not_in'       => $postnot,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        /*'date_query'             => array(
                                        array(
                                          'after' => '24 hours ago',
                                          ),
                                    ),*/
        'tax_query'         => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          ),
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('orosz-ukran-rovid'),
            'operator' => 'NOT IN'
          )
        )
      );

      $ttln = '';
      $popular = '';
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        /*wp_enqueue_style( 'owl-theme-style', get_template_directory_uri() .'/css/owl.theme.css', array(), '', false );
	wp_enqueue_style( 'owl-carousel-style', get_template_directory_uri() .'/css/owl.carousel.css', array(), '', false );
	wp_enqueue_script( 'owl-carousel-script', get_template_directory_uri() .'/js/owl.carousel.js', array(), '', true );*/


        $output .= '<section class="hometyle_mainSection"><div class="tyle_container auto_float"><div class="row">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          $author_id = $the_query->post_author;
          $custom_author = get_field('news_author', $the_query->post->ID);

          $poplr = get_field('most_popular_news', $the_query->post->ID);
          $brknews = get_field('breaking_news', $the_query->post->ID);

          if ($poplr == 1) {
            $popular = ' post-background-green mb-3';
          } else {
            $popular = '';
          }

          if ($brknews == 1) {
            $breaknews = ' post-background-yellow mb-3';
            $popular = '';
          } else {
            $breaknews = '';
          }

          //if(strlen($the_query->post->post_title) > 52){
          //$ttln= substr($the_query->post->post_title, 0, 52) . '...';
          //}else{
          $ttln = $the_query->post->post_title;
          //}
          $trm_str = array();
          $newsterm = get_the_terms($the_query->post->ID, 'news_cat');

          foreach ($newsterm as $nwstrm) {
            $trm_link = get_category_link($nwstrm->term_id);
            $trm_str[] = ['link' => '<a href="' . $trm_link . '" class="trmLnk">' . $nwstrm->name . '</a>'];
          }
          $terms_string = join(', ', wp_list_pluck($trm_str, 'link'));

          $output .= '
                <div class="col-12 col-lg-3">
                  <div class="h-100">

                    <div>
                      <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
                    </div>
                    <div class="' . $popular . $breaknews . '">
                      <div>
                        <p class="post-tagline">
                          ' . getCategoryByPostId($the_query->post->ID) . '
                          <span>|</span>
                          <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                        </p>
                      </div>
                      <h2 class="post-title post-title2">
                        <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                        ' . $ttln . '
                        </a>
                      </h2>
                      <p class="post-description section1-description">
                      ' . $the_query->post->post_excerpt . '
                      </p>
                    </div>
                  </div>

                </div>
          ';
          $postnot[] = $the_query->post->ID;
        }
        $output .= '</div></div></section>';
      } else {
        $output .= '<h2 style="text-align:center; font-size:16px;margin:bottom:35px;">no post found in last 24 hrs</h2>';
      }

      /*
if( $the_query->have_posts() ) {
		$output .= '<script>
			jQuery(function($){
			  $("#type-'.$shortcode_id.'").owlCarousel({
					loop:false,
					items:3,
					margin:28,
					nav:false,
					dots:false,
					smartSpeed:800,
					autoplay:false,
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
						},
						400:{
							items:2,
						},
						580:{
							items:2,
						},
						1120:{
							items:3,
						}
					}
			  });
			})
			</script>';
	}
*/
      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-3', 'section3_shortcode');

    function section4_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';




      $tag_ar = explode(',', $tag);
      $i = 1;
      $relpost = array();
      global $postnot;

      $tagterm = get_term_by('slug', $tag, 'newstag');

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 3,
        'post__not_in'       => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => $tag_ar,
            'terms' => array('koronavirus'),
            'operator' => 'IN'
          )
        )
      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
        $output .= '<section class="korona-section auto_float">
          <div class="d-flex align-items-center justify-content-between korona-header">
            <div class="d-flex align-items-center">
              <img src="' . get_template_directory_uri() . '/images/koronavirus_ikon.png" alt="" style="width:30px;height:30px; object-fit:cover;" class="mr-3">
              <h3 class="korona-title mb-0">Koronavírus</h3>
            </div>
            <a href="' . get_term_link($tagterm->term_id) . '" class="tovabb-btn">
              Tovább
              <i class="fa fa-chevron-right"></i>
            </a>
          </div>
          <div class="korona-body">
            <div class="row">
        ';

        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          $output .= '
            <div class="col-md-4">
              <div>
                <p class="post-tagline">
                  ' . getCategoryByPostId($the_query->post->ID) . '
                  <span>|</span>
                  <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                </p>
              </div>
              <h2 class="post-title post-title2">
                <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                  ' . get_the_title() . '
                </a>
              </h2>
            </div>
          ';
          $postnot[] = $the_query->post->ID;
          $i++;
        }

        $output .= '</div></div></section>';
      }


      return $output;
    }
    add_shortcode('section-4', 'section4_shortcode');

    function section5_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 17,
        'post__not_in'       => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        //'date_query'             => array(
        //                  array(
        //                                'before' => '24 hours ago',
        //                              ),
        //                      ),
        'tax_query'         => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          ),
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('orosz-ukran-rovid'),
            'operator' => 'NOT IN'
          )
        )
      );

      $the_query = new WP_Query($args);

      $i = 1;
      $popular = '';

      if ($the_query->have_posts()) {

        $output .= '<section class="aguse_mainSection auto_float section-5"><div class="row">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

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

          $ttln = '';
          $newscont = '';
          $custom_author = get_field('news_author', $the_query->post->ID);

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');

          $ttln = $the_query->post->post_title;

          $newscont = $the_query->post->post_excerpt;

          if ($i == 1) {
            $output .= '
              <div class="col-lg-3 wider-section">
                <div class="article-card">
                  <img src="' . $image_attributes[0] . '" alt="' . $ttln . '" class="article-img mob-image2">
                  <div class="article-card-body ' . $popular . $breaknews . '">
                    <div>
                      <p class="post-tagline">
                        ' . getCategoryByPostId($the_query->post->ID) . '
                        <span>|</span>
                        <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                      </p>
                    </div>
                    <h2 class="post-title post-title3">
                      <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                        ' . get_the_title() . '
                      </a>
                    </h2>
                    <p class="post-description section1-description">
                      ' . $the_query->post->post_excerpt . '
                    </p>
                  </div>
                </div>
              ';
          }
          if ($i > 1 && $i <= 6) {
            $output .= '
              <div class="article-card">
                <div class="article-card-body ' . $popular . $breaknews . '">
                  <div>
                    <p class="post-tagline">
                      ' . getCategoryByPostId($the_query->post->ID) . '
                      <span>|</span>
                      <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                    </p>
                  </div>
                  <h2 class="post-title post-title2">
                    <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                      ' . get_the_title() . '
                    </a>
                  </h2>
                </div>
              </div>
            ';
          }
          if ($i == 6) {
            $output .= '</div>';
          }
          if ($i == 7) {
            $output .= '<div class="col-lg-6 bigger-section">
            <div class="article-card">
              <img src="' . wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] . '" alt="' . $ttln . '" class="article-img mob-image8">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title3">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
                <p class="post-description section1-description">
                  ' . $the_query->post->post_excerpt . '
                </p>
              </div>
            </div>
            ';
          }

          if ($i > 7 && $i <= 11) {
            $output .= '
            <div class="article-card">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title2">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
              </div>
            </div>
          ';
          }

          if ($i == 11) {
            $output .= '</div>';
          }
          if ($i == 12) {
            $output .= '<div class="col-lg-3 wider-section">
            <div class="article-card">
              <img src="' . $image_attributes[0] . '" alt="' . $ttln . '" class="article-img mob-image2">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title3">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
              </div>
            </div>
            ';
          }
          if ($i > 12 && $i <= 17) {
            $output .= '
            <div class="article-card">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title2">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
              </div>
            </div>
          ';
          }
          if ($i == 17) {
            $output .= '</div>';
          }

          $postnot[] = $the_query->post->ID;
          $i++;
        }
        $output .= '</div></section>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-5', 'section5_shortcode');
    function section6_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;

      // $args = array(
      //   'post_type'              => 'linernews',
      //   'post_status'            => 'publish',
      //   'posts_per_page'         => 12,
      //   'post__not_in'       => $postnot,
      //   'no_found_rows'      => true,
      //   'update_post_meta_cache' => false,
      //   'update_post_term_cache' => false,
      //   //'date_query'             => array(
      //   //                  array(
      //   //                                'before' => '24 hours ago',
      //   //                              ),
      //   //                      ),
      //   'tax_query'         => array(
      //     array(
      //       'taxonomy' => 'news_cat',
      //       'field' => 'slug',
      //       'terms' => array('style'),
      //       'operator' => 'Not IN'
      //     )
      //   )
      // );

      // $the_query = new WP_Query($args);

      $i = 1;
      $popular = '';

      // if ($the_query->have_posts()) {

      //   $output .= '<section class="aguse_mainSection auto_float"><div class="aguse_container auto_float"><div class="row"><div class="col-12 col-md-9 col-lg-9">';
      //   while ($the_query->have_posts()) {
      //     $the_query->the_post();

      //     $poplr = get_field('most_popular_news', $the_query->post->ID);
      //     $brknews = get_field('breaking_news', $the_query->post->ID);

      //     if ($poplr == 1) {
      //       $popular = ' post-background-green';
      //     } else {
      //       $popular = '';
      //     }

      //     if ($brknews == 1) {
      //       $breaknews = ' post-background-yellow';
      //       $popular = '';
      //     } else {
      //       $breaknews = '';
      //     }

      //     $custom_author = get_field('news_author', $the_query->post->ID);
      //     $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'full');

      //     $ttln = $the_query->post->post_title;


      //     $newscont = $the_query->post->post_excerpt;


      //     if ($i === 1) {
      //       $output .=
      //         '<div class="mb-3 row">
      //     <div class="col-12 col-md-4 col-lg-4">
      //         <div>
      //         <p class="post-tagline">
      //         ' . getCategoryByPostId($the_query->post->ID) . '
      //           <span>|</span>
      //           <span>' . get_post_time('H:i') .  '</span>
      //         </p>
      //         </div>
      //         <h2 class="post-title post-title2">
      //           <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></h2>
      //         <p class="post-description section1-description">' . $newscont . '</p>
      //     </div>
      //     <div class="col-12 col-md-8 col-lg-8" style="padding-left:0;">
      //         <div>
      //             <img class="w-100" src="' . $image_attributes[0] . '">
      //         </div>
      //     </div>
      // </div>';
      //     }

      //     if ($i === 2) {
      //       $output .= '<div class="row">';
      //     }

      //     if ($i > 1 && $i < 5) {
      //       $output .= '
      //   <div class="col-12 col-md-4">
      //     <div class="h-100">
      //       <div>
      //         <img class="w-100" src="' . $image_attributes[0] . '">
      //       </div>
      //   <div class="px-2 ' . $popular . $breaknews . '">
      //     <p class="post-tagline">
      //     ' . getCategoryByPostId($the_query->post->ID) . '
      //       <span>|</span>
      //       <span>' . get_post_time('H:i') .  '</span>
      //     </p>

      //   <h2 class="post-title post-title2">
      //       <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></h2>
      //       <p class="post-description section1-description">' . $newscont . '</p>
      //       </div> 
      //     </div>
      //   </div>
      //   ';
      //     }
      //     if ($i == 4) {
      //       $output .= '</div></div><div class="col-12 col-lg-3">';
      //     }

      //     if ($i > 4 && $i < 13) {
      //       $output .= '
      //   <div class="mb-3 row ' . $popular . $breaknews . '">
      //     <div class="col-12 col-md-12 col-lg-12">
      //         <div>
      //         <p class="post-tagline">
      //         ' . getCategoryByPostId($the_query->post->ID) . '
      //           <span>|</span>
      //           <span>' . get_post_time('H:i') .  '</span>
      //         </p>
      //         </div>
      //         <h2 class="post-title post-title2">
      //           <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></h2>
      //     </div>
      //   </div>
      //   ';
      //     }

      //     if ($i == 12) {
      //       $output .= '</div>';
      //     }

      //     $postnot[] = $the_query->post->ID;
      //     $i++;
      //   }
      //   $output .= '</div></div></section>';
      // }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-6', 'section6_shortcode');

    function egy_section_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $tag_ar = explode(',', $tag);
      global $postnot;


      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'post__not_in'           => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('epic'),
            'operator' => 'IN'
          ),
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        // get epic category link
        $epic_cat_link = get_term_link('epic', 'news_cat');
        $output .= ' <section class="egy-header position-relative auto_float">
        <a href="' . $epic_cat_link . '" target="_blank"><h2 class="egy-header-title text-uppercase">EPIC</h2></a>';
        while ($the_query->have_posts()) {
          $the_query->the_post();
          $postnot[] = $the_query->post->ID;
          $output .= '
          <div class="text-center egy-header-body">
            <h2 class="post-title post-title1">
              <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a>
            </h2>
            <p class="egy-header-description mb-0">
              ' . $the_query->post->post_excerpt . '
            </p>
          </div>
          ';
        }
        $output .= '<span class="egy-end-section"></span></section>';
      }
      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('egy_section', 'egy_section_shortcode');

    function fekete_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $tag_ar = explode(',', $tag);
      global $postnot;


      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 8,
        'post__not_in'           => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          ),
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('orosz-ukran-rovid'),
            'operator' => 'NOT IN'
          )
        )
      );

      $the_query = new WP_Query($args);
      $last = '';
      $custom_author = get_field('news_author', $the_query->post->ID);
      $i = 1;

      if ($the_query->have_posts()) {

        $output .= '<section class="aguse_mainSection auto_float"><div class="aguse_container auto_float"><div class="row">';
        while ($the_query->have_posts()) {
          $the_query->the_post();
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
          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');


          $output .=  '
            <div class="mb-4 col-12 col-lg-3 d-flex flex-column justify-content-between">
              <div class="h-100" style="padding:0 !important;">
                <div>
                  <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
                </div>
               <div class=" ' . $popular . $breaknews . '">
               <div>
               <p class="post-tagline">
               ' . getCategoryByPostId($the_query->post->ID) . '
                 <span>|</span>
                 <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
               </p>
             </div>
             <h2 class="post-title post-title2">
             <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
               ' . $the_query->post->post_title . '
             </a></h2>
             <p class="post-description section1-description">
               ' . $the_query->post->post_excerpt . '
             </p> 
               </div>
                  </div>
                </div>
            ';

          $postnot[] = $the_query->post->ID;
          $i++;
        }
        $output .= '</div></div></section>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('fekete_news', 'fekete_shortcode');


    function array_sort($array, $on, $order = SORT_ASC)
    {
      $new_array = array();
      $sortable_array = array();

      if (count($array) > 0) {
        foreach ($array as $k => $v) {
          if (is_array($v)) {
            foreach ($v as $k2 => $v2) {
              if ($k2 == $on) {
                $sortable_array[$k] = $v2;
              }
            }
          } else {
            $sortable_array[$k] = $v;
          }
        }

        switch ($order) {
          case SORT_ASC:
            asort($sortable_array);
            break;
          case SORT_DESC:
            arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
          $new_array[$k] = $array[$k];
        }
      }

      return $new_array;
    }

    function getCategoryByPostId($id)
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
    function mosttag_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;

      $i = 1;

      // $args = array(
      //   'post_type'              => 'linernews',
      //   'post_status'            => 'publish',
      //   'posts_per_page'         => 1,
      //   // not in
      //   // 'post__not_in'           => $postnot,
      //   'no_found_rows'      => true,
      //   'update_post_meta_cache' => false,
      //   'update_post_term_cache' => false,
      //   'tax_query'              => array(
      //     array(
      //       'taxonomy' => 'newstag',
      //       'field' => 'slug',
      //       'terms' => array('longform'),
      //     )
      //   )
      // );


      // $main = array();
      // $tagpost = array();
      // $terms = get_terms(array('taxonomy' => 'newstag', 'hide_empty' => true,));
      // foreach ($terms as $term) {
      //   $main[] = $term->term_id;
      // }

      // $the_query = new WP_Query($args);

      // if ($the_query->have_posts()) {
      //   while ($the_query->have_posts()) {
      //     $the_query->the_post();
      //     $term_obj_list = array();
      //     $tagpost = array();
      //     $result = array();

      //     $term_obj_list = get_the_terms($the_query->post->ID, 'newstag');

      //     if (!empty($term_obj_list) && is_array($term_obj_list)) {
      //       foreach ($term_obj_list as $tag) {
      //         $tagpost[] = $tag->term_id;
      //       }
      //     }

      //     if (!empty($main) && !empty($tagpost)) {
      //       $result = array_intersect($main, $tagpost);
      //     }
      //     $tagcount = count($result);
      //     //die;
      //     if ($tagcount > 0) {
      //       $postidarr[$i]['id'] = $the_query->post->ID;
      //       $postidarr[$i]['count'] = $tagcount;
      //     }
      //     unset($tagpost);
      //     $i++;
      //   }
      // }


      // wp_reset_postdata();


      // $final = array_sort($postidarr, 'count', SORT_DESC);
      // $postid = array();
      // $k = 1;
      // foreach ($final as $value) {
      //   if ($k < 5) {
      //     $postid[] = $value['id'];
      //   }
      //   $k++;
      // }


      $j = 1;
      $jarr = array();
      $firstpost = '';

      $fargs = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        //'post__in'               => $postid,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'              => array(
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('longform'),
          )
        )
      );

      $final_query = new WP_Query($fargs);

      if ($final_query->have_posts()) {
        $longform_cat_link = get_term_link('longform', 'newstag');
        $output .= '

        <a href="' . $longform_cat_link . '" target="_blank" class="d-block mb-4"><h3 class="mb-0 text-uppercase olvas-title" style="line-height:1;">OLVASMáNYOS</h3></a
        ';
        while ($final_query->have_posts()) {
          $final_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($final_query->post->ID), 'medium_large');
          // $custom_author = get_field('news_author', $the_query->post->ID);

          $firstpost = '<h1><a href="' . get_the_permalink($final_query->post->ID) . '">' . $final_query->post->post_title . '</a></h1><p class="lacus_pTxt">' . $final_query->post->post_excerpt . '</p>';
          // old version OLVASMÁNYOS
          //       $output .= '<section class="full desktop-only">
          //   <div class="flex immersive-break" style="background-color: rgb(188, 186, 179);">
          //     <div class="container flex column-horizontal-pad center">
          //         <div class="flex full">
          //             <div class="flex half flex-responsive">
          //                 <div class="flex mb-0 full">
          //                     <h3 class="mb-0 overtitle d-flex">' . getCategoryByPostId($the_query->post->ID) . '</h3>
          //                 </div>
          //                 <h2 class="mb-4 full">
          //                 <a href="' . get_the_permalink($final_query->post->ID) . '" class="tag-slug">
          //                 ' . $final_query->post->post_title . '
          //                 </a>
          //                 </h2>
          //                 <h5 class="flex full article-meta">
          //                   ' . $custom_author . '
          //                 </h5>                  
          //             </div>
          //             <div class="reading-line"></div>
          //         </div>
          //     </div>
          //     <div class="immersive-fade desktop-only"
          //         style="background: linear-gradient(to right, rgba(188, 186, 179, 0) 0%, rgb(54 54 54) 50%, rgba(188, 186, 179, 0) 100%);">
          //     </div>
          //     <div class="dark-fade"></div>
          //     <div class="blurred-image"><img          
          //             src="' . $image_attributes[0] . '"
          //             alt=""></div>
          //     <div class="main-image"><img
          //     src="' . $image_attributes[0] . '"
          //             alt=""></div>
          //   </div>
          // </section>';
          // $term = get_the_terms($final_query->post->ID, 'newstag');
          $catterm = get_term_by('slug', 'longform', 'newstag');

          $link = get_term_link($catterm->term_id);
          // $output.= $catPermalink;
          $output .= '
          <section class="full desktop-only">
            <div class="immersive-break-2 d-lg-flex align-items-center">
              <div class="w-50 h-100 image-part">
                <img src="' . $image_attributes[0] . '" alt="" style="width:100%;height:100%;object-fit:cover;">
              </div>
              <div class="w-50 p-5 text-part">
                <h1 class="mb-4 post-title" style="font-size:32px;">
                  <a href="' . get_the_permalink($final_query->post->ID) . '" class="title-slug">
                    ' . $final_query->post->post_title . '
                  </a>
                </h1>
                <p class="post-description text-white">' . $final_query->post->post_excerpt . '</p>
                <a href="' . $link . '" class="tovabb-btn-2">Tovább</a>
              </div>
            </div>
          </section>
          ';


          $j++;
        }
      }

      // $output .= '<section class="lacus_mainSection auto_float clr"><div class="laus_container auto_float" style="background-image: url(' . $image_attributes[0] . ')">' . $firstpost . '<div class="lacus_row auto_float"><div class="row">' . join('', $jarr) . '</div></div></div></section>';



      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }



    add_shortcode('cover_news', 'mosttag_shortcode');

    function section9_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 22,
        // 'offset'                 => 5,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'post__not_in'       => $postnot,
        //    'date_query'             => array(
        //                                  array(
        //                                  'before' => '24 hours ago',
        //                                ),
        //                        ),
        'tax_query'         => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style', 'sport'),
            'operator' => 'Not IN'
          ),
          array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('orosz-ukran-rovid'),
            'operator' => 'NOT IN'
          )
        )
      );

      $the_query = new WP_Query($args);
      $i = 1;

      if ($the_query->have_posts()) {

        $output .= '<section class="porta_section auto_float"><div class="row">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

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

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          $ttln = $the_query->post->post_title;
          $newscont = $the_query->post->post_excerpt;

          if ($i == 1) {
            $output .= '
              <div class="col-lg-5 bigger-section">
                <div class="article-card">
                  <img src="' . $image_attributes[0] . '" alt="' . $ttln . '" class="article-img mob-image4">
                  <div class="article-card-body ' . $popular . $breaknews . '">
                    <div>
                      <p class="post-tagline">
                        ' . getCategoryByPostId($the_query->post->ID) . '
                        <span>|</span>
                        <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                      </p>
                    </div>
                    <h2 class="post-title post-title3">
                      <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                        ' . get_the_title() . '
                      </a>
                    </h2>
                    <p class="post-description section1-description">
                      ' . $the_query->post->post_excerpt . '
                    </p>
                  </div>
                </div>
              ';
          }
          if ($i > 1 && $i <= 6) {
            $output .= '
              <div class="article-card">
                <div class="article-card-body ' . $popular . $breaknews . '">
                  <div>
                    <p class="post-tagline">
                      ' . getCategoryByPostId($the_query->post->ID) . '
                      <span>|</span>
                      <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                    </p>
                  </div>
                  <h2 class="post-title post-title2">
                    <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                      ' . get_the_title() . '
                    </a>
                  </h2>
                </div>
              </div>
            ';
          }
          if ($i == 6) {
            $output .= '</div>';
          }
          if ($i == 7) {
            $output .= '<div class="col-lg-3 wider-section">';
          }

          if ($i > 6 && $i <= 16) {
            $output .= '
            <div class="article-card">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title2">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
              </div>
            </div>
          ';
          }

          if ($i == 16) {
            $output .= '</div>';
          }

          if ($i == 17) {
            $output .= '<div class="col-lg-4 wider-section">
            <div class="article-card">
            <img src="' . wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large')[0] . '" alt="' . $ttln . '" class="article-img mob-image2">
            <div class="article-card-body ' . $popular . $breaknews . '">
              <div>
                <p class="post-tagline">
                  ' . getCategoryByPostId($the_query->post->ID) . '
                  <span>|</span>
                  <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                </p>
              </div>
              <h2 class="post-title post-title3">
                <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                  ' . get_the_title() . '
                </a>
              </h2>
              <p class="post-description section1-description">
                ' . $the_query->post->post_excerpt . '
              </p>
            </div>
          </div>
            ';
          }

          if ($i > 17 && $i <= 22) {
            $output .= '
            <div class="article-card">
              <div class="article-card-body ' . $popular . $breaknews . '">
                <div>
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                </div>
                <h2 class="post-title post-title2">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                  </a>
                </h2>
              </div>
            </div>
          ';
          }

          if ($i == 22) {
            $output .= '</div>';
          }

          $postnot[] = $the_query->post->ID;
          $i++;
        }

        $output .= '</div></section>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-9', 'section9_shortcode');

    function section10_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $tag_ar = explode(',', $tag);
      global $postnot;


      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'post__not_in'           => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('Kisokos'),
            'operator' => 'IN'
          ),
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $kisokos_cat_link = get_term_link('Kisokos', 'news_cat');
        $output .= ' <section class="egy-header position-relative auto_float">
        <a href="' . $kisokos_cat_link . '" target="_blank"><h2 class="egy-header-title text-uppercase">Kisokos</h2></a>
        ';
        while ($the_query->have_posts()) {
          $the_query->the_post();
          $postnot[] = $the_query->post->ID;
          $output .= '
          <div class="text-center egy-header-body">
            <h2 class="post-title post-title1">
              <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a>
            </h2>
            <p class="egy-header-description mb-0">
              ' . $the_query->post->post_excerpt . '
            </p>
          </div>
          ';
        }
        $output .= '<span class="egy-end-section"></span></section>';
      }
      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-10', 'section10_shortcode');

    function section_kult_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $tag_ar = explode(',', $tag);
      global $postnot;


      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 4,
        'post__not_in'           => $postnot,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('kultura'),
            'operator' => 'IN'
          ),
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $kultura_cat_link = get_term_link('kultura', 'news_cat');
        $output .= ' <section class="position-relative auto_float">
        
        <a href="' . $kultura_cat_link . '" target="_blank"><h2 class="egy-header-title single text-uppercase">Kult</h2></a>
        <div class="row">
        ';
        while ($the_query->have_posts()) {
          $the_query->the_post();
          $postnot[] = $the_query->post->ID;
          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
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
          $output .=  '
            <div class="mb-4 col-12 col-lg-3 d-flex flex-column justify-content-between">
              <div class="h-100" style="padding:0 !important;">
                <div>
                  <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
                </div>
               <div class=" ' . $popular . $breaknews . '">
               <div>
               <p class="post-tagline">
               ' . getCategoryByPostId($the_query->post->ID) . '
                 <span>|</span>
                 <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
               </p>
             </div>
             <h2 class="post-title post-title2">
             <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
               ' . $the_query->post->post_title . '
             </a></h2>
             <p class="post-description section1-description">
               ' . $the_query->post->post_excerpt . '
             </p> 
               </div>
                  </div>
                </div>
            ';
        }
        $output .= '</div></section>';
      }
      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-kult', 'section_kult_shortcode');

    function section_sportnews_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '-1',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;

      $i = 1;

      $output .= '<div class="">';
      $args = array(
        'post_type'        => 'linernews',
        'post_status'      => 'publish',
        'posts_per_page'   => 10,
        'no_found_rows'      => true,
        'post__not_in'     => $postnot,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'news_cat',
            'field'    => 'slug',
            'terms'    => 'sport'
          )
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $sport_cat_link = get_term_link('sport', 'news_cat');
        $output .= '<div class="">
          
        
        <a href="' . $sport_cat_link . '" target="_blank"><h2 class="egy-header-title single text-uppercase">Sport</h2></a>
          <div class="row">
          <div class="col-12 col-lg-6">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $custom_author = get_field('news_author', $the_query->post->ID);
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

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          if ($i == 1) {
            $output .= '<div class="">
            <div style="padding:0 !important;">
                <div>
                  <img class="w-100 mob-image5" src="' . $image_attributes[0] . '">
                </div>
            <div class=" ' . $popular . $breaknews . '">
            <div>
            <p class="post-tagline">
            ' . getCategoryByPostId($the_query->post->ID) . '
              <span>|</span>
              <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
            </p>
        </div>
        <h2 class="post-title post-title2">
          <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
          ' . get_the_title() . '
          </a>
        </h2>
        <p class="post-description section1-description">
          ' . $the_query->post->post_excerpt . '
        </p>   
            </div>            
      </div></div><hr>';
          }
          if ($i == 2) {
            $output .= '
            <div class="d-flex">            
            <div style="width: 150px;height: 80px;min-width: 150px;">
                <img class="w-100 h-100" style="object-fit:cover;" src="' . $image_attributes[0] . '">
            </div>            
            <div class="' . $popular . $breaknews . ' d-flex flex-column justify-content-center ml-3" >
                <div>
                    <div class="mt-0 post-tagline">
                        ' . getCategoryByPostId($the_query->post->ID) . '
                        <span>|</span>
					    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                    </div>
                </div>
                <h2 class="post-title post-title2">
                    <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                    ' . get_the_title() . '
                    </a>
                </h2>
            </div>
        </div>
    
    </div><div class="col-12 col-lg-6"><div class="row">';
          }
          if ($i == 3) {
            $output .= '<div class="col-12 col-lg-6">
                <div>
                  <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
                </div>
                  <div class="article-card-body' . $breaknews . $popular . '">
                    <div>
                      <p class="post-tagline">
                      ' . getCategoryByPostId($the_query->post->ID) . '
                        <span>|</span>
                        <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                      </p>
                    </div>
                    <h2 class="post-title post-title2">
                      <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                      ' . get_the_title() . '
                      </a>
                    </h2>
                    <p class="post-description section1-description">
                      ' . $the_query->post->post_excerpt . '
                    </p>
                  </div>
      ';
          }

          if ($i > 3 && $i < 7) {
            $output .= '
          <div class="col-12 col-md-12 col-lg-12 article-card-body ' . $popular . $breaknews . '">
            <div>
              <p class="post-tagline">
              ' . getCategoryByPostId($the_query->post->ID) . '
                <span>|</span>
                <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
              </p>
            </div>
            <h2 class="post-title post-title2">
              <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . get_the_title() . '
              </a>
            </h2>
          </div>
          ';
          }
          if ($i == 6) {
            $output .= '</div>';
          }

          if ($i == 7) {
            $output .= '<div class="col-12 col-lg-6 ">
            <div class="article-card-body ' . $breaknews . $popular . '">
              <div>
              <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
              </div>
              <div>
              <p class="post-tagline">
              ' . getCategoryByPostId($the_query->post->ID) . '
              <span>|</span>
              <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
              </p>
              </div>
              <h2 class="post-title post-title2">
              <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
              ' . get_the_title() . '
              </a>
              </h2>
              <p class="post-description section1-description">
              ' . $the_query->post->post_excerpt . '
              </p>
            </div>
        
      ';
          }

          if ($i > 7 && $i < 11) {
            $output .= '
        <div class="px-2 mb-2 col-12 col-md-12 col-lg-12 article-card-body' . $popular . $breaknews . '">
          <div>
            <p class="post-tagline">
            ' . getCategoryByPostId($the_query->post->ID) . '
              <span>|</span>
              <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
            </p>
          </div>
          <h2 class="post-title post-title2">
            <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
            ' . get_the_title() . '
            </a>
          </h2>
        </div>
        ';
          }

          if ($i == 10) {
            $output .= '</div>
        </div>
        </div>
        </div>
        </div>
        </div>';
          }
          $postnot[] = $the_query->post->ID;
          $i++;
        }
      }

      // Restore original Post Data
      wp_reset_postdata();

      return $output;
    }
    add_shortcode('section-sportnews', 'section_sportnews_shortcode');

    function section_stylenews_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '-1',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      global $postnot;
      $firstArticle = '';
      $i = 1;
      $style_cat_link = get_term_link('style', 'news_cat');
      $output .= '<div class="auto_float style_boxRow mb-4">
      
      <a href="' . $style_cat_link . '" target="_blank"><h2 class="egy-header-title single text-uppercase">Style</h2></a>
        <div class="row">';
      $args = array(
        'post_type'        => 'linernews',
        'post_status'      => 'publish',
        'posts_per_page'   => 11,
        'no_found_rows'      => true,
        'post__not_in'     => $postnot,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'news_cat',
            'field'    => 'slug',
            'terms'    => 'style'
          )
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
          $the_query->the_post();

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

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          if ($i == 1) {
            $firstArticle = $the_query->post->ID;
            $output .= '<div class="col-12 col-lg-6"><div><img class="w-100 mob-image5" src="' . $image_attributes[0] . '"></div></div>';
          }
          if ($i == 2) {
            $output .= '
            <div class="col-12 col-lg-6">
              <div class="from-first-article mb-3 ' . $popular . $breaknews . '">
                <p class="post-tagline">
                ' . getCategoryByPostId($firstArticle) . '
                  <span>|</span>
                  <span>' . get_the_time('H:i', $firstArticle) .  '</span>
                </p>
                <h2 class="post-title post-title1">
                  <a class="title-slug" href="' . get_the_permalink($firstArticle) . '">
                  ' . get_the_title($firstArticle) . '
                  </a>
                </h2>
              </div>
              
            
            ';
          }
          if ($i >= 2 && $i <= 7) {
            $output .= '
              <div class="item mb-3 d-flex align-items-start ' . $popular . $breaknews . '">
                <p class="post-tagline mt-0 mr-4">
                <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                </p>
                <h2 class="post-title post-title1">
                  <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                  ' . get_the_title($the_query->post->ID) . '
                  </a>
                </h2>
              </div>
            ';
          }
          if ($i == 8) {
            $output .= '</div>';
          }
          if ($i >= 8 && $i <= 11) {
            $output .= '
              <div class="col-lg-3 mt-4">
                <div>
                  <img class="w-100 mob-image3" src="' . $image_attributes[0] . '">
                </div>
                <div class="' . $popular . $breaknews . '">
                  <p class="post-tagline">
                    ' . getCategoryByPostId($the_query->post->ID) . '
                    <span>|</span>
                    <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
                  </p>
                  <h2 class="post-title post-title2">
                    <a class="title-slug" href="' . get_the_permalink($the_query->post->ID) . '">
                      ' . get_the_title() . '
                    </a>
                  </h2>
                </div>
              </div>
            ';
          }
          $postnot[] = $the_query->post->ID;
          $i++;
        endwhile;
      endif;
      $output .= '</div> </div>';
      return $output;
    }
    add_shortcode('section-stylenews', 'section_stylenews_shortcode');




    function getmost_popularpost_lastday($atts, $content)
    {
      extract(shortcode_atts(array(
        'cat' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $cat_ar = explode(',', $cat);
      $i = 1;
      $args = array(
        'post_type'         => 'linernews',
        'post_status'       => 'publish',
        'posts_per_page'    => 15,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        /*'date_query'    => array(
                    array(
                     'after' => '24 hours ago'
                    )
                  ),*/
        'meta_query'    => array(
          'relation' => 'OR',
          array(
            'key'   => 'most_popular_news',
            'value' => '1',
          ),
          array(
            'key'   => 'breaking_news',
            'value' => '1',
          )

        ),
        'tax_query'         => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          )
        )


      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
        $output .= '<div class="popular_prow auto_float">
        <h2 class="egy-header-title single text-uppercase">Fontos hírek az elmúlt 24 órából</h2>
            <div class="row">';
        while ($the_query->have_posts()) {

          $the_query->the_post();
          $tdy = date('Y-m-d H:i:s');
          $pday = get_the_date('Y-m-d H:i:s');
          $date1 = date_create($tdy);
          $date2 = date_create($pday);
          $diff = date_diff($date1, $date2);
          $publish_time = get_the_time('', $the_query->post->ID);

          $output .= '<div class="col-md-4 col-sm-6">
            <div class="popular_col clr">
               <div class="popular_col_left">
                <span>' . $i . '.</span>
               </div>
               <div class="popular_col_right">              
              <p><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></p>
             </div>
            </div>
           </div>';
          $i++;
        }
        $output .= '</div></div>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('MostPopular_News', 'getmost_popularpost_lastday');


    function wpb_move_comment_field_to_bottom($fields)
    {
      $comment_field = $fields['comment'];
      unset($fields['comment']);
      $fields['comment'] = $comment_field;
      return $fields;
    }

    add_filter('comment_form_fields', 'wpb_move_comment_field_to_bottom');


    function wpb_move_cookies_field_to_bottom($fields)
    {
      $cookies_field = $fields['cookies'];
      unset($fields['cookies']);
      $fields['cookies'] = $cookies_field;
      return $fields;
    }

    add_filter('comment_form_fields', 'wpb_move_cookies_field_to_bottom');




    function latest_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '-1',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';


      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
      );
      $popular = '';
      $ttln = '';
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        $output .= '<section class="latest_single">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          $custom_author = get_field('news_author', $the_query->post->ID);

          $poplr = get_field('most_popular_news', $the_query->post->ID);
          if ($poplr == 1) {
            $popular = ' poplrpost';
          } else {
            $popular = '';
          }

          //if(strlen($the_query->post->post_title) > 45){
          //$ttln= substr($the_query->post->post_title, 0, 45) . '...';
          //}else{
          $ttln = $the_query->post->post_title;
          //}

          $output .= '<div class="latest_img"><a href="' . get_the_permalink($the_query->post->ID) . '"><img src="' . $image_attributes[0] . '" class="img-responsive"></a></div>';
          $output .= '<div class="popular_title' . $popular . '"><h2><a href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></h2></div>';
          $output .= '<div class="latest_auth">Szerző: <a href="' . home_url('/szerzo/') . '?a=' . $custom_author . '" class="athr_lnk">' . $custom_author . '</a></div>';
        }
        $output .= '</section>';
      }


      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('latest_single', 'latest_shortcode');
    function popularpost_sidebar($atts, $content)
    {
      extract(shortcode_atts(array(
        'cat' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $cat_ar = explode(',', $cat);
      $i = 1;
      $args = array(
        'post_type'         => 'linernews',
        'post_status'       => 'publish',
        'posts_per_page'    => 4,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        /*'date_query'    => array(
                    array(
                     'after' => '24 hours ago'
                    )
                  ),*/
        'meta_query'    => array(
          array(
            'key'   => 'most_popular_news',
            'value' => '1',
          )
        ),
        'tax_query'         => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style', 'sport'),
            'operator' => 'Not IN'
          )
        )


      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
        $output .= '<div class="popular_single"><div class="row">';
        while ($the_query->have_posts()) {

          $the_query->the_post();
          $tdy = date('Y-m-d H:i:s');
          $pday = get_the_date('Y-m-d H:i:s');
          $date1 = date_create($tdy);
          $date2 = date_create($pday);
          $diff = date_diff($date1, $date2);

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'thumbnail');

          $output .= '<div class="col-sm-12">
            <div class="popular_sin clr">
               <div class="popular_img pull-left"><img src="' . $image_attributes[0] . '" class="img-responsive" /></div>
               <div class="popular_content"><h4><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></h4><p>' . $diff->h . ' Hours Ago</p></div>
            </div>
           </div>';
        }
        $output .= '</div></div>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('popularpost_single', 'popularpost_sidebar');


    function justin_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '5',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $ttln = '';

      $args = array(
        'post_type'         => 'linernews',
        'post_status'       => 'publish',
        'posts_per_page'    => 5,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'         => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          )
        ),
        /*'date_query'    => array(
                    array(
                     'after' => '24 hours ago'
                    )
                  )*/


      );

      // The Loop
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $output .= '<div class="justin_single" style="padding-top: 20px;margin-top: 17px;">
    <div class="sidebar-img">
    <img src="' . get_template_directory_uri() . '/images/24_liner.png" class="img-responsive">
    </div>
    <ul>';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          //if(strlen($the_query->post->post_title) > 46){
          //$ttln= substr($the_query->post->post_title, 0, 46) . '...';
          //}else{
          $ttln = $the_query->post->post_title;
          //}
          $poplr = get_field('most_popular_news', $the_query->post->ID);
          $brknews = get_field('breaking_news', $the_query->post->ID);

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
          
   
          <span>' . (time() - strtotime($the_query->post->post_date) > 86400 ? get_post_time('M. d') : get_post_time('H:i')) . '</span>
            ';
          // if (true || false) {
          //   $output .= '<img class="fontos-img" src="' . get_bloginfo("template_url") . '/images/fontos.png" style="width:15px" />';
          // }
          $output .= '            
          </span>
          <h6>
            <a href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a>
          </h6>
        </li>';
        }
        $output .= '</ul>
      <a class="meg-tobb-btn" href="' . get_permalink(get_page_by_title('Friss hirek')) . '">
      MÉG TÖBB
      </a>
    </div>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('justin', 'justin_shortcode');

    function single_widget_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '10',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $ttln = '';

      $args = array(
        'post_type'         => 'linernews',
        'post_status'       => 'publish',
        'posts_per_page'    => 10,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'         => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'slug',
            'terms' => array('style'),
            'operator' => 'Not IN'
          )
        ),
        /*'date_query'    => array(
                    array(
                     'after' => '24 hours ago'
                    )
                  )*/


      );

      // The Loop
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
        $output .= '<div class="single_widget">    
    <ul>';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          //if(strlen($the_query->post->post_title) > 46){
          //$ttln= substr($the_query->post->post_title, 0, 46) . '...';
          //}else{
          $ttln = $the_query->post->post_title;
          //}
          $poplr = get_field('most_popular_news', $the_query->post->ID);
          $brknews = get_field('breaking_news', $the_query->post->ID);

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
          // news_cat of the post
          $terms = get_the_terms($the_query->post->ID, 'news_cat');
          $term = array_pop($terms);


          $output .= '<li>          
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="widget-article-date">' . get_post_time('H:i') .  '</span>
            <a class="widget-category-link" target="_blank" href="' . get_term_link($term->term_id) . '">' . str_replace('#', '', $term->name) . '</a>
          </div>
            ';
          $output .= '            
          
          <div>
            <a class="widget-single-title" href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a>
          </div>
        </li>';
        }
        $output .= '</ul>
      <a class="meg-tobb-btn" href="' . get_permalink(get_page_by_title('Friss hirek')) . '">
      MÉG TÖBB
      </a>
    </div>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('single_widget', 'single_widget_shortcode');







    function singlepopular_shortcode($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => '',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';

      global $post;
      $draught_links = array();
      $terms = get_the_terms($post->ID, 'news_cat');
      if ($terms && !is_wp_error($terms)) {

        foreach ($terms as $term) {
          $draught_links[] = $term->term_id;
        }
      }
      //print_r($draught_links);
      $args = array(
        'post_type'              => 'linernews',
        //'post_status'            => 'publish',
        'posts_per_page'         => 3,
        //'no_found_rows' 		 => true,
        //'update_post_meta_cache' => false,
        //'update_post_term_cache' => false,
        'post__not_in'        => array($post->ID),
        'tax_query'              => array(
          array(
            'taxonomy' => 'news_cat',
            'field' => 'term_id',
            'terms' => $draught_links
          )
        )
        /*,'meta_query'             => array(
                                    array(
                                      'key'   => 'most_popular_news',
                                      'value' => '1',
                                    )
                                  )*/
      );

      $ttln = '';
      $popular = '';
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        $output .= '<section class="tyle_mainSection single_dontmiss"><div class="tyle_container auto_float"><div class="row" id="type-' . $shortcode_id . '">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');
          $custom_author = get_field('news_author', $the_query->post->ID);

          $poplr = get_field('most_popular_news', $the_query->post->ID);
          $newsterm = get_the_terms($the_query->post->ID, 'news_cat');
          $terms_string = join(', ', wp_list_pluck($newsterm, 'name'));

          if ($poplr == 1) {
            $popular = ' lineleft';
          } else {
            $popular = '';
          }

          //if(strlen($the_query->post->post_title) > 52){
          //$ttln= substr($the_query->post->post_title, 0, 52) . '...';
          //}else{
          $ttln = $the_query->post->post_title;
          //}
          $img_src = '';
          if ($image_attributes[0]) {
            $img_src = $image_attributes[0];
          }
          $output .= '<div class="col-md-4 col-sm-12"><div class="tyle_oBx tyle_oBx1"><span class="nues_imgSpan"><img src="' . $img_src . '"></span><div class="nues_content' . $popular . '"><p><a href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></p><label class="f_wBig"><strong><a href="' . home_url('/szerzo/') . '?a=' . $custom_author . '" class="athr_lnk">' . $custom_author . '</a></strong> <b></b></label><label>' . $terms_string . '</label></div></div></div>';
        }

        $output .= '</div></div></section>';
      } else {
        $output .= 'Nothing Found';
      }


      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('dontmiss_news', 'singlepopular_shortcode');

    function wpse_81939_post_types_admin_order($wp_query)
    {
      if (is_admin()) {
        // Get the post type from the query
        $post_type = $wp_query->query['post_type'];
        if ($post_type == 'linernews') {
          $wp_query->set('orderby', 'date');
          $wp_query->set('order', 'DESC');
        }
      }
    }
    add_filter('pre_get_posts', 'wpse_81939_post_types_admin_order');


    // Add the custom columns to the book post type:
    add_filter('manage_linernews_posts_columns', 'set_custom_edit_book_columns');
    function set_custom_edit_book_columns($columns)
    {
      unset($columns['author']);
      $columns['news_author'] = __('Author', 'liner');

      return $columns;
    }

    // Add the data to the custom columns for the book post type:
    add_action('manage_linernews_posts_custom_column', 'custom_book_column', 10, 2);
    function custom_book_column($column, $post_id)
    {
      switch ($column) {

        case 'news_author':
          //$terms = get_the_term_list( $post_id , 'book_author' , '' , ',' , '' );
          $custom_author = get_field('news_author', $post_id);
          if (is_string($custom_author))
            echo $custom_author;
          else
            _e('Unable to get author(s)', 'liner');
          break;
      }
    }


    //define(SINGLE_PATH, TEMPLATEPATH . '/single');

    if (!defined('SINGLE_PATH')) {
      //define('SINGLE_PATH', get_template_directory_uri() . '/single');
      define('SINGLE_PATH', TEMPLATEPATH . '/single');
    }

    //echo 'get_template_directory_uri(): '.SINGLE_PATH;

    add_filter('single_template', 'my_single_longform_template');
    function my_single_longform_template($single)
    {
      global $wp_query, $post;

      $longform = get_field('long_form', $wp_query->post->ID);
      if ($longform == 1) {
        return SINGLE_PATH . '-longform.php';
      } else {
        return SINGLE_PATH . '-linernews.php';
      }
    }

    //user mapping to new post scandir

    function map_user_to_news()
    {

      if (get_the_ID() == 1) {
        /*

		Username - Displayed Name -  user id

A T-800-as - A T800-as

AztekSzotar - Köles István Ákos
BassMasterSK - Kulcsár Péter
Fanni - Borbély Fanni
Kiss Laszlo - Kiss László
KolBen - Kolláth Benjámin
Kornis Vivien - Kornis Vivien
LinerAcc - Lakatos István
NNoel98 - Nagy Noel
pgyemant - Gyémánt Péter
Steve04 - Lakatos István
SzKata - Szabó Kata
Takacs Petra - Takács Petra





		*/


        echo 'user will be mapped<br/>';
        $user_map = array();

        $user_map['A T800-as']['name'] = 'A T-800-as';
        $user_map['A T-800-as']['name'] = 'A T-800-as';
        $user_map['Hujber Dávid']['name'] = 'A T-800-as';
        //$user_map['A T800-as 7']['id'] = 7;

        $user_map['Köles István Ákos']['name'] = 'AztekSzotar';
        //$user_map['Köles István Ákos']['id'] = 9;


        $user_map['Kulcsár Péter']['name'] = 'BassMasterSK';
        //$user_map['Kulcsár Péter']['id'] = 9;

        $user_map['Borbély Fanni']['name'] = 'Fanni';
        $user_map['Kiss László']['name'] = 'Kiss Laszlo';
        $user_map['Kolláth Benjámin']['name'] = 'KolBen';
        $user_map['Kornis Vivien']['name'] = 'Kornis Vivien ';
        $user_map['Lakatos István']['name'] = 'LinerAcc';
        $user_map['Nagy Noel']['name'] = 'NNoel98';
        $user_map['Gyémánt Péter']['name'] = 'pgyemant';
        //$user_map['Lakatos István']['name'] = 'Steve04';
        $user_map['Szabó Kata']['name'] = 'SzKata';
        $user_map['Takács Petra']['name'] = 'Takacs Petra';

        echo '<pre>';

        //aget user id by user name
        foreach ($user_map as $u => $ud) {

          //echo $u;
          //print_r($ud);
          $username = $ud['name'];
          $user1 = get_user_by('login', $username);
          //$id = $user1->ID;
          $user_map[$u]['id'] = $user1->ID;

          //print_r($user1);

        }



        print_r($user_map);

        //get all new and update author

        $args = array(
          'post_type'              => 'linernews',
          'posts_per_page'         => -1,
        );
        $z = 1;
        $runupto = 99999999999999999999999999999;
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {

          while ($the_query->have_posts()) {

            //echo $z;

            $the_query->the_post();
            //get stored user
            $custom_author = get_field('news_author', $the_query->post->ID);
            //print_r($the_query->post->ID);
            //print_r($custom_author);
            $user_id_new = $user_map[$custom_author]['id'];

            //print_r($the_query);
            //update new post


            if ($z <= $runupto) { //run once
              //start again from 13509
              if ($z >= 13509) {
                if ($user_id_new) {

                  //$args2 = array('ID'=>999999999999999999999999999999999999999999,'post_author'=>$user_id_new);
                  $args2 = array('ID' => $the_query->post->ID, 'post_author' => $user_id_new);
                  $news_returned = wp_update_post($args2);


                  if ($news_returned) {

                    echo "  $z <span style='color:green'>updated news id : {$the_query->post->ID} , new post author id : {$user_id_new}</span><br/>";
                  } else {
                    echo "  $z <span style='color:red'>could not update news id :  {$the_query->post->ID} , new post author id : {$user_id_new}</span><br/>";
                  }
                } else {
                  echo "  $z <span style='color:red'>could not  found author match name stored '{$custom_author}', news id :  {$the_query->post->ID} </span><br/>";
                }
              } //started again ended.

              $z++;
            } //run once end


          }
          // Restore original Post Data
          //wp_reset_postdata();
        }

        echo '</pre>';
      }
    }
    //script stopped
    //add_action('wp_head','map_user_to_news');

    /* add dark mode **/
            add_filter('body_class', function ($classes) {

                $dark_mode = isset($_GET['darkmode']) ? $_GET['darkmode'] : 0;
                //check if user have aleady  enable dark mode
                if (isset($_COOKIE['dark_mode'])) {
                    $dark_mode = true;
                }
                if (isset($dark_mode) and $dark_mode != 0) {
                    return array_merge($classes, array('darkmode'));
                }

                return $classes;
            });

    // add_filter('wp_nav_menu_items', 'dm_switch_button', 10, 2);
    function dm_switch_button($items, $args)
    {
      if ($args->theme_location == 'primary') {
        $items .= dm_switch_button_html();
      }
      return $items;
    }
    function dm_switch_button_html()
    {

      if (isset($_COOKIE['dark_mode'])) {
        $dark_mode = true;
      }
      $selected = '';
      if (isset($dark_mode)) {
        $selected = 'checked';
      }
      $items = '<li><form action="" name="darkmode_form" method="post" id="darkmode_form" enctype="multipart/form-data"><label class="switch_dm"><input class="dm_checkbox" name="darkmode" type="checkbox" ' . $selected . ' value="1"><span class="slider_dm round_dm fas fa-sun"></span></label><input type="hidden"  name="dark_mode_form_submitted" value="1"/><input type="hidden"  name="dark_mode_form_submitted_val" id="dark_mode_form_submitted_val" value="no"/><input id="dark_mode_submit_btn" style="display:none" type="submit"  name="dark_mode_submit_btn" value="submit"/></form></li>';

      return $items;
    }
    function url_origin($s, $use_forwarded_host = false)
    {
      $ssl      = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
      $sp       = strtolower($s['SERVER_PROTOCOL']);
      $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
      $port     = $s['SERVER_PORT'];
      $port     = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
      $host     = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
      $host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;
      return $protocol . '://' . $host;
    }

    function full_url($s, $use_forwarded_host = false)
    {
      return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
    }

    function dm_cookies()
    {
      //cookie dark mode it need to be at the top or cookie willnot work :(
      if (isset($_REQUEST['dark_mode_form_submitted'])) {
        $current_ul_md = full_url($_SERVER);
        if ($_REQUEST['dark_mode_form_submitted_val'] == 'yes') {
          setcookie('dark_mode', 1, time() + 3600, '/');
        }
        if ($_REQUEST['dark_mode_form_submitted_val'] == 'no') {
          setcookie('dark_mode', '', time() - 3600, '/');
          unset($_COOKIE['dark_mode']);
        }

        //	purge_all cache on switch darkmode
        do_action('litespeed_purge_all', 'Darkmode switch');


        wp_redirect($current_ul_md);
        exit();
      }
    }
    add_action('init', 'dm_cookies');

    /* add category in feed */
    function liner_cat_rss_categories($the_list)
    {
      global $post;
      $terms = get_the_terms($post->ID, 'news_cat');
      $cats = '';
      if (is_array($terms)) {
        foreach ($terms as $t => $tv) {
          $cats  .= '<category><![CDATA[ ' . $tv->name . ' ]]></category>';
        }
      }
      return $the_list . $cats;
    }

    add_filter('the_category_rss', 'liner_cat_rss_categories');

    //remove cunt from editors
    add_filter('manage_posts_columns', 'change_columns_for_user', 10, 2);
    function change_columns_for_user($columns, $post_type)
    {
      if ('post' != $post_type)
        return $columns;

      if (current_user_can('administrator'))
        return $columns;
      else {
        //Remove column
        unset($columns['view_count']);
        unset($columns['post_views']);
        return $columns;
      }
    }


    add_filter('manage_posts_columns', 'change_columns_for_user_linernews', 10, 2);
    function change_columns_for_user_linernews($columns, $post_type)
    {

      if ('linernews' != $post_type)
        return $columns;


      if (current_user_can('administrator'))
        return $columns;
      else {
        //Remove column
        unset($columns['view_count']);
        unset($columns['post_views']);
        return $columns;
      }
    }
    add_filter('manage_linernews_posts_columns', 'change_columns_for_editor_linernews', 10000, 1);
    function change_columns_for_editor_linernews($columns)
    {

      if (current_user_can('administrator'))
        return $columns;
      else {
        //Remove column
        unset($columns['view_count']);
        unset($columns['post_views']);
        return $columns;
      }

      return $columns;
    }
    // disable chart from editor on dashboard
    add_filter('pvc_user_can_see_stats', 'liner_pvc_user_can_see_stats');
    function liner_pvc_user_can_see_stats()
    {
      if (current_user_can('administrator'))
        return true;

      return false;
    }
    //hide view count on meta box
    add_filter('pvc_restrict_edit_capability', 'liner_pvc_restrict_edit_capability');
    function liner_pvc_restrict_edit_capability()
    {
      return false;
    }
    add_action('add_meta_boxes', 'liner_wpdocs_remove_post_custom_fields', 1000);

    function liner_wpdocs_remove_post_custom_fields()
    {
      remove_meta_box('post_views_meta_box', 'linernews', 'side');
    }
    function liner_admin_footer_function()
    {
      echo '<style>.edit-post-post-views{display:none}</style>';
    }
    add_action('admin_footer', 'liner_admin_footer_function');


    // admin check if acf saved to help decrease slow query 
    add_action('acf/save_post', 'breaking_bar_save_meta');
    function breaking_bar_save_meta($post_id)
    {
      if (any_breaking_news()) {
        update_option('breaking_bar_run_query', 1);
        update_option('breaking_bar_run_query_upate_time', time());
      } else {
        update_option('breaking_bar_run_query', 0);
        update_option('breaking_bar_run_query_upate_time', time());
      }
    }
    //any_breaking_news();
    function any_breaking_news()
    {
      global $post;
      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'    => array(
          array(
            'key'   => 'breaking_bar',
            'value' => '1',
          )
        )
      );
      $t = new WP_Query($args);
      return $t->post_count;
    }

    //breaking bar
    function breaking_bar_shortcode($atts, $content)
    {
      // it will help to decrease queries on inner page 
      $runq = false;  //default	
      $show_breaking_bar = get_option('breaking_bar_run_query');
      if ($show_breaking_bar) {
        $runq = 1;
      } //for article pages	
      if (!$runq) {
        return '';
      } //this is -ve condition



      $output = '';
      $selectpost = '';
      global $post;
      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'    => array(
          array(
            'key'   => 'breaking_bar',
            'value' => '1',
          )
        )
      );

      $the_query = new WP_Query($args);

      while ($the_query->have_posts()) {
        $the_query->the_post();
        $author_id = $the_query->post->post_author;
        $custom_author = get_field('news_author', $the_query->post->ID);


        $output .= '
             <div class="breaking_bar_content" data-news-id="' . $the_query->post->ID . '">
					<div class="breaking_before_title" ><span >Fontos: </span></div>
                  <div class="breaking_bar_news_text br_scrolling">
				  <a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></div>
				  <a class="fa fa-close close_breaking_bar" data-news-id="' . $the_query->post->ID . '" ></a>

             </div>
         ';
      }
      // Restore original Post Data
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('breaking_bar', 'breaking_bar_shortcode');

    function add_breaking_bar()
    {
      //echo 'br bar via action';
      ?>
      <div class='container breaking_bar_outer' id='breaking_bar_outer' style='display:none;'>
        <div class=' breaking_bar'>
          <?php echo do_shortcode('[breaking_bar]'); ?>


        </div>
      </div>
    <?php
    }

    add_action('breaking_bar', 'add_breaking_bar');

    /**
     * recommended articles
     * at least match 2 tags
     * arg: articles_need int (how many article to return)
     * arg: tag_min_match int (how many tag need to matched)
     * ref: https://wordpress.stackexchange.com/questions/103078/posts-with-at-least-3-tags-of-a-list-of-tags
     */

    function get_recommended_articles_ids($articles_need = 2, $tag_min_match = 2)
    {

      global $post;
      $articles_ids = array();
      $relterms_links = array();
      $relterms = get_the_terms($post->ID, 'newstag');
      if ($relterms && !is_wp_error($relterms)) {
        foreach ($relterms as $relterm) {
          $relterms_links[] = $relterm->slug;
        }

        $tags  = $relterms_links;
        $args = array(
          'post_type'              => 'linernews',
          'post_status'            => 'publish',
          'posts_per_page'         => -1,
          'post__not_in'         => array($post->ID),
          'no_found_rows'      => true,
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
          'tax_query'            => array(
            array(
              'taxonomy' => 'newstag',
              'field'    => 'slug',
              'terms'    => $relterms_links,
            )
          )
        );
        $tagged_posts = new WP_Query($args);
        //$articles_need = 3;
        $articles_count = 0;
        while ($tagged_posts->have_posts()) : $tagged_posts->the_post();
          // Check each single post for up to 3 matching tags and output <li>
          $tag_count = 0;
          // $tag_min_match = 3;
          foreach ($tags as $tag) {
            if (has_term($tag, 'newstag') && $tag_count < $tag_min_match) {
              $tag_count++;
            }
          }
          if ($tag_count == $tag_min_match) {
            $articles_ids[] = get_the_ID();
            $articles_count++;
          }

          if ($articles_need == $articles_count) {
            //break the while loop  , article needed completed
            break;
          }
        endwhile;
        wp_reset_query();
      } //eof check if tags on article
      return $articles_ids;
    }
    // recommended article for inner pages
    function recommended_articles_shortcode($atts, $content)
    {
      //get articles by tag matches
      $articles_ids = get_recommended_articles_ids($articles_need = 2, $tag_min_match = 2);
      $output = '';

      if ($articles_ids) {
        $args = array(
          'post_type'              => 'linernews',
          'post_status'            => 'publish',
          'posts_per_page'         => 2,
          'post__in'  => $articles_ids
        );

        $the_query = new WP_Query($args);

        $output .= '<div class="crp_related crp_related_shortcode "><h3>Ne hagyd ki</h3>';

        while ($the_query->have_posts()) {
          $the_query->the_post();
          $author_id = $the_query->post->post_author;
          $custom_author = get_field('news_author', $the_query->post->ID);


          $output .=  '<label><a href="' . get_the_permalink($the_query->post->ID) . '" class="crp_link linernews-130586"><span class="crp_title">' . $the_query->post->post_title . '</span></a></label>';
        }
        $output .= '<div class="crp_clear"></div></div>';
        // Restore original Post Data
        wp_reset_postdata();
      }
      return $output;
    }
    add_shortcode('recommended_articles', 'recommended_articles_shortcode');

    /*
 * contact us form
 */

    function liner_contact_us_ajax()
    {
      // Implement ajax function here
      if (isset($_POST['action'])) {

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);


        $site  =  get_bloginfo('name');
        $from  =  get_bloginfo('admin_email');
        $to    =  'info@liner.hu';
        //$to		=	'ajayitprof@gmail.com';

        $subject = 'contact us email : ' . $subject;
        $body = "Name : $name <br/>
      Email : $email <br/>
      Subject : $subject <br/>
      Message : $message <br/>
      ";
        $headers[] = "From: $site <$from>";
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        wp_mail($to, $subject, $body, $headers);



        //on success
        echo 'OK';
      }

      wp_die();
    }
    add_action('wp_ajax_liner_contact_us', 'liner_contact_us_ajax');    // If called from admin panel
    add_action('wp_ajax_nopriv_liner_contact_us', 'liner_contact_us_ajax');    // If called from front end
    function liner_contact_us_2_ajax()
    {
      // Implement ajax function here


      $kv_errors = array();
      if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $fields = array('name', 'email', 'message');

        foreach ($fields as $field) {
          if (isset($_POST[$field])) $posted[$field] = stripslashes(trim($_POST[$field]));
          else $posted[$field] = '';
        }
        if ($posted['name'] == null)
          array_push($kv_errors,  sprintf('Notice: Please enter Your Name.', 'kvcodes'));

        if ($posted['email'] == null)
          array_push($kv_errors,  sprintf('Notice: Please enter Your Email.', 'kvcodes'));

        if ($posted['message'] == null)
          array_push($kv_errors,  sprintf('Notice: Please enter Your Message.', 'kvcodes'));

        $errors = array_filter($kv_errors);

        if (empty($errors)) {
          if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
          }

          $uploadedfile = $_FILES['file'];

          $upload_overrides = array('test_form' => false);

          $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

          if ($movefile && !isset($movefile['error'])) {
            $movefile['url'];
          }

          $attachments = array($movefile['file']);
          $headers = 'From: ' . $posted['name'] . ' <' . $posted['email'] . '>' . "\r\n";
          $body = '
          Name: ' . $posted['name'] . '<br>
          Email: ' . $posted['email'] . '<br>
          Message: ' . $posted['message'] . '<br>
          Attachment: ' . $movefile['url'] . '<br>
          ';
          wp_mail('sztori@liner.hu', 'Sendmail', $body, $headers);
          echo 'OK';
          unlink($movefile['file']);
        }
      }

      wp_die();
    }
    add_action('wp_ajax_liner_contact_us_2', 'liner_contact_us_2_ajax');    // If called from admin panel
    add_action('wp_ajax_nopriv_liner_contact_us_2', 'liner_contact_us_2_ajax');    // If called from front end

    function feed_extra($qv)
    {
      if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('linernews');
      return $qv;
    }
    add_filter('request', 'feed_extra');

    //feed update interval

    add_filter('wp_feed_cache_transient_lifetime', function () {
      return 300;
    });

    // ajax post count
    function liner_page_count_ajax()
    {
      $article_url = $_REQUEST['page_url'];
      $article_obj = get_page_by_path(basename(untrailingslashit($article_url)), OBJECT, 'linernews');
      $article_id = $article_obj->ID;
      //custom count
      if (function_exists('pvc_view_post')) {
        $r = pvc_view_post($article_id);
        echo $article_id . ': ' . $r;
      }
      wp_die();
    }
    add_action('wp_ajax_liner_ajax_page_count', 'liner_page_count_ajax');
    add_action('wp_ajax_nopriv_liner_ajax_page_count', 'liner_page_count_ajax');

    /*euro 2021

    function section_euro2021($atts, $content)
    {
      extract(shortcode_atts(array(
        'tag' => 'EB2020,EURO2021',
      ), $atts));



      $output = '';
      $tag_ar = explode(',', $tag);

      $output .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>';

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 5,
        'no_found_rows'      => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'tax_query'        => array(
          array(
            'taxonomy' => 'newstag',
            'field' => 'name',
            'terms' => $tag_ar
          )
        )




      );

      $the_query = new WP_Query($args);
      $last = '';
      $i = 1;

      $first3 = array();

      if ($the_query->have_posts()) {

        $output .= '<section class="section-euro2021 "><div class="euro_container "><div class="row">';
        $output .= ' <div class="col-lg-3"> <div class="EURO2021-title"> <img class="euro_bigpic" src="' . get_template_directory_uri() . '/images/eu2020_logov2.png"/> <img class="euro_smallpic"  src="' . get_template_directory_uri() . '/images/eur_logo_mobv2.png"/> </div></div>';
        $output .= ' <div class="col-lg-8 "> ';
        $output .= ' <div class="euroslider owlCarousel" id="owlCarousel"> ';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium_large');

          $output .= '<div class="single-slide">';
          $output .= ' <img src="' . $image_attributes[0] . '"/> ';
          $output .= '<div  class="euro2021_tag_container"><a  class="euro2021_tag" href="' . home_url('tema/eb2020') . '">Euro 2020 </a> </div><h3> 				<a href="' . get_the_permalink($the_query->post->ID) . '">' . wp_trim_words($the_query->post->post_title, 15, '') . ' </a></h3>';
          //  $output .= '<h3> <a href="'.get_the_permalink($the_query->post->ID).'">'.$the_query->post->post_title.' </a></h3>';

          $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '</div>';
        //https://bxslider.com/options/
        $output .= '<script>jQuery(document).ready(function(){
			  jQuery(".euroslider").bxSlider({pager:true,
			  minSlides: 1,
				maxSlides: 3,
			  moveSlides: 1,
			  slideWidth: 230,
				slideMargin:5,
				responsive:true,
				touchEnabled: true

			  });

	});
			</script>';



        // $output .= '<div class="col-sm-8 col-xs-12"> here hsould be content </div> ';

        $output .= '</div></div></section>';
      }

      // Restore original Post Data
      ?>
      <style>
        section.section-euro2021 {
          margin-bottom: 25px;
          width: 100%;
        }

        .euro_container {
          /* background-color:#0f3246; 
          background-image: url('<?php echo get_template_directory_uri(); ?>/images/Eurocup_2020.png');
          background-repeat: no-repeat;
          background-position: right;
          padding-top: 23px;
        }

        .EURO2021-title {}

        .EURO2021-title img {
          margin-left: 10%;
          width: 190px;
        }

        .bx-wrapper {
          background-color: transparent !important;
          -webkit-box-shadow: none !important;
          box-shadow: none !important;
          border: none !important;
        }

        .single-slide {
          background-color: #fff
        }

        .single-slide h3 {
          line-height: 18px;
          padding: 12px;
          height: 150px;
          font-family: 'Bai Jamjuree';
        }

        .single-slide a {
          color: black;
          font-size: 18px;
        }

        .bx-wrapper .bx-prev {
          left: -44px !important;
        }

        .bx-wrapper .bx-next {
          right: -44px !important;
        }

        .euro_bigpic {}

        .euro_smallpic {
          display: none;
        }

        .euro2021_tag_container {
          margin-top: 12px
        }

        .euro2021_tag {
          border-bottom: 3px double #607d8b;
          margin-left: 12px;
          font-size: 1.082em !important;
          text-decoration: none;
        }

        .euro2021_tag a {
          font-size: 1.082em;
        }

        @media (max-width: 430px) {
          .euro_bigpic {
            display: none;
          }

          .euro_smallpic {
            display: block;
            padding-bottom: 20px;
            margin: 0 auto !important;
          }

          .single-slide {
            width: 180px !important
          }

          .euro2021_tag {
            font-weight: normal !important;
          }

          .euro_container {
            /* background-color:#0f3246; 
            background-image: url('<?php echo get_template_directory_uri(); ?>/images/Eurocup_2020.png');
            background-repeat: no-repeat;
            background-position: center;
          }
      </style>

    <?php
      wp_reset_postdata();
      return $output;
    }
    add_shortcode('section-euro', 'section_euro2021');*/


    /**************** Featured News Shortcode *******************/

    add_shortcode('featured_news', 'featured_news_callback');
    function featured_news_callback($atts, $content)
    {
      extract(shortcode_atts(array(
        'per_page' => '-1',
      ), $atts));

      $shortcode_id = rand(0, 99999);
      $output = '';
      $type = '';
      global $postnot;

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'    => array(
          array(
            'key'   => 'most_popular_news',
            'value' => '1',
          )
        )
      );

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {

        $output .= '<section class="nc_section2 auto_float">
          <div class="nc_container auto_float">';
        while ($the_query->have_posts()) {
          $the_query->the_post();

          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'full');
          $author_id = $the_query->post->post_author;
          $custom_author = get_field('news_author', $the_query->post->ID);
          $news_type = get_field('news_type', $the_query->post->ID);

          if ($news_type == 'video') {
            $type = ' type_video';
          } elseif ($news_type == 'slider') {
            $type = ' type_slider';
          } else {
            $type = '';
          }

          $output .= '<div class="row"><div class="col-sm-12 div_nc_left_title"><h2><a href="' . get_the_permalink($the_query->post->ID) . '">' . $the_query->post->post_title . '</a></h2></div></div>';
          $output .= '<div class="div_nc_left"><div class="nc_videoDiv">';
          if (empty($type)) {
            $output .= '<a href="' . get_the_permalink($the_query->post->ID) . '" class="simplenews"><img src="' . $image_attributes[0] . '"></a>';
          } else {
            $output .= '<img src="' . $image_attributes[0] . '"><a href="' . get_the_permalink($the_query->post->ID) . '" class="btn' . $type . '">Link</a>';
          }


          $output .= '</div><div class="nc_imgContent">
                    <span><a href="' . home_url('/szerzo/') . '?a=' . $custom_author . '" class="athr_lnk">' . $custom_author . ' </a></span>
                    <p>' . $the_query->post->post_excerpt . '</p>';

          //$output .= '2 news will be here';
          $output_latest_news_block =  get_latest_news_blocks($the_query->post->ID);
          $output .= '<div class="crp_related crp_related_shortcode ">';
          $output .= $output_latest_news_block[1];
          $output .= $output_latest_news_block[2];
          $output .= '</div>';

          $output .= ' </div>
             </div>';
          $postnot[] = $the_query->post->ID;
        }
      }

      // Restore original Post Data
      wp_reset_postdata();




      $ttln = '';

      $args = array(
        'post_type'              => 'linernews',
        'post_status'            => 'publish',
        'posts_per_page'         => 13,
        'post__not_in'  => $postnot,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'    => array(
          array(
            'key'   => 'most_popular_news',
            'value' => '1',
          )
        )
      );

      $the_query = new WP_Query($args);
      $z = 1;
      if ($the_query->have_posts()) {

        $output .= '<div class="div_nc_right">';
        while ($the_query->have_posts()) {
          $the_query->the_post();
          $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'full');
          $custom_author = get_field('news_author', $the_query->post->ID);

          $ttln = $the_query->post->post_title;


          $poplr = get_field('most_popular_news', $the_query->post->ID);
          $brknews = get_field('breaking_news', $the_query->post->ID);

          if ($poplr == 1) {
            $popular = ' popular';
          } else {
            $popular = '';
          }

          if ($brknews == 1) {
            $breaknews = ' brknews';
            $popular = '';
          } else {
            $breaknews = '';
          }

          if ($z % 2 != 0) {

            $output .= '<div class="nc_left_1' . $popular . $breaknews . '">
                   <h3><a href="' . get_the_permalink($the_query->post->ID) . '">' . $ttln . '</a></h3>
                   <label><a href="' . home_url('/szerzo/') . '?a=' . $custom_author . '" class="athr_lnk">' . $custom_author . '</a></label>
                </div>
                <div class="nc_right_1">
                  <span><img src="' . $image_attributes[0] . '"></span>
                </div>';
          } else {
            $output .= '<div class="volt_d latest_news_' . $z . '">';
            $output .= '<div class="crp_related crp_related_shortcode ">';
            //$output .= $output_latest_news_block[$z];
            $output .=  '<label><a href="' . get_the_permalink($the_query->post->ID) . '" class="home_latest_news">' . get_the_title() . '</a></label>';
            $output .= '</div>';
            $output .= '</div>';
          }
          $postnot[] = $the_query->post->ID;
          $z++;
        }

        $output .= '</div></div></section>';
      }

      wp_reset_postdata();
      return $output;
    }
