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
    
    
    <table border="0" style="border: 2px solid black;">
        <tr>
            <td colspan="2">Nama <span style="margin-left: 151px">: <?php echo e(Auth::user()->name); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">No. Induk <span style="margin-left: 124px">: <?php echo e($tabungan[0]->user->user_code); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Alamat <span style="margin-left: 142px">: <?php echo e(Auth::user()->address); ?></span></td>
        </tr>
        <tr>
            <td colspan="2">No. Tlp <span style="margin-left: 139px">:
                    <?php echo e(Auth::user()->phone); ?></span><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
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
            <?php if($tabungan->isEmpty()): ?>
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tidak ada data.<br><br><br>
                    </td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $tabungan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e(formatDateIndo($item->tanggal)); ?></td>
                        <?php if($item->kredit > 0): ?>
                            <td></td>
                            <td></td>
                            <td><?php echo e('Rp. ' . number_format($item->kredit, 0, ',', '.')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($item->bankSampah->jenisSampah->nama); ?></td>
                            <td><?php echo e('Rp. ' . number_format($item->debit, 0, ',', '.')); ?></td>
                            <td></td>
                        <?php endif; ?>
                        <td>
                            <?php echo e('Rp. ' . number_format($item->sisa_saldo, 0, ',', ',')); ?>

                        </td>
                        <td></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </tbody>
    </table>
    
    
</body>

</html>
<?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/transaksi/pdf-tabungan.blade.php ENDPATH**/ ?>