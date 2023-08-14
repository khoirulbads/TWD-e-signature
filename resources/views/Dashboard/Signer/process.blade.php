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
              @endif
              <br>
                <div class="col-lg-8">
                  <div class="card">
                        <div class="image-container">
                            @if($pdfData->count == 1)
                            <img src="/assets/docs/{{$pdfData->folder}}/{{$fsub}}.png" alt="Base Image" style="width:100%" id="baseImg">
                            @endif
                            @if($pdfData->count > 1)
                            <img src="/assets/docs/{{$pdfData->folder}}/{{$fsub}}-{{$pdfData->count}}.png" alt="Base Image" style="width:100%;" id="baseImg">
                            @endif
                            <img id="overlayImage" class="overlay-image" src="/{{$pdfData->setting->signature}}" alt="Overlay Image" style="width:80px; position: absolute;
            top: 0;
            left: 0;
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
        
        baseImage.onload = function() {
                const imageWidth = baseImage.width;
                imageContainer.style.width = imageWidth + "px";
        };
            overlayImage.addEventListener("dragstart", function(e) {
                // Mengatur data untuk operasi drag
                e.dataTransfer.setData("text/plain", "");
                e.dataTransfer.setDragImage(overlayImage, 0, 0);
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
                // Buat elemen canvas
                const canvas = document.createElement("canvas");
                canvas.width = imageContainer.offsetWidth * 2;
                canvas.height = imageContainer.offsetHeight * 2;
                const ctx = canvas.getContext("2d");
                var Data =  @json($data);

                // Render div menjadi gambar menggunakan html2canvas
                html2canvas(imageContainer, {scale : 2}).then(function(canvas) {
                    // Gambar hasil rendering ke dalam canvas
                    ctx.drawImage(canvas, 0, 0, canvas.width, canvas.height);

                    // Simpan gambar dalam format PNG
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append("image", blob, "div_image.png");

                        fetch("/signer/submissions/save/"+Data.id, {
                            method: "POST",
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                    }, "image/png");
                });
            });
        });

    </script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    
@endpush