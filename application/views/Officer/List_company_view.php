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
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> จัดการข้อมูลสถานประกอบการ

                        <form action="<?php echo base_url('Officer/Company/deleteAll/');?>" method="post">
                        <button type="submit" class="btn btn-danger float-right">ซ่อนบริษัททั้งหมด</button>
                          </form>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-hand-pointer-o"></i> เพิ่มสถานประกอบการ
                        </button>
                    </div>
                      <div class="card-body">
                      <?php 
                          if($status){
                            echo '<div class="alert alert-'.$status['color'].'">'.$status['text'].'</div>';
                          }
                  
                        ?>
                          <br>

                
                              <table class="table table-bordered datatable" >
                              <thead>
                                <tr bgcolor="">

                                  <th class="text-left">
                                  </th>
                                  <th class="text-left">ชื่อสถานประกอบการ</th>
                                  <th class="text-left">จำนวนเจ้าหน้าที่</th>
                                  <th class=""></th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($data as $row){?>
                                <tr>
                                  <td class="text-center">
                                    
                                  </td>
                                  <td class="text-left"><?php echo $row['company_name_th'];?> (<?php echo $row['company_name_en'];?>)
                                    <?php 
                                      if($row['company_status'] == 'deactive') {
                                        echo '<span class="badge badge-warning">ถูกซ่อน</span>';
                                      }
                                  ?>
                                  </td>
                                  <td class="text-right"><?php echo $row['company_total_employee']; ?></td>
                                  <td class="form-inline">
                                        <?php echo anchor('Officer/Trainer/lists/'.$row['company_id'], '<i class="fa fa-user-circle-o"></i> เจ้าหน้าที่', 'class="btn  btn-primary"');?>                              
                                        <div style="width:2%"></div>
                                        <?php echo anchor('Officer/Company_info/step1/'.$row['company_id'], '<i class="fa fa-list-alt"></i> รายละเอียด', 'class="btn  btn-primary"');?>   
                                        <div style="width:2%"></div>                           
                                        <?php echo anchor('Officer/Company/address/'.$row['company_id'], '<i class="fa fa-address-card-o"></i> ที่อยู่', 'class="btn  btn-primary"');?>             
  				      <div style="width:2%"></div>
                                        <?php echo anchor('Officer/Company/delete/'.$row['company_id'], '<i class="fa fa-eraser"></i> ซ่อนบริษัท', 'class="btn btn-danger"');?>
                                        <div style="width:2%"></div>
                                        <?php echo anchor('Officer/Company/undelete/'.$row['company_id'], '<i class="fa fa-eraser"></i> โชว์บริษัท', 'class="btn btn-success"');?>
                                  </td>
                                </tr>
                              <?php 
                              }
                              ?>
                              </tbody>
                            </table>
                            <br>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มสถานประกอบการ</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
            </div>
            <form action="<?php echo site_url('Officer/Company/post_add');?>" method="post">
              <div class="modal-body">
                <div class="col-md-12">
                  <label>ชื่อสถานประกอบการ</label>
                  <input type="text" id="company_name" name="company_name" class="form-control" placeholder="ชื่อบริษัท">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-success">บันทึก</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  function check_uncheck_checkbox(isChecked) {
    if(isChecked) {
      $('input[name="chkbox[]"]').each(function() { 
        this.checked = true; 
      });
    } else {
      $('input[name="chkbox[]"]').each(function() {
        this.checked = false;
      });
    }
  }

</script>