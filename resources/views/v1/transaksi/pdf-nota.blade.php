<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            padding: 5px 10px;
            text-align: center;
        }

        td {
            padding: 5px 10px;
            text-align: left;
        }

        .table2 tbody tr td {
            text-align: center;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body style="padding: 16px">
    <div style="width: 100%;margin-bottom: 50px;">
        <div style="text-align: center;">
            <h1 style="font-size: 22px">WASTE FOR REWARD</h1>
            <p style="font-size: 20px;margin-top: -15px">(Lingkungan bersih, dompet berisi)</p>
        </div>
    </div>
    <table>
        <tr>
            <td colspan="2">
                Tanggal <span style="margin-left: 137px">:</span>
                <span>{{ date('d-m-Y') }}</span>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="2">
                User Id <span style="margin-left: 142px">:</span>
                <span>{{ Auth::user()->user_code }}</span>
            </td>
        </tr> --}}
        <tr>
            <td colspan="2">
                Nama <span style="margin-left: 151px">:</span>
                <span>{{ Auth::user()->name }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">No. Rekening <span style="margin-left: 100px">: {{ Auth::user()->no_rekening }}
                    {{ Auth::user()->bank ? '(' . Auth::user()->bank . ')' : '' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Terbilang <span style="margin-left: 126px">: {{ Str::ucfirst($nominalTerbilang) }}</span>
            </td>
        </tr><br>
        <tr>
            <td colspan="2">Nominal <span style="margin-left: 132px">:</span> <span>
                    Rp. {{ number_format($lastTabungan->kredit, 0, ',', '.') }}
                </span></td>
        </tr>
    </table>
    <table border="0" style="margin-top: 30px">
        <tr>
            <td>
                TANDA BUKTI PENARIKAN<br><br><br><br><br>
            </td>
            <td style="width: 200px;text-align: center;">
                Disahkan<br><br><br><br><br>
            </td>
            <td style="width: 200px;text-align: center;">
                Teller <br><br><br><br><br>
            </td>
            <td style="width: 200px;text-align: center;">
                TT. Penarikan<br><br><br><br><br>
            </td>
        </tr>
    </table>
</body>

</html>
