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
?>
<div class="container">
    <div id="primary">
        <div class="sztorid-section">
            <div class="sztorid-img">
                <img src="<?php echo get_template_directory_uri() ?>/images/sztorid.png" alt="ads" class="img-fluid">
            </div>
            <h1 class="sztorid-title">Van egy sztorid?</h1>
            <p class="sztorid-paragraph">Szemtanúja voltál valaminek, vagy épp van egy olyan történeted, melyet szívesen megosztanál másokkal?
                Küldd el nekünk, és amennyiben érdekesnek találjuk, úgy közzétesszük azt oldalunkon.</p>
        </div>
        <div class="">
            <form class="mb-5" method="post" id="contactForm" name="contactForm">
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <input type="email" class="form-control py-4" name="email" id="email" placeholder="Email-cím">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <input type="text" class="form-control py-4" name="name" id="name" placeholder="Name">
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 form-group mb-3">
                        <textarea class="form-control" name="message" id="message" cols="30" rows="8" placeholder="Message"></textarea>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 form-group text-center">
                        <input type="submit" value="Submit" class="btn btn-block btn-primary rounded-0 py-2 px-4">
                        <input type='hidden' name='action' value='liner_contact_us' />
                        <span class="submitting"></span>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- #primary -->

</div>
<?php get_footer(); ?>