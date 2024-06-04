document.addEventListener('DOMContentLoaded', function() {//đổi màu thanh menu nav
  var menu = document.getElementById('menu');

  function updateMenuBackground() {
      if (window.pageYOffset > 0) {
          menu.style.background = 'rgba(233, 233, 235, 0.8)';
          menu.style.height = '71px'; // Màu nhạt hơn khi cuộn trang
      } else {
          menu.style.background = 'white';
          menu.style.height = '50px'; // Màu gốc
      }
  }

  window.addEventListener('scroll', updateMenuBackground);
});
/*document.addEventListener('DOMContentLoaded', function()   
  var fadeElements = document.querySelectorAll('.fade-content');

  function updateFadeElements() {
    for (var i = 0; i < fadeElements.length; i++) {
      var element = fadeElements[i];
      var rect = element.getBoundingClientRect();
      var viewportHeight = window.innerHeight || document.documentElement.clientHeight;

      // Kiểm tra xem phần tử có nằm dưới thanh menu hay không
      if (rect.top < viewportHeight) {
        element.classList.add('fade'); // Thêm class "fade" để áp dụng độ mờ
      } else {
        element.classList.remove('fade'); // Xóa class "fade" để không áp dụng độ mờ
      }
    }
  }

  window.addEventListener('scroll', updateFadeElements);
  window.addEventListener('resize', updateFadeElements);

  // Gọi hàm updateFadeElements lần đầu để cập nhật trạng thái ban đầu
  updateFadeElements();
});*/
document.addEventListener('DOMContentLoaded', function() {//thu nhỏ thanh menu
  var menu = document.getElementById('menu');

  function updateMenuSize() {
    if (window.pageYOffset > 0) {
      menu.classList.add('shrink'); // Thêm class "shrink" để áp dụng hiệu ứng thu nhỏ
    } else {
      menu.classList.remove('shrink'); // Xóa class "shrink" để không áp dụng hiệu ứng thu nhỏ
    }
  }

  window.addEventListener('scroll', updateMenuSize);

  // Gọi hàm updateMenuSize lần đầu để cập nhật trạng thái ban đầu
  updateMenuSize();
});
document.addEventListener('DOMContentLoaded', function() {
  var menu = document.getElementById('menu'); // Lấy thẻ có id là 'menu'
  var contentSections = document.querySelectorAll('section'); // Lấy tất cả các thẻ 'section'
  function updateMenuBackground() {
    var isMenuTransparent = false; // Biến để kiểm tra xem menu có đang trong trạng thái trong suốt hay không
    contentSections.forEach(function(section) {
      // Duyệt qua từng phần tử trong danh sách các phần tử 'section'
      var sectionRect = section.getBoundingClientRect(); // Lấy kích thước và vị trí của phần tử 'section'
      var menuRect = menu.getBoundingClientRect(); // Lấy kích thước và vị trí của menu
      if (sectionRect.top <= menuRect.bottom) {
        // Nếu phần tử 'section' đang nằm trên hoặc chồng lên phần tử menu
        isMenuTransparent = true; // Đánh dấu menu đang trong trạng thái trong suốt
        return; // Thoát khỏi vòng lặp forEach
      }
    });

    if (isMenuTransparent) {
      // Nếu menu đang trong trạng thái trong suốt
      menu.classList.add('transparent'); // Thêm lớp CSS 'transparent' vào menu để hiển thị màu nền trong suốt
    } else {
      // Ngược lại, menu không trong trạng thái trong suốt
      menu.classList.remove('transparent'); // Xóa lớp CSS 'transparent' khỏi menu để hiển thị màu nền thông thường
    }
  }
  // Gọi lại hàm 
  updateMenuBackground();

  // Thêm sự kiện scroll vào cửa sổ trình duyệt để gọi lại hàm updateMenuBackground khi trang được cuộn
  window.addEventListener('scroll', function() {
    updateMenuBackground();
  });
});

function toggleTextOverlay(item) {//section1 chạm ảnh để rõ thấy chữ và mất nội dung ban đầu 
  item.classList.toggle('show-text');
}
function toggleImageText(image) {
  var bottomText = document.getElementById('bottom-text');
bottomText.classList.add('hide');
}
//sách
const book = document.querySelector('.book');
const hiddenText = document.querySelector('.a1');

book.addEventListener('mouseover', () => {
  hiddenText.classList.remove('hidden');
});

book.addEventListener('mouseout', () => {
  hiddenText.classList.add('hidden');
});
const book1 = document.querySelector('.book1');
const hiddenText1 = document.querySelector('.a2');

book1.addEventListener('mouseover', () => {
  hiddenText1.classList.remove('hidden1');
});

book1.addEventListener('mouseout', () => {
  hiddenText1.classList.add('hidden1');
});
const book2 = document.querySelector('.book2');
const hiddenText2 = document.querySelector('.a3');

book2.addEventListener('mouseover', () => {
  hiddenText2.classList.remove('hidden2');
});

book2.addEventListener('mouseout', () => {
  hiddenText2.classList.add('hidden2');
});
 
//section3

// Lấy khung frame bằng ID hoặc lớp CSS
var frame = document.getElementById('frameId'); // Thay 'frameId' bằng ID của khung frame hoặc sử dụng các phương thức khác để lấy khung frame theo lớp CSS

// Ẩn thanh dọc kéo của khung frame
frame.style.overflow = 'hidden';
$(".custom-carousel").owlCarousel({
  autoWidth: true,
  loop: true
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

    // Tính toán chỉ số chấm tròn tương ứng theo thứ tự từ chấm 1 đến chấm 9
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
 