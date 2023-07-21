<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="/uliya-html/images/logo-1.png" type="image/x-icon">
  <title>SIGNaja.com - Beranda</title>


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
                  SIGNaja.com
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
                      SIGNaja <br>
                      
                    </h1>
                    <p>
                        Platform berbasi website penyedia Tanda Tangan Digital untuk membuat dokumen anda lebih aman.  
                    </p>
                    <div class="btn-box">
                      
                      <a href="/auth/login" class="btn-1">
                        Login</i>
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
      <div class="fl scanner" id="scanner" >
        <center> 
          <div id="reader" style="width: 300px;" ></div>
          <div id="verifiedImg" style="display:none">
            <img src="{{asset('/uliya-html/images/verified.png')}}" alt="" style="width:300px" >    
          </div>
          </center>      
      </div>
      <input type="hidden" placeholder="ID Partner" name="idPartner" id="idPartner" value="" required> 
      <div class="box">
        <div id="dataDetail">

        </div>
        <div class="detail-box">
          <div>
            <button id="scanBtn" style="display: inline-block; background-color: blue; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Scan Dokumen
            </button>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- end about section -->


  <!-- footer section -->
  <section class="container-fluid footer_section">
    <div class="container">
      <p>
        &copy; {{date('Y')}} All Rights Reserved By SIGNaja.com
      </p>
    </div>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="{{asset('/uliya-html/js/jquery-3.4.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/uliya-html/js/bootstrap.js')}}"></script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


<script type="text/javascript">
  const readerDiv = document.getElementById("reader");
  const img = document.getElementById("verifiedImg");
  const btn = document.getElementById("scanBtn");
  
  const formatsToSupport = [
      Html5QrcodeSupportedFormats.QR_CODE
   ];
   const html5QrCode = new Html5Qrcode("reader");

   const qrCodeSuccessCallback = (decodedText, decodedResult) => {
      /* handle success */
      console.log(`Code matched = ${decodedText}`, decodedResult);
      
      readerDiv.style.display = "none";
      img.style.display = "block";


    };
  
   const config = { fps: 10, qrbox: { width: 200, height: 200, formatsToSupport: formatsToSupport} };
   
   btn.addEventListener('click', () => {
        // Toggle the display property of the div
        if (readerDiv.style.display === 'none') {
            readerDiv.style.display = 'block';
            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);

        } else {
            readerDiv.style.display = 'none';
        }
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>