// project carousel
// $(".blogCarousal").owlCarousel({
//     loop: true,
//     margin: 30,
//     autoplay: true,
//     autoplaySpeed: 1000,
//     dots: false,
//     responsiveClass: false,
//     responsive: {
//         0: {
//             items: 1,
//             nav: false
//         },
//         600: {
//             items: 2,
//             nav: false
//         },
//         1000: {
//             items: 4.5,
//             nav: false
//         }
//     }
// })


// toggling innovation popup
function toggleInnoPop() {
    $(".innovationPop").toggleClass('hidden flex');
}



$(document).ready(function () {

    // Praimary button icon changing
    $('.pbton').mouseenter(function () {
        $(this).children('.pbcon').attr('data-icon', 'uil:arrow-right');
    }).mouseout(function () {
        $(this).children('.pbcon').attr('data-icon', 'uil:angle-right');
    });



    // Slidein
    function isElementInViewport(element) {
        var rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.top <= (window.innerHeight || document.documentElement.clientHeight)
        );
    }

    var $elements = $(".showOnScroll");

    function viewportChecker() {
        $elements.each(function () {
            if (isElementInViewport(this)) {
                $(this).addClass("visible");
            } else {
                /* Removes Elements When Not In Viewport */
                //$(this).removeClass("visible");
            }
        });
    }

    $(window).on("load scroll", viewportChecker);
});


//------------------------
$(document).ready(function () {
    // Ajax csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#flip").click(function () {
        $("#panel").slideToggle("slow");
    });

    // Only number in text
    $('input.onlynumber').keyup(function (e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });

    $("#flashpop").fadeOut(3000);

    // Function to handle the scroll event
    $(window).scroll(function () {
        // Get the current scroll position
        var scrollTop = $(window).scrollTop();

        // Check if the user has scrolled down
        if (scrollTop > 0) {
            // Remove the class 'py-5' when scrolling down
            $('#mainnavigation').removeClass('py-5');
        } else {
            // Add the class 'py-5' when scrolling to the top
            $('#mainnavigation').addClass('py-5');
        }
    });
});

$("#ajaxflash").fadeOut(3000);
$("#notificationflush").fadeOut(3000);
// ===============Modal===========
(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".modal-link").on("click", function () {
            $("body").addClass("modal-open");
        });
        $(".close-modal").on("click", function () {
            $("body").removeClass("modal-open");
        });
    });
})(jQuery);
// ===============Test-swiper==========

// =================loadmore===========
$(function () {
    $(".service_box").slice(0, 8).show();
    $("body").on("click touchstart", ".load-more", function (e) {
        e.preventDefault();
        $(".service_box:hidden").slice(0, 4).slideDown();
        if ($(".service_box:hidden").length == 0) {
            $(".load-more").css("visibility", "hidden");
        }
    });
});

// ====================Gallery tab==============
$(".tabs-nav li:first-child").addClass("active");
$(".tab-content").hide();
$(".tab-content:first").show();

// Click function
$(".tabs-nav li").click(function () {
    $(".tabs-nav li").removeClass("active");
    $(this).addClass("active");
    $(".tab-content").hide();

    var activeTab = $(this).find("a").attr("href");
    $(activeTab).fadeIn();
    return false;
});

// ================Accordion============

/* jQuery
================================================== */
$(function () {
    $(".acc__title").click(function (j) {
        var dropDown = $(this).closest(".acc__card").find(".acc__panel");
        $(this).closest(".acc").find(".acc__panel").not(dropDown).slideUp();

        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
        } else {
            $(this).closest(".acc").find(".acc__title.active").removeClass("active");
            $(this).addClass("active");
        }

        dropDown.stop(false, true).slideToggle();
        j.preventDefault();
    });
});

// =====================



// Client Subscription -----------------------------
$('form#subscriptionForm').submit(function (e) {
    e.preventDefault();
    let subscribed = $('#subscriptionsuccess');
    $.ajax({
        method: 'POST',
        url: BASE_URL + 'subscribe',
        data: $('form#subscriptionForm').serialize(),
        success: function (response) {
            if (response.status == "success") {
                subscribed.html(response.message);
                $('form#subscriptionForm').trigger("reset");
                setTimeout(function () {
                    subscribed.html('');
                }, 5000);
            } else if (response.status == "error") {
                subscribed.html(response.message);
                setTimeout(function () {
                    subscribed.html('');
                }, 5000);
            }
        }
    });
});
// Client Subscription end -----------------------------



// Notification
// function sendMarkRequest(id = null) {

//     return $.ajax({
//         method: 'POST',
//         url: BASE_URL + 'markNotification',
//         data: {
//             id
//         }
//     });
//  }

//  Mark as reasds
//  $(function(){
//     $('.mark-as-read').click(function(e){

//         e.preventDefault();
//         let url = $(this).attr('href');
//         console.log(url);
//         let request = sendMarkRequest($(this).data('id'));

//         request.done(()=>{
//             $(this).parents('div.alert').remove();
//             $(location).attr('href', url);
//         });
//     });

//     $('#mark-all').click(function(){
//         let request = sendMarkRequest();

//         request.done(()=>{
//             let html = '<div class="py-10 text-center"><p class=" text-dgreen ">No Notification.</p> </div>';
//             $('div.tablinedot').remove();
//             $('#notificationdiv').html(html);
//         });
//     });
//  });


// Classic Editor function
// function createEditor(elementId) {
//     ClassicEditor
//         .create(document.querySelector(elementId), {
//             toolbar: {
//                 items: [
//                     'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo', '|', 'link', 'blockQuote'
//                 ],
//                 shouldNotGroupWhenFull: true
//             }
//         })
//         .catch(error => {
//             console.error(error);
//         });
// }
