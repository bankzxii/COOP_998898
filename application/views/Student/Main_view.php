    <!-- Main content -->
    <main class="main">

    <?php echo $this->breadcrumbs->show() ;?>


      <div class="container-fluid">
        <div class="animated fadeIn">
          <div class="row">

                <?php if( count($ins001) < 1 ) : ?>
                <div class="col-md-12">
		    <div class="alert alert-primary">
                <a style=" font-size:20px;">ขั้นตอนสมัครสหกิจ</a><br>
			<b>1.โปรดอัพเดทข้อมูลนิสิตก่อนเข้าใช้งาน</b>
                        <a href="http://prepro.informatics.buu.ac.th:8003/index.php/c_login/login" style="color: red; font-size:18px;">คลิ๊กเพื่ออัพเดทข้อมูลนิสิต (สำคัญ** ให้อัพเดทข้อมูลประวัติของตัวเองหากไม่กรอก ข้อมูลใน IN-S001 จะไม่ครบถ้วน)</a><br>
                        <b>2.โปรดสมัครเข้าร่วมเป็นนิสิตสมัครสหกิจก่อนเข้าใช้งานค่ะ</b>
                        <a href="<?php echo site_url('Student/Main/coop_register');?>" style="color: red; font-size:18px;"> คลิ้กเพื่อดาวน์โหลด IN-S001</a>
                       <b> หลังจากดาวน์โหลดเอกสารเสร็จแล้วให้นำส่งเจ้าหน้าที่ของคณะ เพื่อสมัครเป็นนิสิตสหกิจ</b><br>
                        <b>3.ดูผลการสมัครสหกิจ : </b>
                        <a href="http://prepro.informatics.buu.ac.th:8001/index.php/Student/Job/register_status" style="color: red; font-size:18px;"> คลิ๊กเพื่อตรวจสอบผลการสมัคร</a>

                    </div>

                </div>
                <?php endif; ?>

                <?php if($status) : ?>
                <div class="col-md-12">
                    <div class="alert alert-<?php echo $status['color'];?>">
                        <b><?php echo $status['text'];?></b>
                    </div>

                </div>
                <?php endif; ?>

                <?php if($session_alert) : ?>
                <div class="col-md-12">
                    <?php echo $session_alert;?>

                </div>
                <?php endif; ?>

                

            <?php foreach($rowNews as $row) { ?>
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $row['news_title'];?>
                            <span class="btn btn-danger float-right"><?php echo thaiDate(date('Y-m-d H:i', strtotime($row['news_date'])), false, false);?></span>                            
                        </div>
                        <div class="card-body">
                            <?php echo $row['news_detail'];?>
                        </div>

                        <?php if(@$row['file']) { ?>                        
                        <div class="card-footer">
                            ดาวน์โหลดไฟล์:
                            <?php 
                            foreach($row['file'] as $rowFile) {
                                echo '<a href="'.base_url('uploads/'.$rowFile).'" class="btn btn-xs btn-info">'.basename($rowFile).'</a>';
                            }
                            ?>
                        </div>
                        <?php } ?>
                        
                    </div>
                </div>  
            <?php } ?> 
          </div>  
        </div>
      </div>
      <!-- /.conainer-fluid -->
    </main>

