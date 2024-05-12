<?php $this->load->view('includes/header'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/register.css'); ?>">
    <title>Sign Up</title>
</head>
<body>
    <div id="userForm"></div>
        <script type="text/template" id="user-template">
            <div class="login-container">
                <div class="login-form">
                <div class="login-logo">
                    <div class="logo-subtext">
                    <img class="logo" src="assets/images/logo.jpg" alt='sss' srcSet=''/>
                    </div>
                </div>
                <h2>Sign up</h2>
                <form action="<?php echo base_url('auth/register'); ?>" method="post">
                    <div class="form-group">
                        <input type="text" name="username" required />
                        <label>Username</label>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" required />
                        <label>Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required />
                        <label>Password</label>
                    </div>
                    <button type="submit">Sign up</button>
                    <div class="signup">
                    <div class="signup">
                    <a href ="<?php echo base_url('login'); ?>">Already Have a Account? Sign In Here</a>
                    </div>  
                    </div>
                </form>
            </div>
        </div>
    </script>

    <script src="<?php echo base_url('assets/js/user.js'); ?>"></script>
</body>
</html>