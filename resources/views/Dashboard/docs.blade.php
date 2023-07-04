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
    <img src="assets/docs/{{$data->folder}}/{{$fsub}}.png" style="width:90%">
    @endif
    @if($i > 1)
    <img src="assets/docs/{{$data->folder}}/{{$fsub}}-{{$i}}.png" style="width:90%">
    @endif
    <br>
    <img src="data:image/png;base64, {!! $data->qrcode !!}"></div>
    <p style="page-break-after: always;"></p>
    @endfor
    </body>
</html>