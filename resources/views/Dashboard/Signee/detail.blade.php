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
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              @if(Auth::user()->role == 3)
              <a href="/signee/submissions" class="btn btn-secondary" >
                <i class="bi bi-chevron-left"></i>
                  Kembali  
              </a>
              @endif
              @if(Auth::user()->role == 2)
              <a href="javascript:history.back()" class="btn btn-secondary" >
                <i class="bi bi-chevron-left"></i>
                  Kembali  
              </a>
              @endif
              @if(Auth::user()->role == 1)
              <a href="javascript:history.back()" class="btn btn-secondary" >
                <i class="bi bi-chevron-left"></i>
                  Kembali  
              </a>
              @endif
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
                      <h5 class="card-title">Unggahan Berkas</h5>
                      <!-- Default Accordion -->
                      <div class="accordion" id="accordionExample">
                        @php 
                            $i = 1;
                        @endphp
                        @foreach($data->documents as $docs)
                        @if($docs->status != 5)
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$docs->id}}" aria-expanded="true" aria-controls="collapseOne">
                              Berkas #v{{$i++}}

                            @if($docs->status == 1)
                            <span class="badge bg-warning">pending</span>
                            @endif
                            @if($docs->status == 2)
                            <span class="badge bg-success">disetujui</span>
                            @endif
                            @if($docs->status == 3)
                            <span class="badge bg-danger">ditolak</span>
                            @endif
                            @if($docs->status == 4)
                            <span class="badge bg-secondary">dibatalkan</span>
                            @endif
                            </button>
                          </h2>
                          <div id="collapse{{$docs->id}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
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
                        @endif
                        @endforeach
                        @if(Auth::user()->role == 2 && $data->status == 1)
                        <div class="d-grid gap-2 mt-3">
                          <a class="btn btn-success" 
                          data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="bi bi-check"></i>Setuju
                          </a>
                          <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x"></i>
                            Tolak  
                          </a>
                        </div>
                        @endif
                        @if(Auth::user()->role == 3 && $data->status == 3)
                        <div class="d-grid gap-2 mt-3">
                          <a data-bs-toggle="modal" data-bs-target="#reuploadModal" class="btn btn-success" >
                            <i class="bi bi-upload"></i>
                            Re-Upload Berkas
                          </a> 
                        </div>
                        @endif
                        
                      </div><!-- End Default Accordion Example -->
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Berkas disetujui</h5>
                      <!-- Default Accordion -->
                      <div class="accordion" id="accordionExample">
                        @php 
                            $i = 1;
                        @endphp
                        @foreach($data->documents as $docs)
                        @if($docs->status == 5)
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                          </h2>
                          <div id="collapse{{$docs->id}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <a href="{{env('APP_URL')}}/{{$docs->file_name}}" target="_blank" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Buka Dokumen" >
                                <i class="bi bi-file-earmark-pdf" ></i> Buka Dokumen
                            </a>
                            <br>
                            disetujui pada <strong>{{$docs->updated_at}}</strong>
                            <br>
                            <br>{{$docs->deleted_at}}
                            @if($docs->notes)
                            <i>"{{$docs->notes}}"</i>
                            @endif
                            </div>
                          </div>
                        </div>
                        @endif
                        @endforeach
                        </div><!-- End Default Accordion Example -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="rejectModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Tolak Berkas</h5>

                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="/signer/submissions/reject/{{$data->id}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                          <div class="col-12">
                            <div class="form-floating">
                              <textarea class="form-control" placeholder="Proposal Keuangan tahun 2020" id="floatingTextarea" style="height: 100px;" name="notes"></textarea>
                              <label for="floatingTextarea">Notes</label>
                            </div>
                          </div>
                          <div>
                            <button type="submit" class="btn btn-primary" >Save</button>
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          </div>
                        </form><!-- End floating Labels Form -->

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="reuploadModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Re-Upload Berkas</h5>

                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="/signee/submissions/reupload/{{$data->id}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                          <div class="col-12">
                          <div class="form-floating">
                              <input type="file" class="form-control" id="floatingName" accept=".pdf" placeholder="Berkas" name="document" >
                              <p style="color: orange; font-size: 10px">File harus format .pdf</p>
                              <label for="floatingName">Upload Berkas</label>
                            </div>
                          </div>
                          <div>
                            <button type="submit" class="btn btn-primary" >Save</button>
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          </div>
                        </form><!-- End floating Labels Form -->

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            <div class="modal fade" id="approveModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Setujui Dokumen</h5>
                      
                      <h5>Apakah anda ingin menyertakan tanda tangan?</h5>
                      <a href="#" class="btn btn-success" 
                      id="yesBtn">
                            <i class="bi bi-check"></i>Ya, sertakan.
                      </a>
                      <a href="#" class="btn btn-danger" 
                      id="noBtn">
                            <i class="bi bi-x"></i>Tidak, paraf saja.
                      </a>

                          
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!--endModal -->
        
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript code -->
<script>
$(document).ready(function() {
  
  var yes = $("#yesBtn");
  var no = $("#noBtn");
  var Data =  @json($data);
  
  yes.click(function(e) {
    e.preventDefault(); 
    e.stopPropagation();

    window.location.href = "/signer/submissions/approve/"+Data.id+"?is_signature=yes"; 
    
    yes.off("click");
    no.off("click"); 
  });
  no.click(function(e) {
    e.preventDefault(); 
    e.stopPropagation();

    window.location.href = "/signer/submissions/approve/"+Data.id+"?is_signature=no"; 
    
    yes.off("click");
    no.off("click"); 
  });
});
</script>


  </main><!-- End #main -->
@stop