<?php
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$date = '';
global $postnotin;
$i = 1;
$args = array(
    'post_type'              => 'linernews',
    'post_status'            => 'publish',
    'posts_per_page'         =>    5,
    'post__not_in'           => $postnotin,
    'orderby'                => 'date',
    'tax_query'              => array(
        array(
            'taxonomy' => 'newstag',
            'field' => 'slug',
            'terms' => array('orosz-ukran-haboru-fontosabb-tortenesek'),
            'operator' => 'IN'
        )
    )

);

$the_query = new WP_Query($args); ?>



<div class="container">
    <div id="primary">
        <?php
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
                $the_query->the_post();
                if ($i == 1) {
                    echo '<h1 class="friss-title">' . get_the_title() . '</h1>';
                }
                $i++;
            endwhile;
            wp_reset_query();
        endif;
        ?>

        <p class="mb-4 post-description">Élő közvetítés az orosz-ukrán háború történéseiről</p>
        <div class="row">
            <div class="col-md-8 category-wide-section">
                <div class="key-points-section">
                    <h2 class="egy-header-title single">Key points</h2>
                    <div class="key-points-list">
                        <?php
                        if ($the_query->have_posts()) :
                            while ($the_query->have_posts()) :
                                $the_query->the_post();
                                ?>
                                <div class="key-points-item">
                                    <div class="key-points-item-content">
                                        <h3 class="key-points-item-title"><?php the_title(); ?></h3>

                                        <a href="<?php the_permalink(); ?>" class="key-points-item-link">View post
                                            <!-- <span class="chevron-down">↓</span> -->
                                            <i class="fa fa-arrow-down chevron-down"></i>
                                        </a>
                                    </div>
                                </div>
                        <?php
                                $postnotin[] = $the_query->post->ID;
                            endwhile;
                            wp_reset_query();
                        endif;
                        ?>
                    </div>
                </div>
                <div class="timeline mt-5">
                    <?php
                    $short_args = array(
                        'post_type'              => 'linernews',
                        'post_status'            => 'publish',
                        'posts_per_page'         =>    5,
                        // 'post__not_in'           => $postnotin,
                        'orderby'                => 'date',
                        'paged'                  => $paged,
                        'tax_query'              => array(
                            array(
                                'taxonomy' => 'newstag',
                                'field' => 'slug',
                                'terms' => array('orosz-ukran-rovid', 'orosz-ukran-haboru-fontosabb-tortenesek'),
                                'operator' => 'IN'
                            )
                        )

                    );

                    $short_query = new WP_Query($short_args);
                    if ($short_query->have_posts()) :
                        while ($short_query->have_posts()) :
                            $short_query->the_post();
                            $permalink = get_permalink();

                            $poplr = get_field('most_popular_news', $short_query->post->ID);
                            $brknews = get_field('breaking_news', $short_query->post->ID);

                            if ($poplr == 1) {
                                $popular = ' timeline-highlighted ';
                            } else {
                                $popular = '';
                            }

                            if ($brknews == 1) {
                                $breaknews = ' timeline-highlighted ';
                                $popular = '';
                            } else {
                                $breaknews = '';
                            }

                            ?>
                            <div class="timeline-item">
                                <div class="timeline-header mb-3 d-flex align-items-center justify-content-between">
                                    <div class="timeline-time">
                                        <?php echo get_the_date('Y.m.d - H:i'); ?>
                                    </div>
                                    <div class="d-flex align-items-start justify-content-between h-100">
                                        <div class="share-content flex-row" style="margin:0 !important;">
                                            <a href="#" class="copy-link pr" data-permalink="<?php echo $permalink; ?>" data-id="copylink_<?php echo $post->ID ?>">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" />
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" class="">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/Facebook-share.png" style="width:30px" />
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php echo $permalink; ?>" target="_blank">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/Twitter-share.png" style="width:30px" />
                                            </a>


                                            <div class="copy-message" data-id="copylink_<?php echo $post->ID ?>">
                                                URL másolva
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-content <?php echo $popular . $breaknews; ?>">
                                    <?php $terms = get_the_terms($post->ID, 'newstag');
                                            $term_list = array();
                                            foreach ($terms as $term) {
                                                $term_list[] = $term->slug;
                                            }
                                            if (stripos(json_encode($term_list), 'orosz-ukran-rovid') === false) : ?>
                                        <div class="inner-content">
                                            <a href="<?php echo $permalink; ?>" class="timeline-title">
                                                <?php echo get_the_title(); ?>
                                            </a>
                                            <?php the_content(); ?>
                                            <!-- permalink read more -->
                                            <a href="<?php echo $permalink; ?>" class="read-more">Read more</a>
                                        </div>
                                    <?php else : ?>
                                        <div class="content">
                                            <h3 class="timeline-title"><?php the_title(); ?></h3>
                                            <?php the_content(); ?>
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php endwhile;
                        wp_reset_query();
                    endif;
                    ?>
                </div>
                <?php

                $big = 999999999; // need an unlikely integer
                echo '<div class="text-center">';
                echo '<div class="page-links page cat aut">';
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $short_query->max_num_pages
                ));
                echo '</div>';
                echo '</div>';
                ?>
            </div>
            <div class="col-md-4 category-wide-sidebar">
                <?php if (is_active_sidebar('sidebar-5')) : ?>
                    <div class="news_sidebar category-sidebar">
                        <?php dynamic_sidebar('sidebar-5'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>