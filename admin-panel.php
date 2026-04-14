<!DOCTYPE html>

<?php 
include('func.php');  
include('newfunc.php');
$con = mysqli_connect("localhost","root","","myhmsdb");


$pid      = isset($_SESSION['pid'])      ? $_SESSION['pid']      : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email    = isset($_SESSION['email'])    ? $_SESSION['email']    : '';
$fname    = isset($_SESSION['fname'])    ? $_SESSION['fname']    : '';
$gender   = isset($_SESSION['gender'])  ? $_SESSION['gender']   : '';
$lname    = isset($_SESSION['lname'])   ? $_SESSION['lname']    : '';
$contact  = isset($_SESSION['contact']) ? $_SESSION['contact']  : '';


if(empty($username)) {
    header("Location: index.php");
    exit();
}

if(isset($_POST['app-submit']))
{
  $pid      = isset($_SESSION['pid'])      ? $_SESSION['pid']      : '';
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
  $email    = isset($_SESSION['email'])    ? $_SESSION['email']    : '';
  $fname    = isset($_SESSION['fname'])    ? $_SESSION['fname']    : '';
  $lname    = isset($_SESSION['lname'])   ? $_SESSION['lname']    : '';
  $gender   = isset($_SESSION['gender'])  ? $_SESSION['gender']   : '';
  $contact  = isset($_SESSION['contact']) ? $_SESSION['contact']  : '';
  $doctor   = $_POST['doctor'];
  $email    = isset($_SESSION['email'])    ? $_SESSION['email']    : '';
  $docFees  = $_POST['docFees'];
  $appdate  = $_POST['appdate'];
  $apptime  = $_POST['apptime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);
	
  if(date("Y-m-d",$appdate1) >= $cur_date){
    if((date("Y-m-d",$appdate1) == $cur_date and date("H:i:s",$apptime1) > $cur_time) or date("Y-m-d",$appdate1) > $cur_date) {
      $check_query = mysqli_query($con,"select apptime from appointmenttb where doctor='$doctor' and appdate='$appdate' and apptime='$apptime'");

        if(mysqli_num_rows($check_query) == 0){
          $query = mysqli_query($con,"INSERT INTO appointmenttb 
(pid,fname,lname,gender,email,contact,doctor,docFees,appdate,apptime,userStatus,doctorStatus) 
VALUES('$pid','$fname','$lname','$gender','$email','$contact','$doctor','$docFees','$appdate','$apptime','1','1')");
          if($query) {
            echo "<script>alert('Your appointment successfully booked!');</script>";
          } else {
            echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
        } else {
          echo "<script>alert('We are sorry, the doctor is not available at this time. Please choose a different time or date!');</script>";
        }
    } else {
      echo "<script>alert('Please select a future time or date!');</script>";
    }
  } else {
      echo "<script>alert('Please select a future time or date!');</script>";
  }
}

if(isset($_GET['cancel'])) {
    $query = mysqli_query($con,"update appointmenttb set userStatus='0' where ID = '".$_GET['ID']."'");
    if($query) {
      echo "<script>alert('Your appointment successfully cancelled!');</script>";
    }
}

function generate_bill(){
  $con = mysqli_connect("localhost","root","","myhmsdb");
  $pid = isset($_SESSION['pid']) ? $_SESSION['pid'] : '';
  $output = '';
  $query = mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from prestb p inner join appointmenttb a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
  while($row = mysqli_fetch_array($query)){
    $output .= '
    <label> Patient ID : </label>'.$row["pid"].'<br/><br/>
    <label> Appointment ID : </label>'.$row["ID"].'<br/><br/>
    <label> Patient Name : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
    <label> Doctor Name : </label>'.$row["doctor"].'<br/><br/>
    <label> Appointment Date : </label>'.$row["appdate"].'<br/><br/>
    <label> Appointment Time : </label>'.$row["apptime"].'<br/><br/>
    <label> Disease : </label>'.$row["disease"].'<br/><br/>
    <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
    <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
    <label> Fees Paid : </label>'.$row["docFees"].'<br/>
    ';
  }
  return $output;
}

if(isset($_GET["generate_bill"])){
  require_once("TCPDF/tcpdf.php");
  $obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
  $obj_pdf->SetCreator(PDF_CREATOR);
  $obj_pdf->SetTitle("Generate Bill");
  $obj_pdf->SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
  $obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf->SetDefaultMonospacedFont('helvetica');
  $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  $obj_pdf->SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
  $obj_pdf->SetPrintHeader(false);
  $obj_pdf->SetPrintFooter(false);
  $obj_pdf->SetAutoPageBreak(TRUE, 10);
  $obj_pdf->SetFont('helvetica','',12);
  $obj_pdf->AddPage();

  $content = '';
  $content .= '
      <br/>
      <h2 align="center"> Global Hospitals</h2><br/>
      <h3 align="center"> Bill</h3>
  ';
  $content .= generate_bill();
  $obj_pdf->writeHTML($content);
  ob_end_clean();
  $obj_pdf->Output("bill.pdf",'I');
}

function get_specs(){
  $con = mysqli_connect("localhost","root","","myhmsdb");
  $query = mysqli_query($con,"select username,spec from doctb");
  $docarray = array();
    while($row = mysqli_fetch_assoc($query)) {
        $docarray[] = $row;
    }
    return json_encode($docarray);
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Patient Dashboard | MediCare Plus</title>
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">

    <style>
      * { font-family: 'IBM Plex Sans', sans-serif; }
      button:hover { cursor: pointer; }
      #inputbtn:hover { cursor: pointer; }
      .bg-primary { background: -webkit-linear-gradient(left, #3931af, #00c6ff); }
      .list-group-item.active { z-index: 2; color: #fff; background-color: #342ac1; border-color: #007bff; }
      .text-primary { color: #342ac1 !important; }
      .btn-primary { background-color: #3c50c1; border-color: #3c50c1; }
    </style>
  </head>

  <body style="padding-top:50px;">

    <!-- Navbar -->
    <nav class="navbar navbar-dark fixed-top" style="background: linear-gradient(to right, #1b5e20, #00897b);">
      <a class="navbar-brand" href="#">
        <i class="fa fa-user-plus" aria-hidden="true"></i> MediCare Plus
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid" style="margin-top:50px;">
      <h3 style="margin-left:40%; padding-bottom:20px; font-family:'IBM Plex Sans',sans-serif;">
        Welcome &nbsp; <?php echo htmlspecialchars($username); ?>
      </h3>

      <div class="row">

        <!-- Sidebar -->
        <div class="col-md-4" style="max-width:25%; margin-top:3%">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab">Dashboard</a>
            <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Book Appointment</a>
            <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list">Appointment History</a>
            <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list">Prescriptions</a>
          </div><br>
        </div>

        <!-- Main Content -->
        <div class="col-md-8" style="margin-top:3%;">
          <div class="tab-content" id="nav-tabContent" style="width:950px;">

            <!-- Dashboard Tab -->
            <div class="tab-pane fade show active" id="list-dash" role="tabpanel">
              <div class="container-fluid container-fullw bg-white">
                <div class="row">
                  <div class="col-sm-4" style="left:5%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x">
                          <i class="fa fa-square fa-stack-2x text-primary"></i>
                          <i class="fa fa-terminal fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 style="margin-top:5%;">Book My Appointment</h4>
                        <script>
                          function clickDiv(id) { document.querySelector(id).click(); }
                        </script>
                        <p><a href="#list-home" onclick="clickDiv('#list-home-list')">Book Appointment</a></p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4" style="left:10%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x">
                          <i class="fa fa-square fa-stack-2x text-primary"></i>
                          <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 style="margin-top:5%;">My Appointments</h4>
                        <p><a href="#app-hist" onclick="clickDiv('#list-pat-list')">View Appointment History</a></p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4" style="left:20%; margin-top:5%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x">
                          <i class="fa fa-square fa-stack-2x text-primary"></i>
                          <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 style="margin-top:5%;">Prescriptions</h4>
                        <p><a href="#list-pres" onclick="clickDiv('#list-pres-list')">View Prescription List</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Book Appointment Tab -->
            <div class="tab-pane fade" id="list-home" role="tabpanel">
              <div class="container-fluid">
                <div class="card">
                  <div class="card-body">
                    <center><h4>Create an Appointment</h4></center><br>
                    <form class="form-group" method="post" action="admin-panel.php">
                      <div class="row">

                        <div class="col-md-4"><label>Specialization:</label></div>
                        <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                            <option value="" disabled selected>Select Specialization</option>
                            <?php display_specs(); ?>
                          </select>
                        </div><br><br>

                        <script>
                          document.getElementById('spec').onchange = function() {
                            let spec = this.value;
                            let docs = [...document.getElementById('doctor').options];
                            docs.forEach((el, ind, arr) => {
                              arr[ind].setAttribute("style","");
                              if (el.getAttribute("data-spec") != spec) {
                                arr[ind].setAttribute("style","display:none");
                              }
                            });
                          };
                        </script>

                        <div class="col-md-4"><label>Doctors:</label></div>
                        <div class="col-md-8">
                          <select name="doctor" class="form-control" id="doctor" required>
                            <option value="" disabled selected>Select Doctor</option>
                            <?php display_docs(); ?>
                          </select>
                        </div><br><br>

                        <script>
                          document.getElementById('doctor').onchange = function() {
                            var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                            document.getElementById('docFees').value = selection;
                          };
                        </script>

                        <div class="col-md-4"><label>Consultancy Fees</label></div>
                        <div class="col-md-8">
                          <input class="form-control" type="text" name="docFees" id="docFees" readonly/>
                        </div><br><br>

                        <div class="col-md-4"><label>Appointment Date</label></div>
                        <div class="col-md-8">
                          <input type="date" class="form-control" name="appdate" required>
                        </div><br><br>

                        <div class="col-md-4"><label>Appointment Time</label></div>
                        <div class="col-md-8">
                          <select name="apptime" class="form-control" id="apptime" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="08:00:00">8:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="12:00:00">12:00 PM</option>
                            <option value="14:00:00">2:00 PM</option>
                            <option value="16:00:00">4:00 PM</option>
                          </select>
                        </div><br><br>

                        <div class="col-md-4">
                          <input type="submit" name="app-submit" value="Book Appointment" class="btn btn-primary" id="inputbtn">
                        </div>

                      </div>
                    </form>
                  </div>
                </div>
              </div><br>
            </div>

            <!-- Appointment History Tab -->
            <div class="tab-pane fade" id="app-hist" role="tabpanel">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Doctor Name</th>
                    <th>Consultancy Fees</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Current Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = "select ID,doctor,docFees,appdate,apptime,userStatus,doctorStatus from appointmenttb where fname='$fname' and lname='$lname';";
                    $result = mysqli_query($con, $query);
                    while($row = mysqli_fetch_array($result)){
                  ?>
                  <tr>
                    <td><?php echo $row['doctor']; ?></td>
                    <td><?php echo $row['docFees']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td>
                      <?php
                        if($row['userStatus']==1 && $row['doctorStatus']==1) echo "Active";
                        if($row['userStatus']==0 && $row['doctorStatus']==1) echo "Cancelled by You";
                        if($row['userStatus']==1 && $row['doctorStatus']==0) echo "Cancelled by Doctor";
                      ?>
                    </td>
                    <td>
                      <?php if($row['userStatus']==1 && $row['doctorStatus']==1){ ?>
                        <a href="admin-panel.php?ID=<?php echo $row['ID']; ?>&cancel=update"
                           onclick="return confirm('Are you sure you want to cancel this appointment?')">
                          <button class="btn btn-danger">Cancel</button>
                        </a>
                      <?php } else { echo "Cancelled"; } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <!-- Prescriptions Tab -->
            <div class="tab-pane fade" id="list-pres" role="tabpanel">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Doctor Name</th>
                    <th>Appointment ID</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Diseases</th>
                    <th>Allergies</th>
                    <th>Prescriptions</th>
                    <th>Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $query = "select doctor,ID,appdate,apptime,disease,allergy,prescription from prestb where pid='$pid';";
                    $result = mysqli_query($con, $query);
                    if(!$result){ echo mysqli_error($con); }
                    while($row = mysqli_fetch_array($result)){
                  ?>
                  <tr>
                    <td><?php echo $row['doctor']; ?></td>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['appdate']; ?></td>
                    <td><?php echo $row['apptime']; ?></td>
                    <td><?php echo $row['disease']; ?></td>
                    <td><?php echo $row['allergy']; ?></td>
                    <td><?php echo $row['prescription']; ?></td>
                    <td>
                      <form method="get">
                        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>"/>
                        <input type="submit" onclick="alert('Bill Paid Successfully!');" name="generate_bill" class="btn btn-success" value="Pay Bill"/>
                      </form>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <?php include('chatbot.php'); ?>

  </body>
</html>
