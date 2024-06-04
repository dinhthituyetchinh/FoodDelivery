$(".custom-carousel").owlCarousel({
    autoWidth: true,//cho phép chiều rộng tự động
    loop: true//vòng lặp vô hạn
  });
  $(document).ready(function () {
    $(".custom-carousel .item").click(function () {
      $(".custom-carousel .item").not($(this)).removeClass("active");
      $(this).toggleClass("active");
    });
  });
  $(document).ready(function() {
    var owl = $('.custom-carousel');
    owl.owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true
    });
  
    owl.on('changed.owl.carousel', function(event) {
      var currentItemIndex = event.item.index;
      $('.slider-dot').removeClass('active');
  
      // Tính toán chỉ số chấm tròn tương ứng theo thứ tự từ chấm 1 đến chấm 6
      var dotIndex = currentItemIndex % 9;
  
      $('.slider-dot').eq(dotIndex).addClass('active');
    });
  
    var slideCount = $('.custom-carousel .item').length;
    var visibleDotCount = 9;
    var sliderDots = $('<div class="slider-dots"></div>');
    for (var i = 0; i < slideCount; i++) {
      var dot = $('<div class="slider-dot"></div>');
      if (i === 0) {
        dot.addClass('active');
      }
      if (i < visibleDotCount) {
        sliderDots.append(dot);
      }
    }
    $('.custom-carousel').after(sliderDots);
  });
  // cài đặt và tạo ra một carousel có các chức năng như trình chiếu ảnh tự động, 
  //nút điều hướng, chấm tròn điều hướng và chuyển đổi lớp active khi nhấp vào các phần tử của carousel.
  