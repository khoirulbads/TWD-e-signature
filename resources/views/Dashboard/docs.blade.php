<!DOCTYPE html>
<html>
  <head>
    <title>{{$data->id}}-signed.pdf</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  </head>
  <body>
    @for ($i = 1; $i <= $data->count ; $i++)
      <?php 
        $sub = substr($data->old_name, 12);
        $fsub = substr($sub, 0, -4);
      ?>
    @if($i == 1)
    <img src="assets/docs/{{$data->folder}}/{{$fsub}}.png" style="width:100%">
    @endif
    @if($i > 1)
    <img src="assets/docs/{{$data->folder}}/{{$fsub}}-{{$i}}.png" style="width:100%">
    @endif
    <br>
    <!-- <hr style="bottom:180px; width:200%"></hr> -->
    <img src="data:image/png;base64, {!! $data->qrcode !!}" style="position:absolute; bottom:8px">
    <img src="{{$data->setting->paraf}}" style="width:140px;position:absolute; bottom:8px; margin-left:70px;">
    <p style="position:absolute; bottom:-25px; font-size:10px">Check URL: https://scanaja.com</p>
    @if($i == $data->count && $data->is_signature == "yes")
    <p style="page-break-after: always;"></p>
    <br>
    <p>Dokumen dengan judul <span>{{$data->title}}</span> yang berjumlah {{$data->count}} halaman yang diupload oleh: <br />
    <span>Nama: {{$data->signee->name}}</span><br />
    <span>Email: {{$data->signee->email}}</span><br />
    <span>Tanggal Pengajuan: {{$data->created_at}} WIB</span><br />
    Telah disetujui dan ditandangani secara digital pada platform <span>SIGNaja.com</span>.
    </p>
    <br>
    <p style="margin-left:400px;">Disetujui pada {{ now()->format('d-m-Y') }} </p>
    <img src="{{$data->setting->signature}}" style="width:200px;margin-left:400px;">
    <p style="margin-left:400px;">{{$data->setting->signer_name}}</p>
    <img src="data:image/png;base64, {!! $data->qrcode !!}" style="position:absolute; bottom:8px">
    <p style="position:absolute; bottom:-25px; font-size:10px">Check URL: https://scanaja.com</p>
    @endif
    @endfor
    
    </body>
</html>