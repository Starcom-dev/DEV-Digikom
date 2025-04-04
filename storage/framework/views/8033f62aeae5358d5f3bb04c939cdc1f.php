
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        button {
            background-color: #383638;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #505050;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Remove Account</h1>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <form action="/delete-account" method="POST">
            <button type="submit">Delete Account</button>
        </form>
    </div>
</body>
</html>
<?php /**PATH /home/digikom/laravel/resources/views/pages/privacy/remove.blade.php ENDPATH**/ ?>