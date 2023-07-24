@extends ('Dashboard.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Pengajuan Berkas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Dashboard</a></li>
          <li class="breadcrumb-item active">Setting</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
    @if(!$data)
    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        Anda belum mengatur tanda tangan dan paraf, silakan isi form di bawah !!
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
      @if(Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
                {{Session::get('success')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::get('warning'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
                {{Session::get('warning')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::get('danger'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
                {{Session::get('danger')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if($data && $data->signature)
            <img src="{{env('APP_URL')}}/{{$data->signature}}" alt="Profile" >
            @else
            <h2 style="color:red">Belum ada Tanda Tangan</h2>
            @endif
            <h3>Tanda Tangan</h3>
            <div class="pt-2">
            <form class="row g-3" method="POST" action="/signer/setting/save" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingName" accept=".png,.jpg,.jpeg" placeholder="Berkas" name="signature" required="">
                    <p style="color: orange; font-size: 10px">File harus berupa gambar</p>
                    <label for="floatingName">Upload Tanda Tangan</label>
                  </div>
                </div>
                <div class="d-grid gap-2 mt-3">
                  <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
              </form><!-- End floating Labels Form -->
          </div>
                      
            </div>

            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if($data && $data->paraf)
            <img src="{{env('APP_URL')}}/{{$data->paraf}}" alt="Profile" >
            @else
            <h2 style="color:red">Belum ada Paraf</h2>
            @endif
            <h3>Paraf</h3>
            <div class="pt-2">
            <form class="row g-3" method="POST" action="/signer/setting/save" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingName" accept=".png,.jpg,.jpeg" placeholder="Berkas" name="paraf" required="">
                    <p style="color: orange; font-size: 10px">File harus berupa gambar</p>
                    <label for="floatingName">Upload Paraf</label>
                  </div>
                </div>
                <div class="d-grid gap-2 mt-3">
                  <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
              </form><!-- End floating Labels Form -->
          </div>
                      
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Setting</button>
                </li>
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="POST" action="/signer/setting/save" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                  
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Signer</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="hidden" name="setting_data" value="data">
                        <input name="signer_name" type="text" class="form-control" id="fullName" placeholder="Anton, S.H." 
                        @if($data && $data->signer_name)
                        value="{{$data->signer_name}}"
                        @endif
                        >
                        </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Lokasi</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="location" type="text" class="form-control" id="company" placeholder="Bali"
                        @if($data && $data->location)
                        value="{{$data->location}}"
                        @endif
                        >
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="department" type="text" class="form-control" id="company" placeholder="Direktur"
                        @if($data && $data->department)
                        value="{{$data->department}}"
                        @endif
                        ></div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Email Law Firm</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="legal_email" type="text" class="form-control" id="company" placeholder="lawfirm@gmail.com"
                        @if($data && $data->legal_email)
                        value="{{$data->legal_email}}"
                        @endif
                        ></div>
                    </div>

                    <div  class="d-grid gap-2 mt-3">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->
@stop