
    <!-- Main content -->
<!--     <main class="main"> -->

      <!-- Breadcrumb -->
      <!-- <?php echo $this->breadcrumbs->show(); ?>

      <div class="container-fluid">
        <div class="animated fadeIn">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  แผนที่
                </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div id="map" style="width:100%; height:600px;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
          </div>  
        </div>

      </div> -->
      <!-- /.conainer-fluid -->
<!--     </main> -->


<!-- Breadcrumb -->

<!-- Main content -->
<main class="main">

<!-- Breadcrumb -->
<?php echo $this->breadcrumbs->show(); ?>



<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row" >
            <!--1 box-->
            <div class="col-md-12">
                <div class="card">
                <div class="card-header"><i class="fa fa-align-justify"> แผนที่</div></i>
                    <div class="card-body">
                        <div class="row">
                            <!-- แสดงรายการที่เพิ่ม -->
                            <div class="col-md-3">
                                        <form action="<?php echo base_url('Adviser/Coop_map/map_view')?>" method="post">
                                          <center><button type="submit" class="btn btn-md btn-success" style="width: 100%; height: 50px;"> แสดงบนแผนที่</button></center>
                                          <br>
                                          <b><center><a style="color: red;">ตารางแสดงบริษัทที่มีนิสิตสหกิจ</a></center></b>
                                            <table class="table table-bordered" style="width:100% !important;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                          <div id="divCheckAll">
                                                            <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);">
                                                          </div>
                                                        </th>
                                                        <th class="text-left">ชื่อบริษัท</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($getData as $row) {?>
                                                    <tr>
                                                        <td class="text-left">
                                                          <input 
                                                          type=checkbox 
                                                          name=chkbox1[] 
                                                            value='<?php echo $row['company_id'];?>' 
                                                            <?php if(in_array($row['company_id'], $company_checked_id2)) echo 'checked';?>
                                                            ></td>
                                                        <td class="text-left"><?php echo $row['company_name_th']?></td>                            
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                            
                                            <br>
                                            <br>
                                            <b><center><a style="color: red;">ตารางแสดงบริษัททั้งหมด</a></center></b>
                                            <table class="table table-bordered" style="width:100% !important;">
                                              <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                          <div id="divCheckAll">
                                                            <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox2(this.checked);">
                                                          </div>
                                                        </th>
                                                        <th class="text-left">ชื่อบริษัท</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($hasLocation as $hasLocation) {?>
                                                    <tr>
                                                        <td class="text-left"><input type=checkbox name=chkbox[] 
                                                          value='<?php echo $hasLocation['company_id'];?>'
                                                          <?php if(in_array($hasLocation['company_id'], $company_checked_id)) 
                                                          echo 'checked';?>
                                                          ></td>
                                                        <td class="text-left"><?php echo $hasLocation['company_name_th']?></td>                            
                                                    </tr>
                                                <?php } ?>
                                                <?php foreach($nullLocation as $nullLocation) {?>
                                                    <tr>
                                                        <td class="text-left"><input type=checkbox name=chkbox3[] 
                                                          value='<?php echo $nullLocation['company_id'];?>' disabled></td>
                                                        <td class="text-left"><a style="color: red;"><?php echo $nullLocation['company_name_th']?></a></td>                            
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                          </form>
                                </div>
                                
                            <!-- เพิ่ม -->
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="map" style="width:100%; height:600px;"></div>
                                        </div>
                        
                                    </div>
                                </div>
                                <!-- เพิ่ม -->

                                

                        </div>
                      
                            <!-- แสดงรายการที่เพิ่ม -->

                    </div><!-- close card  -->
                </div><!-- close card body -->
            </div><!-- close card col-md-6 -->


        </div><!-- close row -->
    </div><!-- close animated -->
 </div> <!-- close rocontainerw -->
 
 </main>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcah51LjCiIIFTqdekv78MHZvqT2NpCLo&callback=initMap"></script>
    
<script>
function initMap() {
    var locations = [
        <?php 
        if( count($company) > 0 ) {
          foreach($company as $row) {
            echo '["'.$row['company_name_th'].'", '.$row['map']['company_address_latitude'].', '.$row['map']['company_address_longitude'].', "'.$row['pin_color'].'", "'.$row['message'].'"],';
          } 
        }
        ?>
      
    ];

    bounds  = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById('map'), {
      // zoom: 20,
      center: new google.maps.LatLng(13.736717, 100.523186),
      streetViewControl: false,
      mapTypeControl: false,
      disableDefaultUI: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|'+locations[i][3]
        });
        loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
        bounds.extend(loc);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {

        return function() {
            //get company data from ajax
            infowindow.setContent("สถานประกอบการ: <b>"+locations[i][0]+"</b><br>"+locations[i][4]);
            infowindow.open(map, marker);
            
        }
      })(marker, i));
    }
    map.fitBounds(bounds);
    map.panToBounds(bounds);
}

function check_uncheck_checkbox(isChecked) {
  if(isChecked) {
    $('input[name="chkbox1[]"]').each(function() { 
      this.checked = true; 
    });
  } else {
    $('input[name="chkbox1[]"]').each(function() {
      this.checked = false;
    });
  }
}

function check_uncheck_checkbox2(isChecked) {
  if(isChecked) {
    $('input[name="chkbox[]"]').each(function() { 
      this.checked = true; 
    });
  } else {
    $('input[name="chkbox[]"]').each(function() {
      this.checked = false;
    });
  }
}
</script>