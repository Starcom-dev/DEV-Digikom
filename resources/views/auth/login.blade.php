<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Digikom</title>
    <link rel="stylesheet" href={{ asset('templateViews/template/assets/vendors/mdi/css/materialdesignicons.min.css')}}>
    <link rel="stylesheet" href={{ asset('templateViews/template/assets/vendors/css/vendor.bundle.base.css')}}>
    <link rel="stylesheet" href={{ asset('templateViews/template/assets/css/style.css')}}>
    <link rel="shortcut icon" href={{ asset('assets/digikomLogo.png')}} />
  </head>
  <body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center" style="background-image: url('{{ asset('assets/bglogin.png') }}'); background-size: cover;">
                <div class="card col-lg-4 mx-auto">
                    <div class="card-body px-5 pb-5">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/digikomLogo.png') }}" alt="logo" style="width: 100px; height: 100px;" />
                        <h3 class="card-title  my-3">Login</h3>
                    </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control p_input" onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                            </div>
                            <div class="form-group">
                            <label>Password *</label>
                            <input type="password" id="password" name="password" class="form-control p_input" onfocus="this.style.backgroundColor='#2A3038'; this.style.color='#ffffff';" required>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <label>
                                <input type="checkbox" id="show-password" onclick="togglePassword()"> Show Password
                            </label>
                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src={{ asset('templateViews/template/assets/vendors/js/vendor.bundle.base.js')}}></script>
    <script src={{ asset('templateViews/template/assets/js/off-canvas.js')}}></script>
    <script src={{ asset('templateViews/template/assets/js/hoverable-collapse.js')}}></script>
    <script src={{ asset('templateViews/template/assets/js/misc.js')}}></script>
    <script src={{ asset('templateViews/template/assets/js/settings.js')}}></script>
    <script src={{ asset('templateViews/template/assets/js/todolist.js')}}></script>
    <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var checkbox = document.getElementById("show-password");
        if (checkbox.checked) {
            passwordField.type = "text"; // Ubah tipe menjadi text
        } else {
            passwordField.type = "password"; // Ubah tipe kembali ke password
        }
    }
</script>

  </body>
</html>