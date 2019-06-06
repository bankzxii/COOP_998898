<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/util.css');?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/main.css');?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('fonts/font-awesome-4.7.0/css/font-awesome.min.css');?>">
</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('/assets/img/bg-01.jpg');">
      <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
        <form action="<?php echo base_url('Change_pwd/get_company_person');?>" method="post">
          <span class="login100-form-title p-b-53">
            Change Password
          </span>
          <div class="p-t-31 p-b-9">
            <span class="txt1">
              username
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Username is required">
            <input class="input100" type="text" name="username" >
            <span class="focus-input100"></span>
          </div>
          
          <div class="p-t-13 p-b-9">
            <span class="txt1">
              Old Password
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100" type="password" name="old_pass" >
            <span class="focus-input100"></span>
          </div>
          <div class="p-t-13 p-b-9">
            <span class="txt1">
              New Password
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100" type="password" name="new_pass" >
            <span class="focus-input100"></span>
          </div>
          <div class="p-t-13 p-b-9">
            <span class="txt1">
              Comfirm Password
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100" type="password" name="confirm_pass" >
            <span class="focus-input100"></span>
          </div>

          <div class="container-login100-form-btn m-t-17">
            <button type=submit class="login100-form-btn">
              Submit  
            </button>
          </div>
              <div style="height:40px;"></div>
                    
                        
                        </div> 

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>




</body>
</html>