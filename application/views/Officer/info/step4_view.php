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
                    <li class="active">เพิ่มตำแหน่งงาน</li>
                </ul>

                <div class="card">
                    <form action="<?php echo $form_url;?>" method="post">
                    <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> เพิ่มตำแหน่งงาน 
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                if($this->session->flashdata('form-alert')) {
                                    echo $this->session->flashdata('form-alert');
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-star"></i> เพิ่มตำแหน่งงาน</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>ตำแหน่งงาน</th>
                                            <th width="400px">ลักษณะงานที่นิสิตต้องปฏิบัติ (Job Description)</th>
                                            <th>ทักษะพิเศษ</th>
                                            <th>จำนวน</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($company_job as $row) {?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $row['job_title']; ?></td>
                                                <td><?php echo $row['job_description']; ?></td>
                                                <td><?php echo $row['job_skill']?></td>
                                                <td class="text-right"><?php echo $row['job_number_employee']; ?></td>
                                                <td>
                                                    <a href="<?php echo $work_form_url.'/job_form_edit/'.$row['job_id'];?>" class="btn btn-info">แก้ไข</a>
                                                    <a href="<?php echo $work_form_url.'/job_hide/'.$row['job_id'];?>" class="btn btn-warning">ลบ</a>
                                                    
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
    $("#show").click(function(){
        $("#show_select").show();
    });

    $("#hide").click(function(){
        $("#show_select").hide();
    });
});
</script>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
       
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มตำแหน่งงาน</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <form action="<?php echo $work_form_url;?>/job_add" method="post">
            <div class="modal-body">   
                <input type="hidden" name="company_id" value="<?php echo $company['company_id'];?>">
            
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="job_title_id">ตำแหน่ง</label><code>*</code>
                        <select class="form-control" id="job_title_id" name="job_title_id">
                            <option value="">--กรุณาเลือก--</option>
                            <?php foreach($job_title as $row) {?>
                                <option value="<?php echo $row['job_title_id'];?>"><?php echo $row['job_title'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="number_of_employee">จำนวน</label><code>*</code>
                        <input type="number" min="1" class="form-control" id="number_of_employee" name="number_of_employee">
                    </div>
                </div>
                <div class="row">
                            <?php foreach ($skills as $skill_category) { ?>
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo $skill_category['skill_category_name']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($skill_category['skills'] as $key => $skill) { ?>
                                  
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input class="chkbx" type="checkbox" id="key_<?php echo $skill['skill_id'];?>" value="<?php echo $skill['skill_name'];?>" name="skill[]">
                                                    <label class="form-check-label" for="key_<?php echo $skill['skill_id'];?>"><?php echo $skill['skill_name'];?></label>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>                            
                        </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="col-md-8 form-control-label" for="textarea-input">ท้กษะพิเศษ<code>*คลิ๊กจากcheckboxด้านบน</code></label>
                        <textarea id="job_skill" name="job_skill" rows="1" class="form-control" value=""></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="col-md-8 form-control-label" for="textarea-input">ลักษณะงานที่นิสิตต้องปฏิบัติงาน<code>*</code></label>
                        <textarea id="textarea-input" name="job_description" rows="9" class="form-control" value=""></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-success">บันทึก</button>
            </div>
            </form>                        
        </div>
    </div>
</div>  

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $(".chkbx").click(function(){
            var text=""
            $(".chkbx:checked").each(function(){            
                text+=$(this).val()+ ',';
            });
            
            $('#job_skill').val(text);
        });
    });
</script>      
