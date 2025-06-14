<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Obat</title>
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

        h1, h2 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead {
            background-color: #f2f2f2;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
        }

        .footer .left {
            float: left;
            width: 50%;
        }

        .footer .right {
            float: right;
            width: 40%;
            text-align: center;
        }

        .ttd {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #007BFF;">APOTEK ASMANAH FARMA</h1>
        <h2>Laporan Data Obat</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="4%">No</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Penyedia</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($obat as $item): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $item['nama']; ?></td>
                <td><?= $item['nama_tipe']; ?></td>
                <td><?= $item['nama_penyedia']; ?></td>
                <td>Rp<?= number_format($item['harga_pembelian'], 0, ',', '.'); ?></td>
                <td>Rp<?= number_format($item['harga_penjualan'], 0, ',', '.'); ?></td>
                <td><?= $item['stok']; ?></td>
                <td style="
                    <?php
                        $warna = '';
                        switch (strtolower($item['status'])) {
                            case 'terima':
                                $warna = 'background-color: #d4edda; color: #155724;'; // hijau
                                break;
                            case 'proses':
                                $warna = 'background-color: #fff3cd; color: #856404;'; // kuning
                                break;
                            case 'tolak':
                                $warna = 'background-color: #f8d7da; color: #721c24;'; // merah
                                break;
                            default:
                                $warna = 'background-color: #e2e3e5; color: #383d41;'; // abu-abu
                                break;
                        }
                        echo $warna . ' text-align:center; font-weight:bold;';
                    ?>
                ">
                    <?= ucfirst($item['status']); ?>
                </td>

                <td><?= date('d F Y', strtotime($item['tanggal_masuk'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="left">
            <p>Tanggal Cetak: <?= date('d F Y'); ?></p>
        </div>
        <div class="right">
            <p>Mengetahui,</p>
            <div class="ttd">
                <p><strong><u>Admin</u></strong></p>
            </div>
        </div>
    </div>
</body>
</html>
