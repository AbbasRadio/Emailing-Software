<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Manager Registration</title>
    <link rel = "icon" href ="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-email-512.png">
    <link href="../assets/css/style.min.css" rel="stylesheet">
    <!-- Font Icon -->
    <link rel="stylesheet" href="../others/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../others/css/style.css">
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
                    <form method="POST" id="signup-form" class="signup-form" action="<?=BASE_URL('DataController/Register')?>">
                        <h2 class="form-title">Create account</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="f_name" id="name" required placeholder="Your First Name"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="m_name" id="name" placeholder="Your Middle Name"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="l_name" id="name" placeholder="Your Last Name"/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" required id="email" placeholder="Your Email"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" required name="password" id="password" placeholder="Password" minlength="8" maxlength="18" />
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <select class="form-input" name="gender" id="gender" required placeholder="Select Gender">
                              <option value="" >--Select Gender--</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="address" id="address" required placeholder="Enter your address"/>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-input" name="number" id="number" required placeholder="Enter your number" maxlength="10" />
                        </div>
                        <div class="form-group">
                          <div class='input-group date' id='datetimepicker1'>
                             <input type='date' class="form-input" required name="dob" placeholder="DD-MM-YYYY" />
                             <span class="input-group-addon">
                             <span class="glyphicon glyphicon-calendar"></span>
                             </span>
                          </div>
                        </div>
                        <!-- <div class="form-input">
                            <label for="picture">Profile Picture</label><br>
                            <input type="file" name="picture" class="form-input-file" id="picture">
                        </div> -->
                        <br>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
                    </form>
                    <p class="loginhere">
                        Have already an account ? <a href="<?=BASE_URL('DataController/Authenticate')?>" class="loginhere-link">Login here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="../others/vendor/jquery/jquery.min.js">
      $(function () {
             $('#datetimepicker1').datetimepicker();
         });
    setTimeout(function(){
         $('.alert').slideUp(); 
        }, 3000);
    </script>
    <script src="../others/js/main.js"></script>
</body>
</html>