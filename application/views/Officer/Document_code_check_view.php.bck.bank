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
            <div class="card-header"><i class="fa fa-align-justify"></i>ตรวจสอบเอกสารเเยกประเภท</div>
              <div class="card-body">

                <div class="container-fluid">
                  <form action="" method="post" class="form-horizontal">
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label" for="hf-email">เลือกประเภทเอกสาร</label>
                      <div class="col-md-10">
                        <select name="form_id" id="form_id" class="form-control">
                          <option> ------ </option>
                          <?php
                          foreach($forms as $form) {
                            echo '<option value="'.$form['document_id'].'">'.$form['document_code'].' - '.$form['document_name'].'</option>';
                          }
                          ?>
                        </select>
                        <!-- <span class="help-block">Please enter your email</span> -->
                      </div>
                    </div>
                  </form>
                </div>

                <table class="table table-bordered" id="form_search_result" style="display:none;">
                    <thead>
                      <tr>
                        <th></th>
                        <th class="text-left">รหัสนิสิต</th>
                        <th class="text-left">ชื่อ-นามสกุล</th>
                        <th class="text-left">สถานะการส่งเอกสาร</th>
                        <th class="text-left">เอกสาร</th>
                        
                      </tr>
                    </thead>
                    <tbody></tbody>
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

<script>
var table;
$('#form_id').on('change', function (e) {
    jQuery("#form_search_result").show()
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    //get student form search by form code
    // jQuery("#form_search_result tbody").empty();
    // $('#form_search_result').DataTable().clear().draw()
    if(table)
      table.destroy();


    var dataSrc = [];
    table = $('#form_search_result').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        'order': [[1, 'asc']],
        "ajax": {
          "url": SITE_URL+"/Officer/Coop_Submitted_Form_Search/get_by_form_code/"+valueSelected,
          "dataSrc": ""
        },
        "columns": [
            { "data": "student.student_id" },          
            { "data": "student.id_link" },
            { "data": "student.student_fullname" },            
            { "data": "form.status" },
            { "data": "form.document_pdf_file" }
            
        ],
        'initComplete': function(){
          var api = this.api();

          // Populate a dataset for autocomplete functionality
          // using data from first, second and third columns
          api.cells('tr', [1, 2]).every(function(){
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


});


</script>