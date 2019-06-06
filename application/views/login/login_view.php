<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
  <meta name="author" content="Lukasz Holeczek">
  <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">

  <title>ระบบสหกิจ | มหาวิทยาลัยบูรพา</title>

  <!-- Icons -->
  <link href="<?php echo base_url('assets/theme/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" />


  <!-- Main styles for this application -->
  <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

  <!-- Styles required by this views -->
  <style>
  body {
    background: url('<?php echo base_url('/assets/img/login-bg.jpg');?>') no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }

  </style>
</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1>Login</h1>
              <?php if(@$status) { ?>
                    <p class="alert alert-warning">รหัสผู้ใช้ผิดพลาด <b>โปรดตรวจสอบ</b></p>
              <?php } else { ?>
                    <p class="text-muted">Sign In to your account</p>
              <?php } ?>
              <form action="<?php echo site_url('member/post_login');?>" method="post">
              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" class="form-control" placeholder="Username" name="username">
              </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="password">
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary px-4">Login</button>
                  <br>
                  <br>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <div class="col-md-12">
                   
                  <a style="color: #6699FF; font-size:18px;" >สำหรับสถานประกอบการ</a><br>
               
              </div>
                  <a href="<?php echo base_url('/Change_pwd')?>">เปลี่ยนรหัสผ่าน&nbsp;&nbsp;&nbsp;</a>
                  <a href="<?php echo base_url('/Forgot_pwd')?>">ลืมรหัสผ่าน?</a>
                </div>
              </div>
              </form>
            </div>
          </div>
          <div class="card text-white py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <!-- <h2>ระบบสหกิจ</h2> -->
                <img src="<?php echo base_url('assets/img/new_logo_228.png');?>" style="margin-top:30px;width: 100%;">
                <!-- <img src="<?php echo base_url('assets/img/it-logo.png');?>" style="width:50%;"> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap and necessary plugins -->
  <script src="<?php echo base_url('assets/theme/jquery/dist/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/theme/popper.js/dist/umd/popper.min.js');?>"></script>
  <script src="<?php echo base_url('assets/theme/bootstrap/dist/js/bootstrap.min.js');?>"></script>

</body>
</html>