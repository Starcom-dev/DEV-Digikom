<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #757fd8;
        }

        #error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3B4492;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
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
            <h2>Konfirmasi Password</h2>
            <p>Isi data berikut untuk mengatur ulang password.</p>

            <form id="resetForm" action="{{ route('reset-password') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="input-group">
                    <label for="new-password">Password Baru</label>
                    <input type="password" id="new-password" name="new_password" placeholder="Masukan password baru"
                        required>
                </div>

                <div class="input-group">
                    <label for="confirm-password">Konfirmasi Password</label>
                    <input type="password" id="confirm-password" name="confirm_password"
                        placeholder="Masukan konfirmasi password" required>
                </div>

                <div class="error-message" id="error-message"></div>

                <button type="submit" id="reset-btn">Reset Password</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("resetForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get the values from the input fields
            const newPassword = document.getElementById("new-password").value;
            const confirmPassword = document.getElementById("confirm-password").value;

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                document.getElementById("error-message").innerText = "Passwords do not match!";
                return;
            }
            this.submit();
        });
    </script>
</body>

</html>
