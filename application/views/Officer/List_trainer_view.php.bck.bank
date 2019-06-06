<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row" >
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i>เจ้าหน้าที่ในบริษัท
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#company_person_form">
                เพิ่มเจ้าหน้าที่
                </button>
            </div>
              <div class="card-body">
              <?php 
                  if($status){
                    echo '<div class="alert alert-'.$status['color'].'">'.$status['text'].'</div>';
                  }
                ?>
              <table class="table table-bordered datatable" >
                    <thead>
                      <tr bgcolor="">
                        <th></th>
                        <th>ชื่อ</th>
                        <th>E-mail</th>
                        <th>ตำเเหน่ง</th>
        
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($data as $row){?>
                      <tr>
                        <td class="text-center">
                        <?php echo $i++; ?>
                        </td>
                        <td class="text-left"><?php echo $row['company_person']['person_fullname'];?></td>
                        <td class="text-left"><?php echo $row['company_person']['person_email']; ?></td>
                        <td class="text-left"><?php echo $row['company_person']['person_position'];?></td> 
                        <td class="form-inline">
                        <form action="<?php echo site_url('Officer/Trainer/delete/'); ?>" method="post">
                        <?php echo anchor('Officer/Trainer/edit_form/'.$row['company_person']['person_id'], '<i class="icon-pencil "></i> แก้ไข', 'class="btn btn-info"');?>
                        <input type="hidden"   name="company_person_id" value="<?php echo $row['company_person']['person_id'] ; ?>">
                        <input type="hidden"   name="company_id" value="<?php echo $company['company_id'] ; ?>">
                        <button type="submit" class="btn btn-danger btn-submit"><i class="icon-trash"></i> ลบ</button>
                        </form>        
                        </td>
                      </tr>
                    <?php 
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>


</main>





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
        jQuery.post("<?php echo site_url('Officer/Trainer/ajax_save_trainer');?>", jQuery("#save_trainer").serialize(), function(result){
            jQuery("#company_person_form").modal('hide');

            if(result.status) {               
                swal("สำเร็จ", result.text, result.color).then((value) => {
                    if(value) {
                        location.reload();
                    }
                });
            } else {
                swal("ผิดพลาด", result.text, result.color);
            }
            jQuery("#save_trainer input[type=text]").val(null);
            

            
        }, 'json');

        
    }
});


</script>
