<?php

/**
 * The template for displaying page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$date = '';
$args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         => 15,
    //'page' 				=>	 $paged		,
    'orderby' => 'date',
    'paged'                 =>     $paged,

);

$the_query = new WP_Query($args);

$i = 1;

?>
<div class='container'>
    <div id="primary">
        <div class="row">
            <div class="col-md-8 category-wide-section">
                <?php
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
                        $the_query->the_post();

                        $poplr = get_field('most_popular_news', $the_query->post->ID);
                        $brknews = get_field('breaking_news', $the_query->post->ID);

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

                        $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id($the_query->post->ID), 'medium');
                        if ($date != get_the_date('Y.m.d')) {
                            setlocale(LC_ALL, 'hu_HU.UTF-8');
                            if ($i == 1) {
                                $dateTitle = 'Friss Hírek';
                            } else {

                                $dateTitle = strftime('%A', strtotime(get_the_date('Y/m/d')));
                            }

                            echo '<div class="d-flex align-items-center justify-content-between mt-4" style="border-bottom: 1px solid #d1d1d1;">
                            <h1 class="friss-title egy-header-title">' . $dateTitle . '</h1>';
                            $date = get_the_date('Y.m.d');
                            echo '<div class="group-date">' . $date . '</div>';
                            echo '</div>';
                        }
                        ?>
                        <div class="news-item d-flex <?php echo $poplr || $brknews ? 'align-items-center' : ''; ?>">
                            <span class="post-tagline mr-4 font-weight-bold <?php echo $poplr || $brknews ? '' : 'mt-5'; ?>"><?php echo get_post_time('H:i'); ?></span>
                            <?php if ($poplr || $brknews) : ?>
                                <img src="<?php echo $image_attributes[0] ?>" style="width: 120px;min-height: 70px;object-fit: cover;max-height: 70px;min-width: 120px;max-width: 120px;" class="mr-4" />
                            <?php endif; ?>
                            <div>
                                <p class="post-tagline">
                                    <?php echo getCategoryByPostIdd($the_query->post->ID); ?>
                                </p>
                                <div class="news-item-title">

                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>
                                <?php if (!$poplr && !$brknews) : ?>
                                    <div class="news-item-content">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php
                        $i++;
                    endwhile;
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
                endif;
                ?>

            </div>
            <div class="col-md-4 category-wide-sidebar">
                <div class="mt-4">
                    <img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;">
                </div>
                <div class="mt-4 mb-4">
                    <img src="<?php echo get_template_directory_uri() ?>/images/300x600.jpeg" alt="ads" class="img-fluid w-100" style="max-width: 100%;max-height: 600px;object-fit: cover;">
                </div>
            </div>
        </div>
    </div><!-- #primary -->

</div>
<?php get_footer(); ?>