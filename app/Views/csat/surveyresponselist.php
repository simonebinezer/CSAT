<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<style>
     .home{
        height:100%;
    }
    #recepient_list .modal-dialog-scrollable .modal-body {
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 15px;
    }

    #recepient_list .modal-header {
        border-bottom: 1px solid #bdbdbd;
        margin: 0px;
    }

    #recepient_list .btn-close {
        font-weight: 600;
        font-size: 16px;
    }

    /* width */
    #recepient_list ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    #recepient_list ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    #recepient_list ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    #recepient_list ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .modal-recepient-list {
        display: flex;
        justify-content: space-between;
        margin: 10px 0px;
    }

    .response-titles-modal {
        /* width: 50%; */
    }

    .recepient-btn {
        background: #0a2472;
    }

    .recepient-btn:hover {
        background: #0a2472;
    }

    .flo-r {
        float: right;
    }

    .new-survey-report {
        background: #fff;
        border-radius: 20px;
        /* padding: 20px; */
    }

    .response-head {
        display: flex;
        justify-content: space-between;
    }

    .response-head h6 {
        color: #092C4C;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin: 20px 30px;
    }

    .border-bottom-response {
        border-bottom: 2px solid #EBF3FC;
    }

    .response-titles {
        display: flex;
        justify-content: space-between;
    }

    .response-content-row {
        color: #092C4C;
        font-family: 'Inter', sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .response-content-row-sub {
        border-radius: 73px;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        padding: 5px 10px;
        width: 30px;
        background-color: #092C4C;
        height: 30px;
    }

    .response-titles-content p {
        float: right;
        font-size: 12px;
        line-height: 28px;
        padding-left: 2px;
        margin: 0px;
    }

    .response-titles-modal p {
        font-size: 12px;
        line-height: 28px;
        padding-left: 2px;
        margin: 0px;
        display: inline-flex;
    }

    .response-titles-content {
        padding: 0px 15px;
    }

    .response-content .dropdown button {
        border-radius: 5px;
        padding: 7px 25px;
        border: 1px solid #092C4C;
        color: #000;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        background: #FFF;

    }

    .page-link {
        border: 1px solid #092C4C;
        border-radius: 65px;
        margin: 10px;
        width: 36px;
        height: 36px;
        color: #000;
    }

    .page-item:first-child .page-link {
        border-top-left-radius: 85px;
        border-bottom-left-radius: 85px;
        border-top-right-radius: 85px;
        border-bottom-right-radius: 85px;
        width: 36px;
        height: 36px;
        padding: 5px 15px;
    }

    .page-item:last-child .page-link {
        border-top-left-radius: 85px;
        border-bottom-left-radius: 85px;
        border-top-right-radius: 85px;
        border-bottom-right-radius: 85px;
        width: 36px;
        height: 36px;
        /* padding: 5px 15px; */
    }

    .page-link:hover {
        z-index: 2;
        color: #fff;
        background-color: #092C4C;
        border-color: #092C4C;
    }

    sup {
        color: #DA2C33;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    #submit {
        background: #0a2472;
        border: 0px;
    }

    .modal-recepient {
        /* margin: 15px 0px; */
        border-bottom: 1px solid #d6cfcf;
    }

    .modal-recepient .response-titles-modal img {
        width: 20px;
    }

    .modal-recepient ul {
        margin: 0px;
        padding: 0px;
    }

    .modal-title . {
        font-size: 25px;
        font-weight: 600;
    }
</style>
<section class="home">
    <div class="container">
        <!-- Breadcrumbs-->
        <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                <h2 class="crt-survey-h2 mb-5 dash">Survey Response</h2>
            </div>
            <?php if (session()->get('tenant_id') == 1) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4 float-right">
                    <select class="custom-select form-select custom-select-sm" class="custom-select custom-select-sm"
                        aria-label="Default select example" name="tenant" id="tenantchange">
                        <?php foreach ($getTenantdata as $getTenantlist) { ?>
                            <option value="<?php echo $getTenantlist['tenant_id']; ?>" <?php if ($selectTenant == $getTenantlist['tenant_id']): ?>selected="selected" <?php endif; ?>>
                                <?php echo $getTenantlist['tenant_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
        <?php if (!empty($surveyList)) {
            $basesurvey = (isset($_GET['tenantId'])) ? base_url('csat/surveyResponse?tenantId=' . $_GET['tenantId']) : base_url('csat/surveyResponse'); ?>
            <form class="form-horizontal" action="<?= $basesurvey; ?>" method="post">
                <div class="row mb-4">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="d-flex justify-content-between">
                            <div class="" style="margin:0px 10px">
                                <select class="custom-select form-select custom-select-sm"
                                    class="custom-select custom-select-sm" aria-label="Default select example"
                                    name="surveyId" id="surveyId">
                                    <?php foreach ($surveyList as $survey) {
                                        ?>
                                        <option value="<?php echo $survey['survey_id']; ?>" <?php if ($survey['survey_id'] == $selectsurvey['survey_id']) { ?> selected="selected"
                                            <?php } ?>>
                                            <?php echo $survey['survey_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="">
                                <!-- <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block "  data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    value="Filter" /> -->
                                <button type="button" class="btn btn-primary btn-block recepient-btn" data-bs-toggle="modal"
                                    data-bs-target="#recepient_list" value="Recepient" >Recepient</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="new-survey-report">



                <?php if (!empty($surveyData)) { ?>
                    <div class="response-head">
                        <h6></h6>
                        <h6 class="flo-r">Download the Excel &nbsp;
                            <button type="button" id="csv" onclick="DownloadCsv()"><img
                                    src="<?php echo base_url(); ?>images\icons\response\download-pie.png"
                                    class="img-centered img-fluid"></button>
                        </h6>
                    </div>
                    <?php foreach ($surveyData as $getSurveylist) { ?>
                        <div class="response-content border-bottom-response ">
                            <div class="row mb-4">

                                <div class="col-md-12">
                                    <div class="response-titles">
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/time.png"
                                                class="img-centered img-fluid">
                                            <p>Sent Time:<span>
                                                    <?php echo $getSurveylist["created_at_time"]; ?>
                                                </span></p>
                                        </div>
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Calendar.png"
                                                class="img-centered img-fluid">
                                            <p>
                                                <?php echo $getSurveylist["created_at_date"]; ?>
                                            </p>
                                        </div>
                                        <!-- <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Laptop.png"
                                                class="img-centered img-fluid">
                                            <p>Device Type:<span>Laptop</span></p>
                                        </div> -->
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Location.png"
                                                class="img-centered img-fluid">
                                            <p>Location:<span>
                                                    <?php echo $getSurveylist["location"] ? $getSurveylist["location"] : ""; ?>
                                                </span></p>
                                        </div>
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Phone.png"
                                                class="img-centered img-fluid">
                                            <p>Phone Number:<span>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['contact_details'] : ""; ?>
                                                </span></p>
                                        </div>
                                        <!-- <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Delivery-time.png"
                                                class="img-centered img-fluid">
                                            <p>Time Interval:<span>
                                                    <?php echo $getSurveylist["timeInterval"] ?>
                                                </span></p>
                                        </div> -->
                                    </div>
                                    <div class="response-titles">
                                        <div class="response-titles-content">
                                            <img src="<?php echo base_url(); ?>images/icons/response/Email.png"
                                                class="img-centered img-fluid">
                                            <p>Email:<span>
                                                    <?php echo isset($getSurveylist['userdata']) ? $getSurveylist['userdata']['email_id'] : ''; ?>
                                                </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <!-- <div class="col-md-1">
                                    <div class="">
                                        <p class="response-content-row-sub">1</p>
                                    </div>
                                </div> -->
                                <?php for ($i=0; $i < count($getSurveylist["questionData"]); $i++) { 
                                    $question=$getSurveylist["questionData"][$i];
                                    $answer= $getSurveylist["answerData"][$i]?>
                                <div class="col-md-12">
                                    <div class="response-titles" style="justify-content: space-between;">
                                        <div class="response-titles-content ">

                                            <p>
                                                <?php echo $question["question"]; ?>
                                            </p>
                                        </div>
                                        <div class="response-titles-content" style="text-align:right;width:360px;">
                                            <p>
                                                <?php echo $answer; ?>
                                            </p>
                                        </div>

                                    </div>

                                </div>
                          <?php  } ?>

                            </div>
                           
                        </div>
                    <?php }
                } else { ?>
                    <div class="text-center">
                        <p class="fs-3"> <span class="text-danger">Oops!</span>There is no record for this survey.</p>
                    </div>
                <?php } ?>

            </div>


        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="recepient_list" tabindex="-1" aria-labelledby="recepient_list" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recepient List -
                       <?php if(isset($selectsurvey)){ echo $selectsurvey['survey_name'];} ?> 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="modal-recepient">
                        <table class="head">
                            <tr>
                                <ul>

                                    <li class="modal-recepient-list">
                                        <div class="response-titles-modal">
                                            <!-- <img src="<?php echo base_url(); ?>images/icons/1.png"
                                                class="img-centered img-fluid"> -->
                                            <p><b>Name</b></p>
                                        </div>

                                        <div class="response-titles-modal">
                                            <!-- <img src="<?php echo base_url(); ?>images/icons/2.png"
                                                class="img-centered img-fluid"> -->
                                            <p>
                                                <b>Email</b>
                                            </p>
                                        </div>
                                        <div class="response-titles-modal">
                                            <!-- <img src="<?php echo base_url(); ?>images/icons/2.png"
                                                class="img-centered img-fluid"> -->
                                            <p>
                                                <b>Status</b>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </tr>
                        </table>
                    </div>
                    <?php if (!empty($recipientList)) { ?>

                        <?php foreach ($recipientList as $recipient) { ?>
                            <!-- <div class="modal-recepient">
                                <div class="row mb-4">
                                    <div class="col-md-5">
                                        <div class="response-titles-modal">
                                            <img src="<?php echo base_url(); ?>images/icons/1.png"
                                                class="img-centered img-fluid">
                                            <p>Name:<span>
                                                    <?php echo $recipient["name"]; ?>
                                                </span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="response-titles-modal">
                                            <img src="<?php echo base_url(); ?>images/icons/2.png"
                                                class="img-centered img-fluid">
                                            <p>
                                                <?php echo $recipient["email_id"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="modal-recepient">
                                <table>
                                    <tr>
                                        <ul>

                                            <li class="modal-recepient-list">
                                                <div class="response-titles-modal">
                                                    <!-- <img src="<?php echo base_url(); ?>images/icons/1.png"
                                                class="img-centered img-fluid"> -->
                                                    <p><span>
                                                            <?php echo $recipient["name"]; ?>
                                                        </span></p>
                                                </div>

                                                <div class="response-titles-modal">
                                                    <!-- <img src="<?php echo base_url(); ?>images/icons/2.png"
                                                class="img-centered img-fluid"> -->
                                                    <p>

                                                        <?php echo $recipient["email_id"]; ?>
                                                    </p>
                                                </div>
                                                <div class="response-titles-modal">
                                                    <p>

                                                        <?php echo $recipient["send_status"]; ?>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </tr>
                                </table>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="text-center">
                            <p class="fs-3"> <span class="text-danger">Oops!</span>There is no record for this
                                survey.
                            </p>
                        </div>
                    <?php } ?>


                </div>

            </div>
        </div>
    </div>
</section>



<script type="text/javascript">
    $("#tenantchange").change(function () {
        var t_id = $(this).val();
        var newUrl = '';
        var currLoc = $(location).attr('href');
        var hashes = window.location.href.indexOf("?");
        if (hashes == -1) {
            var currentUrl = window.location.href + "?tenantId=" + t_id;
            var urls = new URL(currentUrl);
            newUrl = urls.href;
        } else {
            var currentUrl = window.location.href;
            var urls = new URL(currentUrl);
            urls.searchParams.set("tenantId", t_id); // setting your param
            newUrl = urls.href;
        }
        window.location.href = newUrl;
    });


    // $(document).ready(function() {

    function DownloadCsv() {

        $.ajax({
            url: '<?php echo base_url('csat/downloadCsv'); ?>',
            type: 'post',
            data: {
                req: (<?= json_encode($surveyData); ?>)
            },
            success: function (response) {
                console.log(response);
                console.log("successentry");
                var downloadLink = document.createElement("a");
                var fileData = ['\ufeff' + response];
                console.log(fileData);

                var blobObject = new Blob(fileData, {
                    type: "text/csv;charset=utf-8;"
                });
                console.log(blobObject);
                var url = URL.createObjectURL(blobObject);
                downloadLink.href = url;
                console.log(url);
                downloadLink.download = "SurveyData.csv";

                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            },
            error: function (response) {
                console.log("failed");
                console.log(response);
            }

        });
    }


    //  });


    $("#surveyId").change(function () {
        var surveyId = $(this).val();
        var newUrl = '';
        var currLoc = $(location).attr('href');
        console.log("currLoc", currLoc);
        var hashes = window.location.href.indexOf("?");
        if (hashes == -1) {
            var currentUrl = window.location.href + "?surveyId=" + surveyId;
            var urls = new URL(currentUrl);

            newUrl = urls.href;
            console.log("newUrl", newUrl);
        } else {
            var currentUrl = window.location.href;
            var urls = new URL(currentUrl);
            urls.searchParams.set("surveyId", surveyId); // setting your param
            newUrl = urls.href;
            console.log("newUrl", newUrl);
        }
        window.location.href = newUrl;
    });
</script>
<?= $this->endSection() ?>
