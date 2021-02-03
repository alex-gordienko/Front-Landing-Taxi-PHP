<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>iTaxi- Order</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">                                                                  
    <link rel="stylesheet" href="css/templatemo-style.css">
    <style>
       body{
        background-image: url(img/taxi-03.jpg); 
        background-repeat: no-repeat;
        background-position: center; 
        background-size: cover;
        background-attachment: fixed;
        }
    </style>
</head>
    <body> 
        <?php
            include 'config.php';
            $config= new config();
            $zapros=$config->connect();
        ?>          
        <div class="container">
            <div class="row">
                <div class="tm-left-right-container">
                    <!-- Left column: logo and menu -->
                    <div class="tm-blue-bg tm-left-column">                        
                        <div class="tm-logo-div text-xs-center">
                            <img src="img/cta-ligo2-786x257.png" height="50" alt="Logo">
                            <h1 class="tm-site-name">iTaxi</h1>
                        </div>
                        <nav class="tm-main-nav">
                            <ul class="tm-main-nav-ul">
                                <li class="tm-nav-item">
                                    <a href="index.php" class="tm-nav-item-link">Main</a>
                                </li>
                                <li class="tm-nav-item">
                                    <a href="#contact" class="tm-nav-item-link">Call iTaxi</a>
                                </li>
                            </ul>
                        </nav>                                         
                    </div> <!-- Left column: logo and menu -->
                    
                    <!-- Right column: content -->
                    <div class="tm-right-column">
                        <figure>
                            <img src="img/taxi-01.jpg" height="95%" width="95%" alt="Header image" class="img-fluid">    
                        </figure>

                        <div class="tm-content-div">
                            <!-- Contact Us section -->
                            <section id="contact" class="tm-section">
                                <header><h2 class="tm-blue-text tm-section-title tm-margin-b-30">Create Order</h2></header>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <form method="POST" class="contact-form" action="getCheck.php" enctype="">
                                            <div class="form-group">
                                                <input type="text"  name="firstName" class="form-control" placeholder="First Name"  required/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text"  name="secondName" class="form-control" placeholder="Second Name"  required/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text"  name="thirdName" class="form-control" placeholder="Third Name"  required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="tm-body-text">Choose type</label>
                                                <select name="Type">
                                                <?php
                                                    $getTypes=$zapros->query("SELECT * FROM `class` WHERE `ID_Class`!=0");
                                                        while ($result = mysqli_fetch_array($getTypes)) { //среди уже существующих в базе
                                                        echo "<option>".$result['Name']."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="tm-body-text">(Optional) Select date & time to order</label>
                                                <input type="date"  name="date"/>
                                                <input type="time" name="time">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="arrivePoint" class="form-control" placeholder="Arrive Point"  required/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="destPoint" class="form-control" placeholder="Destionation Point"  required/>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="Comment" class="form-control" placeholder="Addiction conditions ('Baby on board, etc.')">
                                            </div>
                                            <div class="form-group">
                                                <label class="tm-body-text">Input your contact number</label>
                                                <input type="text" name="phone" placeholder="+38 (063) 938-37-77" required/>
                                            </div>
                                            <div class="form-group">
                                                <input type="email"  name="contact_email" class="form-control" placeholder="Email(Optional)">
                                            </div> 
                                            <input type="submit" name="add" class="float-right tm-button" value="Send">
                                            <input type="submit" name="getCost" class="float-right tm-button" value="Get Orient Price">
                                    </div>
                                </div>
                                
                            </section>
                            <hr>
                                <footer>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                                        <tr align="left" height="70">  
                                            <td id="Contacts">
                                                <h6>Contacts:</h6>
                                                <h6>alexoid1999@gmail.com</h6>
                                                <h6>vk.com/alexoid1999</h6>
                                                <h6>instagram.com/alexoid.exe</h6>
                                            </td>
                                            <td>
                                                <h6 align="center"> All materials protected by copyright.</h6>
                                                <h6 align="center">Using only with indication of the author</h6>
                                            </td>
                                            <td>
                                                <h6 align="right">&copy; by AleXoiD 2018</h6>
                                            </td>
                                        </tr>
                                        </table>
                              </footer>
                        </div>  
                        
                    </div> <!-- Right column: content -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
        
</body>
</html>