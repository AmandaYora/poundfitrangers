<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
    <style>
    body {
        background: linear-gradient(to right, #007bff, #0056b3);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .card-shadow {
        border-radius: 15px;
        box-shadow: 0px 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .form-icon {
        position: absolute;
        right: 10px;
        top: calc(50% - 0.5em);
        font-size: 18px;
        color: #adb5bd;
    }

    .btn-primary {
        background-color: #0056b3;
        border: none;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-shadow">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4"><i class="fas fa-user-lock"></i> Login</h5>
                        <form method="post" action="<?= base_url('auth'); ?>">
                            <div class="mb-3 position-relative">
                                <label for="username" class="form-label">Username</label>
                                <!-- Penambahan atribut name -->
                                <input type="text" class="form-control" id="username" name="username">
                                <i class="fas fa-user form-icon"></i>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <!-- Penambahan atribut name -->
                                <input type="password" class="form-control" id="password" name="password">
                                <i class="fas fa-lock form-icon"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        let flashdata = '<?php echo session()->getFlashdata('error'); ?>';
        if (flashdata) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: flashdata,
                backdrop: false
            });
        }
    });
    </script>

</body>

</html>