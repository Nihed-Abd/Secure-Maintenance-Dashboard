<?php
require_once '../Controller/postC.php';
require_once '../Model/post.php';
require_once '../Controller/NotificationController.php';
require_once '../Model/Notification.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$post = null;
$postC = new postC();
$notificationC = new NotificationController(); // Create an instance of the NotificationController

if (
    isset($_POST["nom"]) &&
    isset($_POST["codeBarre"]) &&
    isset($_FILES["image"]) &&
    isset($_FILES["picReal"]) &&
    isset($_FILES["codeQrBarre"]) &&
    isset($_POST["dateFabrication"]) &&
    isset($_POST["typePreventif"])
) {
    if (
        !empty($_POST["nom"]) &&
        !empty($_POST["codeBarre"]) &&
        !empty($_FILES["image"]["name"]) &&
        !empty($_FILES["picReal"]["name"]) &&
        !empty($_FILES["codeQrBarre"]["name"]) &&
        !empty($_POST["dateFabrication"]) &&
        !empty($_POST["typePreventif"])
    ) {
        $image = $_FILES["image"]["name"];
        $picReal = $_FILES["picReal"]["name"];
        $codeQrBarre = $_FILES["codeQrBarre"]["name"];

        // Define the target directory for images
        $target_dir = "assets/img/";

        // Ensure the target directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Define the target files
        $target_file_image = $target_dir . basename($image);
        $target_file_picReal = $target_dir . basename($picReal);
        $target_file_codeQrBarre = $target_dir . basename($codeQrBarre);

        // Move the uploaded files to the target directory
        $uploadSuccess = true;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_image)) {
            $uploadSuccess = false;
            $error = "Error uploading image file.";
        }
        if (!move_uploaded_file($_FILES["picReal"]["tmp_name"], $target_file_picReal)) {
            $uploadSuccess = false;
            $error = "Error uploading picReal file.";
        }
        if (!move_uploaded_file($_FILES["codeQrBarre"]["tmp_name"], $target_file_codeQrBarre)) {
            $uploadSuccess = false;
            $error = "Error uploading codeQrBarre file.";
        }

        if ($uploadSuccess) {
            $post = new post(
                $_POST['nom'],
                $_POST['codeBarre'],
                $image,
                $picReal,
                $codeQrBarre,
                $_POST['dateFabrication'],
                $_POST['typePreventif']
            );

            if ($postC->ajouterPost($post)) {
                // Prepare the notification
                $userName = $_SESSION['user_name']; // Assuming user name is stored in session
                $time = date('Y-m-d H:i:s');
                $notificationMessage = "New Post added by " . $userName;

                $notification = new Notification(
                    $time,
                    $notificationMessage,
                    $userName
                );

                if ($notificationC->addNotification($notification)) {
                    header('Location: listPosts.php');
                    exit();
                } else {
                    $error = "Error adding notification to database.";
                }
            } else {
                $error = "Error adding post to database.";
            }
        }
    } else {
        $error = "Missing information.";
    }
  
}
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard - SagemCom</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
    
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user me-2"></i>SagemCom</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="assets/img/roube.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $user_name; ?></h6>
                        <span><?php echo $user_email; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                <a href="dashbord.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashbord</a>
                    <a href="listPosts.php" class="nav-item nav-link "><i class="fa fa-file-alt"></i>Posts</a>
                    <a href="addPost.php" class="nav-item nav-link active"><i class="fa fa-plus me-2"></i>Add Post</a>
                    <a href="historique.php" class="nav-item nav-link "><i class="fa fa-history me-2"></i>History</a>
                    <a href="entretient.php" class="nav-item nav-link "><i class="fa fa-tools me-2"></i>Entretients</a>

                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" id="searchName" placeholder="Search by name">
                    <input class="form-control border-0" type="search" id="searchCodeBarre" placeholder="Search by code barre">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="assets/img/roube.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $user_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Add New Post</h6>
                            <?php
                            if ($error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ?>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="mb-3">
                                    <label for="codeBarre" class="form-label">Code Barre</label>
                                    <input type="number" class="form-control" id="codeBarre" name="codeBarre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="image" name="image" required>
                                </div>
                                <div class="mb-3">
                                    <label for="picReal" class="form-label">Pic Real</label>
                                    <input class="form-control" type="file" id="picReal" name="picReal" required>
                                </div>
                                <div class="mb-3">
                                    <label for="codeQrBarre" class="form-label">Code QR Barre</label>
                                    <input class="form-control" type="file" id="codeQrBarre" name="codeQrBarre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dateFabrication" class="form-label">Date Fabrication</label>
                                    <input type="datetime-local" class="form-control" id="dateFabrication" name="dateFabrication" required>
                                </div>
                                <div class="mb-3">
                                <label for="typePreventif" class="form-label">Type Preventif</label>
                                <select class="form-control" id="typePreventif" name="typePreventif" required>
                                    <option value="">Select Type</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>

                                <button type="submit" class="btn btn-primary">Add Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">SagemCom</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="#">Roube</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/chart/chart.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>

</html>
