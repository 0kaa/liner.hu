<?php
get_header();
$paged = (get_query_var('date')) ? get_query_var('date') : 1;
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

        <p>description we will change it </p>
        <div class="row">
            <div class="col-md-8 category-wide-section">
                <div class="key-points-section">
                    <h2 class="key-points-title">Key points</h2>
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
                        'posts_per_page'         =>    10,
                        // 'post__not_in'           => $postnotin,
                        'orderby'                => 'date',
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
                            ?>
                            <div class="timeline-item">
                                <div class="timeline-header mb-3 d-flex align-items-center justify-content-between">
                                    <div class="timeline-time">
                                        <?php echo get_the_date('H:i'); ?>
                                    </div>
                                    <div class="d-flex align-items-start justify-content-between share-parent h-100">
                                        <div class="share-content flex-row" style="margin:0 !important;">
                                            <a href="#" class="copy-link pr" data-permalink="<?php echo $permalink; ?>" id="copylink_<?php echo $post->ID ?>">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/copy.png" style="width:30px" />
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" class="facebook-share-icon">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/Facebook-share.png" style="width:30px" />
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php echo $permalink; ?>" target="_blank">
                                                <img src="<?php echo get_bloginfo("template_url"); ?>/images/Twitter-share.png" style="width:30px" />
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
                                <div class="timeline-content">
                                    <?php $terms = get_the_terms($post->ID, 'newstag');
                                            $term_list = array();
                                            foreach ($terms as $term) {
                                                $term_list[] = $term->slug;
                                            }
                                            if (stripos(json_encode($term_list), 'orosz-ukran-rovid') === false) : ?>
                                        <div class="inner-content">
                                            <h3 class="timeline-title"><?php echo get_the_title(); ?></h3>
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
            </div>
            <div class="col-md-4 category-wide-sidebar">
                <?php if (is_active_sidebar('sidebar-5')) : ?>
                    <div class="news_sidebar">
                        <?php dynamic_sidebar('sidebar-5'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>