<?php $this->load->view('includes/header'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/register.css'); ?>">
    <title>Login</title>
</head>
<body>
<div class="login-container">
<div id="loginFormContainer" data-url="<?php echo base_url('auth/login_process'); ?>"></div>
<script type="text/template" id="login-template">
    <div class="login-form">
            <div class="login-logo">
                <div class="logo-subtext">
                    <img class="logo" src="assets/images/logo.jpg" alt='' srcSet=''/>
                </div>
            </div>
                <h2>Sign in</h2>
                <form id="actualLoginForm">
                    <div class="form-group">
                        <input type="email" id="email" name="email" value="<%= email %>" />
                        <label>Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" />
                        <label>Password</label>
                    </div>
                    <div class="forgot-password">
                        <a href="">Forgot password?</a>
                    </div>
                    <button type="submit">Login</button>
                    <div class="signup">
                        <a href ="<?php echo base_url('signup'); ?>">Not Registerd Yet? Sign Up Here</a>
                    </div>
                </form>
            </div>
</script>
    <script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
    </div>
</body>
</html>
