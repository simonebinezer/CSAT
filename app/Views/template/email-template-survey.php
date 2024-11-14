<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS Email</title>
</head>

<body>
    <?php
    $url = base_url() . "getSurveyAnwser/" . $contactdata["id"] . "/" . $postdata['survey'] . "/" . $userId . "/" . $tenantdata['tenant_id'];// . "/" . $surveyrandom;
    $userName = $contactdata["firstname"] . " " . $contactdata["lastname"];
    $tenantName = $tenantdata["tenant_name"];
    $data = $postdata['editor'];

    ?>
    <section>
    
        <!-- <h2 style="color: #000;
            text-align: center; font-family: 'Trebuchet MS', sans-serif;
            font-size: 24px;
            font-style: normal;
            font-weight: 500;margin: 20px auto 0px;">Hi <?php echo $userName; ?></h2> -->
        <a href="<?php echo $url; ?>" style="text-decoration:none;max-width: 794px;">
            <div style="max-width: 794px;
                            margin: 20px auto 90px;
                            background-color: #fff;
                            padding: 60px 50px;
                            border: 1px solid #000;
                            border-radius: 20px;">


                <div style="    text-align: center;
                                display: flex;
                                margin: 0px 41%;
                                justify-content: center;">
                    <img src="<?php echo base_url(); ?>images/HAIR__COMPOUND_LOGO.png" style="    width: 100%;
                    max-width: 125px;">
                    <!-- <h2 style="color: #000;
                        text-align: center; font-family: 'Trebuchet MS', sans-serif;
                        font-size: 24px;
                        font-style: normal;
                        font-weight: 500;"><?php echo $tenantName; ?></h2> -->
                </div>


                <div style="text-align: center;margin: auto;">
                    <h2 style="color: #000;
                text-align: center; font-family: 'Trebuchet MS', sans-serif;
                font-size: 44px;
                font-style: normal;
                font-weight: 500;">Your feedback matters to us; tell us about your experience.</h2>
                </div>
                <div style="max-width: 650px;text-align: center;margin: auto;">
                    <h3 style="
                color: #000;
                text-align: center;
                font-family: 'Trebuchet MS', sans-serif;
                
                font-style: normal;
                font-weight: 500;
                line-height: 30px;">
                        <?php echo $data; ?>
</h3>
                </div>
                <div style="margin: auto;text-align: center;">
                    <h3 style="color: #000;
                                font-family: 'Lora', serif;
                                font-size: 24px;
                                font-style: normal;
                                text-align: left;
                                font-weight: 600;">How likely is it that you would recommend <?php echo $postdata["placeholder_name"] ?> to a friend or colleague?
                    </h3>
                </div>
                <div style="text-align: center;margin:40px 0px">
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 0
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 1
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 2
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 3
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 4
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 5
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 6
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 7
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 8
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 9
                    </p>
                    <p style="text-decoration: none;
                    text-align: center;
                    display: inline-block;
                    margin: 10px 5px;
                    padding: 7px 0px 15px;
                    border-radius: 72px;
                    width: 43px;
                    height: 20px;
                    border: 2px solid #909090;
                    background: #d9d9d9;
                    color: #000;
                    font-family: 'Arima',sans-serif;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 600;"> 10
                    </p>
                </div>
                <div>
                    <p style="color: rgba(0, 0, 0, 0.52);
                                display: inline;
                            font-family: Lora;
                            font-size: 15px;
                            font-style: normal;margin: 0px;
                            font-weight: 600;">Not Likely</p>
                    <p style="color: rgba(0, 0, 0, 0.52);
                                margin: 0px;
                            font-family: 'Lora', serif;
                            font-size: 15px;
                            font-style: normal;
                            font-weight: 600;margin: 0; display: inline;float: right;">Very Likely</p>
                </div>
                <div style="text-align: center;margin: 50px auto;width: 30%;">
                    <p style="border-radius: 30px;padding: 10px 20px;
                                        background: #000;color: #FFF;
                                        font-family: 'Lora', serif;
                                        text-decoration: none;
                                        font-size: 20px;
                                        font-style: normal;
                                        font-weight: 600;">Take a survey</p>
                </div>
            </div>
        </a>
    </section>
</body>

</html>