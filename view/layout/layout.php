<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Shopping Cart by Konstantin Zavizion</title>
    <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>

    <link rel="stylesheet" href="/assets/styles/bootstrap.css">
    <link rel="stylesheet" href="/assets/styles/font-awesome.css">
    <link rel="stylesheet" href="/assets/styles/dt-sidebar.css">
    <link rel="stylesheet" href="/assets/styles/custom.css">

</head>

<body>
  <div id="wrapper" class="">
    <?php include('_sidebar.php'); ?>
    <div id="page-content-wrapper">
      <?php include('_navbar.php'); ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <?=$MASTER_CONTENT?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="/assets/scripts/jquery-3.2.1.js"></script>
  <script src="/assets/scripts/bootstrap.min.js"></script>
  <script src="/assets/scripts/custom.js"></script>

  
</body>

</html>