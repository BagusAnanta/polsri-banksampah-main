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
                <span><?php echo e(date('d-m-Y')); ?></span>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                Nama <span style="margin-left: 151px">:</span>
                <span><?php echo e(Auth::user()->name); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">No. Rekening <span style="margin-left: 100px">: <?php echo e(Auth::user()->no_rekening); ?>

                    <?php echo e(Auth::user()->bank ? '(' . Auth::user()->bank . ')' : ''); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Terbilang <span style="margin-left: 126px">: <?php echo e(Str::ucfirst($nominalTerbilang)); ?></span>
            </td>
        </tr><br>
        <tr>
            <td colspan="2">Nominal <span style="margin-left: 132px">:</span> <span>
                    Rp. <?php echo e(number_format($lastTabungan->kredit, 0, ',', '.')); ?>

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
<?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/transaksi/pdf-nota.blade.php ENDPATH**/ ?>