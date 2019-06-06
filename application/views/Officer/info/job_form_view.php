<!-- Breadcrumb -->

<!-- Main content -->
<main class="main">

<!--breadcrumb-->
<?php echo $this->breadcrumbs->show(); ?>



<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row" >
            <div class="col-lg-12">
                <div class="card">
                 <div class="card-header"><i class="fa fa-align-justify"></i>เเก้ไขตำเเหน่งงาน</div>
                  <form action="<?php echo $work_form_url;?>" method="post">
                    <div class="card-body "> 
                        <?php
                            if($this->session->flashdata('form-alert')) {
                                 echo $this->session->flashdata('form-alert');
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-12"></div>

                            <div class="form-group col-sm-12">
                                <label for="job_title_id">ตำแหน่ง</label> <?php echo form_error('job_title_id'); ?><code>*</code>
                                <select class="form-control" id="job_title_id" name="job_title_id">

                                    <option>--กรุณาเลือก--</option>
                                    <?php 
                                    foreach($company_job_title as $row) {
                                        if(form_value_db('job_title_id', $company_job_position_by_id['job_title_id']) == $row['job_title_id']) {
                                            echo '<option value="'.$row['job_title_id'].'" selected>'.$row['job_title'].'</option>';
                                        } else {
                                            echo '<option value="'.$row['job_title_id'].'">'.$row['job_title'].'</option>';    
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-12"></div>
                            <input type="hidden" name="job_id" value="<?php echo $company_job_position_by_id['job_id'];?>">    
                            <input type="hidden" name="company_id" value="<?php echo $company_job_position_by_id['company_id'];?>">

                            <div class="col-sm-12"></div>
                            
                            <div class="form-group col-sm-12">
                                <label for="job_number_employee">จำนวน</label> <?php echo form_error('job_number_employee'); ?><code>*</code>
                                <input type="number" min="1" class="form-control" id="job_number_employee" name="job_number_employee" value="<?php echo form_value_db('job_number_employee', $company_job_position_by_id['job_number_employee']);?>">
                            </div>

                            <div class="col-sm-12"></div>
                            <div class="col-sm-12"></div>
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

                            <div class="form-group col-sm-12">
                                <label class="col-md-12 form-control-label" for="textarea-input">ทักษะพิเศษ</label><?php echo form_error('job_description'); ?><code>*</code>
                                <textarea id="job_skill" name="job_skill" rows="1" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="col-md-12 form-control-label" for="textarea-input">ลักษณะงานที่นิสิตต้องปฏิบัติงาน</label><?php echo form_error('job_description'); ?><code>*</code>
                                <textarea id="textarea-input" name="job_description" rows="9" class="form-control"><?php echo form_value_db('job_description', $company_job_position_by_id['job_description']);?></textarea>
                            </div>

                            <div class="col-sm-12"></div>
                        </div>     
                        <div class="col-md-12 text-center"> 
                            <button type="reset" class="btn btn-danger"><i></i>ยกเลิก</button>
                            <button type="submit" class="btn btn-success"><i></i>บันทึก</button>                
                        </div>

                    </div>
                     </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

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