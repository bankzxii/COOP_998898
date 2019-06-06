<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
  <body>
   
 
    <h4>Display Records From Database Using Codeigniter</h4>
    
    <table border="1">
      <tr>
        <td><input type="checkbox" name="#"></td>
        <td>Company_id</td>
        <td>Latitude</td>
        <td>Longitude</td>
        <td>Company_name_th</td>
      </tr>
      <?php
      // $i='1';
      foreach($posts as $row){
      echo "<tr>";
      // echo "<td>".$i."</td>";
      echo "<td><input id='active' type='checkbox' value=".$row['company_id']."</td>";
      echo "<td>".$row['company_id']."</td>";
      echo "<td>".$row['company_address_latitude']."</td>";
      echo "<td>".$row['company_address_longitude']."</td>";
      echo "<td>".$row['company_name_th']."</td>";

      echo "</tr>";
      // $i++;
      }
      ?>
    </table>
    

  </body>
</html>

<script>
$("#active").click(function() {
    var company_id = $("#active").val();
    jQuery.ajax({
        type: "POST",
        url: "http://prepro.informatics.buu.ac.th:8001/Officer/Test_query/Checked",
        data: {company_id:company_id},
    });

    });
</script>