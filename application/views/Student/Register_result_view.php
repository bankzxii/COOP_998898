<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row" >
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><i class="fa fa-align-justify"></i> ประกาศผลการสมัครงาน
          </div>
            <div class="card-body">
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
                    <?php $i=1; foreach ($company_job_position_has_student as $row) { ?>
                     <tr>
                      <td class="text-center"><?php echo $i++; ?></td>
                      <td><?php echo $row['position_title'];?></td>
                      <td><?php echo $row['name_th']." (".$row['name_en'].")";?></td>
                      <td><?php echo $row['status_name'];?></td>
                     </tr>
                    <?php } ?>
                    </tbody>
                  </table>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>

 
