
@extends ('emails.layout',array())
@section('content')
<table width="100%">
    <tbody>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> <b>{{$data->signee->name}}</b> telah mengirim pengajuan berkas berjudul <b>{{$data->title}}</b>pada {{$data->created_at}} WIB. silakan masuk menggunakan akun anda dan periksa berkas.  </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> TERIMA KASIH </td>
        </tr>
    </tbody>
</table>

@stop
