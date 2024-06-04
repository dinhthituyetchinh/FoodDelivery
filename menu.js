$(document).ready(function ($) {
    "use strict";


    var book_table = new Swiper(".book-table-img-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,
        effect: "coverflow",
        coverflowEffect: {
            rotate: 3,
            stretch: 2,
            depth: 100,
            modifier: 5,
            slideShadows: false,
        },
        loopAdditionSlides: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    var team_slider = new Swiper(".team-slider", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 2000,

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });

    jQuery(".filters").on("click", function () {
        jQuery("#menu-dish").removeClass("bydefault_show");
    });
    $(function () {
        var filterList = {
            init: function () {
                $("#menu-dish").mixItUp({
                    selectors: {
                        target: ".dish-box-wp",
                        filter: ".filter",
                    },
                    animation: {
                        effects: "fade",
                        easing: "ease-in-out",
                    },
                    load: {
                        filter: ".all, .breakfast, .lunch, .dinner",
                    },
                });
            },
        };
        filterList.init();
    });

    jQuery(".menu-toggle").click(function () {
        jQuery(".main-navigation").toggleClass("toggled");
    });

    jQuery(".header-menu ul li a").click(function () {
        jQuery(".main-navigation").removeClass("toggled");
    });

    gsap.registerPlugin(ScrollTrigger);

    var elementFirst = document.querySelector('.site-header');
    ScrollTrigger.create({
        trigger: "body",
        start: "30px top",
        end: "bottom bottom",

        onEnter: () => myFunction(),
        onLeaveBack: () => myFunction(),
    });

    function myFunction() {
        elementFirst.classList.toggle('sticky_head');
    }

    var scene = $(".js-parallax-scene").get(0);
    var parallaxInstance = new Parallax(scene);


});


jQuery(window).on('load', function () {
    $('body').removeClass('body-fixed');// Xóa lớp CSS 'body-fixed' khỏi phần tử <body>. 

    //activating tab of filter
    let targets = document.querySelectorAll(".filter");//ấy tất cả các phần tử có lớp CSS là 'filter' và lưu trữ chúng trong một mảng gọi là 'targets'.
    let activeTab = 0;// Thiết lập giá trị mặc định của tab được chọn là 0 (đầu tiên).
    let old = 0;// Biến 'old' được sử dụng để lưu trữ tab trước đó được chọn.
    let dur = 0.4;// Thiết lập thời gian mặc định cho các hiệu ứng chuyển động là 0.4 giây.
    let animation;//Khai báo một biến 'animation' để lưu trữ các hiệu ứng chuyển động

    for (let i = 0; i < targets.length; i++) {
        targets[i].index = i;
        targets[i].addEventListener("click", moveBar);
    }//Vòng lặp for dùng để gắn một sự kiện "click" cho mỗi phần tử 'filter'. Khi một phần tử 'filter' được nhấp vào, hàm moveBar() sẽ được gọi.

    // initial position on first === All 
    gsap.set(".filter-active", {
        x: targets[0].offsetLeft,
        width: targets[0].offsetWidth
    });//: Thiết lập vị trí ban đầu của phần tử có lớp CSS là 'filter-active'  dựa trên vị trí và chiều rộng của tab đầu tiên.

    function moveBar() {//được gọi khi một tab được nhấp vào. Nếu tab được nhấp vào khác với tab hiện tại (activeTab), các hiệu ứng chuyển động sẽ được tạo ra.
        if (this.index != activeTab) {//Kiểm tra xem có một hiệu ứng chuyển động đang hoạt động hay không
            if (animation && animation.isActive()) {
                animation.progress(1);
            }
            animation = gsap.timeline({//: Tạo một timeline (dòng thời gian) mới để lưu trữ các hiệu ứng chuyển động.
                defaults: {
                    duration: 0.4
                }
            });
            old = activeTab;//Lưu trữ giá trị của tab hiện tại vào biến 'old'.
            activeTab = this.index;//Gán giá trị của tab được nhấp vào biến 'activeTab'.
            animation.to(".filter-active", {//
                x: targets[activeTab].offsetLeft,
                width: targets[activeTab].offsetWidth
            });//Tạo hiệu ứng chuyển động cho phần tử có lớp CSS là 'filter-active', di chuyển nó đến vị trí và chiều rộng của tab mới được chọn.

            animation.to(targets[old], {//tạo hiệu ứng chuyển động cho tab trước đó được chọn (có chỉ số 'old')
                color: "#0d0d25",
                ease: "none"
            }, 0);
            animation.to(targets[activeTab], {//: Tạo hiệu ứng chuyển động cho tab mới được chọn (có chỉ số 'activeTab'), thay đổi màu sắc của nó thành "#fff" (màu trắng).
                color: "#fff",
                ease: "none"
            }, 0);

        }

    }
});