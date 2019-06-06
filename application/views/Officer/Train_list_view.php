<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">
  <div class="animated fadeIn">
      <div class="row" >

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> จัดการข้อมูลการอบรม
              <a class="btn btn-primary float-right" href="<?php echo site_url('Officer/Training/add');?>"><i class="fa fa-hand-pointer-o"></i> เพิ่มการอบรม</a>

            </div>
              <div class="card-body">
              <?php 
                  if($status){
                    echo '<div class="alert alert-'.$status['color'].'">'.$status['text'].'</div>';
                  }
          
                ?>
              <table class="table table-bordered" id="train_table">
                    <thead>
                      <tr bgcolor="">
                        <th class="text-center"></th>
                        <th class="text-center">วันที่</th>
                        <th class="text-center">ประเภท</th>
                        <th class="text-center">ชื่อโครงการ</th>
                        <th class="text-center">วิทยากร</th>
                        <th class="text-center">สถานที่อบรม</th>                        
                        <th class="text-center">จำนวนชั่วโมง</th>
                        <th class="text-center">จำนวนที่นั่ง</th>
                        <th class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;
                    foreach ($data as $row){?>
                      <tr>
                        <td class="text-center"></td>
                        <td class="text-left"><?php echo thaiDate($row['train']['train_start_date']); ?></td>
                        <td class="text-left"><?php echo $row['train_type']['train_type_name'] ?></td>
                        <td class="text-left"><?php echo $row['train']['train_title'] ?></td>
                        <td class="text-left"><?php echo $row['train']['train_lecturer'] ?></td>
                        <td class="text-left"><?php echo $row['train_location']['location_room'] ?></td>                        
                        <td class="text-right"><?php echo $row['train']['train_hour'] ?></td>
                        <td class="text-right"><?php echo $row['train']['train_seat'] ?></td>
                        <td class="text-center">
                          <div class="btn-group-vertical">
                              <?php echo anchor('Officer/Training/Students/'.$row['train']['train_id'], '<i class="fa fa-list"></i> รายชื่อนิสิต', 'class="btn btn-block btn-primary"');?>
                              <p style="width:5px;"></p>
                              <?php echo anchor('Officer/Training/edit/'.$row['train']['train_id'], '<i class="fa fa-eraser"></i> แก้ไขข้อมูล', 'class="btn btn-block btn-primary"');?>                              
                              <p style="width:5px;"></p>
                              <form action="<?php echo site_url('Officer/Training/delete'); ?>" method="post">
                                <input type="hidden" name="train_id" value="<?php echo $row['train']['train_id'] ; ?>">
                              <!--  <button type="submit" class="btn btn-danger btn-submit btn-block"><i class="fa fa-trash-o"></i> ลบ</button> -->
                              </form>
                            </div> 
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


        
      </div>
    </div>
  </div>
</div>



<script>


$('.btn-submit').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: "คุณแน่ใจใช่ไหม",
        text: "ที่จะลบข้อมูลที่เลือก",
        icon: "warning",
        buttons: true,
        dabgerMode: true
    })
    .then((isConfirm) => {
      if (isConfirm) {
        form.submit();
      } else {

      }
    })

});

$(document).ready(function() {

    var dataSrc = [];

    var table = $('#train_table').DataTable( {
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
          api.cells('tr', [2, 3, 4, 5, 6, 7]).every(function(){
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