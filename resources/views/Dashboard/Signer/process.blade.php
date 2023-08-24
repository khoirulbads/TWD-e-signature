@extends ('Dashboard.layout')
@section('content')
<main id="main" class="main">
    @for ($i = 1; $i <= $pdfData->count ; $i++)
      <?php 
        $sub = substr($pdfData->old_name, 12);
        $fsub = substr($sub, 0, -4);
        
      ?>
    @endfor
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
              @if(Auth::user()->role == 2)
              <a href="javascript:history.back()" class="btn btn-secondary" >
                <i class="bi bi-chevron-left"></i>
                  Kembali  
              </a>
              <a href="#" id="saveBtn" class="btn btn-success" >
                <i class="bi bi-save"></i>
                  Simpan
              </a>
              <br>
              <br>
              @if($pdfData->count > 1)
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Pilih Halaman :</label>
                    <div class="col-sm-2">
                        <select class="form-select" aria-label="Default select example" id="page">
                            @for($i = 1; $i <= $pdfData->count ; $i++)
                                <option value="{{$i}}" @if($i == $pdfData->count) selected @endif>
                                    {{$i}}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
              @endif
              @endif
                <div class="col-lg-8">
                  <div class="card">
                        <div class="image-container" style="width:210mm">
                            @if($pdfData->count == 1)
                            <img src="/assets/docs/{{$pdfData->folder}}/{{$fsub}}.png" alt="Base Image" style="width:210mm;" id="baseImg">
                            @endif
                            @if($pdfData->count > 1)
                            <img src="/assets/docs/{{$pdfData->folder}}/{{$fsub}}-{{$pdfData->count}}.png" alt="Base Image" style="width:210mm;" id="baseImg">
                            @endif
                            <img id="overlayImage" class="overlay-image" src="/{{$pdfData->setting->signature}}" alt="Overlay Image" style="width:200px; position: absolute;
                                top: 210mm;
                                left: 150mm;
                                pointer-events: none;">
                        </div>
                    </div>
                </div>
              </div>
             
            <!-- Modal -->
              
            <!-- <div class="modal fade" id="approveModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Setujui Dokumen</h5>
                      
                      <h5>Apakah anda ingin menyertakan tanda tangan?</h5>
                      <a href="#" class="btn btn-success" id="yesBtn" style="pointer-events:none;">
                            <i class="bi bi-check"></i>Ya, sertakan.
                      </a>
                      <a href="#" class="btn btn-danger" id="noBtn">
                            <i class="bi bi-x"></i>Tidak, paraf saja.
                      </a>

                          
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
              <!--endModal -->
        
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
@stop


@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageContainer = document.querySelector(".image-container");
        const overlayImage = document.getElementById("overlayImage");
        const baseImage = document.getElementById("baseImg");
        var pageSelected = 1;
        // baseImage.onload = function() {
        //         const imageWidth = baseImage.width;
        //         imageContainer.style.width = imageWidth + "px";
        // };
            overlayImage.addEventListener("dragstart", function(e) {
                // Mengatur data untuk operasi drag
                e.dataTransfer.setData("text/plain", "");
                e.dataTransfer.setDragImage(overlayImage, 0,0 );
            });

            imageContainer.addEventListener("dragover", function(e) {
                e.preventDefault();
            });

            imageContainer.addEventListener("drop", function(e) {
                e.preventDefault();
                const x = e.clientX - imageContainer.getBoundingClientRect().left;
                const y = e.clientY - imageContainer.getBoundingClientRect().top;
                
                const maxX = imageContainer.clientWidth - overlayImage.clientWidth;
                const maxY = imageContainer.clientHeight - overlayImage.clientHeight;

                if (x >= 0 && y >= 0 && x <= maxX && y <= maxY) {
                    overlayImage.style.left = x + "px";
                    overlayImage.style.top = y + "px";
                }

            });
         
            saveBtn.addEventListener("click", function() {
            // Ambil posisi overlay image dan base image
                const overlayRect = overlayImage.getBoundingClientRect();
                const baseRect = baseImage.getBoundingClientRect();
                var Data =  @json($data);
                // Hitung perbedaan antara posisi overlay image dan garis tepi base image
                const differenceX = overlayRect.left - baseRect.left;
                const differenceY = overlayRect.top - baseRect.top;
                var pageSelect = pageSelected;
                console.log(pageSelected+"page");
                const formData = new FormData();
                        formData.append("x",differenceX*(210/baseImg.width));
                        formData.append("y",differenceY*(210/baseImg.width));
                        formData.append("size",200*(210/baseImg.width));
                        formData.append("page", pageSelect);
                        console.log(differenceY*(210/baseImg.width));
                        
                        fetch("/signer/submissions/save/"+Data.id+"?is_signature=yes", {
                            method: "POST",
                            body: formData,
                            redirect:"follow",
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => {
                          if(response.redirected){
                            window.location.href = response.url;
                          }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                    
            });

            $("#page").change(function() {
                var pdf =  @json($pdfData);
                var fsub =  @json($fsub);
                // console.log(baseImg.width*(210/baseImg.width));
                pageSelected = $(this).val();
                if(pageSelected == 1){
                    
                    $("#baseImg").attr("src", "/assets/docs/"+pdf.folder+"/"+fsub+".png");
                }else{
                    $("#baseImg").attr("src", "/assets/docs/"+pdf.folder+"/"+fsub+"-"+pageSelected+".png");    
                }
                
            });
        });

    </script>
    <!-- <script>
        $(document).ready(function() {
            
            $("#page").change(function() {
                var pdf =  @json($pdfData);
                var fsub =  @json($fsub);
                
                var pageSelected = $(this).val();
                if(pageSelected == 1){
                    
                    $("#baseImg").attr("src", "/assets/docs/"+pdf.folder+"/"+fsub+".png");
                }else{
                    $("#baseImg").attr("src", "/assets/docs/"+pdf.folder+"/"+fsub+"-"+pageSelected+".png");    
                }
                
            });
        });
    </script> -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endpush