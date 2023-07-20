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
    <img src="{{$data->setting->paraf}}" style="width:50px;position:absolute; bottom:8px; margin-left:70px;">
    <p style="position:absolute; bottom:-25px; font-size:10px">Dokumen ini telah disetujui dan ditanda tangani secara digital oleh Anton Law Firm pada platform ParafDigital.id serta telah menyimpan salinannya. </p>
    @if($i == $data->count && $data->is_signature == "yes")
    <p style="page-break-after: always;"></p>
    @endif
    @endfor
    <br>
    <p>Dokumen dengan judul <span>{{$data->title}}</span> dengan halaman berjumlah {{$data->count}} yang di 
    upload oleh <span>{{$data->signee->name}}</span> pada {{$data->created_at}} telah disetujui dan ditandangani secara digital pada platform <span>signaja.com</span>.
    </p>
    <br>
    <p style="margin-left:400px;">disetujui pada {{ now()->format('d-m-Y') }} </p>
    <h5 style="margin-left:400px;">XXX LawFirm </h5>
    <img src="{{$data->setting->signature}}" style="width:120px;margin-left:400px;">
    <p style="margin-left:400px;">{{$data->setting->signer_name}}</p>
    </body>
</html>