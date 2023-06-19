<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="/uliya-html/images/logo-1.png" type="image/x-icon">
  <title>E-Signature - Beranda</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{asset('/uliya-html/css/bootstrap.css')}}" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('/uliya-html/css/style.css')}}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{asset('/uliya-html/css/responsive.css')}}" rel="stylesheet" />
</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-11 offset-lg-1">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
              <a class="navbar-brand" href="index.html">
                <img src="{{asset('/uliya-html/images/logo-1.png')}}" style="width:130%" alt="">
                <span>
                  E-Signature
                </span>
              </a>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                  <ul class="navbar-nav  ">
                    <li class="nav-item">
                      <a class="nav-link" href="/auth/login">login<i class="btn  my-2 my-sm-0 nav_login-btn"></i></a>
                    </li>
                  </ul> 
                </div>

              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-5 offset-md-1 ">
                  <div class="detail_box">
                    <h1>
                      E-Signature <br>
                      
                    </h1>
                    <p>
                        Platform berbasi website penyedia E-Signature untuk membuat dokumen anda lebih aman.  
                    </p>
                    <div class="btn-box">
                      <a href="" class="btn-1">
                        Cek Dokumen
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 px-0">
                  <div class="img-box">
                    <img src="{{asset('/uliya-html/images/slider-img.jpg')}}" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
         </div>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Cek Dokumen
        </h2>
      </div>
      <div class="box">
        <div class="img-box">
          <img src="{{asset('/uliya-htmlimages/about-img.jpg')}}" alt="">
          <div class="about_img-bg">
            <img src="{{asset('/uliya-htmlimages/about-img-bg.png')}}" alt="">
          </div>
        </div>
        <div class="detail-box">
          <p>
            It is a long established fact that a reader will be distracted by the readable content of a page when
            looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of
            letters,
          </p>
          <div>
            <a href="">
              about More
            </a>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- end about section -->
  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="info_container">
        <div class="info_social">
          <div class="d-flex justify-content-center">
            <h4 class="">
              Follow on
            </h4>
          </div>
          <div class="social_box">
            <a href="">
              <img src="images/fb.png" alt="">
            </a>
            <a href="">
              <img src="images/twitter.png" alt="">
            </a>
            <a href="">
              <img src="images/instagram.png" alt="">
            </a>
            <a href="">
              <img src="images/linkedin.png" alt="">
            </a>
            <a href="">
              <img src="images/dribble.png" alt="">
            </a>
            <a href="">
              <img src="images/pinterest.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->

  <!-- footer section -->
  <section class="container-fluid footer_section">
    <div class="container">
      <p>
        &copy; 2019 All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="{{asset('/uliya-html/js/jquery-3.4.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/uliya-html/js/bootstrap.js')}}"></script>

</body>

</html>