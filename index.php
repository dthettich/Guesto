<?php

$db = new SQLite3('db.sqlite3');

$results = $db->query('SELECT * FROM guest');
while ($row = $results->fetchArray()) {

  #echo $row["id"] ."\t". $row["lastname"] ."\t". $row["firstname"] ."\t";
  #echo $row["mail"] ."\t". $row["street"] ."\t". $row["phone"] ."\n";
}



?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
<script  type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script  type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<script  type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
    var table = $('#example').DataTable();

    $('#example tbody').on( 'click', 'tr', function () {
      $( "#del_button" ).show( "fast" );
        if ( $(this).hasClass('selected') ) {
          $( "#del_button" ).hide( "fast" );
             $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );


} );
</script>
  <script src="js/jquery.confirm.js"></script>

</head>
<body>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Guesto</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">View </a></li>
          <li><a href="add_guest.php">Add</a></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Link</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">

      <div class="col-md-10 col-md-offset-1">
        <div class="col-sm-20">
          <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"></div>
            <!-- Table -->
            <table id="example" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Mail</th>
                  <th>Street</th>
                  <th>No.</th>
                  <th>Zip</th>
                  <th>City</th>
                  <th>Participate?</th>
                  <th>Comment</th>
                </tr>
              </thead>
              <tbody>
                <!<?php

                while ($row = $results->fetchArray()) {
                  echo '<tr><th scope="row">'.$row["id"].'</th>';
                  echo '<td>'.$row["lastname"].'</td>';
                  echo '<td>'.$row["firstname"].'</td>';
                  echo '<td>'.$row["mail"].'</td>';
                  echo '<td>'.$row["street"].'</td>';
                  echo '<td>'.$row["streetnumber"].'</td>';
                  echo '<td>'.$row["zip"].'</td>';
                  echo '<td>'.$row["city"].'</td>';

                  /*
                  if (strcmp(trim($row["participation"]),"yes") == 0) {
                    echo '<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                  } else {
                    echo '<td><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                  }
                  */
                  echo '<td>'.$row["participation"].'</td>';
                  echo '<td>'.$row["comment"].'</td>';
                  echo '</tr>';
                  #echo $row["id"] ."\t". $row["lastname"] ."\t". $row["firstname"] ."\t";
                  #echo $row["mail"] ."\t". $row["street"] ."\t". $row["phone"] ."\n";
                }

                $db->close();
                 ?>
              </tbody>
            </table>
          </div>
          <div class="col-sm-20">
                <input id="del_button" name="delete" type="delete" value="Delete selected entry" class="btn btn-primary" style="display: none">
          </div>
        </div>
      </div>
      </div>
  </div> <!-- container end -->

  <script>
  $("#del_button").click(function() {
      $.confirm({
          text: "Are you sure to delete this guest! Please confirm:",
          confirm: function(button) {
                var table = $('#example').DataTable();

            var name = table.row('.selected').data();
            if (name) {
              table.row('.selected').remove().draw( false );
                        $( "#del_button" ).hide( "fast" );
            }
          },
          cancel: function(button) {
              alert("You cancelled.");
          }
      });
  });      </script>
  <script  type="text/javascript" language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</head>
</html>
