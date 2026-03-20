<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Sign In</h4>

                    <div id="msg" class="alert d-none"></div>

                    <form id="signinForm">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Sign In</button>
                    </form>

                    <p class="text-center mt-3">
                        No account? <a href="<?= base_url('auth/signup') ?>">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$('#signinForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: '<?= base_url("auth/login") ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                window.location = '<?= base_url("auth/landing") ?>';
            } else {
                var msgBox = $('#msg');
                msgBox.removeClass('d-none alert-success')
                      .addClass('alert alert-danger')
                      .text(res.message).show();
            }
        }
    });
});
</script>
</body>
</html>