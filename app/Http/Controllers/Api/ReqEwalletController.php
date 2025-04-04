<?php
header('Content-Type: application/json');
include '../auth_function.php';
include '../config.php';
include '../function.php';

if (!handle_basic_auth()) {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $json_request = file_get_contents('php://input');
    $param = json_decode($json_request, true);

    $id_siswa = $param['id_siswa'];
    $tipe = $param['tipe'];
    $id_opsi = $param['id'];
    $id_spp = $param['p_id'];
    $biaya_admin = $param['biaya_admin'];
    $kode = $param['kode'];
    $no_hp = no_hp($param['no_hp']);
    $idt = date('YmdHis');
    $exp = date('Y-m-d H:i:s', strtotime("+2 hours"));
    $id_transaksi = "TRX" . $idt . $id_spp;

    if ($tipe == 'spp') {

        $query2 = mysqli_query($link, "SELECT * FROM pembayaran_spp WHERE id = '$id_spp'");
        $hasil2 = mysqli_fetch_array($query2);
        $nominal = $hasil2['jumlah'];
        $t_bayar = $nominal + $biaya_admin;
    } else if ($tipe == 'nonspp') {

        $query2 = mysqli_query($link, "SELECT * FROM pembayaran WHERE id = '$id_spp'");
        $hasil2 = mysqli_fetch_array($query2);
        $nominal = $hasil2['jumlah'];
        $t_bayar = $nominal + $biaya_admin;
    } else if ($tipe == 'topup') {

        $query2 = mysqli_query($link, "SELECT * FROM voucher WHERE id = '$id_spp'");
        $hasil2 = mysqli_fetch_array($query2);
        $nominal = $hasil2['nominal'];
        $t_bayar = $nominal + $biaya_admin;
    }

    if ($kode == 'ID_OVO') {

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.xendit.co/ewallets/charges',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "reference_id": "' . $id_transaksi . '",
                "currency": "IDR",
                "amount": ' . $t_bayar . ',
                "checkout_method": "ONE_TIME_PAYMENT",
                "channel_code": "ID_OVO",
                "channel_properties": {
                    "mobile_number": "' . $no_hp . '"
                }
            }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . API_KEY,
                    'for-user-id: ' . USER_ID,
                    'Content-Type: application/json'
                ),
            )
        );
    } else {

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.xendit.co/ewallets/charges',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "reference_id": "' . $id_transaksi . '",
                    "currency": "IDR",
                    "amount": ' . $t_bayar . ',
                    "checkout_method": "ONE_TIME_PAYMENT",
                    "channel_code": "' . $kode . '",
                    "channel_properties": {
                        "success_redirect_url": "https://superedu.id/"
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . API_KEY,
                    'for-user-id: ' . USER_ID,
                    'Content-Type: application/json'
                ),
            )
        );
    }

    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);
    $id = $json['id'];
    $status = $json['status'];

    if ($kode == 'ID_OVO') {

        $kode_bayar = $no_hp;
    } else if ($kode == 'ID_DANA') {

        $kode_bayar = $json['actions']['mobile_web_checkout_url'];
    } else if ($kode == 'ID_LINKAJA') {

        $kode_bayar = $json['actions']['mobile_web_checkout_url'];
    } else if ($kode == 'ID_SHOPEEPAY') {

        $kode_bayar = $json['actions']['mobile_deeplink_checkout_url'];
    }

    if ($status = 'PENDING') {

        if ($tipe == 'spp') {

            $update = mysqli_query($link, "UPDATE
                                            pembayaran_spp
                                        SET
                                            id_transaksi = '$id_transaksi',
                                            ref_id = '$id',
                                            biaya_admin = '$biaya_admin',
                                            total_bayar = '$t_bayar',
                                            batas_bayar = '$exp',
                                            opsi_bayar = '$id_opsi',
                                            kode_bayar = '$kode_bayar'
                                        WHERE
                                            id = '$id_spp'");
        } else if ($tipe == 'nonspp') {

            $update = mysqli_query($link, "UPDATE
                                            pembayaran
                                        SET
                                            id_transaksi = '$id_transaksi',
                                            ref_id = '$id',
                                            biaya_admin = '$biaya_admin',
                                            total_bayar = '$t_bayar',
                                            batas_bayar = '$exp',
                                            opsi_bayar = '$id_opsi',
                                            kode_bayar = '$kode_bayar'
                                        WHERE
                                            id = '$id_spp'");
        } else if ($tipe == 'topup') {

            $update = mysqli_query($link, "INSERT INTO `topup`(
                `trx_id`,
                `id_siswa`,
                `nominal`,
                `status`,
                `tgl`,
                `biaya_admin`,
                `opsi_bayar`,
                `kode_bayar`,
                `batas_bayar`
            )
            VALUES('$id_transaksi', '$id_siswa', '$nominal', '0', '$datetime', '$biaya_admin', '$id_opsi', '$kode_bayar', '$exp')");
        }

        if ($update) {

            http_response_code(200);
            echo json_encode([
                'status' => "success",
                'trx_id' => $id_transaksi
            ], JSON_PRETTY_PRINT);
        } else {

            http_response_code(400);
            echo json_encode([
                'status' => "error",
                'message' => "Transaksi gagal",
            ], JSON_PRETTY_PRINT);
        }
    } else {

        http_response_code(400);
        echo json_encode([
            'status' => "error",
            'message' => "Transaksi gagal",
        ], JSON_PRETTY_PRINT);
    }
} else {

    http_response_code(405);
}