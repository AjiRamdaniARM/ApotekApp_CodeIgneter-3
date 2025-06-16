<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 0;
            padding: 20px;
        }

        .struk {
            width: 280px;
            margin: 0 auto;
            border: 1px dashed #000;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .header {
            margin-bottom: 10px;
        }

        .header h2, .header p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 3px 0;
        }

        .total-row td {
            border-top: 1px dashed #000;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }

        .info {
            margin-top: 10px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <div class="header text-center">
            <h2>Apotek Sehat</h2>
            <p>Jl. Contoh No.123, Sukabumi</p>
        </div>

        <div class="info">
            <p><strong>Kode:</strong> <?= $transaksi['transaksi_kode'] ?></p>
            <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($transaksi['tanggal_transaksi'])) ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                <tr>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['jumlah'] ?></td>
                    <td><?= number_format($d['harga'], 0, ',', '.') ?></td>
                    <td><?= number_format($d['total'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td><?= number_format($transaksi['total_harga'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">Bayar</td>
                    <td><?= number_format($transaksi['bayar'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3">Kembali</td>
                    <td><?= number_format($transaksi['bayar'] - $transaksi['total_harga'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>-- Terima kasih telah berbelanja --</p>
            <p>Apotek Sehat | <?= date('d/m/Y') ?></p>
        </div>
    </div>
</body>
</html>
