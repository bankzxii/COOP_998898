<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row" >
      <!--table รายชื่อนิสิต-->
      <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i>เปลี่ยนรหัสผ่านสถานประกอบการ</div>
          <div class="card-body">
	 <div class="col-md-12">
                    <div class="alert alert-primary">
                        <b>**กรุณากรอกอีเมล์และรหัสผ่านใหม่ของเจ้าหน้าที่ HR ของสถานประกอบการ</b>
                        
                    </div>

                </div>
              <form action="<?php echo site_url('Officer/Company/Change_pwd');?>" method="post">
	<table border="1">
	<tr>
		<td>Email</td>
		<td><input type="email" name="email"></td>
	</tr>
	<!--<tr>
		<td>Old Password</td>
		<td><input type="Password" name="Old_pwd"></td>
	</tr>-->
	<tr>
		<td>New Password</td>
		<td><input type="Password" name="New_pwd"></td>
	</tr>
	</table>
</br>
	<button type="submit" class="btn btn-success" name="edit" id="change_student_status">เปลี่ยนรหัสผ่าน</button>
</form>
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


