<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <?php echo script_tag('js/jquery.min.js'); ?>
    </head>
<?php echo script_tag('js/jquery.min.js'); ?>
<style>
.rating-2 {
        /* height: 417px; */
        background: #092C4C;
    }

    .rating-2 .content-head {
        padding: 10% 0px;
        text-align: center;
    }

    .rating-2 .content-head h3 {
        color: #FFF;
        text-align: center;
        font-family: 'Lora', serif;
        font-size: 45px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }
    .social-icon-survey {
        display: flex;
        background: #092C4C;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .social-icon-survey p {
        color: #FFF;
        text-align: center;
        font-family: 'Lora', serif;
        font-size: 24px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin: 0px;
    }

    .social-icon-survey div a {
        margin: 0px 10px;
    }
</style>
<body>
    <section class="rating-2">
    <!-- <div class="row m-3">
        <div class=" offset-3 col-md-6 col-sm-12 col-xs-12">
            <img src="<?php echo base_url(); ?>images/surveyFeed.jpg"  class="img-centered img-fluid" style="height:200px;" alt="login-image">
        </div>
    </div> -->
    <?php if (session()->getFlashdata('response') !== NULL) : ?>
            <p style="color:#fff; font-size:18px;"  align="center"><?php echo session()->getFlashdata('response'); ?></p>
        <?php endif; ?>  
    <!-- <div class="row m-3">  -->
            
        <!-- <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card col-md-12 bg-white shadow-md p-5">
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Thank You !</h1>
                    <p>you already completed the survey section.</p>
                    <button id="submitoption" class="btn btn-outline-success">Back Home</button>
                </div> 

            </div>
        </div> -->
        <div class="content-head">
            <img style="margin-bottom:25px" src="<?php echo base_url(); ?>images/thankYou_image.png" class="img-fluid">
            <h3>Thank you so much for your feedback,<br/> We look forward to better serving you.</h3>
        </div>
        <!-- <div class="social-icon-survey">
            <div>
                <p>Follow us on:</p>
            </div>
            <div><a href="#"><img src="<?php echo base_url(); ?>images/Instagram.png" /></a></div>
            <div><a href="#"><img src="<?php echo base_url(); ?>images/YouTube.png" /></a></div>
            <div><a href="#"><img src="<?php echo base_url(); ?>images/Facebook.png" /></a></div>
        </div> -->

    <!-- </div> -->
    </section>
</body>
        


     
<script type="text/javascript">
    // $(document).ready(function(){  
    //     $("#submitoption").click(function () {
    //        window.location.href = "<?php echo base_url(); ?>/login";
    //     });      
    // });
</script>
</html>