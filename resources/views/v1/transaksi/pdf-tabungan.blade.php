<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan</title>
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
    {{-- <div style="width: 100%;margin-bottom: 140px;position: relative;">
        <img src="img/logo-polsri.png" style="text-align: center;float: left;margin-top: -20px" width="100"
            height="100" alt="">
        <img src="img/logo-pertamina-ep.png" style="text-align: center;float: left;margin-top: -20px;" width="200"
            height="100" alt="">
        <div style="float: left;margin-left: 65px;text-align: center;margin-top: -7px;">
            <h1 style="font-size: 22px">WASTE FOR REWARD</h1>
            <p style="font-size: 20px;margin-top: -15px">(Lingkungan bersih, dompet berisi)</p>
        </div>
        <div style="float: right;">
            <div style="text-align: center;width: 200px; background-color: #04764E;padding: 5px 10px;">
                <span style="color: white">SLIP PENYETORAN</span>
            </div>
            <div style="margin-top: 5px;text-align: center;width: 200px; background-color: #04764E;padding: 5px 10px;">
                <span style="color: white">DEPOSIT SLIP</span>
            </div>
        </div>
    </div> --}}
    {{-- <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 5px">
                <div style="width: 20px;height: 15px;border: 1px solid black;margin-right: 5px"></div>
            </td>
            <td>
                <span>Tabungan Sampah</span>
            </td>
            <td style="width: 5px">
                <div style="width: 20px;height: 15px;border: 1px solid black;margin-right: 5px"></div>
            </td>
            <td>
                <span>Tabungan Lebaran</span>
            </td>
            <td style="width: 5px">
                <div style="width: 20px;height: 15px;border: 1px solid black;margin-right: 5px"></div>
            </td>
            <td>
                <span>Sedekah</span>
            </td>
            <td style="width: 5px">
                <div style="width: 20px;height: 15px;border: 1px solid black;margin-right: 5px"></div>
            </td>
            <td>
                <span>Barter</span>
            </td>
        </tr>
    </table> --}}
    <table border="0" style="border: 2px solid black;">
        <tr>
            <td colspan="2">Nama <span style="margin-left: 151px">: {{ Auth::user()->name }}</span></td>
        </tr>
        <tr>
            <td colspan="2">No. Induk <span style="margin-left: 124px">: {{ $tabungan[0]->user->user_code }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Alamat <span style="margin-left: 142px">: {{ Auth::user()->address }}</span></td>
        </tr>
        <tr>
            <td colspan="2">No. Tlp <span style="margin-left: 139px">:
                    {{ Auth::user()->phone }}</span><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
        </tr>
        <tr>
            <td>
                Perhatian:
                <ol>
                    <li>
                        <p>
                            Mohon diperiksa jumlah saldo <br> anda di bank sampah,
                            sebelum <br>
                            meninggalkan
                            kasir
                        </p>
                    </li>
                    <li>
                        <p>
                            Jika buku tabungan ini hilang, <br> harap dilaporkan ke
                            pengurus <br> bank
                            sampah
                        </p>
                    </li>
                </ol>
            </td>
            <td style="text-align: center">
                Mengetahui <br><br><br><br><br>
                Manager Bank Sampah <br><br>
            </td>
        </tr>
    </table>
    <br>
    <table class="table2" border="2" style="border: 2px solid black;">
        <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis Sampah</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Saldo</th>
            <th>TTD Petugas</th>
        </thead>
        <tbody>
            @if ($tabungan->isEmpty())
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tidak ada data.<br><br><br>
                    </td>
                </tr>
            @else
                @foreach ($tabungan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ formatDateIndo($item->tanggal) }}</td>
                        @if ($item->kredit > 0)
                            <td></td>
                            <td></td>
                            <td>{{ 'Rp. ' . number_format($item->kredit, 0, ',', '.') }}</td>
                        @else
                            <td>{{ $item->bankSampah->jenisSampah->nama }}</td>
                            <td>{{ 'Rp. ' . number_format($item->debit, 0, ',', '.') }}</td>
                            <td></td>
                        @endif
                        <td>
                            {{ 'Rp. ' . number_format($item->sisa_saldo, 0, ',', ',') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    {{-- <table border="2" style="border: 2px solid black;border-top: none">
        <!-- Signatures -->
        <tr>
            <th style="width: 50%;border: 2px solid black;border-top: none;">DISAHKAN:</th>
            <th style="width: 50%;border: 2px solid black;border-top: none;">DEBITUR</th>
        </tr>
        <tr>
            <td style="text-align: center;border: 2px solid black">
                Direktur Bank Sampah Induk<br><br><br><br><br><br>
                Ummy Haniek Mayningrum
            </td>
            <td style="border: 2px solid black"></td>
        </tr>
        <tr>
            <th colspan="2" style="width: 100%;border: 2px solid black">DISETUJUI</th>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%;text-align: center;border: 2px solid black">
                DIREKTUR BANK SAMPAH INDONESIA<br>
                Palembang,<br><br><br><br><br><br>
                (Hanardono)
            </td>
        </tr>
    </table> --}}
    {{-- <table border="2" style="border: 2px solid black;border-top: none;">
        <!-- Payment Method -->
        <tr>
            <td style="border: 2px solid black;border-top: none;">
                PEMBAYARAN DILAKUKAN:<br>
                1. TRANSFER<br>
                2. CASH<br>
                3. MENABUNG<br>
                4. BARTER
            </td>
            <td style="width: 200px;border: 2px solid black;border-top: none;">
                No Rek<br><br><br><br><br>
            </td>
            <td style="border: 2px solid black;border-top: none;">
                Keterangan Atas Nama: <br><br><br><br><br>
            </td>
            <td style="width: 200px;border: 2px solid black;border-top: none;">
                Bank<br><br><br><br><br>
            </td>
        </tr>
    </table> --}}
</body>

</html>
