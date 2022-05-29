<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Manager Login</title>
    <link rel = "icon" href ="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-email-512.png">
    <link href="../assets/css/style.min.css" rel="stylesheet">
    <!-- Font Icon -->
    <link rel="stylesheet" href="<?=BASE_URL()?>/others/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?=BASE_URL()?>/others/css/style.css">
</head>
<body id="body">

    <div class="main">

        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="col-lg-12">
        
        <?php if($this->session->flashdata('Updated')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Updated'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Sent')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Sent'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Inserted')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Inserted'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Thank')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('Thank'); ?></div>
        <?php } ?>
        <?php if(validation_errors()) {?>
            <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Phone')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Phone'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Invalid')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Invalid'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Error')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Error'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('user')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('user'); ?></div>
        <?php } ?>
        <?php if($this->session->flashdata('Email')){ ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('Email'); ?></div>
        <?php } ?>
    </div>
                    <form method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Login</h2>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Your Email"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Log In"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Not A Member ? <a href="<?=BASE_URL('DataController/Register')?>" class="loginhere-link">Sign-Up</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
    <!-- JS -->
    <script src="<?=BASE_URL()?>/others/vendor/jquery/jquery.min.js"></script>
    <script src="<?=BASE_URL()?>/others/js/main.js"></script>
    <script type="text/javascript">
        setTimeout(function(){
         $('.alert').slideUp(); 
        }, 3000);
    </script>
</body>
</html>