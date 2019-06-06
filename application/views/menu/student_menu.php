
  
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url('Student/main');?>"><i class="icon-home"></i> หน้าแรก <span class="badge badge-primary">NEW</span></a>
          </li>

          <li class="nav-title">
            นิสิต
          </li>
          <li class="nav-item nav-dropdown">
          <a class="nav-link" href="<?php echo site_url('Student/Profile/view');?>" target="_top"><i class="icon-notebook"></i> ประวัตินิสิต</a>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i> การอบรม</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
              <?php echo anchor('Student/Training/check_hour/', '<i class="fa fa-hourglass-start"></i> ตรวจสอบชั่วโมงอบรม', 'class="nav-link"');?>
              </li>
              <li class="nav-item">
              <?php echo anchor('Student/Training/check_history/', '<i class="fa fa-history"></i> ตรวจสอบประวัติอบรม', 'class="nav-link"');?>
              </li>
              <li class="nav-item">
                <!-- <?php echo anchor('Student/Training/register/', '<i class="fa fa-registered"></i> สมัครเข้าร่วมอบรม', 'class="nav-link"');?> -->
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-note"></i> การสอบสหกิจ</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('student/test/lists');?>" target="_top"><i class="fa fa-registered"></i> สมัครสอบสหกิจ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('student/test/result');?>" target="_top"><i class="fa fa-file-pdf-o"></i> ประกาศผลสอบ</a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-graduation"></i> สหกิจศึกษา</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Student/Job/lists');?>" target="_top"><i class="icon-list"></i> ตำแหน่งงานที่เปิดรับ</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Student/Job/register_status');?>" target="_top"><i class="fa fa-bell-o"></i> ประกาศผลการสมัคร</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Student/Skill/');?>" target="_top"><i class="fa fa-check"></i> ทักษะที่ถนัด</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('Student/Upload_document/');?>" target="_top"><i class="fa fa-upload"></i> อัพโหลดเอกสาร</a>
              <!-- <a class="nav-link" href="#" target="_top"><i class="fa fa-upload"></i> อัพโหลดเอกสาร</a> -->
              
              </li>
            </ul>
          </li>

	<li class="nav-item nav-dropdown">
          <a class="nav-link" href="https://docs.google.com/document/d/17JCPThIT9Gsus371QmDSgD1TpSdI_T8zzdvDTaQanO4/edit?fbclid=IwAR06iP6oD2gXBQm12LN37pG-WvhFsJA5rU3eey2KnvB2wrt3LuMEdaT7GNw#"><i class="icon-notebook"></i> คู่มือการใช้งาน</a>
        </li>
	<!--คู่มือนิสิต -->
        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
