<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$leaving_from = $going_to = $no_of_seats =$full_name = $date = $mobile_no = $email = $remarks = "";
$leaving_from_err = $going_to_err = $no_of_seats_err = $full_name_err = $date_err = $mobile_no_err = $email_err = $remarks_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate leaving from
    $leaving_from = $_POST['leaving_from'];

    // Validate going to
    $going_to = $_POST['going_to'];


    // Validate name
    $input_full_name = trim($_POST["full_name"]);
    if(empty($input_full_name)){
        $full_name_err = "Please enter a full name.";
    } elseif(!filter_var($input_full_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $full_name_err = "Please enter a valid name.";
    } else{
        $full_name = $input_full_name;
    }

    // Validate no_of_seats
    $input_no_of_seats = trim($_POST["no_of_seats"]);
    if(empty($input_no_of_seats)){
        $no_of_staffs_err = "Please enter the no of seats.";     
    } elseif(!ctype_digit($input_no_of_seats)){
        $no_of_seats_err = "Please enter a valid number.";
    } else{
        $no_of_seats= $input_no_of_seats;
    }

    

    // Validate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter date.";     
    } elseif(!date($input_date)){
        $date_err = "Please enter a positive integer value.";
    } else{
        $date= $input_date;
    }

    // Validate mobile_number
    $input_mobile_no = trim($_POST["mobile_no"]);
    if(empty($input_mobile_no)){
        $mobile_no_err = "Please enter the contact number.";     
    } elseif(!ctype_digit($input_mobile_no)){
        $mobile_no_err = "Please enter a valid number.";
    } else{
        $mobile_no= $input_mobile_no;
    }

     // Validate email
     $input_email = trim($_POST["email"]);
     if(empty($input_email)){
         $email_err = "Please enter your email.";     
     } else{
         $email = $input_email;
     }

    // Validate remarks
    $input_remarks = trim($_POST["remarks"]);
    if(empty($input_remarks)){
        $remarks_err = "Please enter.";
    } elseif(!filter_var($input_remarks, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $remarks_err = "Please enter.";
    } else{
        $remarks = $input_remarks;
    }
    
    // Check input errors before inserting in database
    if(empty($leaving_from_err) && empty($going_to_err) && empty($full_name_err)&& empty($no_of_seats_err) && empty($date_err) && empty($mobile_no_err) && empty($email_err) && empty($remarks_err)){
        // Prepare an update statement
        $sql = "UPDATE ticketbooking SET leaving_from=?, going_to=?, full_name=?, no_of_seats=?, date=?, mobile_no=?, email=?, remarks=? WHERE id=?";


        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            // $stmt->bind_param("sssssssi", $param_name, $param_dropdown, $param_no_of_staffs, $param_establish_date, $param_description, $param_address, $param_contact, $param_id);
            $stmt->bind_param("ssssssssi", $param_leaving_from, $param_going_to, $param_full_name, $param_no_of_seats, $param_date, $param_mobile_no, $param_email, $param_remarks, $param_id);
           
            // Set parameters
            $param_leaving_from = $leaving_from;
            $param_going_to = $going_to;
            $param_full_name = $full_name;
            $param_no_of_seats = $no_of_seats;
            $param_date = $_date;
            $param_mobile_no = $mobile_no;
            $param_email = $email;
            $param_remarks = $remarks;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: busbookingindex.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM ticketbooking WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $leaving_from = $row["leaving_from"];
                    $going_to = $row["going_to"];
                    $full_name = $row["full_name"];
                    $no_of_seats = $row["no_of_seats"];
                    $date = $row["date"];
                    $mobile_no = $row["mobile_no"];
                    $email = $row["email"];
                    $remarks = $row["remarks"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $mysqli->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                       <!--Leaving from start  -->
                       <div class="form-group <?php echo (!empty($leaving_from_err)) ? 'has-error' : ''; ?>">
                            <label>Leaving from</label>
                            <select name="leaving_from">
                            <option value="">--select--</option>
                                <option value="Kathmandu" <?php if($leaving_from == "Kathmandu") echo"selected";?>>Kathmandu</option>
                                <option value="Pokhara" <?php if($leaving_from == "Pokhara") echo"selected";?>>Pokhara</option>
                                <option value="Butwal"<?php if($leaving_from == "Butwal") echo"selected";?>>Butwal</option>
                                <option value="Birgunj" <?php if($leaving_from == "Birgunj") echo"selected";?>>Birgunj</option>
                                <option value="Biratnagar" <?php if($leaving_from == "Biratnagar") echo"selected";?>>Biratnagr</option> 
                            </select>
                        </div>
                        <!-- Leaving from end -->

                        <!-- Going to start -->
                        <div class="form-group <?php echo (!empty($going_to_err)) ? 'has-error' : ''; ?>">
                            <label>Going to</label>
                            <select name="going_to">
                            <option value="">--select--</option>
                                <option value="Kathmandu" <?php if($going_to == "Kathmandu") echo"selected";?>>Kathmandu</option>
                                <option value="Pokhara" <?php if($going_to == "Pokhara") echo"selected";?>>Pokhara</option>
                                <option value="Butwal"<?php if($going_to == "Butwal") echo"selected";?>>Butwal</option>
                                <option value="Birgunj" <?php if($going_to == "Birgunj") echo"selected";?>>Birgunj</option>
                                <option value="Biratnagar" <?php if($going_to == "Biratnagar") echo"selected";?>>Biratnagr</option>
                            </select>
                        </div>
                        <!-- Going to end -->

                        <!-- full name start -->
                        <div class="form-group <?php echo (!empty($full_name_err)) ? 'has-error' : ''; ?>">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>">
                            <span class="help-block"><?php echo $full_name_err;?></span>
                        </div>
                        <!-- full name end -->

                        <!-- no of seatss start -->
                        <div class="form-group <?php echo (!empty($no_of_seats_err)) ? 'has-error' : ''; ?>">
                            <label>No. of seats</label>
                            <input type="text" name="no_of_seats" class="form-control" value="<?php echo $no_of_seats; ?>">
                            <span class="help-block"><?php echo $no_of_seats_err;?></span>
                        </div>
                        <!-- no of seats end -->

                        <!--  date start -->
                        <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                            <label>Date</label>
                            <input type="Date" name="date" class="form-control" value="<?php echo $date; ?>">
                            <span class="help-block"><?php echo $date_err;?></span>
                        </div>
                        <!--  date end -->

                        <!-- contact start -->
                        <div class="form-group <?php echo (!empty($mobile_no_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile_no" class="form-control" value="<?php echo $mobile_no; ?>">
                            <span class="help-block"><?php echo $mobile_no_err;?></span>
                        </div>
                        <!-- contact end -->

                        <!-- email start -->
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <!-- email end -->

                        <!-- remarks start -->
                        <div class="form-group <?php echo (!empty($remarks_err)) ? 'has-error' : ''; ?>">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control"><?php echo $remarks; ?></textarea>
                            <span class="help-block"><?php echo $remarks_err;?></span>
                        </div>
                        <!-- remarks end -->            


                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="busbookingindex.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>