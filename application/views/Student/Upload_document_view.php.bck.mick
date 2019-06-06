<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
    <div class="row" >
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><i class="fa fa-align-justify"></i>อัพโหลดเอกสารที่เกี่ยวข้อง</div>
                 <div class="card-body text-center  ">
                 <?php echo form_open_multipart('Student/Upload_document');?>
                 
                 <?php if($session_alert) : ?>
                    <div class="col-md-12">
                      <?php echo $session_alert;?>
                    </div>
                  <?php endif; ?>

                  <div class="text-center">
                      <label class="form-control-label" for="">เลือกประเภทเอกสาร</label>
                      <select class="form-control" style="width:50%; margin: 0 auto;" name="coop_document_id" required>
                        <option> ---- </option>
                        <?php foreach($documents as $row) { ?>
                          <option value="<?php echo $row['document_id'];?>"><?php echo $row['document_code'].' '.$row['document_name'];?></option>
                        <?php } ?>
                        

                      </select>
                  </div>
                  <div style="height:20px;"></div>

                  <div class="text-center">
                      <label class="form-control-label" for="file-input">เลือกไฟล์เอกสาร</label>
                      <input type="file" name="file-input">
                  </div>

                  
                  <div class="text-center" style="margin-top:70px;">
                    <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-dot-circle-o"></i>อัพโหลดเอกสาร</button>
                  </div>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
