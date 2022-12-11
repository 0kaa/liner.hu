equalheight = function (container) {
  var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
  jQuery(container).each(function () {
    $el = jQuery(this);
    jQuery($el).height("auto");
    topPostion = $el.position().top;
    if (currentRowStart != topPostion) {
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
      rowDivs.length = 0; // empty the array
      currentRowStart = topPostion;
      currentTallest = $el.height();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest =
        currentTallest < $el.height() ? $el.height() : currentTallest;
    }
    for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
      rowDivs[currentDiv].height(currentTallest);
    }
  });
};

function sample_test() {
  alert("Function Called");
}
jQuery(window).load(function () {
  if (jQuery(window).width() > 767) {
    equalheight(".porta_right article");
  }
});
jQuery(window).resize(function () {
  if (jQuery(window).width() > 767) {
    equalheight(".porta_right article");
  }
});
jQuery(function ($) {
  $(".both-line.fancy").each(function () {
    $(this).wrapInner("<span />");
  });

  $(".menu_1ul li a.search_btn").click(function (e) {
    $(".menu_1ul li .search_panle").slideToggle();
    e.preventDefault();
  });
  if (jQuery("body").hasClass("single")) {
    const articleContent = document.querySelector('.article-textbody')
    const lastParagraph =
      articleContent.querySelectorAll('#liner_cikk_roadblock_1_2')[0]
    const connectionComponent = document.querySelector('.kapcsolodo_cikkek')
    if (lastParagraph && connectionComponent) {

      lastParagraph.parentNode.insertBefore(
        connectionComponent,
        lastParagraph.nextSibling
      )
    }


    // if .kapcsolodo_cikkek inside blockquote, move it outside jquery
    if ($('.kapcsolodo_cikkek').parent().is('blockquote')) {
      $('.kapcsolodo_cikkek').insertAfter('.article-textbody blockquote');
    }
  }


  if ($("body").hasClass("single-linernews")) {
    var $temp = $("<input>");
    var $url = $(location).attr("href");
    $(".author-detail ul.author-social li button.btn").on("click", function () {
      $("body").append($temp);
      $temp.val($url).select();
      document.execCommand("copy");
      $temp.remove();
      $(this).text("Link kimásolva!");
    });

    $(".post-social ul.social-sharing li button.btn").on("click", function () {
      $("body").append($temp);
      $temp.val($url).select();
      document.execCommand("copy");
      $temp.remove();
      $(this).text("Link kimásolva!");
    });

    $(".related_post").clone().insertAfter(".editor_content > *:eq(3)");
    $(".child_content > .related_post").remove();
  }

  if (jQuery(window).width() > 767) {
    var nav_offset_top = $(".site-masthead").height();
    function navbarFixed() {
      if ($(".site-masthead").length) {
        $(window).scroll(function () {
          var scroll = $(window).scrollTop();
          if (scroll >= nav_offset_top) {
            $(".site-masthead").addClass("navbar_fixed");
          } else {
            $(".site-masthead").removeClass("navbar_fixed");
          }
        });
      }
    }
    navbarFixed();
  }
});
/**  breaking news **/
jQuery(document).ready(function ($) {
  /* breaking bar close and other functions */
  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }
  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == " ") c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }
  function eraseCookie(name) {
    document.cookie =
      name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  }

  //on ready check if cookie exists
  if ($(".close_breaking_bar").length) {
    //get current breaking new id
    var show_br_news = 1;
    var close_b = $(".close_breaking_bar");
    var news_id = close_b.data("news-id");
    var cookie_name = "wp_news_" + news_id;
    //check cookie
    var x = getCookie(cookie_name);
    if (x) {
      console.log("cookie existes");
      //eraseCookie(cookie_name)
      //console.log('cookie delted');
      var show_br_news = 0;
    }
    if (show_br_news) {
      $(".breaking_bar").fadeIn();
      $(".breaking_bar_outer").fadeIn();

      //set breaking bar width on load
      var wcontainer = jQuery(".container ").width();
      jQuery(".breaking_bar").css("width", wcontainer);

      console.log("br news  show now");
    }
    //on close button click
    close_b.click(function (e) {
      //create cookie
      setCookie(cookie_name, news_id, 1);
      console.log("cookie created");

      //other actions
      $(".breaking_bar").fadeOut();
      jQuery("header").removeClass("move_header");
      jQuery(".breaking_bar").addClass("closed");
      e.preventDefault();
    });
  } else {
    console.log("no breaking  news");
  }

  // for inner page
  //news bar
  var sidebar = jQuery('.single_news .next-articles');
  if (sidebar) {
    var sidebar_top = sidebar.offset().top;
  }
  jQuery(window).scroll(function ($) {
    var scroll = jQuery(window).scrollTop();

    //console.log('show_br_news');
    // console.log(show_br_news);
    var is_single = jQuery("body").hasClass("single");
    //only add if signle page
    if (is_single) {
      if (scroll > 0 && show_br_news == 1) {
        var is_closed = jQuery(".breaking_bar").hasClass("closed");
        //console.log(is_closed);
        if (is_closed != true) {
          jQuery(".breaking_bar").addClass("breaking_bar_float");
          jQuery("header").addClass("move_header");
        }
      } else {
        jQuery(".breaking_bar").removeClass("breaking_bar_float");
        jQuery("header").removeClass("move_header");
      }
      if (scroll > sidebar_top) {
        sidebar.addClass('fixed');
      } else {
        sidebar.removeClass('fixed');
      }

      jQuery('.single_news').each(function () {
        // console.log('single_news', jQuery(this).attr('data-slug'));
        var element = jQuery(this)
        var element_top = element.offset().top;
        var element_height = element.height();
        var element_bottom = element_top + element_height;
        if (scroll > element_top && scroll < element_bottom) {
          jQuery('.related-article').removeClass('active');
          jQuery('.related-article[data-slug="' + jQuery(this).attr('data-slug') + '"]').addClass('active');
          var wcontainer = jQuery(this).innerHeight();
          var wscroll = jQuery(window).scrollTop();
          var wscroll_perc = ((wscroll - element_top) / (wcontainer)) * 100;


          // console.log(wscroll_perc)
          if (wscroll_perc <= 100) {
            jQuery('.related-article[data-slug="' + jQuery(this).attr('data-slug') + '"].active .divbar').css("width", wscroll_perc + "%");
          }

        }



        // if (jQuery(this).attr('data-slug') == currentPath) {
        //   jQuery('.related-article').removeClass('active');
        //   jQuery('.related-article[data-slug="' + currentPath + '"]').addClass('active');
        //   var wcontainer = jQuery('.single_news[data-slug="' + currentPath + '"]').height();
        //   var wscroll = jQuery(window).scrollTop();
        //   var wscroll_perc = (wscroll / wcontainer) * 100;
        //   if (wscroll_perc <= 100) {
        //     jQuery('.related-article[data-slug="' + currentPath + '"].active .divbar').css("width", wscroll_perc + "%");
        //   }
        // }

      });
    }
    // when scroll is equal element top position add class




    // var domain = window.location.protocol + '//' + window.location.hostname;
    // var path = window.location.href;
    // var currentPath = path.replace(domain + '/', '');
    // // remove / from the end of the path
    // currentPath = currentPath.replace(/\/$/, '');
    // jQuery('.related-article').removeClass('active');
    // jQuery('.related-article[data-slug="' + currentPath + '"]').addClass('active');

    // add width persentage to breaking bar based on scroll



  }); //eof scroll

  $(".weather-widget").each(function () {
    var i = 0;
    var currentWeather = weather[0].list[i];

    $(".weather-widget img").attr(
      "src",
      `${liner_global.baseUrl}/images/${currentWeather.weather[0].icon
        .replace("n", "")
        .replace("d", "")}.png`
    );
    $(".weather-widget .title strong").text(currentWeather.name);
    $(".weather-widget .graduak .value").text(
      Math.ceil(currentWeather.main.temp)
    );
    setInterval(function () {
      i++;
      if (i >= weather[0].list.length) {
        i = 0;
      }
      currentWeather = weather[0].list[i];
      // https://openweathermap.org/img/wn/<?php echo $weather['weather'][0]['icon'] ?>@2x.png
      $(".weather-widget img").attr(
        "src",
        `${liner_global.baseUrl}/images/${currentWeather.weather[0].icon
          .replace("n", "")
          .replace("d", "")}.png`
      );
      $(".weather-widget .title").text(currentWeather.name);
      $(".weather-widget .graduak .value").text(
        Math.ceil(currentWeather.main.temp)
      );
    }, 8000);
  });
  // add parent div to the image
  $(".instagram-media").each(function () {
    var $this = $(this);
    var parent = $this.parent();
    console.log(parent);
    if (parent.is(".embed-instagram")) {
      return false;
    } else {
      $this.wrap('<div class="embed-instagram"></div>');
    }
  });

  $(".button-nav-toggle").click(function () {
    $(this).toggleClass("active");
    $(this).find("i").toggleClass("fa-bars fa-times");
    // focus on search input
    $(".ham-menu").toggleClass("active");
    if ($(".ham-menu").hasClass("active") && window.innerWidth > 768) {
      $(".searchform input").focus();
    }
  });
  $(document).click(function (e) {
    if (
      e.target.classList.contains("button-nav-toggle") ||
      e.target.classList.contains("fa") ||
      e.target.closest(".ham-menu")
    ) {
      return;
    } else {
      $(".button-nav-toggle").removeClass("active");
      $(".button-nav-toggle")
        .find("i")
        .removeClass("fa-times")
        .addClass("fa-bars");
      $(".ham-menu").removeClass("active");
    }
  });
  $(".sub-menu").each(function () {
    // add button after sub menu
    $(this).after(
      '<button class="open-child-category"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
    );
  });
  $(".open-child-category").click(function () {
    $(this).find("i").toggleClass("fa-angle-right fa-minus");
    $(this).prev("ul").toggleClass("active");
  });
  var $temp = $("<input>");

  $(".copy-link.pr").on("click", function (e) {
    e.preventDefault();
    var $url = $(this).data("permalink");
    var id = $(this).data("id");

    $("body").append($temp);
    $temp.val($url).select();
    document.execCommand("copy");
    $temp.remove();
    $(`.copy-message[data-id="${id}"]`).text("URL másolva!");
    $(`.copy-message[data-id="${id}"]`).fadeIn(500).delay(1000).fadeOut(500);
  });
  if (window.innerWidth < 768) {
    $(".post-background-green,.post-background-yellow").each(function () {
      if ($(this).parent().find("img").parent().hasClass("article-card")) {
        $(this).parent().find("img").parent().find("img").addClass("d-none");
      } else {
        $(this).parent().find("img").parent().addClass("d-none");
      }
    });
  } else {
    $(".post-background-green,.post-background-yellow").each(function () {
      if ($(this).parent().find("img").parent().hasClass("article-card")) {
        $(this).parent().find("img").parent().find("img").removeClass("d-none");
      } else {
        $(this).parent().find("img").parent().removeClass("d-none");
      }
    });
  }
});

/** width fix on breaking news **/
jQuery(window).resize(function () {
  if (window.innerWidth < 768) {
    jQuery(".post-background-green,.post-background-yellow").each(function () {
      if (jQuery(this).parent().find("img").parent().hasClass("article-card")) {
        jQuery(this)
          .parent()
          .find("img")
          .parent()
          .find("img")
          .addClass("d-none");
      } else {
        jQuery(this).parent().find("img").parent().addClass("d-none");
      }
    });
  } else {
    jQuery(".post-background-green,.post-background-yellow").each(function () {
      if (jQuery(this).parent().find("img").parent().hasClass("article-card")) {
        jQuery(this)
          .parent()
          .find("img")
          .parent()
          .find("img")
          .removeClass("d-none");
      } else {
        jQuery(this).parent().find("img").parent().removeClass("d-none");
      }
    });
  }
  var wcontainer = jQuery(".container ").width();
  jQuery(".breaking_bar").css("width", wcontainer);
});
