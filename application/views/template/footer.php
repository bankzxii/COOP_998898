  </div>

  <footer class="app-footer">
    <span><a href="#" data-toggle="modal" data-target="#credit_modal">ระบบสหกิจ</a> © 2017 uLab</span>
    <span class="ml-auto"><img src="<?php echo base_url('assets/img/new_logo_228.png');?>" style="height: 40px;"></span>
  </footer>








  <!-- javascript -->
  <?php
  foreach($src_scripts as $file) {
    echo '<script src="'.$file.'"></script>';
  }
  ?>

  <!-- css -->
  <?php
  foreach($src_css as $file) {
    echo '<link rel="stylesheet" href="'.$file.'" />';
  }
  ?>




  <style>
  .help-block {
    color: red;
  }
  </style>



  <script>
    $(document).ready(function(){

      var table = $('.datatable').DataTable({
        "autoWidth": false,
        
        'columnDefs': [
        {
              "searchable": false,
              "orderable": false,
              "targets": 0
        }
        ],

      });
      table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
      } ).draw();




      $(".deleteForm").submit(function(event){
        event.preventDefault();
      });


    });

    function confirmDelete(e)
      {
        var link = jQuery(e).attr('href')
        
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this imaginary file!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            window.location.replace(link)
          }
        });

        return false;


      }
  </script>


<!-- The Modal -->
<div class="modal" id="credit_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ระบบสหกิจ</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p>
          รายนามผู้พัฒนารุ่นแรก
          <br>
          อาจารย์ที่ปรึกษา: ผศ.ดร ณัฐนนท์ ลีลาตระกูล ( nutthanon@buu.ac.th )
          <br>
          ลิ้งค์เอกสาร: <a href="https://drive.google.com/drive/folders/136IIt3j67rEtOI67YQj7xfWCaeCrDL5s?usp=sharing">Click</a>
        </p>
        <ol>
          <li>57160419 ปิยวัฒน์ น้อยภู่ ( 57160419@go.buu.ac.th )</li>
          <li>57660074 โกเมนทร์ เวียงคำ ( 57660074@go.buu.ac.th )</li>
          <li>57660132 พิเชษฐ์ ซื่อสัตย์ ( 57660132@go.buu.ac.th )</li>
          <li>57660135 ศานติกร อภัย ( 57660135@go.buu.ac.th )</li>
        </ol>
        <p>
          รายนามผู้พัฒนารุ่นสอง
          <br>
          <ol>
          <li>58160386 ณัฐฐิญา อนุกูลทอง ( 58160386@go.buu.ac.th )</li>
          <li>58160427 วริทธ์นันท์ พุ่มสุข ( 58160427@go.buu.ac.th )</li>
          <li>58660033 ภควัต ม่วงมิตร ( 58660033@go.buu.ac.th )</li>
          <li>58660124 กชกร ทิพย์วงศ์เมฆ ( 58660124@go.buu.ac.th )</li>
        </ol>
        <p class="text-center">
          <h1><a href="https://www.youtube.com/watch?v=X2WH8mHJnhM" target="_blank">Good luck, have fun lol ~</a></h1>
        </p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



</body>
</html>
