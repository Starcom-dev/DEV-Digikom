<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digikom</title>
</head>

<body>
    <h2>{{ $data['title'] }}</h2>

    <div>
        <p>Hallo,</p>
        <p>Kami menerima permintaan untuk mereset password akun Anda di Sistem Digikom</p>
        <p>Untuk mereset password Anda, klik tautan di bawah ini:</p>
        <a href="{{ $data['link'] }}/{{ $data['token'] }}">{{ $data['link'] }}/{{ $data['token'] }}</a>
        <p>Tautan ini akan aktif selama 24 jam</p>
        <p>Terima kasih,</p>
        <p><b>Digikom</b></p>
    </div>

</body>

</html>
