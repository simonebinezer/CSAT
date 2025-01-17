<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<section class="home">
    <div class="container"> <!-- Breadcrumbs-->
        <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?>
        <!-- Page Content -->
        <h1>Create Question and Summary</h1>
        <hr>
        <?php if (isset($validation)) : ?>
            <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
        <?php endif; ?>
        <?php
        $question_id = (!empty($getQuestData)) ?  $getQuestData['question_id'] : set_value('question_id');
        $question_name = (!empty($getQuestData)) ? stripslashes($getQuestData['question_name']) : set_value('question');
        $description = (!empty($getQuestData)) ?  stripslashes($getQuestData['description']) : set_value('qinfo');
        $info_details = (!empty($getQuestData)) ? $getQuestData['info_details'] :  set_value('answer');
        $other_option = (!empty($getQuestData) && $getQuestData['other_option']) ? json_decode($getQuestData['other_option']) : set_value('answerdata');
        $priority = (!empty($getQuestData) && $getQuestData['priority']) ? $getQuestData['priority'] : set_value('priority');
        ?>
        <form class="form-horizontal" action="<?= base_url('editquestion/' . $question_id) ?>" method="post">
            <input type="hidden" class="form-control" id="question_id" name="question_id" autocomplete="off" value="<?php echo $question_id; ?>">
            <div id="dynamic_field">
                <div class="form-group  mb-3">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="question">Enter Question:</label>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <input type="text" class="form-control" id="question" placeholder="Enter question" name="question" autocomplete="off" value="<?php echo $question_name; ?>">
                            <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('question') ?></div><?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="form-group  mb-3">
                    <div class="form-row row">
                        <label class="control-label col-xl-3 col-lg-3 col-md-3" for="qinfo">Enter Question Info:</label>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <input type="text" class="form-control" id="qinfo" placeholder="Enter Question Info" name="qinfo" autocomplete="off" value="<?php echo $description; ?>">
                            <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('qinfo') ?></div><?php endif; ?>

                        </div>
                    </div>

                </div>


            </div>


            <div class="form-group  mt-3">
                <div class="form-row row">
                    <div class="col-md-6 offset-4">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Submit" />
                    </div>
                </div>
            </div>
    </div>
    </form>

    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $("#answerother_open").hide();
        var otheroption = "<?php echo $info_details; ?>";
        console.log(otheroption);
        if (otheroption == 'other') {
            $("#answerother_open").show();
        } else {
            $("#answerother_open").hide();

        }
        $('#answer_data').change(function() {
            console.log($(this).val());

            if ($(this).val() == 'other') {
                $("#answerother_open").show();
            } else {
                $("#answerother_open").hide();
            }
        });
    });
</script>
<!-- <script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  
      $('#add').click(function(){  
           i++;             
           $('#dynamic_field').append('<div id="row'+i+'"><div class="form-group"><label class="control-label col-sm-2" for="question">Enter Question:</label><div class="col-sm-5"><input type="text" class="form-control"  placeholder="Enter question" name="question[]" autocomplete="off"></div></div><div class="form-group"><label class="control-label col-sm-2" for="qinfo">Enter Question Info:</label><div class="col-sm-5"><input type="text" class="form-control" id="qinfo" placeholder="Enter Question Info" name="qinfo[]" autocomplete="off"></div></div><div class="form-group"><label class="control-label col-sm-2" for="Answer">Select Answer:</label><div class="col-sm-5"><select class="custom-select custom-select-sm" aria-label="Default select example" class="form-select form-select-lg mb-3"  name="amswer[]" ><option value="nps">NPS Answer Type</option></select></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div>');

     });
     
     $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id"); 
           var res = confirm('Are You Sure You Want To Delete This?');
           if(res==true){
           $('#row'+button_id+'').remove();  
           $('#'+button_id+'').remove();  
           }
      });  
      if(i > 5) {
        console.log(i);
      }
  
    });  
</script>  -->
<?= $this->endSection() ?>