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
    
        <div class="content-head">
            <img style="margin-bottom:25px" src="<?php echo base_url(); ?>images/thankYou_image.png" class="img-fluid">
            <h3>This survey is not available now.<br/> Please check with admin.</h3>
        </div>
        
    </section>
</body>
   
</html>