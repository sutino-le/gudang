<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk Barang Keluar</title>
</head>

<body onload="window.print();">
    <table border="0" style="width: 100%;">
        <tr style="text-align: center;">
            <td colspan="4">
                <h3 style="height: 2px;">Toko Mana</h3>
                <h5 style="height: 2px;">Jl. Kebahagiaan dimana, <i>0858-xxxx-xxxx</i></h5>
                <hr style="border: 0; border-top: 1px solid #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td>No. Faktur</td>
            <td colspan="3">: <?= $faktur ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Tgl. Faktur</td>
            <td colspan="3">: <?= date("d/m/Y", strtotime($tanggal)) ?></td>
        </tr>
        <tr style="text-align: left;">
            <td>Pelanggan</td>
            <td colspan="3">: <?= $namapelanggan ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <table style="width: 100%; text-align:left; font-size: 10pt;">
                    <?php
                    $totalhargabayar = 0;
                    foreach ($detailbarang->getResultArray() as $row) :
                        $totalhargabayar += $row['detsubtotal'];
                    ?>
                        <tr>
                            <td colspan="5"><?= $row['brgnama'] ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><?= number_format($row['detjml'], 0, ",", ".") . ' ' . $row['satnama'] ?></td>
                            <td>x</td>
                            <td><?= number_format($row['dethargajual'], 0, ",", ".") ?></td>
                            <td style="text-align: right;"><?= number_format($row['detsubtotal'], 0, ",", ".") ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Total Bayar</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($totalhargabayar, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Bayar</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($jumlahuang, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px dashed #000;">
            </td>
        </tr>
        <tr style="text-align: left;">
            <td colspan="2" align="right">Kembali</td>
            <td>: Rp. </td>
            <td style="text-align: right;"><?= number_format($sisauang, 0, ",", ".") ?></td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="4">
                <hr style="border: 0; border-top: 1px solid #000;">
                <h3 style="height: 2px;">Terimakasih !</h3>
                <h5 style="height: 2px;">Atas kunungan Anda.</h5>
            </td>
        </tr>
    </table>
</body>

</html>