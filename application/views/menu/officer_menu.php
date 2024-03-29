
  
    <div class="sidebar">

    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('Officer/main');?>"><i class="icon-home"></i> ประกาศข่าวสาร</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#selectTermBox"><i class="icon-clock"></i> ปีการศึกษา: <b><?php echo $current_term['term_name'];?></b></a>
        </li>

        <?php if(@$user_info['is_adviser'] == 1) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('Officer/main/change_to_adviser');?>"><i class="fa fa-exchange"></i> กลับสู่เมนูอาจารย์</a>
        </li>
        <?php } ?>

        <li class="nav-title">
          เจ้าหน้าที่
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> จัดการนิสิต</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Students', '<i class="icon-list"></i> เปลี่ยนสถานะ', 'class="nav-link"');?>
            </li>
            
            
          </ul>
        </li>



        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-mortar-board"></i> จัดการอาจารย์</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Adviser', '<i class="fa fa-tripadvisor"></i> อ.ที่ปรึกษากับนิสิต', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Adviser/map_view', '<i class="icon-list"></i> แผนที่', 'class="nav-link"');?>
            </li>

          </ul>
        </li>

        <li class="nav-item nav-dropdown">  
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-building"></i> จัดการผู้ประกอบการ</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Company/', '<i class="fa fa-address-book-o"></i> ข้อมูลสถานประกอบการ', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Company/Change_pwd_view', '<i class="fa fa-address-book-o"></i> เปลี่ยนรหัสผ่าน', 'class="nav-link"');?>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('Officer/News');?>"><i class="fa fa-bullhorn"></i> ประกาศข่าวหน้าเว็บ </a>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-book"></i> จัดการการอบรม</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Training/', '<i class="fa fa-address-book-o"></i> ข้อมูลโครงการอบรม', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Train_check_student/', '<i class="fa fa-calendar-check-o"></i>  เช็คชื่อเข้าอบรม', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Train_location/', '<i class="fa fa-edit"></i> สถานที่อบรม', 'class="nav-link"');?>
            </li>
          </ul>
        </li>
        <!-- โค้ดไม่มีการอัพเดท, น่าจะไม่ได้ใช้ส่วนนี้ -->
        <!--<li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-check"></i> จัดการสอบ</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Test_form/', '<i class="fa fa-leanpub"></i> ข้อมูลรับสมัครการสอบ', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Test_Management/', '<i class="fa fa-th-list"></i> ข้อมูลนิสิตเข้าสอบ', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Test_result/', '<i class="fa fa-check"></i> ผลการสอบ', 'class="nav-link"');?>
            </li>
          </ul>
        </li>-->
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graph"></i> รายงาน</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Coop_student/', '<i class="fa fa-handshake-o"></i> รายชื่อนิสิตสหกิจ', 'class="nav-link"');?>            
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Coop_student/exam_score', '<i class="fa  fa-list-ol"></i> คะแนนนิสิตสหกิจ', 'class="nav-link"');?>            
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Coop_Submitted_Form_Search/by_student', '<i class="icon-doc"></i> ส่งเอกสาร (บุคคล)', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Coop_Submitted_Form_Search/by_form', '<i class="icon-docs"></i> ส่งเอกสาร (ประเภท)', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Coop_student_assessment_result/', '<i class="fa fa-check-square-o"></i> ผลประเมินนิสิต', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Company_assessment_result/', '<i class="fa fa-check-square-o"></i> ผลประเมินบริษัท', 'class="nav-link"');?>
            </li>

            <li class="nav-item">
              <?php echo anchor('Officer/Report_cooperative/', '<i class="fa fa-tasks"></i> สรุปภาพรวม', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Report_cooperative/to_excel', '<i class="fa fa-file-excel-o"></i> ส่งออกเป็น Excel', 'class="nav-link"');?>
            </li>
                        
          </ul>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-file-o"></i> จัดการแบบประเมิน</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
            <?php echo anchor('Officer/Company_assessment_form/', '<i class="fa fa-tasks"></i> แบบประเมินบริษัท', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Coop_student_assessment_form/', '<i class="fa fa-mortar-board"></i> แบบประเมินนิสิต', 'class="nav-link"');?>
            </li>
          </ul>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-cogs fa-md fa-spin"></i> ตั้งค่า</a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <?php echo anchor('Officer/Setting/lists_job_title', '<i class="fa fa-gear"></i> จัดการตำแหน่งงาน', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
              <?php echo anchor('Officer/Setting/lists_skill_name', '<i class="fa fa-gear"></i> จัดการประเภททักษะ', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Setting/edit_term', '<i class="fa fa-gear"></i> ภาคปีการศึกษา', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Setting/edit_document', '<i class="fa fa-gear"></i> กำหนดเอกสาร', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Setting/adviser_setting', '<i class="fa fa-gear"></i> เปลี่ยนสิทธิ์อาจารย์', 'class="nav-link"');?>
            </li>
            <li class="nav-item">
            <?php echo anchor('Officer/Setting/core_subjects_list', '<i class="fa fa-gear"></i> จัดการวิชาแกน', 'class="nav-link"');?>
            </li>
          </ul>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link" href="https://drive.google.com/uc?id=1NpTv2QHjiGA6QZ9kp9bqwEp8Aolk6IXt&authuser=0&export=download"><i class="icon-notebook"></i> คู่มือการใช้งาน</a>
        </li>
    </nav>
    <button class="sidebar-minimizer brand-minimizer sidebar-minimized" type="button"></button>
  </div>


<div class="modal fade" id="selectTermBox">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เลือกปีการศึกษา</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="term_option">ปีการศึกษา</label>
            <select class="form-control" id="term_option">
              <option disabled> ------ </option>
              <?php 
              foreach($terms as $term) {
                if($current_term['term_id'] == $term['term_id']) {
                  echo '<option value="'.$term['term_id'].'" selected>'.$term['term_name'].'</option>';
                } else {
                  echo '<option value="'.$term['term_id'].'">'.$term['term_name'].'</option>';                  
                }
              }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="changeTermAjax()">เปลี่ยนปีการศึกษา</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิดหน้าต่าง</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/js/officer_js/term.js');?>"></script>

