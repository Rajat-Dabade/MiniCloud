

<?php

   require_once("../include/connect.php");
        session_start();
        if(!isset($_SESSION['username'])){
            session_destroy();
        }

        ini_set('display_error', 'Off');
    
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>{{ Websitename }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta charset="UTF-8">

        <!-- load bootstrap and fontawesome via CDN -->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <style>
            html, body, input, select, textarea
            {
                font-size: 1.05em !important;
            }
            b:hover {
                color: #F59D1E;   
            }
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 80%;
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }

            /* Add Animation */
            @-webkit-keyframes animatetop {
                from {top:-300px; opacity:0} 
                to {top:0; opacity:1}
            }

            @keyframes animatetop {
                from {top:-300px; opacity:0}
                to {top:0; opacity:1}
            }

            /* The Close Button */
            .close {
                color: white;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

            .modal-header {
                padding: 2px 16px;
                background-color: #000000;
                color: white;
            }

            .modal-body {padding: 2px 16px;}

            .modal-footer {
                padding: 2px 16px;
                background-color: #000000;
                color: white;
            }
            form{
              display: inline;
            }
        </style>

  

  
    </head>
    <body>

        <header>
			<nav class="navbar navbar-inverse"  data-spy="affix" data-offset-top="197">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="../index.php" style="color: #F59D1E">WebSiteName</a>
                </div>
                <ul class="nav navbar-nav">
                  <li><a href="../index.php">Home</a></li>
                </ul>
               <ul class="nav navbar-nav navbar-right">
                <?php if(!isset($_SESSION['username'])) { 
                        echo "<script type='text/javascript'>
                            window.location.href='../index.php'</script>";
                       }else{
                        echo  '<li><a href="services.php">Services</a></li>';
                        echo  '<li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span>'.$_SESSION['username'].'</a></li>';
                        echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> logout</a></li>';
                } ?>
                  
                </ul>
              </div>
            </nav>
		</header>

        <div class="container">
            <h1 style="text-align: center;letter-spacing: 2px;font-size: 50px;color: #F59D1E"><b>WELCOME TO PLATFORM AS A SERVICE (PaaS)</b></h1>

            

            <div style="margin-top: 50px"><button id="myBtn" class="btn btn-primary btn-lg"><spam class="glyphicon glyphicon-refresh"></spam>Create Platform</button></div>

            <!-- Creating Model -->

              <div id="myModal" class="modal">
                  <div class="modal-content">
                    <div class="modal-header">
                      <span class="close">&times;</span>
                      <h2>Your Platform Details</h2>
                    </div>
                    <div class="modal-body">
                      <form action="createPlatform.php" method="post">
                      <label>Name Of Project</label>
                      <input type="text" name="project_name" required>
                      <input type="submit" name="submit" value="Create Instance">
                      </form>
                    </div>
                    <div class="modal-footer">
                      <h3></h3>
                    </div>
                  </div>

                </div>

            <!-- Ending Model -->


            <!-- script For model -->

              <script>
                  
                  var modal = document.getElementById('myModal');

                 
                  var btn = document.getElementById("myBtn");

                  
                  var span = document.getElementsByClassName("close")[0];

                  btn.onclick = function() {
                      modal.style.display = "block";
                  }

                  span.onclick = function() {
                      modal.style.display = "none";
                  }

                  window.onclick = function(event) {
                      if (event.target == modal) {
                          modal.style.display = "none";
                      }
                  }
                  </script>

            <!-- script end For model -->


            <div style="margin-top: 30px">
              <h2 style="text-align: center;font-size: 40px">YOUR PROJECTS</h2>

                
    <?php

        $username = $_SESSION['username'];

        
       

        $sql = "SELECT Containers.ContName, Paltforms.Info, Containers.IP, Containers.port FROM ((Containers INNER JOIN Paltforms ON Containers.PltID = Paltforms.PltID) INNER JOIN PAASUsers ON Containers.ContID = PAASUsers.ContID) where PAASUsers.Username='".$username."' ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

          echo '
                <table class="table" style="margin-top: 30px">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Project Name</th>
                      <th scope="col">Platform</th>
                      <th scope="col">IP</th>
                      <th scope="col">Port Number</th>
                      <th scope="col">Choose File</th>
                      <th scope="col">operation</th>
                    </tr>
                  </thead>
                  <tbody>';

        while($row = mysqli_fetch_assoc($result)) {
            
             

            echo "<tr>
                      <td scope=".'row'.">".str_replace($_SESSION['username']."_", "", $row["ContName"])."</td>
                      <td>".$row["Info"]."</td>
                      <td>".$row["IP"]."</td>
                      <td>".$row["port"]."</td>

                      <td><form action='/cgi-bin/uploadCode.py' method='post' enctype='multipart/form-data'>
                        <input type='hidden' value=".$row["ContName"]." name='contName'>
                        <input type='file' name='file' required>
                        <button type='submit' class='glyphicon glyphicon-upload'>
                      </form></td>


                      <td>
                      <form action='/cgi-bin/deleteCont.py' action='get'>
                        <input type='hidden' value=".$row["ContName"]." name ='operation'>
                        <button type='submit'  class='btn btn-danger' role='button' aria-disabled='true'><span class='glyphicon glyphicon-trash'></span>DELETE</button>
                      </form>
                       </td>
                  </tr>";

        }

          echo ' </tbody>
                </table>';

        } else {
            echo '<h3 style="text-align: center;color: black">No Project found</h3>
                 
            </div>';
        }

    ?>


            
		</div>

    </body>
</html>
