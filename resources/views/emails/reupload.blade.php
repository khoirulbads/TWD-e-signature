
@extends ('emails.layout',array())
@section('content')
<table width="100%">
    <tbody>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px">Berkas berjudul <b>{{$data->title}}</b>  telah diperbaiki dan diunggh kembali oleh <b>{{$data->signee->name}}</b>. silakan masuk menggunakan akun anda dan periksa kembali.  </td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#333;font-weight:normal;padding-top:0px;padding-bottom:20px;text-align:left;padding-left:10px"> TERIMA KASIH </td>
        </tr>
    </tbody>
</table>

@stop
