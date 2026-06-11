<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Penyetoran</title>
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
    <?php
    	$months = [
    		'01' => 'Januari',
    		'02' => 'Februari',
    		'03' => 'Maret',
    		'04' => 'April',
    		'05' => 'Mei',
    		'06' => 'Juni',
    		'07' => 'Juli',
    		'08' => 'Agustus',
    		'09' => 'September',
    		'10' => 'Oktober',
    		'11' => 'November',
    		'12' => 'Desember'
    	];
	?>
    <div style="width: 100%;margin-bottom: 140px;position: relative;">
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
    </div>
    <table style="margin-bottom: 20px;">
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
    </table>
    <table border="0" style="border: 2px solid black;border-bottom: none;">
        <tr>
            <td>No. Rekening <span style="margin-left: 100px">:
                    <?php echo e(Auth::user()->no_rekening . ' ' . '(' . Auth::user()->bank . ')'); ?></span></td>
            <td>Periode : <span><?php echo e($months[$month].' '.$year); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">Bank Sampah Cabang <span style="margin-left: 47px">:</span></td>
        </tr>
        <tr>
            <td colspan="2">Nama <span style="margin-left: 151px">: <?php echo e(Auth::user()->name); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">Alamat <span style="margin-left: 142px">: <?php echo e(Auth::user()->address); ?></span></td>
        </tr>
        <tr>
            <td>
                <span>Mata Uang <span style="margin-left: 117px">:</span></span>
            </td>
            <td style="width: 500px">
                <div style="width: 20px;height: 15px;border: 1px solid black;float: left;"></div>
                <span style="float: left;margin-left: 5px;margin-right: 50px">
                    SAMPAH TERPILIH
                </span>
                <div style="width: 20px;height: 15px;border: 1px solid black;float: left;">
                    
                </div>
                <span style="float: left;margin-left: 5px;margin-right: 50px">
                    RUPIAH
                </span>
                <div style="width: 20px;height: 15px;border: 1px solid black;float: left;"></div>
                <span style="float: left;margin-left: 5px">
                    EMAS
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Penyetor / Depositor <span style="margin-left: 56px">:</span></td>
        </tr>
        <tr>
            <td colspan="2">Nama <span style="margin-left: 151px">: <?php echo e(Auth::user()->name); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">Alamat <span style="margin-left: 142px">: <?php echo e(Auth::user()->address); ?></span></td>
        </tr>
        <tr>
            <td>No. Tlp <span style="margin-left: 139px">: <?php echo e(Auth::user()->phone); ?></span><br><br></td>
            <td>Terbilang : <?php echo e(Str::ucfirst($totalHargaTerbilang)); ?><br><br></td>
        </tr>
        <tr>
            <td colspan="2">Sumber Sampah <span style="margin-left: 83px">:</span></td>
        </tr>
    </table>
    <table class="table2" border="2" style="border: 2px solid black;border-bottom: none;">
        <thead>
            <th style="border: 2px solid black">No</th>
            <th style="border: 2px solid black">JENIS SAMPAH</th>
            <th style="border: 2px solid black">HARGA SATUAN</th>
            <th style="border: 2px solid black">QUANTITY</th>
            <th style="border: 2px solid black">TOTAL</th>
        </thead>
        <tbody>
            <?php if($items->isEmpty()): ?>
                <tr>
                    <td rowspan="5" colspan="5" style="text-align: center;border: 2px solid black">
                        Tidak ada data.<br><br><br>
                    </td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="border: 2px solid black"><?php echo e($loop->iteration); ?></td>
                        <td style="border: 2px solid black"><?php echo e($item->jenisSampah->nama); ?></td>
                        <td style="border: 2px solid black">
                            <?php echo e('Rp. ' . number_format($item->jenisSampah->harga, 0, ',', ',')); ?>

                        </td>
                        <td style="border: 2px solid black"><?php echo e($item->qty); ?></td>
                        <td style="border: 2px solid black">
                            <?php echo e('Rp. ' . number_format($item->jenisSampah->harga * $item->qty, 0, ',', ',')); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="4" style="border: 2px solid black;font-weight: 700;">TOTAL HARGA</td>
                    <td style="border: 2px solid black;font-weight: 700">
                        <?php echo e('Rp. ' . number_format($totalHarga, 0, ',', ',')); ?></td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
    <table border="2" style="border: 2px solid black;border-top: none">
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
    </table>
    <table border="2" style="border: 2px solid black;border-top: none;">
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
    </table>
</body>

</html>
<?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/history/pdf-slip-penyetoran.blade.php ENDPATH**/ ?>