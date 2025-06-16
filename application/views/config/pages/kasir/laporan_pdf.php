<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Kasir</title>
<style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            float: left;
            width: 60px;
            height: 60px;
        }

        .header h2 {
            margin: 0;
        }

        .clear {
            clear: both;
        }

        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead {
            background-color: #f2f2f2;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px 6px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .footer .left {
            float: left;
            width: 50%;
            text-align: left;
        }

        .footer .right {
            float: right;
            width: 40%;
            text-align: center;
        }

        .footer .ttd {
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 style="color: blue; font-family: Arial, Helvetica, sans-serif">APOTEK ASMANAH FARMA</h1>
        <h2>Laporan Data Transaksi Kasir</h2>
        <div class="clear"></div>
    </div>
<table class="table table-bordered" style="width: 100%; max-width: 600px;">
    <thead class="thead-light">
        <tr>
            <th style="text-align: center;">Total Pendapatan Hari Ini</th>
            <th style="text-align: center;">Total Pendapatan Keseluruhan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; font-weight: bold; color: #2e59d9;">
                Rp <?= number_format($total_today ?? 0, 0, ',', '.') ?>
            </td>
            <td style="text-align: center; font-weight: bold; color: #2e59d9;">
                Rp <?= number_format($total_all ?? 0, 0, ',', '.') ?>
            </td>
        </tr>
    </tbody>
</table>

<br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Kasir</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($transaksi as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $t['transaksi_kode'] ?></td>
                <?php
$bulanIndo = [
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

$tanggal = date('d', strtotime($t['tanggal_transaksi']));
$bulan = $bulanIndo[date('m', strtotime($t['tanggal_transaksi']))];
$tahun = date('Y', strtotime($t['tanggal_transaksi']));
?>
<td><?= $tanggal . ' ' . $bulan . ' ' . $tahun ?></td>

                <td><?= $t['nama'] ?></td>
                <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>


      <div class="footer">
        <div class="left">
            <p>Tanggal cetak: <?= date('d F Y'); ?></p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <div class="ttd">
                <p><u><strong>Admin</strong></u></p>
            </div>
        </div>
    </div>

</body>
</html>
