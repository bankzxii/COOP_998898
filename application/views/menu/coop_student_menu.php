
  
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html"><i class="icon-home"></i> หน้าแรก <span class="badge badge-primary">NEW</span></a>
          </li>

          <li class="nav-title">
            นิสิตฝึกสหกิจ
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-address-book-o"></i> ข้อมูลทั่วไป</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <?php echo anchor('/', '<i class="fa fa-address-card-o"></i> ข้อมูลนิสิต', 'class="nav-link"');?>  
              </li>
              <li class="nav-item">
              <?php echo anchor('Coop_student/Daily_activity/', '<i class="fa fa-edit "></i> จัดการกิจกรรมการฝึกงานแต่ละวัน', 'class="nav-link"');?>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> IN-S003</a>          
            <ul class="nav-dropdown-items">
              <li class="nav-item">
              <?php echo anchor('Coop_student/Permit_form/', '<i class="fa fa-download"></i> ดาวน์โหลดเอกสาร', 'class="nav-link"');?>
              </li>
              <li class="nav-item">
              <?php echo anchor('Coop_student/upload_document/?code=IN-S003', '<i class="fa fa-upload"></i> อัพโหลดเอกสาร', 'class="nav-link"');?>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> IN-S004</a>
            <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="components-buttons.html"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
            </li>
            <li class="nav-item">
              <?php echo anchor('Coop_student/upload_document/?code=IN-S004', '<i class="fa fa-upload"></i> อัพโหลดเอกสาร', 'class="nav-link"');?>
            </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> IN-S005</a>
            
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="components-buttons.html"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
              </li>
              <li class="nav-item">
                <?php echo anchor('Coop_student/upload_document/?code=IN-S005', '<i class="fa fa-upload"></i> อัพโหลดเอกสาร', 'class="nav-link"');?>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-doc"></i> IN-S006</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="components-buttons.html"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
              </li>
              <li class="nav-item">
                <?php echo anchor('Coop_student/upload_document/?code=IN-S006', '<i class="fa fa-upload"></i> อัพโหลดเอกสาร', 'class="nav-link"');?>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <?php echo anchor('Coop_student/Reportmanager/', '<i class="fa fa-gavel"></i> จัดการหัวข้อรายงาน', 'class="nav-link"');?>
          </li>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-file-text-o"></i> แบบสำรองทั่วไป</a>
            <ul class="nav-dropdown-items">
              <li class="nav-item">
                <a class="nav-link" href="components-buttons.html"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
              </li>
              <li class="nav-item">
                <?php echo anchor('Coop_student/upload_document/?code=IN-S006', '<i class="fa fa-upload"></i> อัพโหลดเอกสาร', 'class="nav-link"');?>
              </li>
            </ul>
          </li>
          <li class="nav-item nav-dropdown">
          <?php echo anchor('Coop_student/Assessment_st_company/', '<i class="fa fa-file-o"></i> แบบประเมินสถานประกอบการ', 'class="nav-link"');?>
          </li>

        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
