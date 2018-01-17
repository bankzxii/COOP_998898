<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<ol class="breadcrumb">
  <li class="breadcrumb-item">Home</li>
  <li class="breadcrumb-item"><a href="#"><?php echo $user->login_type;?></a></li>
  <li class="breadcrumb-item active">แบบอนุญาติให้นิสิตไปปฏิบัติงานสหกิจ</li>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row" >
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><i class="fa fa-align-justify"></i>แบบอนุญาติให้นิสิตไปปฏิบัติงานสหกิจ</div>

              <div class="card-body">

                <div class="card-header"><strong> 1.ข้อมูลทั่วไป</strong></div>
              
                

                <form id="permit_form">
                 <div class="row">
                 <div class="form-group col-sm-8">
                   <label for="fullname">ชื่อนิสิต นาย/นางสาว</label>
                   <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $student->fullname ?>">
                  </div>
                 </div>
                 <div class="row">
                  <div class="form-group col-sm-4">
                   <label for="student_code">รหัสนิสิต</label>
                   <input type="text" class="form-control" id="student_code" name="student_code" value="<?php echo $student->student_id ?>">
                  </div>
                  <div class="form-group col-sm-4">
                   <label for="student_field">สาขาวิชา</label>
                   <input type="text" class="form-control" id="student_field" name="student_field" value="<?php echo $student->student_field ?>">
                </div>
                <div class="form-group col-sm-4">
                   <label for="city">หลักสูตร</label>
                   <input type="text" class="form-control" id="city" placeholder="">
                  </div>
              </div>
              <div class="row">
              <div class="form-group col-sm-8">
                   <label for="allower_fullname">ชื่อผู้ปกครอง นาย/นาง/นางสาว</label>
                   <input type="text" class="form-control" id="allower_fullname" name="allower_fullname" value="<?php echo @$permit->allower_fullname;?>">
                  </div>
              </div>
              <div class="row">
              <div class="form-group col-sm-8">
                   <label for="allower_relative">ความสัมพันธ์กับนิสิต</label>
                   <input type="text" class="form-control" id="allower_relative" name="allower_relative" value="<?php echo @$permit->allower_relative;?>">
                  </div>
              </div>
              <div><label for="city">สถานที่ติดต่อสะดวก</label></div>
              <div class="row">
                  <div class="form-group col-sm-4">
                   <label for="address_number">บ้านเลขที่</label>
                   <input type="text" class="form-control" id="address_number" name="address_number" value="<?php echo @$permit->address_number;?>">
                  </div>
                  <div class="form-group col-sm-4">
                   <label for="address_road">ถนน</label>
                   <input type="text" class="form-control" id="address_road" name="address_road" value="<?php echo @$permit->address_road;?>">
                </div>
                <div class="form-group col-sm-4">
                   <label for="address_district">ตำบล</label>
                   <input type="text" class="form-control" id="address_district" name="address_district" value="<?php echo @$permit->address_district;?>">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-4">
                   <label for="address_area">อำเภอ</label>
                   <input type="text" class="form-control" id="address_area" name="address_area" value="<?php echo @$permit->address_area;?>">
                  </div>
                  <div class="form-group col-sm-4">
                   <label for="address_province">จังหวัด</label>
                   <input type="text" class="form-control" id="address_province" name="address_province" value="<?php echo @$permit->address_province;?>">
                </div>
                <div class="form-group col-sm-4">
                   <label for="address_postal_code">รหัสไปรษณีย์</label>
                   <input type="text" class="form-control" id="address_postal_code" name="address_postal_code" value="<?php echo @$permit->address_postal_code;?>">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-sm-4">
                   <label for="allower_telephone">โทรศัพท์</label>
                   <input type="text" class="form-control" id="allower_telephone" name="allower_telephone" value="<?php echo @$permit->allower_telephone;?>">
                  </div>
                  <div class="form-group col-sm-4">
                   <label for="allower_fax_number">โทรสาร</label>
                   <input type="text" class="form-control" id="allower_fax_number" name="allower_fax_number" value="<?php echo @$permit->allower_fax_number;?>">
                </div>
                <div class="form-group col-sm-4">
                   <label for="allower_email">E-mail</label>
                   <input type="text" class="form-control" id="allower_email" name="allower_email" value="<?php echo @$permit->allower_email;?>">
                  </div>
              </div>

               <div class="card-header"><strong> 2.การตอบรับอนุญาติให้นิสิตไปปฏิบัติงานสหกิจศึกษา</strong></div>

              <div class="row">
              <div class="radio col-sm-12">
                          <label for="allow_choice_1">
                            <input type="radio" id="allow_choice_1" name="allow_choice" value="1" <?php if(@$permit->allow_choice==1) echo 'checked';?>> อนุญาติให้นิสิตในปกครองไปปฏิบัติงานสหกิจศึกษาตามที่มหาวิทยาลัยกำหนด
                          </label>
                        </div>
              </div>
              <div class="row">
              <div class="radio col-sm-12">
                          <label for="allow_choice_0">
                            <input type="radio" id="allow_choice_0" name="allow_choice" value="0" <?php if(@$permit->allow_choice==0) echo 'checked';?>> ไม่อนุญาติอนุญาติให้นิสิตในปกครองไปปฏิบัติงานสหกิจศึกษา
                          </label>
                        </div>
              </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-sm btn-primary" name="save" value="1"><i class="fa fa-dot-circle-o"></i>บันทึกเอกสาร</button>                
                  <button type="submit" class="btn btn-sm btn-primary" name="print" value="1"><i class="fa fa-dot-circle-o"></i>พิมพ์เอกสาร</button>
                </div>

                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('/assets/js/coop_student/permit_form.js?'.time());?>"></script>
