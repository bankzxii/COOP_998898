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

              <div class="alert alert-info"><b>โปรดทราบ</b> หน้านี้จะแสดงรายชื่อนิสิตที่ login เข้าระบบแล้วเท่านั้น</div>
		<div class="alert alert-info" align="center">
               <a style="width:2%"></a>
                                      <?php echo anchor('Officer/Students/', '<i class="fa fa-list-alt"></i> ทั้งหมด', 'class="btn  btn-primary"');?>
               <a style="width:2%"></a>
                                      <?php echo anchor('Officer/Students/?coop_status_id=1', '<i class="fa fa-list-alt"></i> รอสมัครงาน', 'class="btn  btn-primary"');?>
              <a style="width:2%"></a>
                                      <?php echo anchor('Officer/Students/?coop_status_id=2', '<i class="fa fa-list-alt"></i> รอสัมภาษณ์', 'class="btn  btn-primary"');?>
              <a style="width:2%"></a>
                                      <?php echo anchor('Officer/Students/?coop_status_id=3', '<i class="fa fa-list-alt"></i> รอผลสอบสัมภาษณ์', 'class="btn  btn-primary"');?>
              <a style="width:2%"></a>
                                      <?php echo anchor('Officer/Students/?coop_status_id=7', '<i class="fa fa-list-alt"></i> เป็นนิสิตสหกิจ', 'class="btn  btn-primary"');?>
		</div>
              <table class="table table-bordered" id="student_table" style="width:100% !important;">

                    <thead>

                      <tr>

                        <th></th>

                        <th></th>

                        <th class="text-center">รหัสนิสิต</th>

                        <th class="text-center">ชื่อ-สกุล</th>

                        <th class="text-center">GPAX</th>

                        <th class="text-center">สาขาวิชา</th>

                        <th class="text-center">ชม.วิชาการ</th>

                        <th class="text-center">ชม.เตรียมความพร้อม</th>

                        <th class="text-center">เก็บชั่วโมง</th> <!-- ครบ/ไม่ครบ -->

                        <th class="text-center">สถานะ</th>

                        <th class="text-center">สถานะสถานประกอบการ</th>

                        <th class="text-center"></th>

                      </tr>

                    </thead>

                    <tbody>

                    </tbody>

                   

              </table>

              <div style="height:40px;"></div>

                    <!---->

                        <div class="container-fluid row">

                          <div class="col-sm-12">

                            <label>เปลี่ยนสถานะนิสิต</label>

                          </div>

                          <div class="col-sm-4">

                            <div class="form-group">

                              <select id="change_coop_type_all" name="change_coop_type_all" class="form-control coop_status_type_val">

                                <option value="">---กรุณาเลือก--</option>

                                <?php foreach ($coop_status_type as $row){?>

                                <option value="<?php echo $row['coop_status_id'];?>"> <?php echo $row['coop_status_name'];?></option>

                                <?php } ?>

                              </select>

                            </div>

                          </div>

                          <div class="col-sm-4">

                            <label></label>

                            <button type="button" class="btn btn-success" id="change_student_status">Success</button>                             

                          </div>

                        </div> 







                        <div style="height:40px;"></div>

                    <!---->

                        <div class="container-fluid row">

                          <div class="col-sm-12">

                            <div class="alert alert-info">

                              <label>** หมายเลขสถานะจากสถานประกอบการ</label>

                              <ol>  

                                <?php foreach($company_status_type as $company_status) { ?>

                                <li><?php echo $company_status['company_status_name'];?></li>

                                <?php } ?>

                              </ol>

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

            "targets": [1, 9]

          },

          {

            "targets": [ 11 ],

            "visible": false,

            "searchable": true,

          }

        ],

        'select': {

          'style': 'multi'

        },

        'order': [[2, 'asc']],

        "ajax": {

          "url": "<?php echo site_url('Officer/Students/ajax_list?coop_status_id='.$this->input->get('coop_status_id'));?>",

          "dataSrc": ""

        },

        "columns": [

            { "data": "student.student_id" },

            { "data": "student.student_id" },            

            { "data": "action_box" },            

            { "data": "student.student_fullname" },

            { "data": "student.student_gpax" },

            { "data": "department.department_name" }, //5



            { "data": "training_hour.0.check_hour" },            

            { "data": "training_hour.1.check_hour" },            

            { "data": "student.student_training_hour" },

			{ "data": "coop_student_type.select_box" },

            { "data": "student.company_status" },

            // { "data": "action_box" },

            { "data": "coop_student_type.status_name" },

            

        ],



        'initComplete': function(){

            var api = this.api();



            // Populate a dataset for autocomplete functionality

            // using data from first, second and third columns

            api.cells('tr', [2, 3, 4, 5, 9, 7]).every(function(){

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

      var coop_status_type = jQuery(".coop_status_type_val option:selected").val()

      var arr = $('#student_table').DataTable().column(0).checkboxes.selected()



      change_coop_type_ajax(arr, coop_status_type)

    });



    // function change_coop_type(student_id, ele)

    // {

    //   change_coop_type_ajax(student_id, jQuery(ele).val())

    // }





});



function change_coop_type(student_id, coop_val)

{

  change_coop_type_ajax([student_id], coop_val)

}





function change_coop_type_ajax(arr, coop_status_type)

{

  var current_table_page = $('#student_table').DataTable().page.info().page

  if(!arr) {

    swal("โปรดเลือกนิสิตที่ต้องการเปลี่ยนสถานะ", {

      icon: "warning",

    });

    return;

  }

  if(!coop_status_type) {

    swal("โปรดเลือกสถานะที่ต้องการเปลี่ยน", {

      icon: "warning",

    });

    return;

  }

      

  swal({

    title: "กรุณายืนสถานะของนิสิต",

    text: "",

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







      var data = { students: student_arr, status: coop_status_type }

      console.log(data)



      jQuery.post(SITE_URL+"/Officer/Students/ajax_change_status/", data, function(response) {

        if(response.status) {

          swal("เปลี่ยนสถานะเรียบร้อย", {

            icon: "success",

          });

        } else {

          swal("ผิดพลาด", {

            icon: "warning",

          });

        }

        $('.coop_status_type_val').prop('selectedIndex', 0)

        $('#student_table').DataTable().clear().draw().ajax.reload(function(){ 

          $('#student_table').DataTable().page( current_table_page ).draw( 'page' );              

        });            

        // $('#student_table').DataTable().page( current_table_page ).draw( 'page' ); 

      }, 'json');





          

    }

  });

}

</script>
