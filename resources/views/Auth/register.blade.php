<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register | E-signature</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="shortcut icon" href="/NiceAdmin/assets/img/logo-1.png" type="image/x-icon">
  
  <!-- Favicons -->
  <!-- <link href="{{asset('/NiceAdmin/assets/img/favicon.png')}}" rel="icon"> -->
  <!-- <link href="{{asset('/NiceAdmin/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('/NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('/NiceAdmin/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('/NiceAdmin/assets/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">E-Signature</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Register Account</h5>
                  </div>

                  <form action="/auth/register" method="post" class="row g-3 needs-validation" novalidate>
                  {!! csrf_field() !!}
                    <div class="col-12">
                      <label for="name" class="form-label">Nama</label>
                      <input type="text" name="name" class="form-control" id="text" required>
                      <div class="invalid-feedback">Please enter your name!</div>
                    </div>
                    
                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$errors->first()}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have account? <a href="/auth/login">Login with your account</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('/NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('/NiceAdmin/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('/NiceAdmin/assets/js/main.js')}}"></script>

</body>

</html>