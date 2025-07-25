<?php
include("db.php");


session_start();




if (isset($_SESSION['worker_id'])) {
    $worker_id = $_SESSION['worker_id'];
} else {
    die("Couldn't find department in session.");
}
//fetching worker details using department in session
$qry = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
$qry_run = mysqli_query($conn,$qry);
$srow  = mysqli_fetch_array($qry_run);
$dept = $srow['worker_dept'];

//table 1 query
$sql4 = "SELECT 
cd.id,
cd.faculty_id,
faculty_details.faculty_name,
faculty_details.department,
faculty_details.faculty_contact,
faculty_details.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.status,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
JOIN 
faculty_details ON cd.faculty_id = faculty_details.faculty_id
WHERE 
(m.worker_dept = '$dept')
AND 
cd.status = '9'
";
$result4 = mysqli_query($conn, $sql4);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <title>worker</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: white;
        background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        padding: 11px 15px;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active:hover {
        border: none;
    }

    a {
        color: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        padding: 11px 15px;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs a:hover {
        color: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        border: 4px solid gray;
        /* Include the border within the button size */
        padding: 8px 15px;
        /* Adjust padding to maintain the button's size */
    }

    th {
        /* background-color: #7460ee; */
        background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        color: white;
    }

    @media (min-width:1300px) and (max-width:1800px) {
        /* For mobile phones: */

    }
    </style>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- Sidebar toggle for mobile -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>

                    <!-- Logo -->
                    <a class="navbar-brand" href="index.html">

                        <span class="logo-text">
                            <img src="assets/images/mkcenavlogo.png" alt="homepage" class="light-logo" />
                        </span>
                    </a>

                    <!-- Toggle for mobile -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>

                <!-- Navbar items -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                        <!-- Additional items can be added here -->
                    </ul>
                    <a href="login.php" class="btn btn-danger">
                        <i class=" fas fa-sign-out-alt" style="font-size: 15px;"></i>
                    </a>


                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a id="view-work-task-history"
                                class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history"
                                class="sidebar-link waves-effect waves-dark sidebar-link" href="new_work.php"
                                aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Work
                                    Asign</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history"
                                class="sidebar-link waves-effect waves-dark sidebar-link" href="workall.php"
                                aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span
                                    class="hide-menu"><?php echo $srow['worker_dept'] ?></span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Complaints</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">

                        <!-- Tabs -->

                        <!-- Tabs -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card">
                                    <div id="navref">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs mb-3" role="tablist">

                                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                                    href="#principal" role="tab"><span class="hidden-sm-up"></span>
                                                    <div id="ref4"><span class="hidden-xs-down"><b>Work
                                                                Assign</b></span></div>
                                                </a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#record"
                                                    role="tab"><span class="hidden-sm-up"></span>
                                                    <div id="ref5"><span class="hidden-xs-down"><b>Work
                                                                Record</b></span></div>
                                                </a> </li>





                                        </ul>
                                    </div>


                                    <!-- Tab panes -->
                                    <div class="tab-content tabcontent-border">
                                        <!--completed start-->
                                        <div class="tab-pane active p-20" id="principal" role="tabpanel">
                                            <div class="p-20">
                                                <div class="table-responsive">
                                                    <h5 class="card-title">Work Assign</h5>
                                                    <table id="principal_table"
                                                        class="table table-striped table-bordered">
                                                        <thead
                                                            style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                            <tr>
                                                                <th><b>S.No</b></th>
                                                                <th><b>Raised Date</b></th>
                                                                <th><b>Venue</b></th>
                                                                <th><b>Complaint</b></th>
                                                                <th><b>Picture</b></th>
                                                                <th><b>Action</b></th>
                                                                <th><b>Status</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                    $s = 1;
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $s ?></td>
                                                                <td><?php echo $row4['date_of_reg'] ?></td>
                                                                <td><?php echo $row4['block_venue'] ?></td>
                                                                <td>
                                                                    <button type="button"
                                                                        value="<?php echo $row4['id']; ?>"
                                                                        class="btn btn viewcomplaint"
                                                                        
                                                                        data-toggle="modal"
                                                                        data-target="#complaintDetailsModal">
                                                                        <i class="fas fa-eye"
                                                                            style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>

                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-light btn-sm showImage"
                                                                        value="<?php echo $row4['id']; ?>"
                                                                        data-toggle="modal">
                                                                        <i class="fas fa-image"
                                                                            style="font-size: 25px;"></i>
                                                                    </button>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button"
                                                                        class="btn btn-success acceptcomplaint"
                                                                        value="<?php echo $row4['id']; ?>"><i
                                                                            class="fas fa-check"></i></button>

                                                                </td>
                                                                <td>
                                                                    <span class="btn btn-success">Approved</span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- WOrk Assign end-->


                                        <!-- Record table start-->
                                        <?php
                                    // Set default month as the current month if no input is provided
                                    $selectedMonth = isset($_POST['selectmonth']) ? $_POST['selectmonth'] : date('m');
                                    



                                    // Fetch data based on the selected month
                                    $sql8 = "SELECT * FROM complaints_detail WHERE status='16'AND type_of_problem='$dept' AND MONTH(date_of_completion) = $selectedMonth AND YEAR(date_of_completion) = YEAR(CURDATE())";
                                    $result8 = mysqli_query($conn, $sql8);

                                    ?>

                                        <div class="tab-pane p-10" id="record" role="tabpanel">
                                            <div class="p-10">
                                                <div class="p-10">
                                                    <div class="card">
                                                        <div class="card-body" style="padding: 10px;">
                                                            <h5 class="card-title">Work Completed records</h5>
                                                            <form method="POST" action="">
                                                                <label for="selectmonth">Select Month (1-12): </label>
                                                                <input type="number" name="selectmonth" min="1" max="12"
                                                                    value="<?php echo $selectedMonth; ?>" required>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Enter</button>
                                                            </form><span style="float:right">
                                                                <button id="download" class="btn btn-success">Download
                                                                    as Excel</button></span><br><br>
                                                            <div class="table-responsive">
                                                                <table id="record_table"
                                                                    class="table table-striped table-bordered">
                                                                    <thead
                                                                        style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                                        <tr>
                                                                            <th class="text-center"><b>
                                                                                    <h5>S.No</h5>
                                                                                </b></th>
                                                                            <th class="col-md-2 text-center"><b>
                                                                                    <h5>Work ID</h5>
                                                                                </b></th>
                                                                            <th class="text-center"><b>
                                                                                    <h5>Venue Details</h5>
                                                                                </b></th>
                                                                            <th class="text-center"><b>
                                                                                    <h5>Completed Details</h5>
                                                                                </b></th>
                                                                            <th class="text-center">
                                                                                <b>
                                                                                    <h5>Completed On</h5>
                                                                                </b>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result8)) {
                                                            $pid = $row['id'];
                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center"><?php echo $s ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php echo $row['id'] ?></td>
                                                                            <td class="text-center">Venue:
                                                                                <?php echo $row['block_venue'] ?> |
                                                                                <br>Problem:
                                                                                <?php echo $row['problem_description'] ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php
                                                                    $id = "SELECT * FROM manager WHERE problem_id=$pid";
                                                                    $query_run1 = mysqli_query($conn, $id);
                                                                    $roww = mysqli_fetch_array($query_run1);
                                                                    $worker_id = $roww['worker_id'];

                                                                    // Fetch worker details
                                                                    $query = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
                                                                    $query_run = mysqli_query($conn, $query);
                                                                    $User_data = mysqli_fetch_array($query_run); ?>
                                                                                Completed by:
                                                                                <?php echo $User_data['worker_first_name'] ?>
                                                                                | <br>
                                                                                Department:
                                                                                <?php echo $User_data['worker_dept'] ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php echo $row['date_of_completion'] ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                            $s++;
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



                <!-- Complaint Details Modal -->
                <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog"
                    aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content"
                            style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                            <!-- Modal Header with bold title and cleaner button -->
                            <div class="modal-header"
                                style="background-color: #007bff; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 15px;">
                                <h5 class="modal-title" id="complaintDetailsModalLabel"
                                    style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                    📋 Complaint Details
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="color: white; font-size: 1.2em;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Modal Body with reduced padding -->
                            <div class="modal-body"
                                style="padding: 15px; font-size: 1.1em; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                                <!-- Complaint Info Section with minimized spacing -->
                                <ol class="list-group list-group-numbered" style="margin-bottom: 0;">
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">Faculty Name
                                            </div>
                                            <b><span id="faculty_name" style="color: #555;"></span></b>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">Mobile
                                                Number</div>
                                            <b><span id="faculty_contact" style="color: #555;"></span></b>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">E-mail</div>
                                            <b><span id="faculty_mail" style="color: #555;"></span></b>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">Venue Name
                                            </div>
                                            <b><span id="venue_name" style="color: #555;"></span></b>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">Type of
                                                Problem</div>
                                            <b><span id="type_of_problem" style="color: #555;"></span></b>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start"
                                        style="padding: 10px; background-color: #fff;">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"
                                                style="font-size: 1.2em; font-weight: 600; color: #007bff;">Problem
                                                Description</div>
                                            <div class="alert alert-light" role="alert"
                                                style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                <span id="problem_description"></span>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>

                            <!-- Modal Footer with reduced padding -->
                            <div class="modal-footer" style="border-top: none; justify-content: center; padding: 10px;">
                                <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal"
                                    style="border-radius: 25px; padding: 10px 30px; font-size: 1.1em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Priority Modal Box -->
                <div class="modal fade" id="prioritymodal1" tabindex="-1" role="dialog"
                    aria-labelledby="priorityModalLabel1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="border-radius: 8px; border: 1px solid #ccc;">
                            <div class="modal-header"
                                style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                                <h5 class="modal-title" id="priorityModalLabel1">Set Priority</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="padding: 20px; background-color: #f5f5f5;">
                                <form id="form20">
                                    <input type="hidden" name="problem_id" id="complaint_id77" value="">

                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="worker" class="font-weight-bold"
                                            style="display: block; margin-bottom: 5px;">Assign Worker:</label>
                                        <select class="form-control" name="worker" id="worker"
                                            style="width: 100%; height: 40px; border-radius: 4px; border: 1px solid #ccc;">
                                        </select>
                                    </div>
                                    <input type="checkbox" id="oth" name="oth" onclick="checkIfOthers()">Others
                                    <div id="othersInput" style="display: none;">
                                        <label class="form-label" for="otherValue">Worker name:</label>
                                        <input type="text" id="otherValue" name="otherworkername"> <br>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #007bff; border: none; padding: 12px 15px; font-size: 12px;">Submit</button>
                                <button type="button" class="btn btn-secondary"
                                    style="background-color: #6c757d; border: none; padding: 12px 15px; font-size: 12px;"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>


                <!-- Worker Details Modal -->
                <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog"
                    aria-labelledby="detailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"
                                style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                <h5 class="modal-title" id="detailsModalLabel">Worker Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="viewcomplaint" style="font-size: 16px;">
                                    <p><strong>Worker Name:</strong>
                                        <span id="worker_first_name"></span>
                                    </p>
                                    <p><strong>Worker Contact:</strong>
                                        <span id="worker_mobile"></span>
                                    </p>
                                    <p><strong>Worker Mail:</strong>
                                        <span id="worker_mail"></span>
                                    </p>
                                    <p><strong>Worker Department:</strong>
                                        <span id="worker_dept"></span>
                                    </p>
                                    <p><strong>Working Type:</strong>
                                        <span id="worker_emp_type"></span>
                                    </p>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Before Image Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Image" class="img-fluid"
                                    style="width: 100%; height: auto;">
                                <!-- src will be set dynamically -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- After Image Modal -->
                <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
                    aria-labelledby="afterImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="modalImage2" src="" alt="After" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Faculty Feedback</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea name="ffeed" id="ffeed" readonly></textarea>
                                <!-- Change to complaintfeed_id -->
                                <input type="hidden" id="complaintfeed_id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success done" data-dismiss="modal">Done</button>
                                <button type="button" class="btn btn-danger reass">Reassign</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date Picker Modal -->
                <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog"
                    aria-labelledby="datePickerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="datePickerModalLabel">Set Reassign Deadline</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="reassign_deadline">Reassign Deadline Date:</label>
                                <input type="date" id="reassign_deadline" name="reassign_deadline" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveDeadline">Set Deadline</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Table Feedback Modal -->
                <div class="modal fade" id="completedfeedbackModal" tabindex="-1" role="dialog"
                    aria-labelledby="completedfeedbackModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="completedfeedbackModalLabel">Faculty
                                    Feedback</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Content goes here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
                <!--image before and complaint end-->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
                    Developed and Maintained by Technology Innovation Hub.</b>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
        <script src="assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

        <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.viewcomplaint').tooltip({
                placement: 'top',
                title: 'View Complaint'
            });
        });


        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.showImage').tooltip({
                placement: 'top',
                title: 'Before'
            });
        });

        $(document).ready(function() {
            $("#principal_table").DataTable();
        });

        $(document).ready(function() {
            $("#record_table").DataTable();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('.acceptcomplaint').tooltip({
                placement: 'top',
                title: 'Accept'
            });
        });


//Accepting the complaint tick button
        $(document).on("click", ".acceptcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            $.ajax({
                url: 'cms_backend.php?action=wacceptcomp',
                type: "POST",
                data: {
                    'user_id': user_id
                },
                success: function(response) {
                    if (response.includes("Success")) {
                        Swal.fire({
                    title: "Accepted!",
                    text: "Work Started",
                    icon: "success"
                });                        $('#principal_table').DataTable().destroy();
                        $("#principal_table").load(location.href + " #principal_table > *",
                            function() {
                                $('#principal_table').DataTable();
                            });



                    } else {
                        alert(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
            //for sending mail as accepted
            $.ajax({
                type: "POST",
                url: "mail.php",
                data: {
                    approved: true,
                    id: user_id,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        console.log("Success");
                    } else {
                        console.log("error");
                    }
                }
            })
        });
        //view complaint details in modal

        $(document).on("click", ".viewcomplaint", function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=whviewcomp',
                data: {
                    user_id: user_id,
                    fac_id: 1,
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    console.log(res);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        $("#id").val(res.data.id);
                        $("#type_of_problem").text(res.data.type_of_problem);
                        $("#problem_description").text(res.data.problem_description);
                        $("#faculty_name").text(res.data.faculty_name);
                        $("#faculty_mail").text(res.data.faculty_mail);
                        $("#faculty_contact").text(res.data.faculty_contact);
                        $("#block_venue").text(res.data.block_venue);
                        $("#venue_name").text(res.data.venue_name);
                        $("#complaintDetailsModal").modal("show");
                    }
                },
            });
        });
        //viewing before image
        $(document).on("click", ".showImage", function() {
            var problem_id = $(this).val();
            console.log(problem_id);
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=get_image',
                data: {
                    problem_id: problem_id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $("#modalImage").attr("src", "uploads/" + response.data.images);
                        $("#imageModal").modal("show");
                    } else {
                        alert(
                            response.message || "An error occurred while retrieving the image."
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert(
                        "An error occurred: " +
                        error +
                        "\nStatus: " +
                        status +
                        "\nDetails: " +
                        xhr.responseText
                    );
                },
            });
        });

//viewing after image
        $(document).on("click", ".imgafter", function() {
            var problem_id = $(this).val();
            $.ajax({
                type: "POST",
                url: 'cms_backend.php?action=get_aimage',
                data: {
                    problem2_id: problem_id,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $("#modalImage2").attr("src", response.data.after_photo);
                        $("#afterImageModal").modal("show");
                    } else {
                        alert(response.message || "An error occurred while retrieving the image.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        });


       //download record as excel file
        document.getElementById('download').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('record_table'));
            XLSX.utils.book_append_sheet(wb, ws, "Complaints Data");

            // Create and trigger the download
            XLSX.writeFile(wb, 'complaints_data.xlsx');
        });
        </script>






</body>

</html>