<!-- Main content -->
<main class="main">
<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

        <div class="container-fluid">
            <div class="animated fadeIn">
                <ul id="progressbar">
                    <li class="active">รายละเอียดเกี่ยวกับสถานประกอบการ / หน่วยงาน</li>
                    <li class="active">ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน</li>
                    <li>ข้อตกลง, สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน</li>
                    <li>เพิ่มตำแหน่งงาน</li>
                </ul>

                <div class="card">
                    <form action="<?php echo $form_url;?>" method="post">
                    <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน
                    </div>
                    <div class="card-body">

                        <div class="row" id="headoffice_person_frm">
                            <div class="col-md-12">
                                <label for="name">ข้อมูลผู้จัดการสถานประกอบการ</label>                            
                            </div>
                            <div class="col-md-10">
                                <select name="headoffice_person_id" class="form-control trainer_lists">
                                <option >Please select</option>
                                    <?php foreach($company_employee as $row){ ?>
                                        <option value="<?php echo $row['person_id'];?>" <?php if($row['person_id'] == $company['headoffice_person_id']) echo 'selected'; ?>><?php echo $row['person_fullname']."/".$row['person_position']."/".$row['person_department']."/".$row['person_telephone']."/".$row['person_fax_number']."/".$row['person_email'];?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#company_person_form"> + เพิ่มผู้จัดการ</a>
                            </div>
                     
                        </div>

                        <div style="height:20px;"></div>
                        <hr>
                        <div style="height:20px;"></div>
                        

                        <label for="name">หากมหาวิทยาลัย ฯ ประสงค์จะติดต่อประสานงานในรายละเอียดกับสถานประกอบการ / หน่วยงาน ขอให้</label>

                        
                        


                        <div class="row">
                            <div class="radio col-sm-12 ">
                                <label>
                                <input type="radio" id="hide" name="radios" value="0">
                                </label>
                                <label for="hide">
                                    ติดต่อโดยตรงกับผู้จัดการ / หัวหน้าหน่วยงาน <?php echo form_error('headoffice_person_id'); ?><code>*</code>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="radio col-sm-12 ">
                                <label>
                                <input type="radio" id="show" name="radios" value="1">
                                </label>
                                <label for="show">
                                ติดต่อกับบุคคลที่ สถานประกอบการ / หน่วยงาน มอบหมายต่อไปนี้ <?php echo form_error('contact_person_id'); ?><code>*</code>
                                </label>
                            </div>

                        </div>

                        <div class="row" id="contact_person_frm" style="display:none;">
                            <div class="col-md-10">
                                <select name="contact_person_id" class="form-control trainer_lists">
                                <option >Please select</option>
                                    <?php foreach($company_employee as $row){ ?>
                                        <option value="<?php echo $row['person_id'];?>" <?php if($row['person_id'] == $company['contact_person_id']) echo 'selected'; ?>><?php echo $row['person_fullname']."/".$row['person_position']."/".$row['person_department']."/".$row['person_telephone']."/".$row['person_fax_number']."/".$row['person_email'];?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#company_person_form"> + เพิ่มผู้นิเทศงาน</a>
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

<script>
$(document).ready(function(){

    <?php if($contact_select_box == 1) : ?>
        jQuery("#show").attr("checked", true);
        jQuery("#contact_person_frm").show();
    <?php ; else : ?>
        jQuery("#hide").attr("checked", true);
    <?php endif; ?>

    jQuery("#show").click(function(){
        jQuery("#contact_person_frm").show();
        
    });

    jQuery("#hide").click(function(){
        jQuery("#contact_person_frm").hide();
    });
});
</script>







<style>
.modal-dialog {
    max-width: 800px;
}
</style>
<!-- The Modal -->
<div class="modal fade" id="company_person_form">
    <div class="modal-dialog model-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มผู้นิเทศงาน</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form id="save_trainer">
            <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="fullname">ชื่อ-นามสกุล</label><code>*</code>
                        <input type="text" id="person_fullname" name="person_fullname" class="form-control" placeholder="ชื่อ-นามสกุล" value="" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for"email">E-mail</label><code>*</code>
                        <input type="email" id="person_email" name="person_email" class="form-control" placeholder="E-mail" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for"position">ตำเเหน่ง</label><code>*</code>
                        <input type="text" id="person_position" name="person_position" class="form-control" placeholder="ตำเเหน่ง" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for"department">แผนกงาน</label><code>*</code>
                        <input type="text" id="person_department" name="person_department" class="form-control" placeholder="เเผนกงาน" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for"telephone">เบอร์โทร</label><code>*</code>
                        <input type="text" id="person_telephone" name="person_telephone" class="form-control" placeholder="เบอร์โทร" required>
                    </div>  
                    <div class="form-group col-md-12">
                        <label for"fax_number">FAX</label>
                        <input type="text" id="person_fax_number" name="person_fax_number" class="form-control" placeholder="FAX">
                    </div>
   
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
                
            </div>
            </form>
        </div>
    </div>
</div>



<script>
var validForm = false
jQuery(document).ready(function(){
    jQuery('#save_trainer').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        
    }).on('success.form.fv', function(e) {
        validForm = true;
    });
});


jQuery( "#save_trainer" ).submit(function( event ) {
    event.preventDefault();

    if(validForm) {
        //post ajax
        jQuery.post("<?php echo $save_trainer_url;?>", jQuery("#save_trainer").serialize(), function(result){
            jQuery("#company_person_form").modal('hide');

            if(result.status) {
                jQuery('.trainer_lists').append($('<option>', {
                    selected: true,
                    value: result.last_id,
                    text: jQuery("#save_trainer input[name=person_fullname]").val()+' (อีเมล: '+jQuery("#save_trainer input[name=person_email]").val()+') (เบอร์โทรศัพท์: '+jQuery("#save_trainer input[name=person_telephone]").val()+')'
                }));
                
                swal("สำเร็จ", result.text, result.color);                
            } else {
                swal("ผิดพลาด", result.text, result.color).then((value) => {
                    if(value) {
                        location.reload();
                    }
                });
            }
            jQuery("#save_trainer input[type=text]").val(null);
            

            
        }, 'json');

        
    }
});


</script>
