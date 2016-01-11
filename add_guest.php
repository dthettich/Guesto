<?php
error_reporting(E_ERROR | E_PARSE);


	if (isset($_POST["submit"])) {
    $id = $_POST['id'];
		$lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
		$mail = $_POST['mail'];
		$street = $_POST['street'];
    $streetnumber = $_POST['streetnumber'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $participation = $_POST['participation'];
    $comment = $_POST['comment'];

		$to = 'example@domain.com';
    $subject = 'Sample Form Output';
		$body ="$lastname, $firstname\n $mail\n$street, $streetnumber\n$zip $city\n$participation\n$comment";

		// Check if name has been entered
		if (!$_POST['lastname'] || !$_POST['firstname']) {
			$errName = 'Please enter your name';
		}

		// Check if email has been entered and is valid
		if (!$_POST['mail'] || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
			$errMail = 'Please enter a valid email address';
		}

		//Check if message has been entered
		if (!$_POST['street'] || !preg_match(" /[^\$%\^*£=~@0123456789]/ ",$_POST['street'])) {
			$errStreet = 'Please enter your street';
		}

    //Check if street number has been entered
    if (!$_POST['streetnumber'] || !preg_match("/^[0-9a-z]+$/",$_POST['streetnumber'])) {
      $errStreetnumber = 'Please enter your street number';
    }

    if (!$_POST['zip'] || !preg_match("/^[1-9]\d{4}$/",$_POST['zip'])) {
      $errZip = 'Please enter your zip';
    }

    if (!$_POST['city'] || !preg_match(" /[^\$%\^*£=~@0123456789]/ ",$_POST['city'])) {
      $errCity = 'Please enter your city';
    }

    if (!$_POST['phone'] || !preg_match("/^[0-9]+$/",$_POST['phone'])) {
      $errPhone = 'Please enter your phone number';
    }

    if (!$_POST['participation'] ) {
      $errParticipation = 'Participation statement is required';
    }


// If there are no errors, send the email
if (!$errName && !$errMail && !$errStreet && !$errStreetnumber && !$errZip && !$errCity && !$errParticipation && !$errPhone) {

  $db = new SQLite3('db.sqlite3');

  $query = sprintf("INSERT INTO guest (lastname, firstname, mail, street, streetnumber, zip, city, phone, participation, comment) VALUES
                                      ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                                       $lastname,
                                       $firstname,
                                       $mail,
                                       $street,
                                       $streetnumber,
                                       $zip,
                                       $city,
                                       $phone,
                                       $participation,
                                       $comment
                                    );
  #echo '<p>'.$query.'</p>';

  $count = $db->exec($query) or die(print_r($db->errorInfo(), true));

  $db->close();

  if ($count !== 0) {
		$result='<div class="alert alert-success">Guest successfully added! Reloading...</div>';
    $page = $_SERVER['PHP_SELF'];
    $sec = "2";
    header("Refresh: $sec; url=$page");
	} else {
		$result='<div class="alert alert-danger">Sorry there was an error executing your query. Please try again later.</div>';
	}
}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guest</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
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
						<li><a href="index.php">View</a></li>
						<li class="active"><a href="add_guest2.php">Add <span class="sr-only">(current)</span></a></li>

					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Link</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>

  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center">Add Guest</h1>
          <form  class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Meyerfake" value="<?php echo htmlspecialchars($_POST['lastname']); ?>">
                  <?php echo "<p class='text-danger'>$errName</p>";?>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Karl" value="<?php echo htmlspecialchars($_POST['firstname']); ?>">
                  <?php echo "<p class='text-danger'>$errName</p>";?>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Email Address</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="mail" name="mail" placeholder="karl@meyerfake.com" value="<?php echo htmlspecialchars($_POST['mail']); ?>">
                  <?php echo "<p class='text-danger'>$errMail</p>";?>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Street</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="street" name="street" placeholder="Faux-way" value="<?php echo htmlspecialchars($_POST['street']); ?>">
                  <?php echo "<p class='text-danger'>$errStreet</p>";?>
              </div>
              <label for="name" class="col-sm-2 control-label">Number</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="streetnumber" name="streetnumber" placeholder="13" value="<?php echo htmlspecialchars($_POST['streetnumber']); ?>">
                <?php echo "<p class='text-danger'>$errStreetnumber</p>";?>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Zip Code</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="zip" name="zip" placeholder="55500" value="<?php echo htmlspecialchars($_POST['zip']); ?>">
                  <?php echo "<p class='text-danger'>$errZip</p>";?>
              </div>
              <label for="name" class="col-sm-2 control-label">City</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="city" name="city" placeholder="Berlin" value="<?php echo htmlspecialchars($_POST['city']); ?>">
                <?php echo "<p class='text-danger'>$errCity</p>";?>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Phone Number</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="017555555555" value="<?php echo htmlspecialchars($_POST['phone']); ?>">
                  <?php echo "<p class='text-danger'>$errPhone</p>";?>
              </div>
            </div>


            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Participate?</label>
                <div class="col-sm-10">
                  <p class="text-center lead">
                  <input type="radio" aria-label="..." name="participation" <?php if (isset($participation) && $participation=="yes") echo "checked";?>  value="yes"> Yes
                  &emsp;&emsp;
                  <input type="radio" aria-label="..." name="participation" <?php if (isset($participation) && $participation=="no") echo "checked";?>  value="no"> No</p>
                  <p class="text-danger"><?php echo $errParticipation;?></p>
              </div>
            </div>


            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="comment" name="comment" placeholder="Add your comment here..." value="<?php echo htmlspecialchars($_POST['comment']); ?>">

              </div>
            </div>

            <hr>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Controls</label>
              <div class="col-sm-10 ">
                <input id="submit" name="submit" type="submit" value="Submit" class="btn btn-primary">
                <input id="reset" name="reset"  type="reset" value="Reset" class="btn btn-danger"</button>

              </div>
            </div>
            <hr>
					<div class="form-group">
            <?php if (!empty($result)) {
              echo '<label for="name" class="col-sm-2 control-label">Log</label>';
            }
            ?>
						<div class="col-sm-10">
							<?php echo $result; ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
  <script>
function myFunction() {
    location.reload();
}
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
