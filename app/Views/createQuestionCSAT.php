<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<section class="home" style="height: -webkit-fill-available">
    <div class="container">
        <!-- Page Content -->
        <div class="header">
            <h1>Create Question and Summary</h1>
        </div>

        <?php if (isset($validation)): ?>
            <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
        <?php endif; ?>
        <form class="form-horizontal" id="" action="<?= base_url('csat/addQuestion') ?>" method="post">
            <div id="dynamic_field">
                <div class="form-group  mb-3">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="question">Enter Question:</label>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="question" placeholder="Enter question"
                                name="question" autocomplete="off" value="<?php echo set_value('question'); ?>">
                            <?php if (isset($validation)): ?>
                                <div style="color:red"><?= $validation->showError('question') ?></div><?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="form-group  mb-3">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="q_info">Enter Question
                            Info:</label>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <input type="text" class="form-control" id="q_info" placeholder="Enter Question Info"
                                name="q_info" autocomplete="off" value="<?php echo set_value('q_info'); ?>">
                            <?php if (isset($validation)): ?>
                                <div style="color:red"><?= $validation->showError('q_info') ?></div><?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="form-group  mb-3">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="q_type">Select Question
                            Type:</label>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="custom-select form-select custom-select-sm"
                                class="custom-select custom-select-sm" aria-label="Default select example" id="q_type"
                                name="q_type">
                                <option value="" disabled selected>Select question type</option>
                                <option value="R">Main question
                                </option>
                                <option value="F">Follow up question
                                </option>
                            </select>
                            <?php if (isset($validation)): ?>
                                <div style="color:red"><?= $validation->showError('q_type') ?></div><?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group  mb-3" id="rating_div" style="display:none">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="q_rating">Select Rating :</label>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <select class="custom-select form-select custom-select-sm"
                                class="custom-select custom-select-sm" aria-label="Default select example" id="q_rating"
                                name="q_rating">
                                <option value="" disabled selected>Select rating</option>
                                <option value="1">1
                                </option>
                                <option value="2">2
                                </option>
                                <option value="3">3
                                </option>
                                <option value="4">4
                                </option>
                                <option value="5">5
                                </option>
                            </select>
                            <?php if (isset($validation)): ?>
                                <div style="color:red"><?= $validation->showError('q_rating') ?></div><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group  mt-3">
                    <div class="form-row">
                        <div class=" ">
                            <button type="submit" class="crt-que-sum-btn btn-block">Create</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
</section>
<script type="text/javascript">
    $("#q_type").on("change", function () {
        console.log("hi",);
        var q_type = $(this).val();
        if (q_type == "F") {
            $("#rating_div").show();
        }
        else {
            $("#rating_div").hide();
            $('#q_rating').val('');
        }
    })


    var q_type_element = $('#q_type');

    var options = q_type_element.children();
    var q_type = "<?= set_value("q_type") ?>";
    options.each(function (index, option) {
        if ($(option).val() == q_type)
            $(option).prop("selected", true);
    });

    var q_rating = "<?= set_value("q_rating") ?>";
    console.log("q_rating", q_rating);
    if ((q_rating != "0" && q_rating != "") || q_type == "F") {

        $("#rating_div").show();
    }
    var q_rating_element = $('#q_rating');

    var options = q_rating_element.children();
    options.each(function (index, option) {
        if ($(option).val() == q_rating)
            $(option).prop("selected", true);
    });

</script>

<?= $this->endSection() ?>