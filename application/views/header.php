<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css'); ?>">
        <title><?php echo $title ?? 'Default Title'; ?></title>
        <header class="dashboard-header">
            <div class = "mid"><img src="<?php echo base_url('assets/images/headers.png');?>" alt="CLONEL Logo" class="logo" /></div>
            <nav class="navigation">
                    <ul>
                    <button class="logout-button"><a href="<?php echo base_url('home'); ?>">Home</a></button>
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <button class="logout-button"><a href="<?php echo base_url('user/profile'); ?>">Profile</a></button>
                          <button class="logout-button2"><a href="<?php echo base_url('auth/logout'); ?>">Logout</a></button>
                            
                        <?php else: ?>
                            <a href="<?php echo base_url('auth/login'); ?>">Login</a>
                            <a href="<?php echo base_url('auth/signup'); ?>">Sign Up</a>
                        <?php endif; ?>
                    </ul>
                </nav>
        </header>
    </head>
</html>
