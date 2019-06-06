<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>


<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row" >
      <!--table รายชื่อนิสิต-->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-align-justify"></i>ตรวจสอบเอกสารรายบุคคล</div>
              <div class="card-body">
              <table class="table table-bordered" id="table" >
                    <thead>
                      <tr>
                        <th></th>
                        <th class="text-left">รหัสนิสิต</th>
                        <th class="text-left">ชื่อ-นามสกุล</th>
                        <th class="text-left">GPAX</th>
                        <th class="text-left">สาขาวิชา</th>Fik
                        <th class="text-left">สถานะการส่งเอกสาร</th>
                        <th class="text-left"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 1;
                    foreach ($data as $row){
                    ?>
                      <tr>
                        <td><?php echo $i++;?></td>
                        <td class="text-left"><?php echo $row['student']['id_link']; ?></td>
                        <td class="text-left"><?php echo $row['student']['student_fullname']; ?></td>
                        <td class="text-right"><?php echo $row['student']['student_gpax']; ?></td>
                        <td class="text-left"><?php echo $row['department']['department_name']; ?></td>
                        <td class="text-left">
                        <?php
                        if($row['complete_form']) {
                          echo '<font color="#006600">ครบ</font>';
                        } else {
                          echo '<font color="red">ไม่ผ่าน</font>';
                        }
                        ?>
                        </td>
                        <td class="text-center">
                          <a class="btn btn-primary document_check_btn " data-studentid="<?php echo $row['student']['student_id'];?>"><i class="fa fa-list-alt"></i> รายละเอียด</a>
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
    </div>
  </div>
</div>

<script src="<?php echo base_url('/assets/js/officer_js/document_check_by_code.js?'.time());?>"></script>
<!-- The Modal -->
<div class="modal fade" id="document_check_student">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">ตรวจสอบเอกสารรายบุคคล</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <table class="table table-bordered" id="document_check_table">
                    <thead>
                      <tr>
                      <th width="60%">เอกสาร</th>
                      <th width="40%">ดาวน์โหลด</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        </div>
        
      </div>
    </div>
  </div>
</div>




<script>


$(document).ready(function() {

  var dataSrc = [];

  var table = $('#table').DataTable( {
      'columnDefs': [
    
      {
            "searchable": false,
            "orderable": false,
            "targets": 0
      }
      ],
      
      'initComplete': function(){
        var api = this.api();

        // Populate a dataset for autocomplete functionality
        // using data from first, second and third columns
        api.cells('tr', [1, 2, 3, 4, 5]).every(function(){
            // Get cell data as plain text
            var data = $('<div>').html(this.data()).text();           
            if(dataSrc.indexOf(data) === -1){ dataSrc.push(data); }
        });
              
        // Sort dataset alphabetically
        dataSrc.sort();
              
        // Initialize Typeahead plug-in
        $('.dataTables_filter input[type="search"]', api.table().container())
            .typeahead({
              source: dataSrc,
              afterSelect: function(value){
                  api.search(value).draw();
              }
            }
        );
      }
      
  } );

  table.on( 'order.dt search.dt', function () {
      table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();


})
</script>