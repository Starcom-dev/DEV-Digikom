<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Reset Password</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;

            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            height: 100%;
            /* max-width: 400px;
            margin: 20px; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-password-box {
            background: white;
            width: 30%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 14px;
            color: #777;
            margin-bottom: 30px;
        }

        a {
            width: 100%;
            padding: 10px;
            background-color: #3B4492;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        a:hover {
            background-color: #0056b3;
        }

        img {
            width: 5rem;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .reset-password-box {
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="reset-password-box">
            <img src="{{ asset('assets/success.png') }}" alt="" style="margin-bottom: 5px">
            <h2>Update Password Berhasil</h2>
            <p>Silahkan login kembali menggunakan password yang baru</p>
            <a href="digicom://login">Kembali ke Login</a>
        </div>
    </div>

    <script></script>
</body>

</html>
