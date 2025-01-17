<?php
include("../Assets/Connection/Connection.php");
if (isset($_POST["btn_submit"])) {
    $name = $_POST["txt_name"];
    $email = $_POST["txt_email"];
    $pwd = $_POST["txt_pwd"];
    $district = $_POST["sel_district"];
    $place = $_POST["sel_place"];
    $photo = $_FILES["File_photo"]["name"];
    $temp = $_FILES["File_photo"]["tmp_name"];
    move_uploaded_file($temp, "../Assets/Files/Users/" . $photo);


    $errors = [];  

    if (!preg_match('/^[A-Z][a-zA-Z ]*$/', $name)) {
        $errors[] = "Name must start with an uppercase letter and contain only alphabets and spaces.";
    }

    
    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Password validation 
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pwd)) {
        $errors[] = "Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, one number, and one special character.";
    }
    if (empty($errors)) {

     $insQry = "insert into tbl_user(user_name, user_email, user_password, user_photo, user_district, user_place,user_curdate) values('" . $name . "','" . $email . "','" . $pwd . "','" . $photo . "','" . $district . "','" . $place . "',CURDATE())";
   
     if ($con->query($insQry)) {
        echo "<div class='alert alert-success text-center'>Inserted successfully!</div>";
     }
    } 
     else {
     // Display validation errors
      foreach ($errors as $error) {
        echo "<script>alert('$error');</script>";
     }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../Assets/JQ/jQuery.js"></script>

    <!-- Custom Style for Background Gradient -->
    <style>
        /* Yellow Gradient Background */
        body {
            background: linear-gradient(135deg, #fceabb, #f8b500);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        /* Center and style the form container */
        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            margin-top: 20px;
        }

        h2 {
            color: #f8b500;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #f8b500;
            border-color: #f8b500;
        }

        .btn-primary:hover {
            background-color: #e0a700;
            border-color: #e0a700;
        }
    </style>
</head>

<body> 
  

<div class="container mt-5">
<div >
        <a href="../index.php">Home</a>
            </div>
    <h2 class="text-center mb-4">User Registration</h2>
    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="txt_name">Name</label>
            <input required type="text" class="form-control" name="txt_name" id="txt_name" placeholder="Enter Name" title="Name allows only alphabets, spaces, and first letter must be capital" pattern="^[A-Z]+[a-zA-Z ]*$"/>
        </div>

        <div class="form-group">
            <label for="txt_email">Email</label>
            <input required type="text" class="form-control" name="txt_email" id="txt_email" placeholder="Enter Email"/>
        </div>

        <div class="form-group">
            <label for="txt_pwd">Password</label>
            <input required type="password" class="form-control" name="txt_pwd" id="txt_pwd" placeholder="Enter Password"/>
        </div>

        <div class="form-group">
            <label for="sel_district">District</label>
            <select name="sel_district" class="form-control" onchange="getPlace(this.value)" id="sel_district">
                <option>--select--</option>
                <?php
                $selQry1 = "select * from tbl_district";
                $resultOne = $con->query($selQry1);
                while ($data = $resultOne->fetch_assoc()) {
                    echo "<option value='{$data["district_id"]}'>{$data["district_name"]}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="sel_place">Place</label>
            <select name="sel_place" class="form-control" id="sel_place">
                <option>--select--</option>
                <?php
                $selQry2 = "select * from tbl_place";
                $resultTwo = $con->query($selQry2);
                while ($data = $resultTwo->fetch_assoc()) {
                    echo "<option value='{$data["place_id"]}'>{$data["place_name"]}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="File_photo">Photo</label>
            <input type="file" class="form-control-file" name="File_photo" id="File_photo" required/>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary" name="btn_submit" id="btn_submit">Submit</button>
            <button type="reset" class="btn btn-secondary" name="btn_cancel" id="btn_cancel">Cancel</button>
        </div>
        <div class="text-center p-3">
        <a href="Login.php">Login</a>
            </div>
    </form>
</div>

<script>
    function getPlace(did) {
        $.ajax({
            url: "../Assets/AjaxPages/AjaxPlace.php?did=" + did,
            success: function (result) {
                $("#sel_place").html(result);
            }
        });
    }
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
