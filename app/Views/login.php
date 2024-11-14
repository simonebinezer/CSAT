<?= $this->extend("layouts/app_before") ?>
<?= $this->section("body") ?>
<?php echo script_tag('js/jquery.min.js'); ?>

<div class="row m-3">
    <?php if (session()->getFlashdata('response') !== NULL) : ?>
        <p style="color:green; font-size:18px;" align="center">
            <?php echo session()->getFlashdata('response'); ?>
        </p>
    <?php endif; ?>

    <?php if (isset($validation)) : ?>
        <p style="color:red; font-size:18px;" align="center">
            <?= $validation->showError('validatecheck') ?>
        </p>
    <?php endif; ?>

    <div class="col-md-8 col-sm-12 col-xs-12">
        <!-- <img src="<?php echo base_url(); ?>images/login.png"  class="img-centered img-fluid" alt="login-image"> -->
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="tab-menus">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" id="anchor" href="#home" class="Login-title">Sign In<span></span></a></li>
                <li><a data-toggle="tab" href="#menu1" class="Login-title">Account creation<span></span></a></li>
                <!-- <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                <li><a data-toggle="tab" href="#menu3">Menu 3</a></li> -->
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane show fade in active">
                    <form id="sign_in" class="form-Centered sign-in" action="<?= base_url('login') ?>" method="post">
                        <!-- 
                    <h5 class="Login-title">Sign Up</h5> -->
                        <!-- <h6 class="Login-desc">Sign Up and start managing your candidates!</h6> -->
                        <div class="">
                            <label>Tenant Name<label>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control input-style" name="tenantname" id="tenantname" placeholder="Tenant Name" value="<?php echo set_value('tenantname'); ?>">
                            <p style="color:red" class="error" id="tenantname_error" type="hidden"></p>
                        </div>
                        <div class="">
                            <label>Email<label>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control input-style" name="email" placeholder="Email Address" id="email" value="<?php echo set_value('email'); ?>">
                            <p style="color:red" class="error" id="email_error" type="hidden"></p>
                        </div>
                        <div class="">
                            <label>Password<label>
                        </div>
                        <div class="">
                            <input type="password" class="form-control input-style" name="password" id="password" placeholder="Password">
                            <p style="color:red" class="error" id="password_error" type="hidden"></p>

                        </div>
                        <div class="form-check">
                            <!-- <input type="checkbox" class="form-check-input checkbox-style"> -->
                            <!-- <label class="form-check-label">Remember me</label> -->
                            <label class="form-check-label float-right"> <a class="d-block small mt-3 mb-3" href="<?php echo site_url('forget'); ?>">Forget Password</a></label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-style Centered">login</button><br>
                        <!-- <a class="btn btn-primary btn-style-2 Centered" href="<?php echo site_url('signup'); ?>">Sign up</a> -->
                    </form>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <form id="sign_up" class="sign-in" action="<?= base_url('signup') ?>" method="post">
                        <!-- <h5 class="Login-title">Sign Up</h5> -->
                        <div class="row mt-5 m-3">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control input-style" name="firstname" id="firstname" placeholder="First name" value="<?php echo set_value('firstname'); ?>">
                                    <p style="color:red" class="error" id="firstname_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control input-style" name="tenantname" id="tenantname" placeholder="Tenant name" value="<?php echo set_value('tenantname'); ?>">
                                    <p style="color:red" class="error" id="tenantname_N_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="email" placeholder="Email Address" class="form-control input-style" name="email" id="email" value="<?php echo set_value('email'); ?>">
                                    <p style="color:red" class="error" id="email_N_error"></p>
                                </div>
                              
                                
                                <div class="mb-3">
                                    <input type="password" class="form-control input-style" placeholder="Password" name="password" id="password">
                                    <p style="color:red" class="error" id="password_N_error"></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control input-style" name="lastname" id="lastname" placeholder="Last name" value="<?php echo set_value('lastname'); ?>">
                                    <p style="color:red" class="error" id="lastname_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control input-style" name="username" id="username" placeholder="User name" value="<?php echo set_value('username'); ?>">
                                    <p style="color:red" class="error" id="username_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="email" placeholder="Email Address to send survey" class="form-control input-style" name="survey_email" id="survey_email" value="support@cxanalytix.com" readonly>
                                    <p style="color:red" class="error" id="survey_email_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control input-style" name="phone_no" id="phone_no" placeholder="Phone No." value="<?php echo set_value('phone_no'); ?>">
                                    <p style="color:red" class="error" id="phone_no_error"></p>
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="Confirm Password" class="form-control input-style" name="confirmpassword" id="confirmpassword">
                                    <p style="color:red" class="error" id="confirmpassword_error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row m-3">
                            <button type="submit" class="btn btn-primary btn-style Centered mb-3">Submit</button>
                            <button type="button" class="btn  btn-style-2 Centered" onclick="clickEvent('anchor')">Back
                                to Login</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <div id='loader' style='display:none'>
        <img src="<?php echo base_url(); ?>images/Circles-menu-3.gif" />
    </div>


</div>

<script>
    $(document).ready(function() {


        //sign in form
        $("#sign_in").submit(function(event) {
            event.preventDefault();
            $('#loader').show();
            console.log("entry");
            var form = $(this);
            console.log(form.attr("id"));
            console.log(form.serialize());

            $.ajax({
                url: '<?php echo base_url('login'); ?>',
                type: 'post',
                dataType: 'json',
                data: form.serialize(),
                success: function(response) {
                    console.log(response);
                    console.log("successentry");
                    if (response.success) {
                        $('#loader').hide();
                        console.log("<?php echo base_url('admin'); ?>");
                        window.location.href = "<?php echo base_url('admin'); ?>";
                    } else {
                        $('#loader').hide();
                        console.log(response.error);
                        const idArray = ["tenantname", "email", "password"];
                        const errorArray = ["tenantname_error", "email_error", "password_error"];

                        errorDisplay(errorArray, idArray, response.error);

                    }
                },
                error: function(response) {
                    console.log(response);
                }

            });

        })

        //sign up form
        $("#sign_up").submit(function(event) {
            event.preventDefault();
            $('#loader').show();
            console.log("entry");
            var form = $(this);
            console.log(form.attr("id"));
            console.log(form.serialize());
            $.ajax({
                url: '<?php echo base_url('signup'); ?>',
                type: 'post',
                dataType: 'json',
                data: form.serialize(),
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        console.log("successentry");
                        $('#loader').hide();
                        clickEvent('anchor');
                        window.location.href = "<?php echo base_url(); ?>";
                    } else {
                        $('#loader').hide();
                        console.log(response.error);
                        const idArray = ["firstname", "tenantname", "email", "survey_email", "password", "lastname", "username", "phone_no", "confirmpassword"];
                        const errorArray = ["firstname_error", "tenantname_N_error", "email_N_error", "survey_email_error", "password_N_error", "lastname_error", "username_error", "phone_no_error", "confirmpassword_error"];

                        errorDisplay(errorArray, idArray, response.error);

                    }
                },
                error: function(response) {
                    console.log(response);
                }

            });

        })

        //show validation messages
        function errorDisplay(errorArray, idArray, messageArray) {
            for (let i = 0; i < idArray.length; i++) {
                console.log(idArray[i]);
                var element = document.getElementById(errorArray[i])
                if (idArray[i] in messageArray) {
                    console.log(errorArray[i]);
                    element.style.display = "block";
                    element.innerText = messageArray[idArray[i]];
                } else {
                    element.style.display = "none";
                }
            }
        }

        //remove errors on changing the tab.

        var elements = document.getElementsByClassName("Login-title");
        for (let index = 0; index < elements.length; index++) {

            const element = elements[index];
            element.addEventListener('click', function() {
                var errorElements = document.getElementsByClassName("error");
                for (let j = 0; j < errorElements.length; j++) {
                    errorElements[j].style.display = "none";
                }
            });
        }

    });



    function clickEvent(idname) {
        $('#' + idname).click();
    }
</script>



<?= $this->endSection() ?>