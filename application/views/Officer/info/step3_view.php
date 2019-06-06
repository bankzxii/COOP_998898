<!-- Main content -->
<main class="main">
<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

        <div class="container-fluid">
            <div class="animated fadeIn">
                <ul id="progressbar">
                    <li class="active">รายละเอียดเกี่ยวกับสถานประกอบการ / หน่วยงาน</li>
                    <li class="active">ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน</li>
                    <li class="active">ข้อตกลง, สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน</li>
                    <li>เพิ่มตำแหน่งงาน</li>
                </ul>

                <div class="card">
                    <form action="<?php echo $form_url;?>" method="post">
                    <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> ข้อตกลง, สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน 
                    </div>
                    <div class="card-body">
                        
                        <label for="name"><b>ข้อตกลง</b></label>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label>เวลาเริ่มงาน</label> <?php echo form_error('company_start_time'); ?>
                                <input type="time" class="form-control" id="company_start_time" name="company_start_time" value="<?php echo form_value_db('company_start_time', @$company['company_start_time']); ?>">                                
                            </div>
                            <div class="form-group col-sm-5">
                                <label>เวลาเลิกงาน</label> <?php echo form_error('company_end_time'); ?>
                                <input type="time" class="form-control" id="company_end_time" name="company_end_time" value="<?php echo form_value_db('company_end_time', @$company['company_end_time']); ?>">                                
                            </div>
                            <div class="form-group col-sm-2">
                                <label>จำนวนวันทำงาน</label> <?php echo form_error('company_work_day'); ?>
                                <input min="1" max="7" type="number" class="form-control" id="company_work_day" name="company_work_day" value="<?php echo form_value_db('company_work_day', @$company['company_work_day']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>ข้อกำหนดอื่น ๆ </label> <?php echo form_error('company_agreement'); ?>
                                <textarea class="form-control" id="company_agreement" name="company_agreement"><?php echo form_value_db('company_agreement', @$company['company_agreement']); ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">ต้องการนิสิตในสาขาวิชา (เลือกได้มากกว่า 1 สาขา)</label> <?php echo form_error('company_has_department[]'); ?>  
                            </div>
                            <?php 
                            foreach($departments as $department) { 
                                $checked = '';

                                if(in_array($department['department_id'], $company_has_department)) {
                                    $checked = 'checked';
                                } else {
                                    $checked = set_checkbox('company_has_department', $department['department_id']);                                    
                                }
                            ?>
                            <div class="form-group col-sm-4">
                                <input type="checkbox" name="company_has_department[]" value="<?php echo $department['department_id'];?>" id="department_<?php echo $department['department_id'];?>" <?php echo $checked; ?>> <label for="department_<?php echo $department['department_id'];?>"><?php echo $department['department_name'];?></label>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">ระยะเวลาที่ต้องการให้นักศึกษาไปปฏิบัติงาน (สามารถเลือกได้มากกว่า 1 ช่วงเวลา)</label> <?php echo form_error('company_work_month[]'); ?>  
                            </div>
                            <div class="form-group col-sm-4">
                                <input type="checkbox" name="company_work_month[]" value="4|7" id="work_month_1" <?php if( in_array('4|7', $company_work_month) || set_checkbox('company_work_month', '4|7') ) echo 'checked'; ?>> <label for="work_month_1">ภาคเรียนฤดูร้อน (เม.ษ. - ก.ค.)</label>
                            </div>
                            <div class="form-group col-sm-4">
                                <input type="checkbox" name="company_work_month[]" value="8|12" id="work_month_2" <?php if( in_array('8|12', $company_work_month) || set_checkbox('company_work_month', '8|12') ) echo 'checked'; ?>> <label for="work_month_2">ภาคเรียนที่ 1 (ส.ค. - ธ.ค.)</label>
                            </div>
                            <div class="form-group col-sm-4">
                                <input type="checkbox" name="company_work_month[]" value="1|5" id="work_month_3" <?php if( in_array('1|5', $company_work_month) || set_checkbox('company_work_month', '1|5') ) echo 'checked'; ?>> <label for="work_month_3">ภาคเรียนที่ 2 (ม.ค. - พ.ค.)</label>
                            </div>
                        </div>

                        <div style="height:20px;"></div>
                        <hr>
                        <div style="height:20px;"></div>

                        <label for="name"><b>สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน</b></label>

                        <div class="row">
                            <div class="form-group col-sm-2">
                                <label>ค่าตอบแทน</label><br><?php echo form_error('benefit_wage'); ?>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_wage" value="0" <?php if(form_value_db('benefit_wage', @$company_benefit['benefit_wage']) == 0) echo 'checked';?>> <label>ไม่มี</label>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_wage" value="1" <?php if(form_value_db('benefit_wage', @$company_benefit['benefit_wage']) == 1) echo 'checked';?>> <label>มี</label><br>
                                ค่าใช้จ่าย <input type="text" id="benefit_wage_period" name="benefit_wage_period" value="<?php echo form_value_db('benefit_wage_period', @$company_benefit['benefit_wage_period']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-2">
                                <label>ที่พัก</label><br><?php echo form_error('benefit_dorm'); ?>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_dorm" value="0" <?php if(form_value_db('benefit_dorm', @$company_benefit['benefit_dorm']) == 0) echo 'checked';?>> <label>ไม่มี</label>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_dorm" value="1" <?php if(form_value_db('benefit_dorm', @$company_benefit['benefit_dorm']) == 1) echo 'checked';?>> <label>มี</label><br>
                                ค่าใช้จ่าย <input type="text" id="benefit_dorm_period" name="benefit_dorm_period" value="<?php echo form_value_db('benefit_dorm_period', @$company_benefit['benefit_dorm_period']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-2">
                                <label>รถรับส่ง</label><br><?php echo form_error('benefit_shuttlebus'); ?>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_shuttlebus" value="0" <?php if(form_value_db('benefit_shuttlebus', @$company_benefit['benefit_shuttlebus']) == 0) echo 'checked';?>> <label>ไม่มี</label>
                            </div>
                            <div class="form-group col-sm-5">
                                <input type="radio" name="benefit_shuttlebus" value="1" <?php if(form_value_db('benefit_shuttlebus', @$company_benefit['benefit_shuttlebus']) == 1) echo 'checked';?>> <label>มี</label><br>
                                ค่าใช้จ่าย <input type="text" id="benefit_shuttlebus_period" name="benefit_shuttlebus_period" value="<?php echo form_value_db('benefit_shuttlebus_period', @$company_benefit['benefit_shuttlebus_period']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>สวัสดิการอื่น ๆ </label> <?php echo form_error('benefit_other'); ?>
                                <textarea class="form-control" id="benefit_other" name="benefit_other"><?php echo form_value_db('benefit_other', @$company_benefit['benefit_other']); ?></textarea>
                            </div>
                        </div>



                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <a href="<?php echo $back_url;?>" class="btn btn-secondary"> < ย้อนกลับ </a>                        
                            <button type="submit" class="btn btn-success">บันทึก > </button>
                            
                        </div>
                    </div>
                    </form>
                </div>
                


            </div>
        </div>

</main>
