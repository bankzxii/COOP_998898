<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show() ;?>


<div class="container-fluid">
  <div class="animated fadeIn">

    <div class="row" >
      <div class="col-sm-12">


        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> รายการสมัคร ตำแหน่งงาน และสถานประกอบการ
          </div>

          <div class="card-body">
            <div class="row">
              <form action="<?php echo site_url('student/job/lists');?>" method="post" style="width: 100%;display: inline-flex;">

                <div class="form-group col-sm-4">
                  <label for="company_id">บริษัท</label>
                  <select class="form-control" id="company_id" name="company_id">
                    <option value="0">-- บริษัททั้งหมด --</option>
                    <?php foreach($company as $row) {?>
                      <option value="<?php echo $row['id'];?>" <?php echo set_select('company_id', $row['id']); ?> ><?php echo $row['name_th']; ?></option>
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

          <?php 
          if(count($data) < 1) {
            echo '<div class="col-lg-12"><div class="alert alert-warning">ไม่พบข้อมูล</div></div>';
          }
          foreach($data as $row) {
          ?>
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <i class="fa fa-building"></i> ชื่อบริษัท: <?php echo $row['company']['name_th'];?>
                  <span class="btn btn-danger float-right">ตำแหน่งงาน: <?php echo $row['company_job_position']['position_title'];?></span>
                </div>
                <div class="card-body">
                  <p>รายละเอียด: <?php echo $row['company_job_position']['job_description'];?></p>
                  <p>ลักษณะบริษัท: <?php echo $row['company']['company_type'];?></p>                            
                  <p>เวลาทำงาน: <?php echo $row['company']['work_start_time'];?>-<?php echo $row['company']['work_end_time'];?></p>
                  <p>พื้นที่: <?php echo $row['address_company']['province'];?></p>
                  <?php if($row['company']['website_url']) : ?>
                  <p>เว็ปไซต์: <a href="<?php echo $row['company']['website_url'];?>"><?php echo $row['company']['website_url'];?></a> </p>
                  <?php endif; ?>
                  <?php echo anchor('Student/Job/register_form_company/'.$row['company']['id'].'/'.$row['company_job_position']['id'], '<i class="icon-pencil"></i> กรอกใบสมัคร', 'class="btn btn-success btn-lg"');?> 
                </div>
              </div>
            </div>
          <?php } ?>  

      </div>
    </div>
  </div>
</div>

 