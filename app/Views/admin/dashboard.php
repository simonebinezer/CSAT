<?= $this->extend("layouts/app") ?>
<?= $this->section("body") ?>

<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<?php echo script_tag('js/functions/Script.js'); ?>
<?php //$logo_img = session()->getFlashdata('logo_update') ? base_url() .session()->getFlashdata('logo_update') : session()->get('logo_update');
$logo_img = "";
$logo_img = ($logo_img == '') ? 'images/cx-images/logo.png' : $logo_img;
?>

<script>
    // Function to check if the page has id="dashboardid"
    function checkActiveMenu() {
        // Check if the page's body or a specific container element has the id "dashboardid"
        if (document.getElementById('dashboardid')) {
            // Add 'active' class to the dashboard anchor tag
            document.getElementById('dashboard-link').classList.add('active');
            document.getElementById('dashboard-link2').classList.add('active');
        }
    }

    // Call the function when the page loads
    window.onload = checkActiveMenu;
</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('css/daterangepicker.css') ?>" />

<section class="home" style="height: max-content;" id="dashboardid">
    <div class="container">
        <div class="row">

            <div class="col-xl-8 col-lg-8 col-md-8">
                <h1 class="dash">Dashboard</h1>
            </div>
            <?php if (session()->get('tenant_id') == 1) { ?>

                <!-- Commented the compare functionality as asked by Prabhu on 27th oct 2023 -->
                <!-- <div class="col-xl-2 col-lg-2 col-md-2">
                <input type="checkbox" class="form-check-input" id="tocompare" name="tocompare" value="yes" <?php if ($getdashData['selectfilter'] == "yes") { ?> checked <?php } ?>>
                 <label class="form-check-label" for="tocompare">To Compare</label>
                </div> -->
                <div class="col-xl-4 col-lg-4 col-md-4 float-right">

                </div>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <div class="col-xl-8 col-lg-8 col-md-8">
                <p class="custom-select-title">Switch survey</p>
                <div class="d-flex mb-3">

                    <?php if (session()->get('tenant_id') == 1) { ?>
                        <select class="custom-select form-select custom-select-sm " aria-label="Default select example"
                            name="tenant" id="tenantchange"
                            style="border-radius:6px;;margin:0px 20px 0px 0px;font-size:12px">

                            <?php foreach ($getdashData['getTenantdata'] as $getTenantlist) { ?>
                                <option value="<?php echo $getTenantlist['tenant_id']; ?>" <?php if ($getdashData['selectTenant'] == $getTenantlist['tenant_id']): ?>selected="selected" <?php endif; ?>>
                                    <?php echo $getTenantlist['tenant_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    &nbsp;
                    <div>
                        <select class="custom-select form-select custom-select-sm " aria-label="Default select example"
                            name="surveyId" id="surveyId"
                            style="border-radius:10px; font-size:12px; <?php echo empty($getdashData['surveyList']) ? 'display:none;' : ''; ?>">>

                            <?php foreach ($getdashData['surveyList'] as $survey) { ?>
                                <option value="<?php echo $survey['campaign_id']; ?>" <?php if ($getdashData['selectedSurvey'] == $survey['campaign_id']): ?>selected<?php endif; ?>>
                                    <?php echo $survey['campaign_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4">
                <p class="custom-select-title">Period range</p>
                <div id="reportrange" class="pull-left"
                    style="border-radius:6px;background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #0A2472;">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span style="font-size :12px;"></span> <b class="caret"></b>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card" style="border-radius: 25px;border:0px">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                <div class="response-title">
                                    <p class="response-head-1">NET PROMOTER SCORE</p>
                                </div>
                                <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 100%; height: 200px;background: rgb(235 243 252);
                                    padding: 20px;
                                    border-radius: 20px;"></canvas>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
                                <div class="response-title">
                                    <p class="response-head-1">RESPONSE RATE</p>
                                </div>
                                <canvas id="chart-line1" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 100%; height: 300px;background: rgb(235 243 252);
                                    padding: 20px;
                                    border-radius: 20px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="row mb-5">
            <div class="col-xl-6 col-lg-6 col-md-6 ">
                <div class="chart-sty">
                    <div class="row pt-3 px-5 pb-2">
                        <p class="response-head-1">NPS Response</p>
                    </div>
                    <canvas id="chartId" aria-label="chart" height="400" width="580" style="background: #EBF3FC;
                            padding: 10px 20px 0px;
                            border-radius: 20px;height:480px !important"></canvas>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card" style="border-radius:25px;border:0px">
                    <div class="card-body">
                        <!-- <div class="mb-1 row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <table class="table mt-6 ">
                                <thead>
                                    <tr>
                                        <th scope="row">
                                            <p class="response-head-1">NPS Summary</p>
                                        </th>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                            <th scope="row">
                                                <p class="response-head-1">previous</p>
                                            </th>
                                        <?php } ?>
                                        <th scope="row">
                                            <p class="response-head-1">Current</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">
                                            <p class="">Promoters</p>
                                        </td>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                            <td scope="row">
                                                <p class="text-center">
                                                    <?php echo count($getDatacomp['promoters']); ?>
                                                </p>
                                            </td>
                                        <?php } ?>
                                        <td scope="row">
                                            <p class="text-center">
                                                <?php echo count($getdashData['promoters']); ?>
                                            </p>
                                        </td>
                                    </tr>
                                        </tbody>
                                        
                                        <tbody>
                                    <tr>
                                        <td scope="row">
                                            <p class="">Passives</p>
                                        </td>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                            <td scope="row">
                                                <p class="text-center">
                                                    <?php echo count($getDatacomp['passives']); ?>
                                                </p>
                                            </td>
                                        <?php } ?>

                                        <td scope="row">
                                            <p class="text-center">
                                                <?php echo count($getdashData['passives']); ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <p class="">Detractors</p>
                                        </td>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>

                                            <td scope="row">
                                                <p class="text-center">
                                                    <?php echo count($getDatacomp['detractors']); ?>
                                                </p>
                                            </td>
                                        <?php } ?>

                                        <td scope="row">
                                            <p class="text-center">
                                                <?php echo count($getdashData['detractors']); ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <p class="">Total Sents</p>
                                        </td>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>

                                            <td scope="row">
                                                <p class="text-center">
                                                    <?php echo $getDatacomp['totalresponse']; ?>
                                                </p>
                                            </td>
                                        <?php } ?>

                                        <td scope="row">
                                            <p class="text-center">
                                                <?php echo $getdashData['totalresponse']; ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <p class="">Total Response</p>
                                        </td>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>

                                            <td scope="row">
                                                <p class="text-center">
                                                    <?php echo $getDatacomp['getsurveyresponse']; ?>
                                                </p>
                                            </td>
                                        <?php } ?>

                                        <td scope="row">
                                            <p class="text-center">
                                                <?php echo $getdashData['getsurveyresponse']; ?>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                        <div class="mb-1 row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="table mt-6 ">
                                    <div class="t-data ">
                                        <div scope="" class="t-data-title">
                                            <p class="response-head-1">NPS Summary</p>
                                        </div>
                                        <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                            <div scope="">
                                                <p class="response-head-1">previous</p>
                                            </div>
                                        <?php } ?>
                                        <!-- <div scope="">
                                            <p class="response-head-1">Current</p>
                                        </div> -->
                                    </div>
                                    <div class="table-t-data bd">
                                        <div class="t-data" style="display: flex; align-items: center;">
                                            <div scope="row" class="t-data-title" style="flex: 2;">
                                                <p style="margin:0px; text-align: left;">Promoters</p>
                                            </div>
                                            <div class="progress" style="flex: 5;">
                                                <div class="progress-bar bg-success-1" role="progressbar"
                                                    style="width: <?php echo count($getdashData['promoters']); ?>%;"
                                                    aria-valuenow="<?php echo count($getdashData['promoters']); ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                                <div scope="row" class="t-data-title" style="flex: 1;">
                                                    <p style="margin:0px" class="text-center">
                                                        <?php echo count($getDatacomp['promoters']); ?>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div scope="row" class="t-data-title" style="flex: 1;">
                                                <p style="margin:0px" class="text-center">
                                                    <?php echo count($getdashData['promoters']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-t-data bd">
                                        <div class="t-data" style="display: flex; align-items: center;">
                                            <div scope="row" class="t-data-title" style="flex: 2;">
                                                <p style="margin:0px; text-align: left;">Passives</p>
                                            </div>
                                            <div class="progress" style="flex: 5;">
                                                <div class="progress-bar bg-info-1" role="progressbar"
                                                    style="width: <?php echo count($getdashData['passives']); ?>%;"
                                                    aria-valuenow="<?php echo count($getdashData['passives']); ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                                <div scope="row" class="t-data-title" style="flex: 1;">
                                                    <p style="margin:0px" class="text-center">
                                                        <?php echo count($getDatacomp['passives']); ?>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div scope="row" class="t-data-title" style="flex: 1;">
                                                <p style="margin:0px" class="text-center">
                                                    <?php echo count($getdashData['passives']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-t-data bd">
                                        <div class="t-data" style="display: flex; align-items: center;">
                                            <div scope="row" class="t-data-title" style="flex: 2;">
                                                <p style="margin:0px; text-align: left;">Detractors</p>
                                            </div>
                                            <div class="progress" style="flex: 5;">
                                                <div class="progress-bar bg-info-2" role="progressbar"
                                                    style="width: <?php echo count($getdashData['detractors']); ?>%;"
                                                    aria-valuenow="<?php echo count($getdashData['detractors']); ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                                <div scope="row" class="t-data-title" style="flex: 1;">
                                                    <p style="margin:0px" class="text-center">
                                                        <?php echo count($getDatacomp['detractors']); ?>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div scope="row" class="t-data-title" style="flex: 1;">
                                                <p style="margin:0px" class="text-center">
                                                    <?php echo count($getdashData['detractors']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-t-data bd" style="background: none;">
                                        <div class="t-data"
                                            style="display: flex; align-items: center; background: none;">
                                            <div class="t-data-title" style="flex: 2;">
                                                <p style="margin:0px; text-align: left;">Responded</p>
                                            </div>
                                            <div class="progress" style="flex: 5; background: none;">
                                                <div class="progress-bar bg-success-2" role="progressbar"
                                                    style="width: <?php echo $getdashData['getsurveyresponse']; ?>%;"
                                                    aria-valuenow="<?php echo $getdashData['getsurveyresponse']; ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                                <div class="t-data-title" style="flex: 1;">
                                                    <p style="margin:0px" class="text-center">
                                                        <?php echo $getDatacomp['getsurveyresponse']; ?>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div class="t-data-title" style="flex: 1;">
                                                <p style="margin:0px" class="text-center">
                                                    <?php echo $getdashData['getsurveyresponse']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-t-data bd" style="background: none;">
                                        <div class="t-data"
                                            style="display: flex; align-items: center; background: none;">
                                            <div class="t-data-title" style="flex: 2;">
                                                <p style="margin:0px; text-align: left;">Recipients</p>
                                            </div>
                                            <div class="progress" style="flex: 5; background: none;">
                                                <div class="progress-bar bg-info-3" role="progressbar" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <?php if (isset($_GET["filter"]) && $_GET['filter'] == 'yes') { ?>
                                                <div class="t-data-title" style="flex: 1;">
                                                    <p style="margin:0px" class="text-center">
                                                        <?php echo $getDatacomp['totalresponse']; ?>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div class="t-data-title" style="flex: 1;">
                                                <p style="margin:0px" class="text-center">
                                                    <?php echo $getdashData['totalresponse']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="subscribe" tabindex="-1" aria-labelledby="subscribeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5" id="subscribeLabel">&nbsp;</p>
                    <h1 class="modal-title fs-5" id="subscribeLabel">Trial Expired</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg
                            xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                            viewBox="0,0,256,256">
                            <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                                stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                                font-family="none" font-weight="none" font-size="none" text-anchor="none"
                                style="mix-blend-mode: normal">
                                <g transform="scale(5.12,5.12)">
                                    <path
                                        d="M9.15625,6.3125l-2.84375,2.84375l15.84375,15.84375l-15.9375,15.96875l2.8125,2.8125l15.96875,-15.9375l15.9375,15.9375l2.84375,-2.84375l-15.9375,-15.9375l15.84375,-15.84375l-2.84375,-2.84375l-15.84375,15.84375z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <P>Your trial has ended.<br />
                        Subscribe now to unlock the app's full features.</P>
                    <button id="alert_subscribe_button" class="trail-end-btn"
                        onclick="invokeSubscribe()">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script type="text/javascript">
    
    $(function () {
        var currentdate = "<?php echo $getdashData['selectRange']; ?>";
        var start = moment().subtract(32, 'days');
        var end = moment();

        if (currentdate) {
            var splitdate = currentdate.split("_");
            var start = moment(new Date(splitdate[0]));
            var end = moment(new Date(splitdate[1]));
        }

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD-MMMM-YYYY') + ' - ' + end.format('DD-MMMM-YYYY'));
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            var startdate = picker.startDate.format('YYYY-MM-DD');
            var enddate = picker.endDate.format('YYYY-MM-DD');
            var daterange = startdate + "_" + enddate;
            var newUrl = '';
            var currLoc = $(location).attr('href');
            console.log("currLoc", currLoc);
            var hashes = window.location.href.indexOf("?");
            if (hashes == -1) {
                var currentUrl = window.location.href + "?daterange=" + daterange;
                var urls = new URL(currentUrl);
                newUrl = urls.href;
            } else {
                var currentUrl = window.location.href;
                var urls = new URL(currentUrl);
                urls.searchParams.set("daterange", daterange); // setting your param
                newUrl = urls.href;
            }
            console.log("newUrl", newUrl);
            window.location.href = newUrl;
        });
    });
    $("#tocompare").change(function () {
        var status = $(this).is(":checked");
        var t_id = (status) ? 'yes' : 'no';
        var newUrl = '';
        var currentdate = "<?php echo $getdashData['selectRange']; ?>";
        var start = moment().subtract(32, 'days');
        var end = moment();
        if (currentdate) {
            var splitdate = currentdate.split("_");
            var start = moment(new Date(splitdate[0]));
            var end = moment(new Date(splitdate[1]));
        }
        var currLoc = $(location).attr('href');
        var hashes = window.location.href.indexOf("?");
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');
        var daterange = startdate + "_" + enddate;
        if (hashes == -1) {
            var currentUrl = window.location.href + "?filter=" + t_id + "&daterange=" + daterange;
            var urls = new URL(currentUrl);
            newUrl = urls.href;
        } else {
            var currentUrl = window.location.href;
            var urls = new URL(currentUrl);
            urls.searchParams.set("filter", t_id); // setting your param
            urls.searchParams.set("daterange", daterange); // setting your param
            newUrl = urls.href;
        }
        window.location.href = newUrl;
    });
    $("#tenantchange").change(function () {
        var t_id = $(this).val();
        var newUrl = '';
        var currLoc = $(location).attr('href');
        console.log("currLoc", currLoc);
        var hashes = window.location.href.indexOf("?");
        if (hashes == -1) {
            var currentUrl = window.location.href + "?tenantId=" + t_id;
            var urls = new URL(currentUrl);

            newUrl = urls.href;
            console.log("newUrl", newUrl);
        } else {
            var currentUrl = window.location.href;
            var urls = new URL(currentUrl);
            urls.searchParams.set("tenantId", t_id); // setting your param
            newUrl = urls.href;
            console.log("newUrl", newUrl);
        }
        window.location.href = newUrl;
    });
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
    $(document).ready(function () {

        // Register the plugin to draw text in the center of the donut chart
        Chart.register({
            id: 'centerTextPlugin',
            beforeDraw: function (chart) {
                // Check if the chart belongs to the #chart-line1 canvas
                if (chart.config.options.elements && chart.config.options.elements.center) {
                    var ctx = chart.ctx;
                    var centerConfig = chart.config.options.elements.center;
                    var fontStyle = centerConfig.fontStyle || 'Inter';
                    var txt = centerConfig.text || '';
                    var color = centerConfig.color || '#000000';
                    var maxFontSize = centerConfig.maxFontSize || 75;
                    var sidePadding = centerConfig.sidePadding || 10;
                    var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2);

                    // Check for screen width to adjust font size based on the window size
                    var fontSizeToUse = window.innerWidth < 500 ? 25 : 50; // If the screen width < 500px, use 25px font size

                    // Set the text properties
                    ctx.font = "bold " + fontSizeToUse + "px " + fontStyle;
                    ctx.fillStyle = color;

                    // Calculate text position
                    var stringWidth = ctx.measureText(txt).width;
                    var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                    var widthRatio = elementWidth / stringWidth;
                    var newFontSize = Math.floor(maxFontSize * widthRatio);
                    var elementHeight = (chart.innerRadius * 2);
                    var finalFontSize = Math.min(newFontSize, elementHeight, maxFontSize);

                    // Calculate the center position
                    var centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                    var centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                    // Apply horizontal offset to move the text slightly to the right (for #chart-line1 only)
                    // Apply horizontal offset to move the text slightly to the right (for #chart-line1 only)
                    if (chart.canvas.id === 'chart-line1') {
                        // Set horizontalOffset to 0 if the screen width is less than 500px, otherwise set it to 20
                        var horizontalOffset = window.innerWidth < 500 ? 0 : 20; // Adjust this value to control the shift (in pixels)
                        centerX += horizontalOffset; // Move centerX to the right
                    }

                    // Draw the text
                    ctx.font = finalFontSize + "px " + fontStyle;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(txt, centerX, centerY);
                }
            }
        });

        // Initialize your chart here


        var flag_compare = "<?php echo isset($_GET["filter"]) ? $_GET['filter'] : ""; ?>";
        var promotor = "<?php echo count($getdashData['promoters']); ?>";
        var passives = "<?php echo count($getdashData['passives']); ?>";
        var detractors = "<?php echo count($getdashData['detractors']); ?>";


        // console.log("promotor", promotor);
        // console.log("passives", passives);
        // console.log("detractors", detractors);
        var getsurveyresponse = "<?php echo $getdashData['getsurveyresponse']; ?>";
        var totalresponse = "<?php echo $getdashData['totalresponse']; ?>";
        var notResponded = totalresponse - getsurveyresponse;

        //progress bar calculation

        var promoters_percent = 0;
        var passives_percent = 0;
        var detractors_percent = 0;
        var response_percent = 0;
        var totalSent_percent = 0;
        if (getsurveyresponse > 0) {
            promoters_percent = Math.round((promotor / getsurveyresponse) * 100);
            passives_percent = Math.round((passives / getsurveyresponse) * 100);
            detractors_percent = Math.round((detractors / getsurveyresponse) * 100);
            response_percent = totalresponse > 0 ? Math.round((getsurveyresponse / totalresponse) * 100) : 100;
        }
        totalSent_percent = totalresponse > 0 ? 100 : 0;
        const progress_bar_percents = [promoters_percent, passives_percent, detractors_percent, response_percent, totalSent_percent];

        const myNodelist = document.querySelectorAll(".progress-bar");

        // console.log("progress_bar_percents",progress_bar_percents);
        // console.log("myNodelist",myNodelist)
        for (let i = 0; i < myNodelist.length; i++) {
            myNodelist[i].style.width = progress_bar_percents[i] + "%";
        }

        // second text value for NPS Score
        var totalNPS = parseInt(promotor) + parseInt(passives) + parseInt(detractors);
        var nps_percentage = Math.round(((promotor - detractors) / totalNPS) * 100);
        //console.log("nps_percentage", nps_percentage);

        // Response Rate Chart details
        var Npsresponse = (totalresponse > 0) ? Math.round((getsurveyresponse / totalresponse) * 100) : Math.round((getsurveyresponse) * 100);

        var ratestatus, responsestatus = 0;
        var revenuestatus, RRestatus = '';
        var compare_ratio, totalrespreturn = '';
        if (flag_compare == 'yes') {
            // Revenue difference for 2 date option - Compare to option validation
            var c_promotor = "<?php echo (isset($getDatacomp['promoters']) ? count($getDatacomp['promoters']) : 0); ?>";
            var c_passives = "<?php echo (isset($getDatacomp['passives']) ? count($getDatacomp['passives']) : 0); ?>";
            var c_detractors = "<?php echo (isset($getDatacomp['detractors']) ? count($getDatacomp['detractors']) : 0); ?>";
            var c_getsurveyresponse = "<?php echo (isset($getDatacomp['getsurveyresponse']) ? $getDatacomp['getsurveyresponse'] : ""); ?>";
            var c_totalresponse = "<?php echo (isset($getDatacomp['totalresponse']) ? $getDatacomp['totalresponse'] : ""); ?>";
            var c_totalNPS = parseInt(c_promotor) + parseInt(c_passives) + parseInt(c_detractors);

            var c_totalDet = Math.round(((c_promotor - c_detractors) / c_totalNPS) * 100);
            totalNPS = (totalNPS > 0) ? totalNPS : 0;
            if (totalNPS > c_totalNPS) {
                ratestatus = parseInt(totalNPS) - parseInt(c_totalNPS);
                revenuestatus = 'high';
            } else {
                ratestatus = parseInt(c_totalNPS) - parseInt(totalNPS);
                revenuestatus = 'low';
            }
            compare_ratio = Math.round((ratestatus / totalNPS) * 100);
            // Response Rate Data difference for 2 date option - Compare to option validation
            if (getsurveyresponse > c_getsurveyresponse) {
                responsestatus = parseInt(getsurveyresponse) - parseInt(c_getsurveyresponse);
                RRestatus = 'high';
            } else {
                responsestatus = parseInt(c_getsurveyresponse) - parseInt(getsurveyresponse);
                RRestatus = 'low';
            }
            totalrespreturn = (getsurveyresponse > 0) ? Math.round((responsestatus / getsurveyresponse) * 100) : 0;
            promotor = parseInt(promotor) + parseInt(c_promotor);
            passives = parseInt(passives) + parseInt(c_passives);
            detractors = parseInt(detractors) + parseInt(c_detractors);
            getsurveyresponse = parseInt(getsurveyresponse) + parseInt(c_getsurveyresponse);

        } else {
            compare_ratio = 0;
            revenuestatus = '';
            totalrespreturn = 0;
            RRestatus = '';
        }

        if (promotor == '0' && passives == '0' && detractors == '0') {
            var ctx = $("#chart-line");
            var myLineChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: ''
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                            position: 'bottom',
                        }
                    }
                }
            });
        }
        else {
            var ctx = document.getElementById('chart-line').getContext('2d');

            // Calculate NPS value
            nps_val = Number.isNaN(nps_percentage) ? 0 : nps_percentage;

            // Adjust the spacing based on the NPS value
            if (nps_val < 0 && nps_val > -99) {
                lspace_nps = '';
                rspace_nps = '';
            } else if (nps_val > 99 || (nps_val < 10 && nps_val > -1)) {
                lspace_nps = '';
                rspace_nps = '';
            } else {
                lspace_nps = '';
                rspace_nps = '';
            }

            // Determine cutout based on screen width
            var cutoutValue = window.innerWidth < 500 ? '62%' : '50%'; // Set cutout to 50% if width < 500px

            var myLineChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Promoters", "Passives", "Detractors"],
                    datasets: [{
                        data: [promotor, passives, detractors],
                        backgroundColor: ['#0A2472', '#0E6BA8', '#8ADCFF'],
                        borderRadius: 7,
                        borderWidth: 2,
                        borderColor: ['#FFF', '#FFF', '#FFF'],
                        spacing: 3, // Adds spacing between each segment
                    }]
                },
                options: {
                    maintainAspectRatio: false,  // Allows custom chart dimensions
                    responsive: true,
                    cutout: cutoutValue, // Use the dynamic cutout value here
                    title: {
                        display: true,
                        text: 'NET PROMOTER SCORE',
                        fontColor: '#000',
                        fontSize: 20,
                        fontFamily: 'Inter, sans-serif'
                    },
                    plugins: {
                        legend: {
                            display: true, // Show legend
                            position: 'bottom', // Legend at the bottom of the chart
                            labels: {
                                padding: 30, // Adds padding around the legend
                                boxWidth: 50, // Width of the legend rectangle
                                boxHeight: 15, // Height of the legend rectangle
                                borderRadius: 100, // Makes legend labels rounded (rectangular with rounded corners)
                            }
                        },
                    },
                    elements: {
                        center: {
                            text: nps_val,  // Display NPS value in the center
                            text2: (Number.isNaN(compare_ratio) ? "0%" : compare_ratio + "%"),  // Second line
                            state: revenuestatus,
                            color: '#000',  // Text color
                            fontFamily: 'Inter',
                            sidePadding: 0,  // Adjust padding as needed
                            minFontSize: 40,
                            maxFontSize: 100,
                            textAlign: 'center',  // Horizontal text alignment
                            verticalAlign: 'middle'  // Center text vertically
                        }
                    }
                }
            });
        }

        if (totalresponse == '0' && getsurveyresponse == "0") {
            var ctx = $("#chart-line1");
            var myLineChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: ''
                },
                options: {
                    plugins: {
                        legend: {
                            display: false, // No legend when no data
                            position: 'bottom',
                        }
                    }
                }
            });
        } else {
            var ctx = $("#chart-line1");
            nps_res = 100; // Example value; replace with your dynamic value

            // Handling spaces based on nps_res value
            if (nps_res > 9) {
                lspace_nps = '';
                rspace_nps = '';
            } else {
                lspace_nps = ' ';
                rspace_nps = '';
            }

            // Determine cutout based on screen width
            var cutoutValue = window.innerWidth < 500 ? '62%' : '50%'; // Set cutout to 50% if width < 500px

            // Donut Chart with central text and legend at the bottom
            var myLineChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Responded", "Not Responded"],
                    datasets: [{
                        data: [getsurveyresponse, notResponded],
                        backgroundColor: ['#0A2472', '#9D9D9D'],
                        borderRadius: 7, // Set the radius of each doughnut segment
                        borderWidth: 2,
                        borderColor: ['#FFF', '#FFF'],
                        spacing: 3, // Adds spacing between each segment
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: '',
                        fontColor: '#000',
                        fontSize: 40,
                        fontStyle: 'normal',
                        fontWeight: '800',
                        fontFamily: 'Inter'
                    },
                    cutout: cutoutValue, // Updated from cutoutPercentage (for v4+)
                    plugins: {
                        legend: {
                            display: true, // Show legend
                            position: 'bottom', // Legend at the bottom of the chart
                            labels: {
                                padding: 30, // Adds padding around the legend
                                boxWidth: 50, // Width of the legend rectangle
                                boxHeight: 15, // Height of the legend rectangle
                                borderRadius: 100, // Makes legend labels rounded (rectangular with rounded corners)
                            }
                        },
                        centerTextPlugin: true // Add custom center text plugin
                    },
                    responsive: true,
                    elements: {
                        center: {
                            text: lspace_nps + nps_res + "%\n", // Central text value
                            text2: totalrespreturn + "%", // Optional second line text
                            state: RRestatus,
                            color: '#000', // Text color
                            fontStyle: 'Inter',
                            padding: 0,
                            minFontSize: 40,
                            maxFontSize: 100,
                            lineHeight: 1.7,
                            textAlign: 'center', // Horizontal alignment
                            verticalAlign: 'middle' // Vertical alignment
                        }
                    }
                }
            });
        }

    });
    var flag_compare = "<?php echo isset($_GET["filter"]) ? $_GET['filter'] : ""; ?>";
    var linelabel = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    if (flag_compare == 'yes') {
        var barchartData = ["<?php echo (isset($getdashData['getfullResponse'][0]) ? $getdashData['getfullResponse'][0] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][1]) ? $getdashData['getfullResponse'][1] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][2]) ? $getdashData['getfullResponse'][2] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][3]) ? $getdashData['getfullResponse'][3] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][4]) ? $getdashData['getfullResponse'][4] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][5]) ? $getdashData['getfullResponse'][5] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][6]) ? $getdashData['getfullResponse'][6] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][7]) ? $getdashData['getfullResponse'][7] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][8]) ? $getdashData['getfullResponse'][8] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][9]) ? $getdashData['getfullResponse'][9] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][10]) ? $getdashData['getfullResponse'][10] : ''); ?>"
        ];

        var barDataPrevious = ["<?php echo (isset($getDatacomp['getfullResponse'][0]) ? $getDatacomp['getfullResponse'][0] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][1]) ? $getDatacomp['getfullResponse'][1] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][2]) ? $getDatacomp['getfullResponse'][2] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][3]) ? $getDatacomp['getfullResponse'][3] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][4]) ? $getDatacomp['getfullResponse'][4] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][5]) ? $getDatacomp['getfullResponse'][5] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][6]) ? $getDatacomp['getfullResponse'][6] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][7]) ? $getDatacomp['getfullResponse'][7] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][8]) ? $getDatacomp['getfullResponse'][8] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][9]) ? $getDatacomp['getfullResponse'][9] : ''); ?>",
            "<?php echo (isset($getDatacomp['getfullResponse'][10]) ? $getDatacomp['getfullResponse'][10] : ''); ?>"
        ];

        var barData = {
            labels: linelabel,

            datasets: [{
                label: "NPS Customer Response",
                data: barchartData,
                backgroundColor: '#0a2472',
                borderRadius: {
                    topLeft: 10,
                    topRight: 10,
                    bottomLeft: 0,
                    bottomRight: 0
                }, // Apply radius only to the top
                borderSkipped: 'bottom', // Only apply the radius at the top
            },
            {
                label: "NPS- Compare response",
                data: barDataPrevious,
                backgroundColor: '#0e6ba8',
                borderRadius: {
                    topLeft: 5,
                    topRight: 5,
                    bottomLeft: 0,
                    bottomRight: 0
                }, // Apply radius only to the top
                borderSkipped: 'bottom', // Only apply the radius at the top
            }
            ],
        }



    } else {
        var barchartData = ["<?php echo (isset($getdashData['getfullResponse'][0]) ? $getdashData['getfullResponse'][0] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][1]) ? $getdashData['getfullResponse'][1] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][2]) ? $getdashData['getfullResponse'][2] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][3]) ? $getdashData['getfullResponse'][3] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][4]) ? $getdashData['getfullResponse'][4] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][5]) ? $getdashData['getfullResponse'][5] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][6]) ? $getdashData['getfullResponse'][6] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][7]) ? $getdashData['getfullResponse'][7] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][8]) ? $getdashData['getfullResponse'][8] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][9]) ? $getdashData['getfullResponse'][9] : ''); ?>",
            "<?php echo (isset($getdashData['getfullResponse'][10]) ? $getdashData['getfullResponse'][10] : ''); ?>"
        ];
        var barData = {
            labels: linelabel,
            datasets: [{
                label: "NPS Customer Response",
                data: barchartData,
                backgroundColor: ['#8ADCFF', '#8ADCFF', '#8ADCFF', '#8ADCFF', '#8ADCFF', '#8ADCFF', '#8ADCFF', '#0E6BA8', '#0E6BA8', '#0A2472', '#0A2472'],
                borderWidth: 0,
                borderRadius: {
                    topLeft: 5,
                    topRight: 5,
                    bottomLeft: 0,
                    bottomRight: 0
                }, // Apply radius only to the top
                borderSkipped: 'bottom', // Only apply the radius at the top
            }]
        };
    }
    var chartOptions = {
        responsive: true,
        plugins: { // Nest the legend and title under plugins
            legend: {
                display: false, // Hide the legend
                position: 'bottom', // Optional position if you later want to display the legend
            },
            title: {
                display: false, // Hide the title
                text: "Chart.js Bar Chart"
            }
        },
        scales: {
            x: {
                grid: {
                    display: false // Remove the grid lines
                },
                ticks: {
                    beginAtZero: true
                }
            },
            y: {
                grid: {
                    display: false // Remove the grid lines
                },
                ticks: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    };

    // Chart creation
    var chrt = document.getElementById("chartId").getContext("2d");
    var chrt = $('#chartId');

    chrt.height(300);
    var chartId = new Chart(chrt, {
        type: 'bar',
        data: barData,
        options: chartOptions, // Use the updated options with legend hidden
    });

</script>
<script>
    Chart.plugins.register({
        afterDraw: function (chart) {
            var ctx = chart.chart.ctx;
            var sum = 0;
            chart.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                    sum += dataset.data[i];
                }
            });
            var centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
            var centerY = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;

            chart.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                    var startAngle = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model.startAngle;
                    var endAngle = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model.endAngle;
                    var midAngle = startAngle + (endAngle - startAngle) / 2;

                    var xOffset = (0.6 * chart.outerRadius) * Math.cos(midAngle);
                    var yOffset = (0.6 * chart.outerRadius) * Math.sin(midAngle);

                    ctx.fillStyle = '#000';
                    var value = dataset.data[i];
                    var percentage = Math.round(value / sum * 100) + '%';
                    ctx.fillText(percentage, centerX + xOffset, centerY + yOffset);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>