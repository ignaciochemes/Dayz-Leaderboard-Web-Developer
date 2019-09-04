<?php  
 $connect = mysqli_connect("localhost", "User", "", "NombreDB");  
 $query ="SELECT * FROM NombreTabla ORDER BY id DESC";  
 $result = mysqli_query($connect, $query);  
 ?> 
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Base de datos Survivors RP</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">

      </head>  
      <body>  
           <br /><br />  
           <div class="container">  
                <h3 align="center">Base de datos Survivors RP</h3>  
                <br />  
                <div class="table-responsive">  
                     <table id="employee_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr> 
				    <td>Nombre</td>
                                    <td>Z Matados</td>
                                    <td>Animales Matados</td>   
                                    <td>Distancia Recorrida</td>  
                                    <td>Suicidios</td>
				    <td>Muertes Por Z</td>
				    <td>Muertes Nat.</td>
				    <td>Max T Sobrev.</td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
				    <td>'.$row["name"].'</td>
                                    <td>'.$row["zKilled"].'</td>
                                    <td>'.$row["animalsKilled"].'</td>  
                                    <td>'.$row["distTrav"].'</td>  
                                    <td>'.$row["suicideCount"].'</td>
				    <td>'.$row["deathsToZCount"].'</td>
				    <td>'.$row["deathsToNaturalCauseCount"].'</td>
				    <td>'.$row["timeSurvived"].'</td>
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>
      </body>  
 </html>  
 <script>
$(document).ready(function() {
    $('#employee_data').DataTable( {
        "order": [[ 1, "desc" ]]
    } );
} );
 //$(document).ready(function(){  
 //    $('#employee_data').DataTable();  
 //});  
 </script>  
