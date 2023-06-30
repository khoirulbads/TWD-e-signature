<!DOCTYPE html>
<html>
  <head>
    <title>Title of the document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  </head>
  <body>
    <h1></h1>
    <!-- <object data="{{env('APP_URL')}}/{{$data->file_name}}" type="application/pdf" width="100%" height="500px">
    <p>Open a PDF file <a href="{{env('APP_URL')}}/{{$data->file_name}}">example</a>.</p> -->
    
    <embed src="{{env('APP_URL')}}/{{$data->file_name}}" width="600" height="500" alt="pdf" /><div class="container mt-4">
      <div class="card">
          <div class="card-body">
          <img src="data:image/png;base64, {!! $data->qrcode !!}"></div>
      </div>
    </div>
  </body>
</html>