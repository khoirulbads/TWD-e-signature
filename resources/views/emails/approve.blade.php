
@extends ('emails.layout',array())
@section('content')
<table width="100%">
    <tbody>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:bold;padding-top:10px;padding-bottom:50px;text-align:left;padding-left:10px"> Hallo {{$data->signee->name}}, </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> Pengajuan berkas anda yang berjudul <b>{{$data->title}}</b> telah <b style="color:green;">DISETUJUI</b>, silakan masuk menggunakan akun anda atau unduh berkas di link di bawah ini.  </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> TERIMA KASIH </td>
        </tr>
        <tr>
            <td style="text-align:center; text-color:white;"> <a href="{{env('APP_URL')}}/{{$data->approved->file_name}}" style="
               color: white;
               width: 90%;
               display: inline-block;
               padding-top: 25px;
               padding-bottom: 25px;
               margin-bottom: 20px;
               border-radius: 13px;   
               background: rgb(223,71,135);
               margin-top : 30px;
               background: -moz-linear-gradient(90deg, rgba(223,71,135,1) 0%, rgba(46,77,196,1) 50%, rgba(61,43,147,1) 100%);
               background: -webkit-linear-gradient(90deg, rgba(223,71,135,1) 0%, rgba(46,77,196,1) 50%, rgba(61,43,147,1) 100%);
               background: linear-gradient(90deg, rgba(223,71,135,1) 0%, rgba(46,77,196,1) 50%, rgba(61,43,147,1) 100%);
               filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#df4787',endColorstr='#3d2b93',GradientType=1);
               " target="_blank">Unduh Berkas</a> </td>
        </tr>
    </tbody>
</table>

@stop
