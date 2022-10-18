<?php
    session_start(); 
    if (!empty($_SESSION["username"])) {
        
        # validating time inactive
        $last_action  = $_SESSION["last_action"];
        $current_time = date("Y-n-j H:i:s");
        $inactive     = (strtotime($current_time)-strtotime($last_action));
       
        //if session inactive time is 30 minutes close session
        if ($inactive>=1800) {
            header("location:./logout");
        }
        
    }else { header('location:./');  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('templates/lib.php'); ?>
    <title>Gestionar Clientes</title>
</head>
<body>
    <?php include('templates/navbar.php'); ?>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Gestionar Clientes</h2>
                </div>
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <table class="table">
                    <thead style="background-color: #4187A9 !important; color:white;">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td> 
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td> 
                        <td>@fat</td>
                        </tr> 
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include('templates/footer.php'); ?>
    <script src="view/lib/bootstrap.min.js" ></script>
</body>
</html>