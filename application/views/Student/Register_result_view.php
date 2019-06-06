<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row" >
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> ประกาศผลการสมัครงาน
          </div>
          <div class="card-body">
            <?php if (!$company_job_position_has_student) {?>
              <div class="alert alert-warning">คุณอยู่ในสถานะต้องสมัครงานใหม่เนื่องจาก <a style=" color: red; font-size:16px;">คุณยังไม่เคยสมัครงาน</a> หรือ <a style=" color: red; font-size:16px;">ไม่ผ่านการคัดเลือก</a></div>
            <?php } else {?>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th class="text-left">ตำแหน่งงาน</th>
                    <th class="text-left">บริษัท</th>
                    <th class="text-left">สถานะบริษัท</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($company_job_position_has_student as $i => $row) {?>
                    <tr>
                      <td class="text-center"><?php echo ++$i; ?></td>
                      <td><?php echo $row['job_title']; ?></td>
                      <td><?php echo $row['company_name_th'] . " (" . $row['company_name_en'] . ")"; ?></td>
                      <td>
                        <?php 
                        if($row['company_status_id'] == 5) {
                          echo $row['coop_status_name'];
                        } else {
                          echo $row['company_status_name']; 
                        }
                        ?>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            <?php }?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



</main>