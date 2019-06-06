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
            <div class="card-header">
                <i class="fa fa-align-justify"></i> รายชื่อผู้เข้าร่วมอบรมเก็บชั่วโมง<?php echo $training['train_type']['train_type_name'];?> โครงการ <?php echo $training['train_title'];?> <?php echo $training['note'];?>

                <?php if($is_uploadform) { ?>
                <a class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#excel_form"><i class="fa fa-hand-pointer-o"></i> เพิ่มรายชื่อนิสิต</a>
                <?php } ?>
                
            </div>
            <div class="card-body">
                <?php if($status){ echo '<div class="alert alert-'.$status['color'].'">'.$status['text'].'</div>'; } ?>
                <?php
                if( count($students) < 1 ) {
                    echo '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
                } else { 
                ?>
                <table class="table table-bordered" id="student_table">
                    <thead>
                        <tr>
                            <td width="5%">ที่</td>
                            <td width="11%">บาร์โค้ด</td>
                            <td width="10%">รหัสนิสิต</td>
                            <td width="40%">ชื่อ - สกุล</td>
                            <td width="40%">ลายมือ</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $i => $student) { ?>
                        <tr>
                            <td align="center"><?php echo ++$i; ?></td>
                            <td align="center"><img src="<?php echo $student['student_barcode'];?>" height="30px" width="80px"></td>
                            <td align="left"><?php echo $student['student_id'];?></td>
                            <td align="left"><?php echo $student['student_fullname'];?></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                   
                </table>
                <?php } ?>

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
    jQuery("title").html('รายชื่อผู้เข้าร่วมอบรมเก็บชั่วโมง<?php echo $training['train_type']['name'];?> โครงการ <?php echo $training['title'];?>') //title for pdf document
    var dataSrc = [];
    var table = $('#student_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                messageTop: '<?php echo $training['note'];?>',
                extend: 'print',
                text: 'พิมพ์รายชื่อ',
                exportOptions: {
                    stripHtml: false,
                },
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .css( 'background-color', '#fff' )
                        // .prepend(
                        //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        // );

                    $(win.document.body).find('h1').css( 'font-size', '14pt' ).css( 'text-align', 'center' );
                    $(win.document.body).find('div').css( 'font-size', '13pt' ).css( 'text-align', 'center' );
                    
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'cssText', 'font-size: 10pt !important; border-collapse: collapse !important' )
                    
                    $(win.document.body).find('td').css( 'font-size', '10pt' );
                    $(win.document.body).find( "td:eq( 0 )" ).css( 'width', '2%' );
                    $(win.document.body).find( "td:eq( 1 )" ).css( 'width', '8%' );
                    $(win.document.body).find( "td:eq( 2 )" ).css( 'width', '8%' );
                    $(win.document.body).find( "td:eq( 3 )" ).css( 'width', '32%' );
                    $(win.document.body).find( "td:eq( 4 )" ).css( 'width', '50%' );

                    
                    
                    
                }
            },
            // {
            //   extend: 'excel',
            //   exportOptions: {
            //     stripHtml: false,
            //   }
            // },

        ],
        'columnDefs': [
          {
            "searchable": false,
            "orderable": false,
            "targets": [0]
          }
        ],
        'select': {
          'style': 'multi'
        },
        'order': [[2, 'asc']],

        'initComplete': function(){
            var api = this.api();

            // Populate a dataset for autocomplete functionality
            // using data from first, second and third columns
            api.cells('tr', [2, 3]).every(function(){
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


});


</script>

<!-- Modal -->
<div id="excel_form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form action="<?php echo site_url('Officer/Training/upload_student_list');?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="training_id" value="<?php echo $training['train_id'];?>">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">การเพิ่มรายชื่อนิสิต</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                การเพิ่มรายชื่อนิสิต
                <ol>
                <li>ให้ Copy แถวที่เป็นรหัสนิสิต</li>
                <li>นำสิ่งที่ Copy ไปวางในช่องว่าง</li>
                <li>ลบ censor ออก</li>
                </ol>
                </div>
                <div class="form-group">
                    <label for="userfile">กรอกรหัสนิสิต</label>
                    <!-- <input type="file" id="userfile" name="userfile" class="form-control"> -->
                    <textarea id="student_id_post" name="student_id_post" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>

    </div>
</div>