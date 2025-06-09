<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Penyedia</title>
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
        <h2>Laporan Data Penyedia</h2>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Nama Penyedia</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            foreach ($penyedia as $p): 
                $tanggal_masuk = date('d F Y', strtotime($p['dibuat_di']));
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $p['nama_penyedia']; ?></td>
                <td><?= $p['alamat']; ?></td>
                <td><?= $p['no_telp']; ?></td>
                <td><?= $tanggal_masuk; ?></td>
            </tr>
            <?php endforeach; ?>
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
