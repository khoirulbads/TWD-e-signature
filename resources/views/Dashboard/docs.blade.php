<!DOCTYPE html>
<html>
  <head>
    <title>{{$pdfData->id}}-signed.pdf</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body style="margin-top:-100px;margin-left:-40px;">
    @for ($i = 1; $i <= $pdfData->count ; $i++)
      <?php 
        $sub = substr($pdfData->old_name, 12);
        $fsub = substr($sub, 0, -4);
      ?>
    @if($i == 1)
    <img src="assets/docs/{{$pdfData->folder}}/{{$fsub}}.png" style="width:210mm;display:absolute;margin-top:50px;">
    @endif
    @if($i > 1)
    <img src="assets/docs/{{$pdfData->folder}}/{{$fsub}}-{{$i}}.png" style="width:210mm;display:absolute;margin-top:50px;">
    @endif
    <br>
    <!-- <hr style="bottom:180px; width:200%"></hr> -->
    <!-- {{-- <img src="data:image/png;base64, {!! $pdfData->qrcode !!}" style="position:absolute; bottom:8px"> --}} -->

    <!-- <img src="{{$pdfData->setting->paraf}}" style="width:140px;position:absolute;"> -->
    <p style="position:absolute; top: 200px; font-size:10px">{{$docTime .' WIB'}}</p>
    {{-- <p style="position:absolute; bottom:-25px; font-size:10px">Check URL: https://signaja.com</p> --}}
    @if($i == $pdfData->page && $pdfData->is_signature == "yes")
    <img src="{{$pdfData->setting->signature}}" style="width:25mm;left:{{$pdfData->x}}px;top:{{$pdfData->y}}px; position:absolute;" >
    <!-- <p style="page-break-after: always;"></p>
    <br>
    <p>Dokumen dengan judul <span>{{$pdfData->title}}</span> yang berjumlah {{$pdfData->count}} halaman yang diupload oleh: <br />
    <span>Nama: {{$pdfData->signee->name}}</span><br />
    <span>Email: {{$pdfData->signee->email}}</span><br />
    <span>Tanggal Pengajuan: {{$pdfData->created_at}} WIB</span><br />
    Telah disetujui dan ditandangani secara digital pada platform <span>SIGNaja.com</span>.
    </p>
    <br>
    <p style="margin-left:400px;">Disetujui pada {{ now()->format('d-m-Y') }} </p>
    <img src="{{$pdfData->setting->signature}}" style="width:200px;margin-left:400px;">
    <p style="margin-left:400px;">{{$pdfData->setting->signer_name}}</p>
    <p style="margin-left:400px;">{{$pdfData->setting->department}}</p>
    {{-- <img src="data:image/png;base64, {!! $pdfData->qrcode !!}" style="position:absolute; bottom:8px">
    <p style="position:absolute; bottom:-25px; font-size:10px">Check URL: https://signaja.com</p> --}}
    <p style="position:absolute; bottom:-25px; font-size:10px">{{$docTime .' WIB' }}</p> -->
    <p style="page-break-after: always;"></p>
    @endif
    @endfor
    </body>
  </html>