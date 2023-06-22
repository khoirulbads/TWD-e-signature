@extends ('Dashboard.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Detail</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Dashboard</a></li>
          <li class="breadcrumb-item"><a>Pengajuan Berkas</a></li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <a href="/signee/submissions" class="btn btn-secondary" >
                <i class="bi bi-chevron-left"></i>
                  Kembali  
                </a>
              <br>
                <div class="col-xl-12">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                 
                  <h5 class="card-title">Detail Pengajuan</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Judul Berkas</div>
                    <div class="col-lg-9 col-md-8">{{$data->title}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">{{$data->description}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tgl Pengajuan</div>
                    <div class="col-lg-9 col-md-8">{{$data->created_at}}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Terakhir diubah</div>
                    <div class="col-lg-9 col-md-8">{{$data->updated_at}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8">
                    @if($data->status == 1)
                    <span class="badge bg-warning">pending</span>
                    @endif
                    @if($data->status == 2)
                    <span class="badge bg-success">disetujui</span>
                    @endif
                    @if($data->status == 3)
                    <span class="badge bg-danger">ditolak</span>
                    @endif
                    @if($data->status == 4)
                    <span class="badge bg-secondary">dibatalkan</span>
                    @endif
                    </div>
                  </div>

                    </div>
                    <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Berkas</h5>

              <!-- Default Accordion -->
              <div class="accordion" id="accordionExample">
                @php 
                    $i = 1;
                @endphp
                @foreach($data->documents as $docs)
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Berkas #v{{$i}}   
                    @if($data->status == 1)
                    <span class="badge bg-warning">pending</span>
                    @endif
                    @if($data->status == 2)
                    <span class="badge bg-success">disetujui</span>
                    @endif
                    @if($data->status == 3)
                    <span class="badge bg-danger">ditolak</span>
                    @endif
                    @if($data->status == 4)
                    <span class="badge bg-secondary">dibatalkan</span>
                    @endif
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <a href="{{env('APP_URL')}}/{{$docs->file_name}}" target="_blank" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Buka Dokumen" >
                        <i class="bi bi-file-earmark-pdf" ></i> Buka Dokumen
                    </a>
                    <br>
                    terakhir diubah <strong>{{$docs->updated_at}}</strong>
                    <br>
                    <br>{{$docs->deleted_at}}
                    @if($docs->notes)
                    <i>"{{$docs->notes}}"</i>
                    @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div><!-- End Default Accordion Example -->

            </div>
          </div>

        </div>

      </div>

                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->
@stop