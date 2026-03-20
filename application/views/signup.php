<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Create Account</h4>

                    <div id="msg" class="alert d-none"></div>

                    <form id="signupForm">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>

                    <p class="text-center mt-3">
                        Already have an account? <a href="<?= base_url('auth/signin') ?>">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$('#signupForm').submit(function(e) {
    e.preventDefault(); // STOP page reload

    $.ajax({
        url: '<?= base_url("auth/register") ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            var msgBox = $('#msg');
            msgBox.removeClass('d-none alert-success alert-danger');

            if (res.status === 'success') {
                msgBox.addClass('alert-success').text(res.message).show();
                setTimeout(function() {
                    window.location = '<?= base_url("auth/signin") ?>';
                }, 1500);
            } else {
                msgBox.addClass('alert-danger').text(res.message).show();
            }
        }
    });
});
</script>
</body>
</html>