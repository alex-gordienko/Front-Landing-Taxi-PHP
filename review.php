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
                                <header><h2 class="tm-blue-text tm-section-title tm-margin-b-30">Make Review</h2></header>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <form action="getReview.php" method="post" class="contact-form">
                                            <div class="form-group">
                                                <label class="tm-body-text">Input your check number</label>
                                                <p class="tm-body-text"> The system find a driver and other details</p>
                                                <input type="text" id="check_num" name="check_num" class="form-control" placeholder="Check Number" required/>
                                            </div>
                                            <p></p>
                                            <div class="form-group">
                                                <textarea id="contact_message" name="contact_message" class="form-control" rows="9" placeholder="Message" required=""></textarea>
                                            </div>
                                            <p></p>                                            
                                            <input type="submit" name="getCheck" class="float-right tm-button" value="Send"></button>
                                        </form>    
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



