<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */

get_header(); ?>
<!--<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/all.js#xfbml=1&version=v9.0" nonce="lxEL1L0D"></script>-->

<div class="container" style='display:none;'>
<div class="single_news">
	<?php
		while ( have_posts() ) :
			the_post();
			//$child_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full' );
			$newstype = get_field('news_type',$post->ID);
			$vdolnk = get_field('video_url',$post->ID);
			$sldrimg = acf_photo_gallery('slider_images',$post->ID);

			if($newstype == 'video'){
              $sldrimg = '';
            }elseif($newstype == 'slider'){
              $vdolnk = '';
            }else{
              $vdolnk = '';
              $sldrimg = '';
            }
?>
	<div class="row"><div class="col-sm-12"><h1 class="page_title text-center"><?php the_title(); ?></h1></div></div>
	</div>
</div>
<div class="text-center">
	<div class="page_banner longform">

	<?php
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
          $vdolnk = '';
          $sldrimg = '';
		$caption = '';
          $child_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'singlepagebanner-thumb' );

          if($child_thumb){
          	$image_cap = wp_get_attachment_caption(get_post_thumbnail_id($post->ID) );
			  if(!empty($image_cap)){
				  $caption = '<span>'.$image_cap.'</span>';
			  }else{
				  $caption = '';
			  }
          	echo '<img src="'.$child_thumb[0].'" class="img-responsive" />'.$caption;
          }else{
			echo '<img src="'.get_bloginfo("template_url").'/images/slide.jpg" class="img-responsive" />';
          }

        }
	?>
	<h1 class="page_title text-center"><?php the_title(); ?></h1>
	<h3>Szerző: <?php the_field('news_author'); ?></h3>
	<div class="excerpt-content">
				<?php the_excerpt(); ?>
			</div>
</div>
	</div>
<div class="container longform 100">
<div class="single_news longform">
	<div class="row">
	<div class="col-sm-12">
		<div class="child_content">
			<div class="author-detail">
				<div class="author-img pull-left">
					<!--img src="<?php echo get_bloginfo("template_url");?>/images/avtar.jpg"-->

				<?php
					//Assuming $post is in scope
					//echo '<pre>';
					//print_r($post);
					//echo '</pre>';

					if (function_exists ( 'mt_profile_img' ) ) {
						$author_id=$post->post_author;
						mt_profile_img( $author_id, array(
							'size' => 'thumbnail',
							'attr' => array( 'alt' => 'not image ' ),
							'echo' => true )
						);
					}
					?>
				</div>
				<div class="author-desc pull-left">
					<h3><?php the_field('news_author'); ?></h3>
					<p><?php echo  get_the_date('Y. F. j - '); ?> <?php echo get_the_time('H:i'); ?></p>
				</div>
				<?php
					$website = get_field('website-url',$post->ID);
					//$facebooklink = get_field('facebook-url',$post->ID);
					$twitterlink = get_field('twitter-url',$post->ID);
				?>
				<ul class="author-social pull-right">
				   	<li><button class="btn" id="copylink1_<?php echo $post->ID ?>">Link másolása</button></li><li><a class="google" target="_blank" href="https://news.google.com/publications/CAAqBwgKMKulmQswy6-xAw?hl=hu&gl=HU&ceid=HU%253Ahu">Google hírek</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<!--div class="excerpt-content">
				<?php //the_excerpt(); ?>
			</div-->
			<div class="editor_content"><?php the_content(); ?>
			<?php 
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'liner' ),
					'after'  => '</div>',
				)
			);
			
			
			//get_template_part( 'content', get_post_format() ); ?></div>
			<div class="post-social clr">

				<ul class="social-sharing">
				   	<li><button class="btn" id="copylink_<?php echo $post->ID ?>">Link másolása</button></li><li><a class="google" target="_blank" href="https://news.google.com/publications/CAAqBwgKMKulmQswy6-xAw?hl=hu&gl=HU&ceid=HU%253Ahu">Google hírek</a></li><li></li>
				</ul>

	   		</div>
			<div class="related_post"><?php //echo do_shortcode( '[crp limit=2 heading=1]' );?> 	<?php echo do_shortcode( '[recommended_articles]' );?></div>
			<div class="comment_content"><?php comments_template( '', true ); ?></div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 d-none">
		<?php if(is_active_sidebar( 'sidebar-5' )) : ?>
		<div class="news_sidebar">
			<?php dynamic_sidebar( 'sidebar-5' ); ?>
		</div>
		<?php endif; ?>

		<div class="sdbrstcky_post">
			<?php echo do_shortcode('[sidebar-sticky]');?>
		</div>
	</div>
	<div class="col-sm-12">
			<div class="missit-sec">
				<div class="title">
					<h3>Ne Hagyd Ki</h3>
				</div>
			<?php //echo do_shortcode('[section-3 tag="macron"]');
				echo do_shortcode('[dontmiss_news]');
			?>

		</div>
</div>
</div>

	<?php endwhile; // end of the loop. ?>
</div></div>
<?php get_footer(); ?>
