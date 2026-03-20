<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand">Chat App</span>
    <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
</nav>

<div class="container mt-5 text-center">
    <h2>Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
    <p class="text-muted">You are successfully logged in.</p>
    <a href="<?= base_url('chat') ?>" class="btn btn-primary btn-lg mt-3">
        Go to Chat Room
    </a>
</div>

</body>
</html>