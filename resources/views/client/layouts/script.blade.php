<script type="text/javascript" src="{{ asset('bower_components/bower/client/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('bower_components/bower/client/js/bootstrap.min.js') }}">
</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="{{ asset('bower_components/bower/client/js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/client/js/move-top.js') }}"></script>
<script defer src="{{ asset('bower_components/bower/client/js/jquery.flexslider.js') }}">
</script>
<script src="{{ asset('bower_components/bower/client/js/jquery.magnific-popup.js')}}" type="text/javascript">
</script>
<script src="{{ asset('bower_components/bower/client/js/jquery.slidey.js') }}">
</script>
<script src="{{ asset('bower_components/bower/client/js/jquery.dotdotdot.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('bower_components/bower/client/js/toastr.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/fileinput.min.js') }}"></script>
<script type="application/x-javascript"> 
	addEventListener("load", function() { 
		setTimeout(hideURLbar, 0); 
	}, false);
	function hideURLbar(){ 
		window.scrollTo(0,1); 
	}
	$(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".scroll").click(function(event){		
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });

        $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
                $(this).toggleClass('open');        
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
                $(this).toggleClass('open');       
            }
            );

        $('.toggle').click(function(){
            $(this).children('i').toggleClass('fa-pencil');	
            $('.form').animate({
                height: "toggle",
                'padding-top': 'toggle',
                'padding-bottom': 'toggle',
                opacity: "toggle"
            }, "slow");
            $('.form').trigger('reset');
            $('invalid-feedback').css({'display' : 'none'});
            $('invalid-feedback').find('strong').text('');
        });
    });

    $("#owl-demo-1").owlCarousel({
        items:6,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:3000,
        animateOut: 'slideOutDown',
        itemsDesktop : [640,4],
        itemsDesktopSmall : [414,3]

    });

    $('.w3_play_icon,.w3_play_icon1,.w3_play_icon2').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
    });

    $().UItoTop({ easingType: 'easeOutQuart' });

    $("#slidey").slidey({
        interval: 8000,
        listCount: 5,
        autoplay: false,
        showList: true
    });

    $(".slidey-list-description").dotdotdot();
    
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-149859901-1');

    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga('create', 'UA-149859901-1', 'demo.w3layouts.com');
    ga('require', 'eventTracker');
    ga('require', 'outboundLinkTracker');
    ga('require', 'urlChangeTracker');
    ga('send', 'pageview');

    $(window).load(function(){
        $('.flexslider').flexslider({
           animation: "slide",
           start: function(slider){
              $('body').removeClass('loading');
          }
      });
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
       }else{
           return true;
       }
   }

   function ValidateForm() {
    var flag = true;
    var name = document.forms["form_register"]["name"].value;
    var email= document.forms["form_register"]["email"].value;
    var password = document.forms["form_register"]["password"].value;
    var rpassword= document.forms["form_register"]["rpassword"].value;
    document.getElementById('error_email_1').parentElement.style.display = 'none';
    document.getElementById('error_name_1').parentElement.style.display = 'none';
    document.getElementById('error_password_1').parentElement.style.display = 'none';
    document.getElementById('error_rpassword_1').parentElement.style.display = 'none';
    if (name == null || name == "") {
       document.getElementById('error_name_1').parentElement.style.display = 'block';
       document.getElementById('error_name_1').innerHTML = 'Mời bạn nhập tên';
       flag = false;
   }
   if (email == null || email == "") {
       document.getElementById('error_email_1').parentElement.style.display = 'block';
       document.getElementById('error_email_1').innerHTML = 'Mời bạn nhập email';
       flag = false;
   } else if (!IsEmail(email)) {
       document.getElementById('error_email_1').parentElement.style.display = 'block';
       document.getElementById('error_email_1').innerHTML = 'Email không đúng định dạng';
       flag = false;
   }
   if (password == null || password == "") {
       document.getElementById('error_password_1').parentElement.style.display = 'block';
       document.getElementById('error_password_1').innerHTML = 'Mời bạn nhập mật khẩu';
       flag = false;
   }
   if (rpassword == null || rpassword == "") {
       document.getElementById('error_rpassword_1').parentElement.style.display = 'block';
       document.getElementById('error_rpassword_1').innerHTML = 'Mời bạn nhập mật khẩu';
       return false;
   } else if (rpassword != password) {
       document.getElementById('error_rpassword_1').parentElement.style.display = 'block';
       document.getElementById('error_rpassword_1').innerHTML = 'Mật khẩu không khớp';
       flag = false;
   }
   return flag;
}

function ValidateFormLogin() {
    var flag = true;
    var email= document.forms["form_login"]["email"].value;
    var password = document.forms["form_login"]["password"].value;
    document.getElementById('error_email_2').parentElement.style.display = 'none';
    document.getElementById('error_password_2').parentElement.style.display = 'none';
    if (email == null || email == "") {
       document.getElementById('error_email_2').parentElement.style.display = 'block';
       document.getElementById('error_email_2').innerHTML = 'Mời bạn nhập email';
       flag = false;
   } else if (!IsEmail(email)) {
       document.getElementById('error_email_2').parentElement.style.display = 'block';
       document.getElementById('error_email_2').innerHTML = 'Email không đúng định dạng';
       flag = false;
   }
   if (password == null || password == "") {
       document.getElementById('error_password_2').parentElement.style.display = 'block';
       document.getElementById('error_password_2').innerHTML = 'Mời bạn nhập mật khẩu';
       flag = false;
   }
   return flag;
}

function checkRating($this, key, rating, num) {
    if ( rating < num ) {
        $($this + key).find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star-half-o');
        $($this + key).find('input[value=' + num + ']').prop({"checked": true});

        return false;
    } else if (rating > num) {
        $($this + key).find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star');
        $($this + key).find('input[value=' + num + ']').prop({"checked": true});
    } else {
        $($this + key).find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star');
        $($this + key).find('input[value=' + num + ']').prop({"checked": true});

        return false;
    }

    return true;
}
function setRating($this,rating, key) {
    if (checkRating($this, key, rating, 0)) {
        if (checkRating($this, key, rating, 1)) {
            if (checkRating($this, key, rating, 2)) {
                if (checkRating($this, key, rating, 3)) {
                    if (checkRating($this, key, rating, 4)) {
                        if (checkRating($this, key, rating, 5)) {

                        }
                    }
                }
            }
        }
    }
}
</script>
@yield('script')