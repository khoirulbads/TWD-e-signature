@extends ('Dashboard.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Pengajuan Berkas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Dashboard</a></li>
          <li class="breadcrumb-item"><a>Pengajuan Berkas</a></li>
          <li class="breadcrumb-item active">Pengajuan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
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
              <!-- Default Table -->
              <table class="table" id="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Berkas</th>
                    <th scope="col">Tgl Pengajuan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                    $i = 1;
                  @endphp
                  @foreach($data as $datas)
                  <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$datas->title}}</td>
                    <td>{{$datas->created_at}}</td>
                    @if($datas->status == 1)
                    <td><span class="badge bg-warning">pending</span></td>
                    @endif
                    @if($datas->status == 2)
                    <td><span class="badge bg-success">disetujui</span></td>
                    @endif
                    @if($datas->status == 3)
                    <td><span class="badge bg-danger">ditolak</span></td>
                    @endif
                    @if($datas->status == 4)
                    <td><span class="badge bg-secondary">dibatalkan</span></td>
                    @endif
                    <td>
                    <a href="/signer/submissions/{{$datas->id}}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Detail" >
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                      <!-- <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$datas->id}}" >
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="/dashboard/trainer/reset/{{$datas->id}}" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Anda yakin ingin reset password akun?')" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Password">
                        <i class="bi bi-key"></i>
                      </a>
                      <a href="/dashboard/trainer/delete/{{$datas->id}}" class="btn btn-danger btn-sm" 
                        onclick="return confirm('Anda yakin ingin menghapus data?')" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                        <i class="bi bi-trash"></i>
                      </a> -->
                    </td>
                  </tr>
                  @endforeach  
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
           <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tambah Pengajuan</h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="POST" action="/signee/submissions" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="Proposal Keuangan" name="title" required="">
                    <label for="floatingName">Judul Berkas</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Proposal Keuangan tahun 2020" id="floatingTextarea" style="height: 100px;" name="description"></textarea>
                    <label for="floatingTextarea">Deskripsi</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="file" class="form-control" id="floatingName" accept=".pdf" placeholder="Berkas" name="document" required="">
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

    @foreach ($data as $datas)
    <div class="modal fade" id="editModal{{$datas->id}}" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
           <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Pengajuan</h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="POST" action="/signee/submissions/update/{{$datas->id}}" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="Proposal Keuangan" name="title" required="" value="{{$datas->title}}">
                    <label for="floatingName">Judul Berkas</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Proposal Keuangan tahun 2020" id="floatingTextarea" style="height: 100px;" name="description" >{{$datas->description}}</textarea>
                    <label for="floatingTextarea">Deskripsi</label>
                  </div>
                </div>
                <div class="col-md-12">
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

    @endforeach

<!-- End Modal -->
  </main><!-- End #main -->
@stop