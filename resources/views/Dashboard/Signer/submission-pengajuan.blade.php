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
                    <th scope="col">Signee</th>
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
                    <td>{{$datas->signee->name}}</td>
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
                    @if (Auth::user()->role == 2)
                    <a href="/signer/submissions/{{$datas->id}}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Detail" >
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                    @endif
                    
                    @if (Auth::user()->role == 1)
                    <a href="/admin/submissions/{{$datas->id}}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Detail" >
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                    @endif  <!-- <a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$datas->id}}" >
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
  </main><!-- End #main -->
@stop