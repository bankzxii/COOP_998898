<!-- Breadcrumb -->

<!-- Main content -->
<main class="main">

<!--Breadcrumb-->
<?php echo $this->breadcrumbs->show(); ?>




<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row" >
            <!--1 box-->
            <div class="col-md-12">
                <div class="card">
                <div class="card-header"><i class="fa fa-align-justify"> จัดการปีการศึกษา</div></i>
                    <div class="card-body">
                        <div class="row">
                            <!-- แสดงรายการที่เพิ่ม -->
                            <div class="col-md-8">
                            <?php
                                                if(@$status) {
                                                    echo '<div class="alert alert-'.$status['color'].'">'.$status['text'].'</div>';
                                                }
                                                ?>
                                                
                                        <table class="table table-bordered datatable">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>ปีการศึกษา</th>
                                                <th>สถานะการปีการศึกษา(ปัจจุบัน)</th>
                                            </tr>
                                            </thead>
                                            <tbody>   
                                                <?php foreach($terms as $term) { ?>                                      
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-left"><?php echo $term['term_name'];?></td>
                                                    <td class="text-center">
                                                        <label class="switch switch-text switch-pill switch-success-outline-alt">
                                                            <input type="checkbox" value="<?php echo $term['term_id'];?>" name="current_term" class="switch-input" <?php if($term['term_is_current'] == '1') echo 'checked';?>>
                                                            <span class="switch-label" data-on="On" data-off="Off"></span>
                                                            <span class="switch-handle"></span>
                                                        </label>
                                                    </td>
                                                </tr> 
                                                <?php } ?>                                  
                                            </tbody>
                                        </table>

                                </div>      
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">     
                                            <h2 class=""> เพิ่มปีการศึกษาใหม่</h2>

                                            <form action="<?php echo site_url('Officer/setting/post_new_term');?>" method="post">

                                                
                                                <div class="form-group">
                                                    <label class="form-control-label" for="text-input">ภาคเรียน <?php echo form_error('semester');?></label>
                                                    <select id="semester" name="semester" class="form-control">
                                                        <option value="">Please select</option>
                                                        <option value="1" <?php echo set_select('semester', '1'); ?>>ที่ 1</option>
                                                        <option value="2" <?php echo set_select('semester', '2'); ?>>ที่ 2</option>
                                                       
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-control-label" for="text-input">ปีการศึกษา <?php echo form_error('year');?></label>
                                                        <select id="year" name="year" class="form-control">
                                                            <option value="">Please select</option>
                                                            <?php
                                                            $year = date('Y')+543;
                                                            for($i=$year-2; $i<$year+10; $i++) { ?>
                                                                <option value="<?php echo $i;?>" <?php echo set_select('year', $i); ?>><?php echo $i;?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-md btn-danger"> ยกเลิก</button>                                                
                                                    <button type="submit" class="btn btn-md btn-success"> บันทึก</button>
                                                </div>
                                            </form>







                                        

                                                
                                                
                                            </div>



                                        </div>
                                    </div>
                                </div>                       
                            </div>                                    
                            <!-- แสดงรายการที่เพิ่ม -->
                    </div><!-- close card  -->
                </div><!-- close card body -->
            </div><!-- close card col-md-6 -->


        </div><!-- close row -->
    </div><!-- close animated -->
 </div> <!-- close rocontainerw -->
 
 </main>


<script>
$("input:checkbox").on('click', function() {
    var $box = $(this);
    if ($box.is(":checked")) {
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        $(group).prop("checked", false);
        $box.prop("checked", true);
    } else {
        $box.prop("checked", false);
    }

    // get val true
    // alert($box.val())
    if($box.prop("checked")) {
        var datastring = "term_id="+$box.val()
        jQuery.post(SITE_URL+"/Officer/Setting/post_current_term", datastring, function(response) {
            if(response.status) {
                toastr["success"]("Success")
            } else {
                toastr["error"]("err")
            }
        }, 'json');
        update_when_edit_term(datastring);
    }

});

    function update_when_edit_success(datastring)
    {
      
      //console.log(data)
      var data = { term_id: datastring }
      jQuery.post(SITE_URL+"/Company/Setting/update_when_edit_term/", data, function() {
        
      }, 'json');
    }




</script>