<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM DETAILS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="stylercss.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid px-1 py-5 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-left">
                <div class="card">
                    <div class="card-header">
                        <h3>USER INFORMATION</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        if (isset($_SESSION['gname'])) {
                            $nm = $_SESSION['gname'];
                            $eml = $_SESSION['email'];
                            $fbURL = $_SESSION['fblink'];
                            $phnum = $_SESSION['phonenum'];
                            $gender = $_SESSION['gender'];
                            $ctry = $_SESSION['country'];
                            $skills = $_SESSION['skills'];
                            $bio = $_SESSION['biography'];

                            echo "<p><strong>Name:</strong> " . htmlspecialchars($nm) . "</p>";
                            echo "<p><strong>Email:</strong> " . htmlspecialchars($eml) . "</p>";
                            echo "<p><strong>Facebook URL:</strong> <a href='" . htmlspecialchars($fbURL) . "' target='_blank'>" . htmlspecialchars($fbURL) . "</a></p>";
                            echo "<p><strong>Password:</strong> [REDACTED]</p>"; 
                            echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($phnum) . "</p>";
                            echo "<p><strong>Gender:</strong> " . htmlspecialchars($gender) . "</p>";
                            echo "<p><strong>Country:</strong> " . htmlspecialchars($ctry) . "</p>";
                            echo "<p><strong>Skills:</strong> " . htmlspecialchars($skills) . "</p>";
                            echo "<p><strong>Biography:</strong> " . nl2br(htmlspecialchars($bio)) . "</p>"; 
                        } else {
                            echo "<p>No data available. Please submit the form.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
