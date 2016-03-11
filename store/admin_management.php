<?php
require_once '../DB/Clerk.php';
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
session_start();
$user = $_SESSION["admin"];

$validationRules = ['do' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ["regexp" => "/^(change)$/"]
    ],
    'cemail' => [
        'filter' => FILTER_VALIDATE_EMAIL
    ],
];

$data = filter_input_array(INPUT_POST, $validationRules);
$e = $data["cemail"]!=FALSE;
        
if($isPost && $url && $data["do"]=="change" && $e){
    try {
        $clerk = Clerk::getClerkInfo($data["cemail"]);
        $cstatus = $clerk["cstatus"];
        $new = 'A';
        if($cstatus=='A'){
            $new = 'D';
            Clerk::clerkStatusUpdate($data["cemail"],$new);
        }
        else{
            Clerk::clerkStatusUpdate($data["cemail"],$new);
        }
                          

    } catch (Exception $exc) {
        die($exc->getMessage());
    }
}

?>

<html>
   <head>
       <meta charset="UTF-8">
       <title>Admin check</title>
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
                 <h3>&nbsp;&nbsp;&nbsp;Admin management</h3>
       <p>&nbsp;&nbsp;&nbsp;Admin: <?=$user?></p>
        <form id ="b1" action="admin_update.php" method="GET">
           <input class="button" type="submit" value="Update"/>
       </form>
       <form id="b2" action="admin_logout.php" method="POST">
           <input class="button" type="submit" value="Log out"/>
       </form>      
                 </div>
                 <div id="ri_box">
       <fieldset>
           <legend>New clerk:</legend>
        <form action="clerk_create.php" method="POST">
            Clerk email: <input type="text" required name="cemail" /><br>
            Clerk name: <input type="text" required name="cname" /><br>
            Clerk password: <input type="password" required name="cpass" /><br>
            Clerk certificate: <input type="text" required name="cert" /><br><br>
            <input class="button" type="submit" value="Create new clerk"/>
        </form>
       </fieldset>
                     </div>
       <h3>Current clerks:</h3>       
       <table>
            <tr>
                <td><b>ID</b></td>
                <td><b>Name</b></td>
                <td><b>Email</b></td>
                <td><b>Status</b></td>               
            </tr>
            <?php 
            try {
                $allClerks = Clerk::getAllClerks();
                foreach ($allClerks as $key => $value): 
                    $id = $value["idclerk"];
                    $name = $value["cname"];
                    $email = $value["cemail"];
                    $status = $value["cstatus"];
            ?>
                <tr>
                    <td><?= $id ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $name ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $email ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $status ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>                  
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="do" value="change" />
                            <input type="hidden" name="cemail" value="<?=$email?>" /> 
                            <input class="button" type="submit" value="Change status" />
                        </form>
                    </td>                   
                </tr>
            <?php 
            endforeach;
            } catch (Exception $e) {
                echo "ERROR: {$e->getMessage()}";
            }          
            ?>
        </table> 
            <br> </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
   </body>
</html>

