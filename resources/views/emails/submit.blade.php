
@extends ('emails.layout',array())
@section('content')
<table width="100%">
    <tbody>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:bold;padding-top:10px;padding-bottom:50px;text-align:left;padding-left:10px"> Hallo {{$data->signee->name}}, </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> Pengajuan berkas anda yang berjudul <b>{{$data->title}}</b> telah berhasil diunggah pada {{$data->created_at}} WIB. Kami membutuhkan beberapa saat untuk me-review berkas anda. Mohon bersedia menunggu.  </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> TERIMA KASIH </td>
        </tr>
    </tbody>
</table>

@stop
