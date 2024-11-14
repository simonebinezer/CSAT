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
        width: 40px;
        height: 40px;
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
                <form action="<?= base_url('createsurveyanswer') ?>" method="post" id="contact_form">
                    <input type="hidden" id="emailid" name="emailid" value="<?php echo $getSurveyData['contactId']; ?>">
                    <input type="hidden" id="surveyid" name="surveyid" value="<?php echo $getSurveyData['campaignId']; ?>">
                    <input type="hidden" id="userid" name="userid" value="<?php echo $getSurveyData['userData']['id']; ?>">
                    <input type="hidden" id="tenantid" name="tenantid" value="<?php echo $getSurveyData['tenantData']['tenant_id']; ?>">
                    <!-- <input type="hidden" id="randomkey" name="randomkey" value="<?php echo isset($randomKey) ? $randomKey : ''; ?>"> -->
                    <?php foreach ($getSurveyData['questionlist'] as $key => $questiondata) { ?>
                        <div class="content">
                            <h3><?php echo stripslashes($questiondata['question_name']); ?></h3>
                        </div>

                        <input type="hidden" id="question_<?php echo $key; ?>" name="question[<?php echo $key; ?>]" value="<?php echo $questiondata['question_id']; ?>">
                        <?php if ($questiondata['info_details'] == 'nps') { ?>
                            <div class="rating-point">
                                <input type="radio" id="radioOption0" name="Answer_1" value="0">
                                <label for="radioOption0" class="custom-radio">0</label>
                                <input type="radio" id="radioOption1" name="Answer_1" value="1">
                                <label for="radioOption1" class="custom-radio">1</label>
                                <input type="radio" id="radioOption2" name="Answer_1" value="2">
                                <label for="radioOption2" class="custom-radio">2</label>

                                <input type="radio" id="radioOption3" name="Answer_1" value="3">
                                <label for="radioOption3" class="custom-radio">3</label>
                                <input type="radio" id="radioOption4" name="Answer_1" value="4">
                                <label for="radioOption4" class="custom-radio">4</label>
                                <input type="radio" id="radioOption5" name="Answer_1" value="5">
                                <label for="radioOption5" class="custom-radio">5</label>
                                <input type="radio" id="radioOption6" name="Answer_1" value="6">
                                <label for="radioOption6" class="custom-radio">6</label>

                                <input type="radio" id="radioOption7" name="Answer_1" value="7">
                                <label for="radioOption7" class="custom-radio">7</label>
                                <input type="radio" id="radioOption8" name="Answer_1" value="8">
                                <label for="radioOption8" class="custom-radio">8</label>
                                <input type="radio" id="radioOption9" name="Answer_1" value="9">
                                <label for="radioOption9" class="custom-radio">9</label>
                                <input type="radio" id="radioOption10" name="Answer_1" value="10">
                                <label for="radioOption10" class="custom-radio">10</label>
                            </div>

                            <div class="pt-3 pb-5">
                                <p class="rating-des-not">Not Likely</p>
                                <p class="rating-des-like">Very Likely</p>
                            </div>
                            <!-- <div style="text-align: center;margin: 50px auto;">
                <button class="survey-button">Take a survey</button>
                    </div> -->
                            <div style="color:red; display:none;" id="errorquestion"></div>
                        <?php  } ?>
                    <?php  } ?>

                    <div class="rating-sec-2 mt-5 " id="next_question">
                        <div class="">
                            <h4 class="pb-5" id="update_quest_title"></h4>
                            <!-- <label id ="update_quest_title"></label> -->
                            <input type="hidden" id="question2" name="question[]" value="">
                        </div>
                        <div class="container">
                            <div class="chkbox-sur-form mb-5">

                                <div class="row">

                                    <!-- <div class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="RESULT_TextField1[]" id="next_questionOptions" multiple>
                                 -->
                                    <input type="hidden" id="checkedOptions" name="Answer_2[]">

                                    <div id="next_questionOptions" class="optionColumn">

                                    </div>

                                    <br><br>

                                    <div style="text-align: center;color:red; display:none;" id="errorquestion2"></div>
                                    <br><br>
                                    <input class="submit-sur" type="submit" value="Submit">

                                </div>

                            </div>
                        </div>


                    </div>
                </form>
            
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
<script type="text/javascript">
    $(document).ready(function() {
        $("form").submit(function(e) {
            var getradio = document.querySelector('input[name="Answer_1"]:checked');
            var array = [];
            $("input:checkbox[name=answers]:checked").each(function() {
                array.push($(this).val());
            });
            $('#checkedOptions').val(array);
            var getselect = document.getElementById("checkedOptions").value;
            console.log("options:", getselect)
            if (getradio == null) {
                $("#errorquestion").show();
                $("#errorquestion").html("Please select one rating for verification");
                e.preventDefault();
            } else if (getselect == "") {
                $("#errorquestion2").show();
                $("#errorquestion2").html("Please give your feedback for this question");
                e.preventDefault();
            }
            // else if(array.length<5){
            //     $("#errorquestion2").show();
            //     $("#errorquestion2").html("Please choose atleast 5 options for this question");
            //     e.preventDefault();
            // } 
            else {
                console.log("your feedback has been recorded");
            }
        });
            $("#next_question").hide();
            $("input[name='Answer_1']").change(function() {
                console.log("entry")
                var radioValue = $(this).val();
                console.log(radioValue);
                $("#errorquestion").hide();
                $("#next_questionOptions").html("");
                $("#update_quest_title").html("");
                console.log(radioValue);
                $.ajax({
                    url: '<?php echo base_url('getquestionnext'); ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id: "<?php echo $getSurveyData['userData']['id']; ?>",
                        "QandA1": radioValue,
                        tenant: "<?php echo ($getSurveyData['tenantData']['tenant_id']); ?>",
                        campaignId: "<?php echo $getSurveyData['campaignId']; ?>"
                    },
                    success: function(response) {
                        var responsedata = response.query;
                        console.log(response);
                        if (responsedata) {
                            var title = responsedata[0] ? responsedata[0].q_name : "";
                            console.log("title:", title);
                            var question_id = responsedata[0] ? responsedata[0].q_id : "";
                            var optionsrest = responsedata[1] ? responsedata[1] : "";
                            $("#update_quest_title").html("<b>" + title.stripSlashes() + "</b>");
                            $.each(optionsrest, function(key, item) {
                                $('#next_questionOptions').append('<div class="sur-chkbox"><input type="checkbox" name="answers" id="myCheckbox_' + key + '" value="' + key + '"><label for="myCheckbox_' + key + '" class="custom-checkbox"><span class="checkbox-content">' + item + '</span></label></div>');
                                console.log("KV:", key, item);
                            });
                            $("#question2").val(question_id);
                            (title) ? $("#next_question").show(): $("#next_question").hide();
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