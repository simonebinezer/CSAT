<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://www.haircompounds.com/"><link rel="shortcut icon" href="//www.haircompounds.com/cdn/shop/files/HC_Logo_Small_Cropped_22ae09f4-034f-4fdc-b7de-57fe506b7c8f_32x32.jpg?v=1615319651" type="image/png">   
    <link rel="stylesheet" href="<?= base_url('css/front/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/front/nps.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/front/Mediaquery.css') ?>">

    <title>NPS Login page</title>
</head>
<body>
  <section class="login-main-page">
<div class="container-fluid">
        <nav class="navbar">
            <div class="">
              <?php $logoimg = (session()->get("logo_user")) ?  session()->get("logo_user") : "/images/logo-new.png"; ?>
              <a class="navbar-brand" href="#">
                <img src="<?php echo base_url().$logoimg; ?>" class="logo img-fluid" alt="logo">
              </a>
            </div>
          </nav>
   <?= $this->renderSection("body") ?>
   </div> 
          <div class="row">
        <!-- <img src="<?php echo base_url(); ?>images/Vectors.png" class="Footer-img img-fluid" alt="login-image"> -->
    </div>
  </section>
</body>

<?php echo script_tag('vendor/jquery/jquery.min.js'); ?>
<?php echo script_tag('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>
<?php echo script_tag('vendor/jquery-easing/jquery.easing.min.js'); ?>


</html>