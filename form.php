<?php 
session_start(); 
ob_start(); //Resorted to this because it stopped accepting/overwrting newer input for some reason
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM VALIDATION AND SANITATION</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="stylecss.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid px-1 py-5 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                <h3>FORM and VALIDATION</h3>
                <p class="blue-text">Complete the Form</p>
                <div class="card">
                    <h5 class="text-center mb-4">Form Registration</h5>

                    <form id="loginform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="coolname">Name</label>
                                <input type="text" name="coolname" id="coolname">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                        </div>

                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="fblink">Facebook URL</label>
                                <input type="url" name="fblink" id="fblink">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password">
                            </div>
                        </div>

                        <div class="row justify-content-between text-left">
                            <div class="form-group col-6 flex-column d-flex">
                                <label for="phonenum">Phone Number</label>
                                <input type="text" name="phonenum" id="phonenum">
                            </div>
                            <div class="form-group col-6 flex-column d-flex">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password">
                            </div>
                        </div>

                        <div class="column justify-content-between text-center">
                            <label for="gender">Gender</label><br>
                            <input type="radio" name="gender" id="gender_male" value="male"> Male
                            <input type="radio" name="gender" id="gender_female" value="female"> Female
                            <input type="radio" name="gender" id="gender_other" value="other"> Other
                        </div>

                        <br>
                        
                        <div class="column justify-content-between text-center">
                            <label for="country">Country</label>
                            <select class="form-select" id="country" name="country">
                                <option selected>Select your country</option>
                                <option value="United States">United States</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                                <option value="India">India</option>
                            </select>
                        </div>

                        <div class="column justify-content-between text-left">
                            <label for="skills">Skills</label><br>
                            <input type="checkbox" name="skills[]" value="Leadership"> Leadership<br>
                            <input type="checkbox" name="skills[]" value="Good Communication"> Good Communication<br>
                            <input type="checkbox" name="skills[]" value="Problem Solving"> Problem Solving<br>
                            <input type="checkbox" name="skills[]" value="Adaptability"> Adaptability<br>
                            <input type="checkbox" name="skills[]" value="Flexibility"> Flexibility<br>
                            <input type="checkbox" name="skills[]" value="Great Time Management"> Great Time Management<br>
                        </div>

                        <label for="biography">Biography</label>
                        <br>
                        <textarea name="biography" id="biography" rows="4" cols="50"></textarea>
                        <br>

                        <input type="submit" name="submitdata" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    function sanitizeData($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST["submitdata"])) {

        $nm = sanitizeData($_REQUEST['coolname']);
        $eml = sanitizeData($_REQUEST['email']);
        $fbURL = sanitizeData($_REQUEST['fblink']);
        $pswd = sanitizeData($_REQUEST['password']);
        $confirmpswd = sanitizeData($_REQUEST['confirm_password']);
        $phnum = sanitizeData($_REQUEST['phonenum']);
        $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
        $ctry = sanitizeData($_REQUEST['country']);
        $skills = isset($_REQUEST['skills']) ? $_REQUEST['skills'] : [];
        $bio = sanitizeData($_REQUEST['biography']);

        $chkerror = [];

        if (empty($nm)) {
            $chkerror[] = "A name is required.";
        }

        if (empty($eml) || !filter_var($eml, FILTER_VALIDATE_EMAIL)) {
            $chkerror[] = "You need to input a valid email.";
        }

        if (empty($pswd) || strlen($pswd) < 8) {
            $chkerror[] = "Password should be at least 8 characters long.";
        }

        if ($pswd !== $confirmpswd) {
            $chkerror[] = "Passwords do not match.";
        }

        if (empty($phnum)) {
            $chkerror[] = "Please write a phone number.";
        }
        if (!preg_match("/^\+?[0-9]{10,15}$/", $phnum)) {
            $chkerror[] = "Please write a valid phone number (10-15 digits).";
        }

        if (!empty($fbURL) && !filter_var($fbURL, FILTER_VALIDATE_URL)) {
            $chkerror[] = "Please enter a valid Facebook URL.";
        }

        if (empty($gender)) {
            $chkerror[] = "Please select a gender.";
        }

        if ($ctry === "Select your country") {
            $chkerror[] = "Please select a country.";
        }

        if (empty($skills)) {
            $chkerror[] = "Please select at least one skill.";
        }

        if (empty($bio)) {
            $chkerror[] = "Biography is required.";
        } else if (strlen($bio) > 200) {
            $chkerror[] = "You exceeded the maximum Biography text limit of 200 characters.";
        }

        if (!empty($chkerror)) {
            foreach ($chkerror as $error) {
                echo "<p style='color: red;'>$error</p>";
            }
        } else {
            $_SESSION['coolname'] = $nm;
            $_SESSION['email'] = $eml;
            $_SESSION['password'] = $pswd;
            $_SESSION['fblink'] = $fbURL;
            $_SESSION['phonenum'] = $phnum;
            $_SESSION['gender'] = $gender;
            $_SESSION['country'] = $ctry;
            $_SESSION['skills'] = implode(", ", $skills);
            $_SESSION['biography'] = $bio;

            header("Location: about.php");
            exit();
        }
    }
    ?>
</body>

</html>
