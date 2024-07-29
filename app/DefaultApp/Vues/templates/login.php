<?php

use systeme\Application\Application as ap;
if (\systeme\Model\Utilisateur::session()) {
    ap::redirection('dashboard');
} else {
    if (isset($_COOKIE['utilisateur'])) {
        $_SESSION['utilisateur'] = $_COOKIE['utilisateur'];
        ap::redirection('dashboard');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#3063A0">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="public/admin/assets/vendor/fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/theme.min.css" data-skin="default">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/theme-dark.min.css" data-skin="dark">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/custom.css">
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        document.querySelector('html').classList.add('loading');
    </script>
</head>
<body>
<!--[if lt IE 10]>
<div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <span class="alert-link">upgrade your browser</span> to improve your experience and security.</div>
<![endif]-->

<main class="auth">
    <header id="auth-header" class="auth-header" style="background-image: url(public/admin/assets/images/illustration/img-1.png);">
        <h1>
            DEMO
        </h1>
    </header>
    <form class="auth-form" method="post">
        <?php
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        echo $msg->display();
        ?>
        <div class="form-group">
            <div class="form-label-group">
                <input type="text" id="inputUser" class="form-control" placeholder="Username" name="username" required autofocus=""> <label for="inputUser">Username</label>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
            </div>
        </div>
        <div class="form-group">
            <input class="btn btn-lg btn-primary btn-block" name="login" type="submit" value="Sign In"/>
        </div>
        <div class="form-group text-center">
            <div class="custom-control custom-control-inline custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember-me"> <label class="custom-control-label" for="remember-me">Keep me sign in</label>
            </div>
        </div>
        <div class="text-center pt-3">
            <a href="#" class="link">Forgot Password?</a>
        </div>
    </form>
    <footer class="auth-footer"> ©<?= Date('Y')?> All Rights Reserved. </footer>
</main>
<script src="public/admin/assets/vendor/jquery/jquery.min.js"></script>
<script src="public/admin/assets/vendor/popper.js/umd/popper.min.js"></script>
<script src="public/admin/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="public/admin/assets/vendor/particles.js/particles.js"></script>
<script src="public/admin/assets/javascript/theme.js"></script>
<script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 4000);
</script>
</body>
</html>

