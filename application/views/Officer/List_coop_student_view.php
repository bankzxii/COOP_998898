<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li class="breadcrumb-item">Home</li>
  <li class="breadcrumb-item"><a href="#">เจ้าหน้าที่</a></li>
  <li class="breadcrumb-item active">รายชื่อนิสิตสหกิจ</li>
</ol>

<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row" >
      <!--table รายชื่อนิสิต-->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i>รายชื่อนิสิตสหกิจ</div>
              <div class="card-body">
              <table class="table table-bordered datatable" >
                    <thead>
                      <tr bgcolor="MediumSeaGreen">
                        <th class="text-center">รหัสนิสิต</th>
                        <th class="text-center" >ชื่อ-สกุล</th>
                        <th class="text-center">ตำแหน่งงาน </th>
                        <th class="text-center">บริษัท</th>
                        <th class="text-center">พี่เลียง</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $row){ 
                      ?>

                      <tr>
                        <td class="text-center"><?php echo $row['student']->id ?></td>
                        <td class="text-center"><?php echo $row['student']->fullname ?></td>
                        <td class="text-center"><?php echo $row['position_title'] ?></td>
                        <td class="text-center"><?php echo $row['company']->name_th ?></td>
                        <td class="text-center"><?php echo $row['mentor_person_id']->fullname ?></td>
                      </tr>
                    <?php 
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('/assets/js/officer/document_check.js?'.time());?>"></script>
<!-- The Modal -->
<div class="modal fade" id="document_check_student">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">ตรวจสอบเอกสารรายบุคคล</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <table class="table table-bordered" id="document_check_table">
                    <thead>
                      <tr>
                      <th width="60%">เอกสาร</th>
                      <th width="40%">ดาวน์โหลด</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
        
      </div>
    </div>
  </div>
</div>