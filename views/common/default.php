<!DOCTYPE html>
<html id="principal-page">
<head>
     <?php
        include_once '../views/common/headerMenu.php';
     ?>
</head>
<body>
    <?php
        include 'calendar.php';
        $calendar = new Calendar(date("Y-m-d"));
    ?>
    <div class="row pt-4">
        <div class="col-md-3"></div>
        <div class="content home col-md-8 col-sm-12">
            <?=$calendar?>
        </div>
    </div>
</body>
</html>
