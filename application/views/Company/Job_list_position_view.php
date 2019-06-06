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
                        <b>**นิสิตที่อยู่ในหน้านี้หมายถึงภาพรวมนิสิตทั้งหมดที่มีสถานะต่างๆภายในบริษัท กรุณาเลือกแท็บถัดไปเพื่อเปลี่ยนสถานะ</b>
                        
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
                    <!--
                        <div class="container-fluid row">
                          <div class="col-sm-12">
                            <label>เปลี่ยนสถานะนิสิต</label>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <select id="company_status_type_all" name="company_status_type_all" class="form-control company_status_type_val">
                                <option value="">---กรุณาเลือก--</option>
                                <?php foreach ($company_status_Type as $row){ ?>
                                <option value="<?php echo $row['company_status_id'];?>"> <?php echo $row['company_status_name'];?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          -->
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
          "url": "<?php echo site_url('Company/Job_list_position/ajax_list')?>",
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
            //{ "data": "student.company_status_id" },
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
      var company_status_now =  Number("<?php echo $this->input->get('company_status_id');?>")
      var company_status_type_val = company_status_now+1
      console.log(company_status_type_val)
      var arr = $('#student_table').DataTable().column(0).checkboxes.selected()

      change_company_type_ajax(arr, company_status_type_val)
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


function change_company_type_ajax(arr, company_status_type)
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
    title: "คุณแน่ใจแล้วใช่หรือไม่",
    text: "การเปลี่ยนสถานะนิสิตนี้ ไม่สามารถย้อนกลับได้",
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
      console.log(data)

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


          
    }
  });
}
</script>
