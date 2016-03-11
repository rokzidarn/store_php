 <!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BE store management</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/main_css.css"/>
    </head>
    <body>
        <header>
            <h1><a style="text-decoration: none" href="../index.php">BE store</a></h1>
        </header>
        <div id="container">  
            <div class="row">
                 <div id="li_box">   
        <fieldset>
            <legend>CLERK LOG IN:</legend>
            <form action="clerk_login.php" method="post">
                E-mail: <input type="text" name="email" required ><br>
                Password: <input type="password" name="password" required ><br><br>
                <input class="button" type="submit" value="LOG IN">
            </form>    
        </fieldset>
        <br>
        </div>
       <div id="ri_box">   
        <fieldset>
            <legend>ADMIN LOG IN:</legend>
            <form action="admin_login.php" method="post">
                E-mail: <input type="text" name="email" required ><br>
                Password: <input type="password" name="password" required ><br><br>
                <input class="button" type="submit" value="LOG IN">
            </form>    
        </fieldset>
        <br><br><br><br><br><br><br>
        </div>
            </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>

