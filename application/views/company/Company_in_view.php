<?php // Turn off all error reporting
error_reporting(0);
?>
<!-- Main content -->
<main class="main">
<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>


    <div class="container-fluid">
        <div class="animated fadeIn">







            <!-- multistep form -->
            <form id="msform">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active">Account Setup</li>
                <li>Social Profiles</li>
                <li>Personal Details</li>
                
                
            </ul>
            <!-- fieldsets -->
            <fieldset>
                
                <h3 class="fs-subtitle">This is step 1</h3>
   
                <div class="card">
                  <div class="card-header"><i class="fa fa-align-justify"></i> รายละเอียดเกี่ยวกับสถานประกอบการ / หน่วยงาน </div>
                    <div class="card-body">
                       <label for="name">ชื่อสถานประกอบการ / หน่วยงาน</label>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>(ภาษาไทย)</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company['name_th']; ?>">
                            </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-sm-6">
                            <label>(ภาษาอังกฤษ)</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company['name_en']; ?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-sm-3">
                            <label>ที่อยู่เลขที่</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['number'];?>">
                          </div>

                          <div class="form-group col-sm-5">
                            <label>อาคาร</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['building'];?>">
                          </div>

                          <div class="form-group col-sm-4">
                            <label>ถนน</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['road'];?>">
                          </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-sm-3">
                            <label>ซอย</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['alley'];?>">
                          </div>

                          <div class="form-group col-sm-3">
                            <label>แขวง</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['district'];?>">
                          </div>

                          <div class="form-group col-sm-3">
                            <label>เขต/อำเภอ</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['area'];?>">
                          </div>

                          <div class="form-group col-sm-3">
                            <label>จังหวัด</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['province'];?>">
                            </div>

                        </div>

                        <div class="row">

                          <div class="form-group col-sm-3">
                            <label>รหัสไปรษณีย์</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_address['postal_code'];?>">
                          </div>

                          <div class="form-group col-sm-4">
                            <label>ประเภทกิจการ/ธุรกิจ/ผลิตภัณฑ์/ลักษณะการดำเนินงาน</label>
                               <input type="text" class="form-control" id="" najme="" placeholder="<?php echo $company['company_type'];?>">
                          </div>

                          <div class="form-group col-sm-3">
                            <label>จำนวนพนักงาน</label>
                               <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company['total_employee'];?>">
                          </div>

                        </div>

                    </div>
                </div>
        
               <input type="button" name="next" class="next action-button" value="Next" />
            </fieldset>

            <fieldset>

                <h3 class="fs-subtitle">This is step 2</h3>


                <div class="card">
                 <div class="card-header"><i class="fa fa-align-justify"></i> ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>ชื่อ-นามสกุล</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_person['fullname'];?>">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>ตำแหน่ง</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_person['position'];?>">
                            </div>

                            <div class="form-group col-sm-4">
                                <label>แผนก/ฝ่าย</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_person['department'];?>">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>โทรศัพท์</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_person['telephone'];?>">
                            </div>

                            <div class="form-group col-sm-4">
                                <label>โทรสาร</label>
                                <input type="text" class="form-control" id="" name="" placeholder="<?php echo $company_person['fax_number'];?>">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Email</label>
                                <input type="email" class="form-control" id="" name="" placeholder="<?php echo $company_person['email'];?>">
                            </div>

                        </div>

                        <label for="name">หากมหาวิทยาลัย ฯ ประสงค์จะติดต่อประสานงานในรายละเอียดกับสถานประกอบการ / หน่วยงาน ขอให้</label>

                        <div class="row">
                            <div class="radio col-sm-6 ">
                                <label>
                                <input type="radio" id="hide" name="radios" value="option1">
                                </label>
                                <label>
                                    ติดต่อโดยตรงกับผู้จัดการ / หัวหน้าหน่วยงาน
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="radio col-sm-6 ">
                                <label>
                                <input type="radio" id="show" name="radios" value="option2">
                                </label>
                                <label>
                                ติดต่อกับบุคคลที่ สถานประกอบการ / หน่วยงาน มอบหมายต่อไปนี้
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12" id="show_select" style="display:none;">
                                <select id="select1" name="select1" class="form-control">
                                <option value="0">Please select</option>
                                    <?php foreach($company_employee as $row){ print_r($row);?>
                                <option value="1"><?php echo $row['fullname']."/".$row['position']."/".$row['department']."/".$row['telephone']."/".$row['fax_number']."/".$row['email'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                     
                        </div>
                        
                    </div>
                </div>

                <input type="button" name="previous" class="previous action-button" value="Previous" />
                <input type="button" name="next" class="next action-button" value="Next" />
            </fieldset>






            <fieldset>

                <h3 class="fs-subtitle">This is step 3</h3>


                    <div class="card">
                      <div class="card-header"><i class="fa fa-align-justify"></i> เพิ่มตำแหน่งงาน </div>
                        <div class="card-body">
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
                                            <th>ตำแหน่งงาน</th>
                                            <th>ลักษณะงานที่นิสิตต้องปฏิบัติ (Job Description)</th>
                                            <th>จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($company_job as $row) {?>
                                            <tr>
                                            <td><?php echo $row['position_title']; ?></td>
                                            <td><?php echo $row['job_description']; ?></td>
                                            <td><?php echo $row['number_of_employee']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>

                           
                                </div>

                            </div>

                        </div>

                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">เพิ่มตำแหน่งงาน</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="ccmonth">ตำแหน่ง</label>
                                                    <select class="form-control" id="ccmonth">
                                                        <option>Programer</option>
                                                        <option>Testor</option>
                                                        <option>IT support</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label>จำนวน</label>
                                                    <input type="number" class="form-control" id="" name="">
                                                </div>

                                                

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <label class="col-md-8 form-control-label" for="textarea-input">ลักษณะงานที่นิสิตต้องปฏิบัติงาน</label>
                                                    <textarea id="textarea-input" name="textarea-input" rows="9" class="form-control" placeholder=""></textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                                    <button type="button" class="btn btn-success">บันทึก</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>                    

                    </div>
                
                <input type="button" name="previous" class="previous action-button" value="Previous" />
                <input type="submit" name="submit" class="submit action-button" value="Submit" />
            </fieldset>

            </form>



















     
        </div>
    </div>
   

        
</main>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})

</script>

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

<style>
/*form styles*/
#msform {
	width: 100% !important;
	margin: 50px auto;
	/* text-align: center; */
	position: relative;
}
#msform fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
	padding: 20px 30px;
	box-sizing: border-box;
	width: 100%;
	/* margin: 0 10%; */
	
	/*stacking fieldsets above each other*/
	position: relative;
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
	display: none;
}
/*inputs*/
#msform input, #msform textarea {
	padding: 15px;
	border: 1px solid #ccc;
	border-radius: 3px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	font-family: montserrat;
	color: #2C3E50;
	font-size: 13px;
}
/*buttons*/
#msform .action-button {
	width: 100px;
	background: #27AE60;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
}
/*headings*/
.fs-title {
	font-size: 15px;
	text-transform: uppercase;
	color: #2C3E50;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 13px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: #000;
	text-transform: uppercase;
	font-size: 9px;
	width: 33.33%;
	/* width: 25%; */
    
	float: left;
	position: relative;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #27AE60;
	color: white;
}




</style>