<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yurekha | Home</title>
    <link rel="icon" href="img/favicon.png">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/advertiesments.css" rel="stylesheet">
</head>
<body bgcolor="#e3e6ea">
<div class="content">
        <!--header section-->
        <header>
            <center><img src="img/Yureka%20logo.png" id="mainLogo"></center>
            <!--navigation bar start-->
            <ul class="nav" style="z-index: 10000;">
                <li class="active"><a href="index.php"><img src="img/nav/nav_yureka_logo.png"></a></li>
                <li><a href="php/courses.php">Courses</a></li>
                <li ><a href="php/about.html">About Us</a>
                </li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="php/signup.php"><img src="img/nav/nav_signup.png" style="vertical-align: bottom">&nbsp;Sign
                        Up</a></li>
                <li><a href="php/login.php"><img src="img/nav/nav_login.png" style="vertical-align: bottom">&nbsp;Log In</a>
                </li>
            </ul>
            <!--navigation bar end-->
        </header>

        <!--body content section-->
        <section class="bodyInner">

            <!Add section-->
            <table width="100%" id="advTable">
            <?php
            require "php/connection/dbConnection.php";
            $qry="DELETE FROM advertisements WHERE uploadedDate < NOW() - INTERVAL 30 DAY";
            runQuery($qry);
                $query_show_adds="SELECT * FROM  advertisements";
                $result = runQuery($query_show_adds);
                $allAdds = "";
                $i=0;
                while($row=mysqli_fetch_assoc($result)){
                    $loadedAdd = "";
                    if($i%2==0){
                        $loadedAdd .= '<tr>
                    <!Add image L-->
                    <td>
                        <div class="advContainer">
                            <img src="';

                        $loadedAdd.=$row["imagePath"];
                        $loadedAdd.='" alt="Add" class="image">
                            <div class="overlay">
                                <div class="text">';
                        $loadedAdd.= $row['hoverDescription'];
                        $loadedAdd.='</div>
                            </div>
                        </div>
                    </td>

                    <!Add description R-->
                    <td><p class="advText_r">';
                         $loadedAdd.= $row['description'];

                       $loadedAdd.= '</p></td>
                </tr>';
                    }else{
                        $loadedAdd .= '<tr>
                    <!Add description L-->
                    <td><p class="advText_l">';
                        $loadedAdd.= $row['description'];
                        $loadedAdd.='</p></td>

                    <!Add image R-->
                    <td>
                        <div class="advContainer">
                            <img src="';
                        $loadedAdd.=$row["imagePath"];
                        $loadedAdd.='" alt="Add" class="image">
                            <div class="overlay">
                                <div class="text">';
                        $loadedAdd.= $row['hoverDescription'];
                        $loadedAdd.='</div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>';
                    }
                    $allAdds = $loadedAdd.$allAdds;
                    $i++;
                }
                echo $allAdds;
                ?>
            </table>
        </section>

        <!--footer section-->
        <footer>
            <hr class="hr1">
            <hr class="hr2">
            <p align="center" style="font-size: small;" title="Yureka Higher Education Institute"><a href="../index.php" >Yureka Higher Education Institute</a> All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>