@extends('emails._index')

@section('title', 'Status Verifikasi')

@section('content')

<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="width:100%;max-width:100%;">
    <tr>
        <td class="sion-title-5" align="center" valign="top">

            <!-- body-bg-color -->
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="row"
                style="width:100%;max-width:100%;">
                <tr>
                    <td class="body-bg-color" align="center" valign="top" bgcolor="#F4F4F4">

                        <!-- bg-color -->
                        <table border="0" width="800" align="center" cellpadding="0" cellspacing="0" class="row"
                            style="width:800px;max-width:800px;">
                            <tr>
                                <td class="bg-color" align="center" valign="top" bgcolor="#FFFFFF">

                                    <!-- container -->
                                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="row" style="width:600px;max-width:600px;">
                                        <tr>
                                            <td align="center" valign="top" class="container-padding">

                                                <!-- space -->
                                                <table border="0" width="100%" align="center" cellpadding="0"
                                                    cellspacing="0" style="width:100%;max-width:100%;">
                                                    <tr>
                                                        <td valign="middle" align="center" height="10"
                                                            style="font-size:10px;line-height:10px;">
                                                            &nbsp; </td>
                                                    </tr>
                                                </table>
                                                <!-- space -->

                                                <!-- space -->
                                                <table border="0" width="100%" align="center" cellpadding="0"
                                                    cellspacing="0" style="width:100%;max-width:100%;">
                                                    <tr>
                                                        <td valign="middle" align="center" height="10"
                                                            style="font-size:10px;line-height:10px;">
                                                            &nbsp; </td>
                                                    </tr>
                                                </table>
                                                <!-- space -->

                                                <!-- title -->
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0"
                                                    align="center" style="width:100%; max-width:100%;">
                                                    <tr>
                                                        <td class="title center-text" valign="middle" align="center"
                                                            style="font-family:'Poppins',Arial,Helvetica,sans-serif; font-size:18px; line-height:35px; font-weight:lighter;font-style:normal; color:#1d2331;text-decoration:none;letter-spacing: 0px;">

                                                            Hai {{ $name }},

                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- title -->

                                                <!-- dots -->
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0"
                                                    align="center" style="width:100%; max-width:100%;">
                                                    <tr>
                                                        <td class="dots center-text" valign="middle" align="center"
                                                            style="font-family:'Georgia',Times New Roman,Helvetica,sans-serif; font-size:28px; line-height:28px; font-weight:normal;font-style:normal; color:#f2564a;text-decoration:none;letter-spacing: 2px;">

                                                            <strong>...</strong>

                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- dots -->

                                                <!-- space -->
                                                <table border="0" width="100%" align="center" cellpadding="0"
                                                    cellspacing="0" style="width:100%;max-width:100%;">
                                                    <tr>
                                                        <td valign="middle" align="center" height="20"
                                                            style="font-size:20px;line-height:20px;">
                                                            &nbsp; </td>
                                                    </tr>
                                                </table>
                                                <!-- space -->

                                                <!-- text -->
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0"
                                                    align="center" style="width:100%; max-width:100%;">
                                                    <tr>
                                                        <td class="text center-text" valign="middle" align="center"
                                                            style="font-family:'Poppins',Arial,Helvetica,sans-serif; font-size:16px; line-height:24px; font-weight:normal;font-style:normal; color:#2f3646;text-decoration:none;letter-spacing: 0px;">

                                                            Status verifikasi peserta <br>
                                                            <strong>{{ $jadwal->tipe . ' ' . $jadwal->nama }}</strong> <br>
                                                            pada tanggal <strong>{{ $jadwal->tgl_awal}}</strong> s/d <strong>{{ $jadwal->tgl_akhir}}</strong> <br><br>
                                                            <strong>{{ $status }}</strong> oleh <strong>BPSDM Prov. Kaltim</strong>

                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- text -->

                                                <!-- space -->
                                                <table border="0" width="100%" align="center" cellpadding="0"
                                                    cellspacing="0" style="width:100%;max-width:100%;">
                                                    <tr>
                                                        <td valign="middle" align="center" height="20"
                                                            style="font-size:20px;line-height:20px;">
                                                            &nbsp; </td>
                                                    </tr>
                                                </table>
                                                <!-- space -->

                                            </td>
                                        </tr>
                                    </table>
                                    <!-- container -->

                                </td>
                            </tr>
                        </table>
                        <!-- bg-color -->

                    </td>
                </tr>
            </table>
            <!-- body-bg-color -->

        </td>
    </tr>
</table>

@endsection