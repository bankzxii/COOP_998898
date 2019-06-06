
<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

                <div class="container-fluid">
                  <div class="animated fadeIn">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="row">

                            <div class="col-lg-12">
                              <div class="card">
                                <div class="card-header"><i class="fa fa-align-justify"></i> รายละเอียดนิสิต</div>
                                <div class="card-body">
                                    <dl class="row">
                                    <dt class="col-sm-4">ชื่อ-นามสกุล</dt>
                                    <dd><?php echo $student['student_fullname'];?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">รหัสนิสิต</dt>
                                    <dd><?php echo $student['student_id'];?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">ชั้นปี</dt>
                                    <dd><?php echo get_student_level_from_entry_year($student_profile['Entry_Years']);?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">หลักสูตร</dt>
                                    <dd><?php echo $student_profile['Course'];?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">สาขา</dt>
                                    <dd><?php echo $department['department_name'];?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">ชื่อเล่น</dt>
                                    <dd><?php echo isEmptyText($student_profile['Student_Nickname']); ?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">จำนวนหน่วยกิจที่เรียนแล้ว</dt>
                                    <dd><?php echo isEmptyText();?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">GPAX</dt>
                                    <dd><?php echo $student['student_gpax']; ?></dd>
                                    </dl>

                                </div>
                              </div>
                            </div>   

                            <div class="col-lg-12">
                            <div class="card">
                              <div class="card-header"><i class="fa fa-align-justify"></i> ข้อมูลติดต่อ</div>
                              <div class="card-body">
                                <dl class="row">
                                  <dt class="col-sm-4">เบอร์โทรศัพท์</dt>
                                  <dd><?php echo isEmptyText($student_profile['Student_Phone']); ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">อีเมล</dt>
                                  <dd><?php echo isEmptyText($student_profile['Student_Email']); ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">เฟสบุ๊ค</dt>
                                  <dd><?php echo isEmptyText($student_profile['Facebook']); ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">Line ID</dt>
                                  <dd><?php echo isEmptyText($student_profile['Line']); ?></dd>
                                </dl>
                                        
                          
                              </div>
                            </div>
                          </div>

                           



                        </div>


                      </div>

                      <div class="col-lg-6">
                        <div class="row">

                         <div class="col-lg-12">
                              <div class="card">
                                <div class="card-header"><i class="fa fa-align-justify"></i> ข้อมูลสหกิจศึกษา</div>
                                  <div class="card-body">

                                    <dl class="row">
                                    <dt class="col-sm-4">
                                    <a class="btn btn-primary document_check_btn " data-studentid="<?php echo $student['student_id'];?>"><i class="fa fa-list-alt"></i> Resume </a>
                                    </dt>
                                    <dd></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">สถานะ</dt>
                                    <dd><?php echo $coop_status_type['coop_status_name']; ?></dd>
                                    </dl>

                                    <dl class="row">
                                    <dt class="col-sm-4">วิชาแกน</dt>
                                    <dd>
                                    <?php if($student['student_core_subject_status']== 1) {
                                        echo "ผ่าน";
                                    }else if($student['student_core_subject_status']== 0){
                                         echo "ไม่ผ่าน";
                                    } ?>
                                    </dd>
                                    </dl>

                                    <dl class="row">
                                      <dt class="col-sm-4">จำนวนชั่วโมงอบรม</dt>
                                      <dd><a href="<?php echo site_url('Company/Student/training_history_student/'.$student['student_id']);?>">ประวัติการอบรมของนิสิตคนนี้</a></dd>
                                    </dl>

                                    <dl class="row">
                                      <dt class="col-sm-4">
                                        <ul>
                                          <li>วิชาการ</li>
                                          <li>เตรียมความพร้อม</li>
                                        </ul>
                                      </dt>
                                      <dd>
                                        <ul class="list-unstyled">
                                          <li><?php echo number_format($train_type[0]['check_hour'], 2);?> / <?php echo $train_type[0]['total_hour'];?> ชั่วโมง</li>
                                          <li><?php echo $train_type[1]['check_hour'];?> / <?php echo $train_type[1]['total_hour'];?> ชั่วโมง</li>
                                        </ul>
                                      </dd>
                                    </dl>
                              </div>
                            </div>
                          </div>

                          
        
                          

                        <?php
                        if(@$coop_student) {
                        ?>
              
                          <div class="col-lg-12">
                            <div class="card">
                              <div class="card-header"><i class="fa fa-align-justify"></i> ข้อมูลสถานประกอบการ</div>
                              <div class="card-body">
                                <dl class="row">
                                  <dt class="col-sm-4">ชื่อสถานประกอบการ</dt>
                                  <dd><?php echo $company['company_name_th'] ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">ตำแหน่งงานที่สมัคร</dt>
                                  <dd><?php echo $job['job_title'] ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">อาจารย์ที่ปรึกษา</dt>
                                  <dd><?php echo $adviser['adviser_fullname'] ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">พี่เสี่ยง</dt>
                                  <dd><?php echo $trainer['person_fullname'] ?></dd>
                                </dl>

                                <dl class="row">
                                  <dt class="col-sm-4">ผลการประเมิน</dt>
                                  <dd><a href="<?php echo site_url('Company/Coop_student_assessment/form/'.$student['student_id']); ?>">ดูผลการประเมิน</a></dd>
                                </dl>

                              </div>
                            </div>
                          </div>
                        <?php } ?>


                        </div>
                      </div>






                      

                      
                    </div>
                  </div>
                </div>   
</main>     


<script src="<?php echo base_url('/assets/js/company_js/document_check_by_code.js?'.time());?>"></script>
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



