
  
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('Adviser/main');?>"><i class="icon-home"></i> หน้าแรก <span class="badge badge-primary">NEW</span></a>
          </li>

          <?php if($user_info['adviser_is_officer'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('Adviser/main/change_to_officer');?>"><i class="fa fa-exchange"></i> เข้าสู่เมนูเจ้าหน้าที่</a>
          </li>
          <?php } ?>

          <li class="nav-title">
            อาจารย์
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> นิสิต</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Adviser/Coop_student/');?>"><i class="icon-doc"></i> รายชื่อนิสิตที่ปรึกษา</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Adviser/Report_Form_plan/');?>"><i class="icon-docs"></i> แบบแจ้งแผนปฎิบัติการสหกิจ</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Adviser/Daily_activity/');?>"><i class="icon-docs"></i> กิจกรรมการฝึกงานในแต่ละวัน</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graduation"></i> สหกิจ</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Adviser/Map_student_list/');?>"><i class="icon-map"></i> แสดงพิกัดงาน</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-notebook"></i> การประเมินผล</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Adviser/Coop_student_assessment');?>"><i class="icon-docs"></i> ผลการฝึกงานของนักศึกษา</a>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graph"></i> สถิติ</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Adviser/Report_cooperative');?>"><i class="icon-graph"></i> รายงานการไปสหกิจ</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('Adviser/Coop_student/exam_score');?>"><i class="fa fa-list-ol"></i> คะแนนสอบ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('Adviser/Coop_map/map_view');?>"><i class="fa fa-list-ol"></i> แผนที่</a>
          </li>
        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
