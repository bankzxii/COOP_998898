<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show() ;?>


<div class="container-fluid">
  <div class="animated fadeIn">

    <div class="row" >
      <div class="col-sm-12">

        <?php if($session_alert) : ?>
          <div class="col-md-12">
            <?php echo $session_alert;?>
          </div>
        <?php ; else : ?>


        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> รายการสมัคร ตำแหน่งงาน และสถานประกอบการ
          </div>

          <div class="card-body">
            <div class="row">
              
                
              <form action="<?php echo site_url('Student/Job/lists');?>" method="post" style="width: 100%;display: inline-flex;">

                <div class="form-group col-sm-4">
                  <label for="company_id">บริษัท</label>
                  <select class="form-control" id="company_id" name="company_id">
                    <option value="0">-- บริษัททั้งหมด --</option>
                    <?php foreach($company as $row) {?>
                      <option value="<?php echo $row['company_id'];?>" <?php echo set_select('company_id', $row['company_id']); ?> ><?php echo $row['company_name_th']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-sm-4">
                  <label for="job_title_id">ตำแหน่งงาน</label>
                  <select class="form-control" id="job_title_id" name="job_title_id">
                    <option value="0">-- ตำแหน่งงานทั้งหมด --</option>
                    <?php foreach($job as $row) {?>
                      <option value="<?php echo $row['job_title_id'];?>" <?php echo set_select('job_title_id', $row['job_title_id']); ?> ><?php echo $row['job_title']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-sm-4">
                  <label for=""></label>
                  <div class="form-control" style="border: unset;">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> ค้นหา</button>
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
        <?php if(!$pass_training) { ?>
             <?php echo'<div class="col-lg-12"><div class="alert alert-warning"> ชั่วโมงอบรมของคุณยังไม่ผ่าน การสมัครงานในขณะที่ชั่งโมงไม่ผ่านมีผลต่อการพิจรณาไปสหกิจ </div></div>';}
          
          if(count($data) < 1) {
            echo '<div class="col-lg-12"><div class="alert alert-warning">บริษัทยังไม่เปิดให้สมัครงาน</div></div>';
          }
          foreach($data as $row) {
          ?>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <i class="fa fa-building"></i> ชื่อบริษัท: <?php echo $row['company']['company_name_th'];?>
                  <span class="btn btn-danger float-right">ตำแหน่งงาน: <?php echo $row['company_job_position']['job_title'];?></span>
                </div>
                <div class="card-body">
                  <p>รายละเอียด: <?php echo $row['company_job_position']['job_description'];?></p>
                  <p>ทักษะที่ควรมี: <?php echo $row['company_job_position']['job_skill'];?></p>
                  <p>ลักษณะบริษัท: <?php echo $row['company']['company_type'];?></p>                            
                  <p>เวลาทำงาน: <?php echo $row['company']['company_start_time'];?>-<?php echo $row['company']['company_end_time'];?></p>
                  <p>พื้นที่: <?php echo $row['address_company']['company_address_province'];?></p>
                  <?php if($row['company']['company_website']) : ?>
                  <p>เว็บไซต์: <a href="<?php echo $row['company']['company_website'];?>"><?php echo $row['company']['company_website'];?></a> </p>
                  <?php endif; ?>
                  <?php echo anchor('Student/Job/register_form_company/'.$row['company']['company_id'].'/'.$row['company_job_position']['job_id'], '<i class="icon-pencil"></i> กรอกใบสมัคร', 'class="btn btn-success btn-lg"');?> 
                </div>
              </div>
            </div>
          <?php } ?>  

          <?php endif; ?>

      </div>
    </div>
  </div>
</div>

 
