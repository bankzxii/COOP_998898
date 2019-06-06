<!-- Main content -->
<main class="main">
<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

        <div class="container-fluid">
            <div class="animated fadeIn">
                <ul id="progressbar">
                    <li class="active">รายละเอียดเกี่ยวกับสถานประกอบการ / หน่วยงาน</li>
                    <li>ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน</li>
                    <li>ข้อตกลง, สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน</li>
                    <li>เพิ่มตำแหน่งงาน</li>
                </ul>

                <div class="card">
                    <form action="<?php echo $form_url;?>" method="post">
                    <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
                    
                    
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> รายละเอียดเกี่ยวกับสถานประกอบการ / หน่วยงาน 
                    </div>
                    <div class="card-body">
            
                       <label for="name">ชื่อสถานประกอบการ / หน่วยงาน</label>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                
                                <label>(ภาษาไทย)</label> <?php echo form_error('company_name_th', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                                <input type="text" class="form-control" id="company_name_th" name="company_name_th" value="<?php echo form_value_db('company_name_th', @$company['company_name_th']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>(ภาษาอังกฤษ)</label> <?php echo form_error('company_name_en', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                                <input type="text" class="form-control" id="company_name_en" name="company_name_en" value="<?php echo form_value_db('company_name_en', @$company['company_name_en']); ?>">                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label>ที่อยู่เลขที่</label> <?php echo form_error('company_address_number', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                                <input type="text" class="form-control" id="company_address_number" name="company_address_number" value="<?php echo form_value_db('company_address_number', @$company_address['company_address_number']);?>">
                            </div>

                            <div class="form-group col-sm-5">
                                <label>อาคาร</label> <?php echo form_error('company_address_building', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                                <input type="text" class="form-control" id="company_address_building" name="company_address_building" value="<?php echo form_value_db('company_address_building', @$company_address['company_address_building']);?>">
                            </div>

                          <div class="form-group col-sm-4">
                               <label>ถนน</label> <?php echo form_error('company_address_road', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_road" name="company_address_road" value="<?php echo form_value_db('company_address_road', @$company_address['company_address_road']);?>">
                          </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-sm-3">
                               <label>ซอย</label> <?php echo form_error('company_address_alley', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_alley" name="company_address_alley" value="<?php echo form_value_db('company_address_alley', @$company_address['company_address_alley']);?>">
                          </div>

                          <div class="form-group col-sm-3">
                               <label>แขวง</label> <?php echo form_error('company_address_district', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_district" name="company_address_district" value="<?php echo form_value_db('company_address_district', @$company_address['company_address_district']);?>">
                          </div>

                          <div class="form-group col-sm-3">
                               <label>เขต/อำเภอ</label> <?php echo form_error('company_address_area', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_area" name="company_address_area" value="<?php echo form_value_db('company_address_area', @$company_address['company_address_area']);?>">
                          </div>

                          <div class="form-group col-sm-3">
                               <label>จังหวัด</label> <?php echo form_error('company_address_province', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_province" name="company_address_province" value="<?php echo form_value_db('company_address_province', @$company_address['company_address_province']);?>">
                            </div>
                        </div>

                        <div class="row">

                          <div class="form-group col-sm-3">
                               <label>รหัสไปรษณีย์</label> <?php echo form_error('company_address_postal_code', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_address_postal_code" name="company_address_postal_code" value="<?php echo form_value_db('company_address_postal_code', @$company_address['company_address_postal_code']);?>">
                          </div>

                          <div class="form-group col-sm-4">
                               <label>ประเภทกิจการ/ธุรกิจ/ผลิตภัณฑ์/ลักษณะการดำเนินงาน</label> <?php echo form_error('company_type', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_type" name="company_type" value="<?php echo form_value_db('company_type', @$company['company_type']);?>">
                          </div>

                          <div class="form-group col-sm-3">
                               <label>จำนวนพนักงาน</label> <?php echo form_error('company_total_employee', '<div class="invalid-feedback" style="display:block;">', '</div>'); ?>
                               <input type="text" class="form-control" id="company_total_employee" name="company_total_employee" value="<?php echo form_value_db('company_total_employee', @$company['company_total_employee']);?>">
                          </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">บันทึก > </button>
                            
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

</main>



<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery.thailand/dependencies/JQL.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery.thailand/dependencies/typeahead.bundle.js');?>"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery.thailand/dist/jquery.Thailand.min.css');?>">
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
<script>

    $.Thailand({
        $district: $('#district'), // input ของตำบล
        $amphoe: $('#area'), // input ของอำเภอ
        $province: $('#province'), // input ของจังหวัด
        $zipcode: $('#postal_code'), // input ของรหัสไปรษณีย์
    })

</script>