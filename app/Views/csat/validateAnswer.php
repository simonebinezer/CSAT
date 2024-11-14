<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php echo script_tag('js/jquery.min.js'); ?>
</head>
<style>
    .optionColumn {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }

    .rating {
        height: 417px;
        background: #092C4C;
    }

    .rating .content-head {
        padding: 12% 0px;
        text-align: center;
    }

    .rating .content-head h3 {
        color: #FFF;
        text-align: center;
        font-family: 'Lora', serif;
        font-size: 45px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .content h3 {
        text-align: center;
        margin: 50px;
    }

    .rating-point {
        display: flex;
        justify-content: space-between;
    }

    .rating-point .custom-radio {
        text-decoration: none;
        margin: 5px 10px;
        border-radius: 72px;
            /* width: 40px;
            height: 40px; */
        border-radius: 30px;
        border: 2px solid #909090;

        background: #EBF3FC;
        color: #000;
        font-family: 'Arima', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 800;
    }

    .rating-des-not {
        color: rgb(9 44 76);
        display: inline;
        font-family: 'Lora', serif;
        font-size: 15px;
        font-style: normal;
        margin: 0px;
        font-weight: 600;
    }

    .rating-des-like {
        color: rgb(9 44 76);
        margin: 0px;
        font-family: 'Lora', serif;
        font-size: 15px;
        font-style: normal;
        font-weight: 600;
        margin: 0;
        display: inline;
        float: right;
    }

    .survey-button {
        border-radius: 30px;
        padding: 10px 20px;
        background: #000;
        color: #FFF;
        font-family: 'Lora', serif;
        text-decoration: none;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
    }

    .rating-sec-2 h4 {
        color: #000;
        font-family: 'Lora', serif;
        font-size: 28px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        text-align: center;
    }

    /* .sur-chkbox label {
        color: #092C4C;
        font-family: 'Lora', serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        position: absolute;
        bottom: -18px;
        left: 100px;
        z-index: 0;
        width: 350px;
    } */

    .sur-chkbox {
        /* border-radius: 10px;
        border: 2px solid #999;
        background: #EAEAEA;
        max-width: 400px;
        padding: 10px;
        margin: 15px auto;
        text-align: center; */
        position: relative;
        margin: 0px auto 25px;
    }


    /* .sur-chkbox:active {
        border-radius: 10px;
        border: 2px solid #092C4C;
        background: #EBF3FC;
        max-width: 400px;
        padding: 10px;
        margin: 15px auto;
        text-align: center;
    } */

    .chkbox-sur-form form {
        text-align: center;
    }

    .chkbox-sur-form form .submit-sur {
        border-radius: 30px;
        background: #092C4C;
        color: #FFF;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        padding: 10px 30px;
        border: 0px;
    }

    #myDiv {
        width: 200px;
        height: 200px;
        background-color: #ccc;
        text-align: center;
        line-height: 200px;
    }

    /* Style the label to make it visually clickable */
    label {
        cursor: pointer;

    }

    /* Default background color */
    label,
    input[type="checkbox"] {
        border-radius: 10px;
        border: 2px solid #999;
        background: #EAEAEA;
        max-width: 350px;
        padding: 10px;
        margin: 0px auto;
        text-align: center;
        z-index: 99;
        /* position: relative; */
        /* right: 100px; */
    }

    /* Change background color when the checkbox is checked */
    input[type="checkbox"]:checked+label {
        border-radius: 10px;
        border: 2px solid #092C4C;

        background: #EBF3FC;



    }

    /* Change background color when the checkbox is focused (active) */
    input[type="checkbox"]:focus+label {
        background-color: lightblue;
    }




    /* Hide the default checkbox */
    input[type="checkbox"].custom-checkbox {
        display: none;
    }

    /* Style the label to make it visually clickable */
    label {
        cursor: pointer;
    }

    /* Style the custom checkbox container */
    span.custom-checkbox-icon {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 3px;
        background-color: white;
        position: relative;
        margin-right: 10px;
        left: -145px;
        top: -8px;
    }

    span.custom-checkbox-icon:active {

        background-color: #092C4C;
        /* Color of the checkmark */

    }

    /* Style the custom checkmark */
    span.custom-checkbox-icon::before {
        content: '\2713';
        /* Unicode checkmark character */
        font-size: 16px;
        color: #fff;
        /* Color of the checkmark */
        background-color: #092C4C;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    /* Show the checkmark when the checkbox is checked */
    input[type="checkbox"].custom-checkbox:checked+label+span.custom-checkbox-icon::before {
        display: block;
    }
</style>
<style>
    /* Hide the default checkbox */
    input[type="checkbox"] {
        display: none;
    }

    /* Style the custom checkbox container */
    .custom-checkbox {
        display: flex;
        align-items: center;
        border-radius: 10px;
        border: 2px solid #999;

        background: #EAEAEA;


        padding: 10px;
        cursor: pointer;
    }

    /* Style the checkbox content */
    .checkbox-content {
        margin-left: 10px;
        color: #000;
        /* Initial color of the text */
        transition: color 0.2s;
        /* Transition for the text color */
        font-size: 18px;
        color: #000;
        font-family: 'Lora', serif;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    /* Style the custom checkbox with a tick mark */
    .custom-checkbox::before {
        content: '\2713';
        /* Unicode character for a checkmark */
        font-size: 16px;
        color: transparent;
        border-radius: 10px;
        border: 2px solid #999;


        /* Border color for the checkmark */
        border-radius: 3px;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    /* Change the checkbox appearance when checked */
    input[type="checkbox"]:checked+.custom-checkbox .checkbox-content {
        color: #000;
        font-family: 'Lora', serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        /* Color of the text when the checkbox is active */
    }

    /* Change the appearance of the tick mark when checked */
    input[type="checkbox"]:checked+.custom-checkbox::before {
        color: #fff;
        /* Color of the checkmark when active */
        background: #092C4C;
        /* Background color when the checkbox is active */
    }

    .submit-sur {
        border-radius: 30px;
        background: #092C4C;
        color: #fff;
        color: #FFF;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        border: 0px;
        padding: 12px;
        width: 15%;
        margin: auto;

    }
</style>
<style>
    /* Hide the default radio buttons */
    input[type="radio"] {
        display: none;
    }

    /* Style the custom radio label */
    .custom-radio {
        display: inline-block;
        padding: 4px;
        cursor: pointer;
        background-color: #fff;
        /* Initial background color for the label */
        transition: background-color 0.2s;
        /* Transition for the background color */
    }

    /* Change the label background color when the associated radio button is checked */
    input[type="radio"]:checked+label.custom-radio {

        border: 2px solid #909090;
        background: #092C4C;

        /* Background color when the radio button is selected (active) */
        color: #fff;
        font-family: 'Arima', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 800;
        line-height: normal;
        margin: 5px 10px;
        border-radius: 72px;
        width: 40px;
        height: 40px;
        /* Text color when the radio button is selected (active) */
    }
</style>
<!-- <script>
    const checkbox = document.getElementById("myCheckbox");

    checkbox.addEventListener("change", function () {
        if (this.checked) {
            // Checkbox is checked, do something
            console.log("Checkbox is checked");
        } else {
            // Checkbox is not checked, do something else
            console.log("Checkbox is not checked");
        }
    });


</script> -->


<body>
    <section>
        <div class="container-fluid">
            <img src="<?php echo base_url(); ?>images/logo 3.png" class="img-fluid" />
        </div>
    </section>
    <section class="rating">
        <div class="content-head">
            <img src="<?php echo base_url(); ?>images/Good Quality.png" class="img-fluid">
            <!-- <h3>Rate Our Services</h3> -->
        </div>
    </section>
    <section id="">
        <div class="container">
            <?php if (session()->getFlashdata('response') !== NULL) : ?>
                <p style="color:green; font-size:18px;" align="center"><?php echo session()->getFlashdata('response'); ?></p>
            <?php endif; ?>

            <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('Answer_1') ?></p>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('Answer_2') ?></p>
            <?php endif; ?>
            <form action="<?= base_url('csat/saveResponse') ?>" method="post" id="contact_form">
                <input type="hidden" id="emailId" name="emailId" value="<?php echo $surveyData['customerId']; ?>">
                <input type="hidden" id="surveyId" name="surveyId" value="<?php echo $surveyData['surveyId']; ?>">
                <input type="hidden" id="tenantId" name="tenantId" value="<?php echo $surveyData['tenantId']; ?>">
                <div class="content">
                    <h3><?php echo stripslashes($surveyData['question']['question']); ?></h3>
                </div>

                <input type="hidden" id="question_1" name="question_1" value="<?php echo $surveyData['question']['question_id']; ?>">
                <div class="rating-point">
                    <!-- <input type="radio" id="radioOption0" name="Answer_1" value="0">
                                <label for="radioOption0" class="custom-radio">0</label> -->
                    <?php foreach ($surveyData["answerList"] as $key => $answer) {
                        $index = $key + 1; ?>
                        <input type="radio" id="radioOption<?= $index ?>" name="Answer_1" value="<?= $index ?>">
                        <label for="radioOption<?= $index ?>" class="custom-radio"><?php if ($surveyData["isImage"]) { ?>
                                <img src="<?= base_url() . "/images/answers/" . $answer ?>" />
                            <?php } else {
                                                                                        echo $answer;
                                                                                    }  ?></label>
                    <?php } ?>

                </div>

                <div class="pt-3 pb-5">
                    <p class="rating-des-not">Not Likely</p>
                    <p class="rating-des-like">Very Likely</p>
                </div>

                <div style="color:red; display:none;" id="errorquestion"></div>
                <div id="next_question_div" style="display:none">
                    <div class="rating-sec-2 mt-5 " id="next_question">


                    </div>
                    <button type="submit">submit</button>
                </div>
                <div style="color:red; display:none;" id="errorquestion2"></div>

            </form>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
<script type="text/javascript">
    $(document).ready(function() {
        $("form").submit(function(e) {
            //e.preventDefault();
            var getradio = document.querySelector('input[name="Answer_1"]:checked');
            var array = [];
            var queAndA2 = Object();
            var div = document.getElementById("next_question");
            // Find all input elements within the div
            var inputs = div.querySelectorAll('input');
            var flag = true;
            // Iterate through each input element
            for (var i = 0; i < inputs.length; i++) {
                queAndA2[inputs[i].name] = inputs[i].value;
                // Check if the value of the input is empty
                if (inputs[i].value.trim() === '') {
                    // Return true or perform any action if any input is empty
                    console.log('Input ' + (i + 1) + ' within div  is empty.');
                    flag = false;
                    break;
                }
            }
            console.log("queAndA2", queAndA2)
            if (getradio == null) {
                $("#errorquestion").show();
                $("#errorquestion").html("Please select one rating for verification");
                e.preventDefault();
            } else if (!flag) {
                $("#errorquestion2").show();
                $("#errorquestion2").html("Please give your feedback for all the questions");
                console.log("here")
                e.preventDefault();
            } else {
                console.log("your feedback has been recorded");
            }
        });
        $("#next_question").hide();
        $("input[name='Answer_1']").change(function() {
            $("#next_question_div").hide();

            console.log("entry")
            var radioValue = $(this).val();
            console.log(radioValue);
            $("#errorquestion").hide();
            $("#errorquestion2").hide()
            $("#next_question").html("");
            $("#update_quest_title").html("");
            console.log(radioValue);
            $.ajax({
                url: '<?php echo base_url('csat/getNextQuestion'); ?>',
                type: 'post',
                dataType: 'json',
                data: {

                    QandA1: radioValue,
                    tenant: "<?php echo ($surveyData['tenantId']); ?>",
                    surveyId: "<?php echo $surveyData['surveyId']; ?>"
                },
                success: function(response) {
                    var responsedata = response.query;
                    console.log(response);
                    if (responsedata) {

                        $.each(responsedata, function(key, item) {
                            console.log("KV:", key, item);
                            $('#next_question').append('<h4>' + item["question"] + '</h4><input type="text" id="" name="Answer[' + item["question_id"] + ']"/>');
                        });
                        $("#next_question").show()
                        $("#next_question_div").show();

                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });

        });

        String.prototype.stripSlashes = function() {
            return this.replace(/\\(.)/mg, "$1");
        }
    });
</script>

</html>