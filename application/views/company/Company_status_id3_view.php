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
            <div class="card-header"><i class="fa fa-align-justify"></i>รายชื่อนิสิต</div>
          <div class="card-body">
<div align="center">
              
              <a style="width:2%"></a>
                                      <?php echo anchor('Company/Job_list_position/', '<i class="fa fa-list-alt"></i> รายชื่อนิสิตทั้งหมด', 'class="btn  btn-primary"');?>
               <a style="width:2%"></a>
                                      <?php echo anchor('Company/Job_list_position/company_status_id1', '<i class="fa fa-list-alt"></i> นิสิตที่สมัคร', 'class="btn  btn-primary"');?>
              <a style="width:2%"></a>
                                      <?php echo anchor('Company/Job_list_position/company_status_id2', '<i class="fa fa-list-alt"></i> นิสิตรอเรียกสัมภาษณ์', 'class="btn  btn-primary"');?>
              <a style="width:2%"></a>
                                      <?php echo anchor('Company/Job_list_position/company_status_id3', '<i class="fa fa-list-alt"></i> นิสิตรอประกาศผลสัมภาษณ์', 'class="btn  btn-primary"');?>
             <a style="width:2%"></a>
                                      <?php echo anchor('Company/Job_list_position/company_status_id4', '<i class="fa fa-list-alt"></i> ผ่านการสัมภาษณ์', 'class="btn  btn-primary"');?>

            </div>
            

              <!---->
              
              <!---->
              <br>
              <div class="col-md-12">
                    <div class="alert alert-primary">
                        <b>**กรุณาเลือกนิสิตที่ผ่านการสัมภาษณ์ (สำหรับนิสิตที่ไม่ถูกเลือก หมายถึงไม่ผ่านการสัมภาษณ์)</b>
                        
                    </div>

                </div>

              <table class="table table-bordered" id="student_table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th class="text-center">รหัสนิสิต</th>
                        <th class="text-center">ชื่อ-สกุล</th>
                        <th class="text-center">GPAX</th>
                        <th class="text-center">สาขาวิชา</th>
                        <th class="text-center">ตำแหน่งที่สมัคร</th>
                        <!--<th class="text-center">สถานะสถานประกอบการ</th>-->
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                   
              </table>
              <div style="height:40px;"></div>
                    
                          <div class="col-sm-4">
                            <label></label>
                            <button type="button" class="btn btn-success" id="change_student_status">ผ่านสัมภาษณ์</button>                             
                          </div>
                        </div> 

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>


<script>
$(document).ready(function() {
    var dataSrc = [];
    var table = $('#student_table').DataTable( {
        'columnDefs': [
          {
            'targets': 0,
            "searchable": false,
            "orderable": false,
            'checkboxes': {
              'selectRow': true
            }
          },
          {
            "searchable": false,
            "orderable": false,
            "targets": [1, 6]
          }
        ],
        'select': {
          'style': 'multi'
        },
        'order': [[2, 'asc']],
        "ajax": {
          "url": "<?php echo site_url('Company/Job_list_position/ajax_list3');?>",
          "dataSrc": ""
        },
        "columns": [
            { "data": "student.student_id" },
            { "data": "student.student_id" },            
            { "data": "student.id_link" },            
            { "data": "student.student_fullname" },
            { "data": "student.student_gpax" },
            { "data": "department.department_name" },
            { "data": "job_position.job_title" },
            //{ "data": "company_status_type.select_box" },
        ],

        'initComplete': function(){
            var api = this.api();

            // Populate a dataset for autocomplete functionality
            // using data from first, second and third columns
            api.cells('tr', [2, 3, 4, 5, 7]).every(function(){
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
        table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#change_student_status').click( function () {
      var company_status_type_val = 4
      //console.log(company_status_type_val)
      var arr = $('#student_table').DataTable().column(0).checkboxes.selected()
      var arr2 = $('#student_table').DataTable().column(2).data()
      // change_company_type_ajax(arr, company_status_type_val, non_slected_student_id, selected_student_id)
      //sent email here
      var non_slected_student_id = []
      var selected_student_id = []
     
      jQuery.each(arr2, function( index, value) {
        var tmp_student_id = value.split(">")[1].split("<")[0]

        if (arr.indexOf(tmp_student_id) == -1) {
          non_slected_student_id.push(tmp_student_id)
        } else {
          selected_student_id.push(tmp_student_id)
        }
      });

      /*jQuery.each(non_slected_student_id, function(index, value){
        console.log(value)
      });*/
      //console.log(arr2)
      //console.log(selected_student_id)
      change_company_type_ajax(arr, company_status_type_val, non_slected_student_id, selected_student_id)
      // delete_student_form_company(non_slected_student_id)
      // send_email_to_officer_ajax(selected_student_id)
    });

    // function change_coop_type(student_id, ele)
    // {
    //   change_coop_type_ajax(student_id, jQuery(ele).val())
    // }


});

function change_company_type(student_id, coop_val)
{
  change_company_type_ajax([student_id], coop_val)
}

function delete_student_form_company(non_slected_student_id)
{
  
      var data = { students: non_slected_student_id }
      //console.log(data)

      jQuery.post(SITE_URL+"/Company/Job_list_position/ajax_delete_student/", data, function() {
        
      }, 'json');
}
 
function send_email_to_officer_ajax(selected_student_id)
{
  
      var data = { students: selected_student_id }
      console.log(data)

      jQuery.post(SITE_URL+"/Company/Job_list_position/ajax_send_email_to_officer_pass/", data, function() {
        
      }, 'json');
}


function change_company_type_ajax(arr, company_status_type, non_slected_student_id, selected_student_id)
{
  var current_table_page = $('#student_table').DataTable().page.info().page
  if(!arr) {
    swal("โปรดเลือกนิสิตที่ต้องการเปลี่ยนสถานะ", {
      icon: "warning",
    });
    return;
  }
  if(!company_status_type) {
    swal("โปรดเลือกสถานะที่ต้องการเปลี่ยน", {
      icon: "warning",
    });
    return;
  }
      
  swal({
    title: "กรุณายืนยันนิสิตที่ผ่านสัมภาษณ์",
    text: "รายชื่อนิสิตที่ผ่านการสัมภาษณ์ จะต้องรอเจ้าหน้าที่ทางคณะยืนยัน หากเจ้าหน้าที่ยืนยันแล้ว รายชื่อนิสิตจะเข้ามาอยู่ในรายชื่อนิสิตสหกิจทันที และนิสิตที่ไม่ได้เลือก หมายถึงนิสิตที่ไม่ผ่านการสัมภาษณ์",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willUpdate) => {
    if (willUpdate) {
      var student_arr = []
      jQuery.each(arr, function( index, value ) {
        student_arr.push(value)
      });



      var data = { students: student_arr, status: company_status_type }
      //console.log(data)

      jQuery.post(SITE_URL+"/Company/Job_list_position/ajax_change_status/", data, function(response) {
        if(response.status) {
          swal("เปลี่ยนสถานะเรียบร้อย", {
            icon: "success",
          });
        } else {
          swal("ผิดพลาด", {
            icon: "warning",
          });
        }

        $('.company_status_type_val').prop('selectedIndex', 0)
        $('#student_table').DataTable().clear().draw().ajax.reload(function(){ 
          $('#student_table').DataTable().page( current_table_page ).draw( 'page' );              
        });            
        // $('#student_table').DataTable().page( current_table_page ).draw( 'page' ); 
      }, 'json');

      delete_student_form_company(non_slected_student_id);
      send_email_to_officer_ajax(selected_student_id);
          
    }
  });
}
</script>

