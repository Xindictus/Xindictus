<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 20/4/2016
 * Time: 11:37
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHPInfo</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
</head>
<body>

<div class="container">
    <div class="row col-md-12 col-sm-12">
        <div class="row text-center">
            <a href="index.php" data-spy="affix">
                <button class="btn btn-info">Return</button>
            </a>
        </div>
        <?php

        phpinfo();

        ?>
    </div>
</div>

</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</html>

