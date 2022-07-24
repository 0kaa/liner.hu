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
        <div class="contact-us-2 pb-4">
            <form class="mb-5" method="post" id="contactForm" name="contactForm">
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <input type="email" class="form-control py-4" name="email" id="email" placeholder="Email-cím">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <input type="text" class="form-control py-4" name="name" id="name" placeholder="Név">
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12 form-group mb-3">
                        <textarea class="form-control" name="message" id="message" cols="30" rows="8" placeholder="Üzenet"></textarea>
                    </div>
                </div>
                <div class="uploaded-files">
                </div>
                <div class="d-flex align-items-center justify-content-between flex-wrap form-bot">
                    <!-- input file -->
                    <!-- <input type="file" name="file" id="file" class="d-none" multiple> -->
                    <input type="file" class="my-pond w-100" id="file" name="file" />

                    <!-- <label for="file" class="upload-file-btn w-50">
                        <span>Upload attachments (Max <span class="uploaded-count">5</span>)</span>
                    </label> -->
                    <div class="flex-grow-1">
                        <input type="submit" value="Submit" class="contact-submit-btn">
                        <input type='hidden' name='action' value='liner_contact_us_2' />
                        <span class="submitting"></span>
                    </div>
                </div>
            </form>
            <div id="form-message-warning mt-4"></div>
            <div id="form-message-success">
                Üzenet elküldve, köszönjük!
            </div>
        </div>
    </div><!-- #primary -->

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">

<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script>
    jQuery(function($) {

        'use strict';

        // Form

        // Turn input element into a pond
        // var pond = $('.my-pond').filepond();

        // Turn input element into a pond with configuration options
        // $('.my-pond').filepond({
        //     required: true,
        //     allowMultiple: true,
        //     maxFiles: 3,
        //     name: 'file',
        //     storeAsFile: true,
        //     labelIdle: 'Húzd ide a fájlokat, vagy <span class="filepond--label-action">böngésés</span>',
        // });

        // Listen for addfile event
        // $('.my-pond').on('FilePond:addfile', function(e) {
        //     console.log('file added event', e);
        // });

        var pond = FilePond.create(
            document.querySelector('#file'), {
                allowMultiple: true,
                instantUpload: false,
                maxFiles: 3,
                name: 'file',
                allowProcess: false
            });

        var contactForm = function() {
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            if ($('#contactForm').length > 0) {
                $("#contactForm").validate({
                    rules: {
                        name: "required",
                        email: {
                            required: true,
                            email: true
                        },
                        message: {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        name: "Please enter your name",
                        email: "Please enter a valid email address",
                        message: "Please enter a message"
                    },
                    /* submit via ajax */
                    submitHandler: function(form) {
                        var waitText = 'Küldés folyamatban...';

                        var fd = new FormData(form);
                        // append files array into the form data
                        var pondFiles = pond.getFiles();
                        fd.delete('file');
                        for (var i = 0; i < pondFiles.length; i++) {
                            fd.append('file[]', pondFiles[i].file);
                        }



                        var ajax = $.ajax({
                            type: "POST",
                            //url: "php/send-email.php",
                            url: ajaxurl,
                            data: fd,
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,

                        });
                        if (ajax) {
                            $('#form-message-warning').hide();
                            setTimeout(function() {
                                $('#contactForm').fadeOut();
                            }, 1000);
                            setTimeout(function() {
                                $('#form-message-success').fadeIn();
                            }, 1400);
                        } else {
                            $('#form-message-warning').html("Something went wrong. Please try again.");
                            $('#form-message-warning').fadeIn();
                        }

                    }

                });
            }
        };
        contactForm();

    });
</script>

<?php get_footer(); ?>