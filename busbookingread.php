<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM ticketbooking WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["leaving_from"];
                $name = $row["going_to"];
                $name = $row["no_of_seats"];
                $name = $row["full_name"];
                $name = $row["date"];
                $name = $row["mobile_no"];
                $address = $row["email"];
                $contact = $row["remarks"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Leaving from</label>
                        <p class="form-control-static"><?php echo $row["leaving_from"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Going to</label>
                        <p class="form-control-static"><?php echo $row["going_to"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Numbers of seats</label>
                        <p class="form-control-static"><?php echo $row["no_of_seats"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <p class="form-control-static"><?php echo $row["full_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static"><?php echo $row["date"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <p class="form-control-static"><?php echo $row["mobile_no"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <p class="form-control-static"><?php echo $row["remarks"]; ?></p>
                    </div>
                    <p><a href="busbookingindex.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>