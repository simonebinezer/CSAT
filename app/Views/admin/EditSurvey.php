<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>

<section class="home">

  <div class="container">
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->

    <h2 class="crt-survey-h2 dash">Edit Campaign</h2>
    <div class="crt-survey">
      <form id="surveyForm" class="form-horizontal" action="<?= base_url('editsurvey') ?>/<?php echo $surveyData["campaign_id"] ?>" method="post">
        <div class="form-group">
          <div class="q-base-1">
            <h3>Main Question:</h3>
            <p>This will ask respondents to rate their likelihood of recommending your product or service on a scale
              from 0 to 10. Based on their response, they will be categorized as a promoter (Score 9-10), Passive (Score
              7-8), or Detractor (Score 0-6).</p>
          </div>
          <div class="campaign">
            <label style="">Please enter a title for the survey</label>
            <input id="campaign_name" name="campaign_name" type="text" placeholder="Campaign Name" />
            <div style="color: red;font-size: 12px; display:none;" id="InvalidCampaign_name"></div>
          </div>
          <div class="d-flex Question">
            <label></label> &nbsp; <label style=""><?php echo  $getQuestData[0]['question_name'] ?></label>
          </div>
          <div class="campaign">
            <label style="">Please enter the Company/Product/Service Name</label>
            <input id="placeholder_name" name="placeholder_name" type="text" placeholder="Company/Product/Service Name" />
            <div style="color: red;font-size: 12px; display:none;" id="InvalidPlaceholder_name"></div>
          </div>
        </div>

        <div class="q-base">
          <h3>Follow - Up Question:</h3>
          <p>For the second question, you have the opportunity to gather more detailed feedback. This question will vary depending on the respondent's Score to the first question, allowing you to tailor the follow-up based on their level of satisfaction.</p>
        </div>
        <div class="q-base">
          <h4>Promoters :</h4>
        </div>
        <div class="que-glad">
          <label><?php echo  $getQuestData[1]['question_name'] ?></label><br />
          <div class="input-btn">
            <div class="dropdown">
              <input type="text" readonly id="drpdwn-button-1" autocomplete="off" placeholder="Please Choose from the list" class="dropdown-button form-select-1" />
              <div style="color: red;font-size: 12px; display:none;" id="errorQuestion2"></div>
              <div class="dropdown-content-1">
                <div class="drp-down-ans t_answer2">
                  <?php foreach ($answerList[0] as $answer) { ?>
                    <label id="<?php echo stripslashes($answer['answer_id']); ?>c1" class="checkbox-item"><input type="checkbox" name="ans_2[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                      <div class="ed-de-an">
                        <?php if ($tenantData['tenant_id'] == 1) { ?>
                          <a href="#" class="edit-del-Answer" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',1)">
                            <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                          </a>
                          <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,1)">
                            <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                          </a>
                        <?php } ?>
                      </div>
                    </label>
                  <?php } ?>
                </div>
                <?php if ($tenantData['tenant_id'] > 1 && count($answerList) > 1) { ?>
                  <div class="drp-custom-ans">
                    <h4 class="drp-custom-ans-h4">Custom Answer</h4>
                    <div class="drp-down-ans c_answer2">
                    <button type="button" onclick="AddPrevAnswers(1)" id="AddPrevAnswers1"><span class="glyphicon glyphicon-plus">Add previous survey answers</span></button>
                      <?php foreach ($answerList[1][0] as $answer) { ?>
                        <label id="<?php echo stripslashes($answer['answer_id']); ?>c1" class="checkbox-item"><input type="checkbox" name="ans_2[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                          <div class="ed-de-an">
                            <a href="#" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',1)" class="edit-del-Answer">
                              <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                            </a>
                            <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,1)">
                              <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                            </a>
                          </div>
                        </label>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="showButton(1)" id="showButton1">Add Your +</button>
          </div>
          <div class="hidden-div" id="myDiv1" style="display:none">
            <div class="ans-up">
              <label>Add Custom Answers :</label>
              <div>
                <input id="c_answer1" type="text" placeholder="Please enter the answer" />
                <button class="updateButton" onclick="addAnswer(document.getElementById('c_answer1').value,1,2)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="errorAnswer1"></div>
              </div>
            </div>
          </div>
          <div class="hidden-div" id="editDiv1">
            <div class="ans-up">
              <label>Edit Custom Answer :</label>
              <div>
                <input type="hidden" id="e_id1" value="" />
                <input id="e_answer1" type="text" />
                <button class="updateButton" onclick="editAnswer1(document.getElementById('e_id1').value,document.getElementById('e_answer1').value,1)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="editErrorAnswer1"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="q-base-2">
          <h4>Passives :</h4>
        </div>
        <div class="que-glad">
          <label><?php echo  $getQuestData[2]['question_name'] ?></label><br />
          <div class="input-btn">

            <div class="dropdown">
              <input type="text" readonly id="drpdwn-button-2" autocomplete="off" placeholder="Please Choose from the list" class="dropdown-button-2 form-select-1" />
              <div style="color: red;font-size: 12px; display:none;" id="errorQuestion3"></div>
              <div class="dropdown-content-2 ">
                <div class="drp-down-ans t_answer3">
                  <?php foreach ($answerList[0] as $answer) { ?>
                    <label id="<?php echo stripslashes($answer['answer_id']); ?>c2" class="checkbox-item"><input type="checkbox" name="ans_3[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                      <div class="ed-de-an">
                        <?php if ($tenantData['tenant_id'] == 1) { ?>
                          <a href="#" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',2)" class="edit-del-Answer">
                            <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                          </a>
                          <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,2)">
                            <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                          </a>
                        <?php } ?>
                      </div>
                    </label>
                  <?php } ?>
                </div>
                <?php if ($tenantData['tenant_id'] > 1 && count($answerList) > 1) { ?>
                  <div class="drp-custom-ans">
                    <h4 class="drp-custom-ans-h4">Custom Answer</h4>
                    <div class="drp-down-ans c_answer3">
                    <button type="button" onclick="AddPrevAnswers(2)" id="AddPrevAnswers2"><span class="glyphicon glyphicon-plus">Add previous survey answers</span></button>
                      <?php foreach ($answerList[1][1] as $answer) { ?>
                        <label id="<?php echo stripslashes($answer['answer_id']); ?>c2" class="checkbox-item"><input type="checkbox" name="ans_3[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                          <div class="ed-de-an">
                            <a href="#" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',2)" class="edit-del-Answer">
                              <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                            </a>
                            <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,2)">
                              <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                            </a>
                          </div>
                        </label>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <button type="button" class="btn btn-primary"onclick="showButton(2)" id="showButton2">Add Your +</button>
          </div>
          <div class="hidden-div" id="myDiv2" style="display:none">
            <div class="ans-up">
              <label>Add Custom Answers :</label>
              <div>
                <input id="c_answer2" type="text" placeholder="Please enter the answer" />
                <button class="updateButton" onclick="addAnswer(document.getElementById('c_answer2').value,2,3)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="errorAnswer2"></div>
              </div>
            </div>
          </div>
          <div class="hidden-div" id="editDiv2">
            <div class="ans-up">
              <label>Edit Custom Answer :</label>
              <div>
                <input type="hidden" id="e_id2" value="" />
                <input id="e_answer2" type="text" />
                <button class="updateButton" onclick="editAnswer1(document.getElementById('e_id2').value,document.getElementById('e_answer2').value,2)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="editErrorAnswer2"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="q-base-3">
          <h4>Detractors :</h4>
        </div>
        <div class="que-glad">
          <label><?php echo  $getQuestData[3]['question_name'] ?></label><br />
          <div class="input-btn">

            <div class="dropdown">
              <input type="text" readonly id="drpdwn-button-3" autocomplete="off" placeholder="Please Choose from the list" class="dropdown-button-3 form-select-1" />
              <div style="color: red;font-size: 12px; display:none;" id="errorQuestion4"></div>
              <div class="dropdown-content-3 ">
                <div class="drp-down-ans t_answer4">
                  <?php foreach ($answerList[0] as $answer) { ?>
                    <label id="<?php echo stripslashes($answer['answer_id']); ?>c3" class="checkbox-item"><input type="checkbox" name="ans_4[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                      <div class="ed-de-an">
                        <?php if ($tenantData['tenant_id'] == 1) { ?>
                          <a href="#" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',3)" class="edit-del-Answer">
                            <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                          </a>
                          <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,3)">
                            <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                          </a>
                        <?php } ?>
                      </div>
                    </label>
                  <?php } ?>
                </div>
                <?php if ($tenantData['tenant_id'] > 1 && count($answerList) > 1) { ?>
                  <div class="drp-custom-ans" id="">
                    <h4 class="drp-custom-ans-h4">Custom Answer</h4>
                    <div class="drp-down-ans c_answer4">
                    <button type="button" onclick="AddPrevAnswers(3)" id="AddPrevAnswers3"><span class="glyphicon glyphicon-plus">Add previous survey answers</span></button>
                      <?php foreach ($answerList[1][2] as $answer) { ?>
                        <label id="<?php echo stripslashes($answer['answer_id']); ?>c3" class="checkbox-item"><input type="checkbox" name="ans_4[]" value="<?php echo stripslashes($answer['answer_id']); ?>"> <?php echo stripslashes($answer['answer_name']); ?>
                          <div class="ed-de-an">
                            <a href="#" onclick="editAnswer(<?php echo stripslashes($answer['answer_id']); ?>,'<?php echo stripslashes($answer['answer_name']); ?>',3)" class="edit-del-Answer">
                              <img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid">
                            </a>
                            <a href="#" class="edit-del-Answer" onclick="alertModal(<?php echo stripslashes($answer['answer_id']); ?>,3)">
                              <img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid">
                            </a>
                          </div>
                        </label>
                      <?php } ?>
                      
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="showButton(3)"id="showButton3">Add Your +</button>
          </div>
          <div class="hidden-div" id="myDiv3" style="display:none">
            <div class="ans-up">
              <label>Add Custom Answers :</label>
              <div>
                <input id="c_answer3" type="text" placeholder="Please enter the answer" />
                <button class="updateButton" onclick="addAnswer(document.getElementById('c_answer3').value,3,4)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="errorAnswer3"></div>
              </div>
            </div>
          </div>
          <div class="hidden-div" id="editDiv3">
            <div class="ans-up">
              <label>Edit Custom Answer :</label>
              <div>
                <input type="hidden" id="e_id3" value="" />
                <input id="e_answer3" type="text" />
                <button class="updateButton" onclick="editAnswer1(document.getElementById('e_id3').value,document.getElementById('e_answer3').value,3)" type="button">Update</button>
                <div style="color: red;font-size: 12px; display:none;" id="editErrorAnswer3"></div>
              </div>
            </div>
          </div>

        </div>


        <div class="form-group" style="border-top: 2px solid #ebf3fc;margin: 50px 0px;">
          <div class=" mt-5 mb-5">
            <input type="submit" name="submit" id="submit" class="btn btn-default btn-block " style="background-color:#092c4c;color: white;float:right" value="Save" />
          </div>
        </div>
      </form>
    </div>
    <style>

    </style>
    <div class="modal fade" id="DeleteModal">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="padding:15px 50px;">
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            <h4> Delete Answer</h4>
          </div>
          <form action="<?= base_url('DeleteCustomer') ?>" method="post">
            <div class="modal-body" style="padding:40px 50px 20px;">
              <p> Are you sure you want to remove the answer from the answer list?</p>
              <div class="form-group">
                <input type="hidden" class="form-control" id="Id" name="Id" value="<?php echo set_value('E_Id'); ?>" placeholder="Enter Contact">
              </div>
              <br />
              <div class="d-grid">
                <button type="button" id="DeleteConfirm" class="btn btn-danger  pull-right" data-bs-dismiss="modal"><span class="fa fa-trash"></span> Confirm</button>
                <button type="button" id="DeleteCancel" class="btn btn-outline-secondary  pull-left" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
              </div>
            </div>
          </form>


        </div>
      </div>
    </div>

  </div>
</section>
<script>
  // JavaScript to show/hide the dropdown content when the button is clicked
  const dropdownButton = document.querySelector('.dropdown-button');
  const dropdownContent = document.querySelector('.dropdown-content-1');

  dropdownButton.addEventListener('click', function() {
    if (dropdownContent.style.display === 'block') {
      dropdownContent.style.display = 'none';
    } else {
      dropdownContent.style.display = 'block';
    }
  });
</script>
<script>
  // JavaScript to show/hide the dropdown content when the button is clicked
  const dropdownButton2 = document.querySelector('.dropdown-button-2');
  const dropdownContent2 = document.querySelector('.dropdown-content-2');

  dropdownButton2.addEventListener('click', function() {
    if (dropdownContent2.style.display === 'block') {
      dropdownContent2.style.display = 'none';
    } else {
      dropdownContent2.style.display = 'block';
    }
  });
</script>
<script>
  /* Anything that gets to the document
   will hide the dropdown */
  $(document).click(function() {
    $(".dropdown-content-1").hide();
    $(".dropdown-content-2").hide();
    $(".dropdown-content-3").hide();
  });

  /* Clicks within the dropdown won't make
     it past the dropdown itself */
  $(".dropdown-button").click(function(e) {
    e.stopPropagation();
  });
  $(".dropdown-content-1").click(function(e) {
    e.stopPropagation();
  });
  $(".dropdown-button-2").click(function(e) {
    e.stopPropagation();
  });
  $(".dropdown-content-2").click(function(e) {
    e.stopPropagation();
  });
  $(".dropdown-button-3").click(function(e) {
    e.stopPropagation();
  });
  $(".dropdown-content-3").click(function(e) {
    e.stopPropagation();
  });
  const dropdownButton3 = document.querySelector('.dropdown-button-3');
  const dropdownContent3 = document.querySelector('.dropdown-content-3');

  dropdownButton3.addEventListener('click', function() {
    if (dropdownContent3.style.display === 'block') {
      dropdownContent3.style.display = 'none';
    } else {
      dropdownContent3.style.display = 'block';
    }
  });
</script>
<script>
 
//show add button logic
  function showButton(div_id) {
    const addAnswerDiv_Id = document.getElementById('myDiv' + div_id);
    const input_Id = document.getElementById('c_answer' + div_id);
    if (addAnswerDiv_Id.style.display === 'none') {
      addAnswerDiv_Id.style.display = 'block'; // Show the div
      input_Id.value = "";
      var errorId = "errorAnswer" + div_id;
      $('#' + errorId).html("");
    } else {
      addAnswerDiv_Id.style.display = 'none'; // Hide the div
    }
  }

  //ADD ANSWER
  function addAnswer(ans, div_id, questionId) {
    console.log("Addentry");
    console.log("t:", ans);
    var errorId = "errorAnswer" + div_id;
    $('#' + errorId).html("");

    $.ajax({
      url: '<?php echo base_url('createAnswer1'); ?>',
      type: 'post',
      dataType: 'json',
      data: {
        answer_name: ans,
        question_Id: questionId,
      },
      success: function(response) {
        console.log(response);
        console.log(response.data);
        if (response.success) {
          console.log(response.data);
          $.each(response.data, function(key, value) {
            var t_id = <?php echo $tenantData['tenant_id'] ?>;
            console.log("t_id", t_id);
            if (t_id == 1) {
              console.log("tenantentryl");
              var className = "t_answer" + questionId;
              $('.' + className).append('<label id="' + key + 'c' + div_id + '"class="checkbox-item"><input type="checkbox" name="ans_' + questionId + '[]" value="' + key + '"> ' + value + ' <div class="ed-de-an"><a href="#"  onclick="editAnswer(' + key + ',\'' + value + '\',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid"></a><a href="#" onclick="alertModal(' + key + ',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid"></a> </div></label>');
            } else {
              console.log("entryl");
              var className = "c_answer" + questionId;
              $('.' + className).append('<label id="' + key + 'c' + div_id + '"class="checkbox-item"><input type="checkbox" name="ans_' + questionId + '[]" value="' + key + '"> ' + value + ' <div class="ed-de-an"><a href="#"  onclick="editAnswer(' + key + ',\'' + value + '\',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid"></a><a href="#" onclick="alertModal(' + key + ',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid"></a> </div></label>');

            }
          });
          window.alert("Answer added successfully");
          var element_id = "myDiv" + div_id;
          console.log("element_id", element_id);
          const addbox = document.getElementById(element_id);
          var addBox_input = "c_answer" + div_id;
          console.log("addBox_input", addBox_input);
          document.getElementById(addBox_input).value = "";
          addbox.style.display = 'none';
        } else {
          var errorMessage = response.data;
          console.log("errorMessage", errorMessage);

          console.log("err", errorId);
          $('#' + errorId).show();
          $('#' + errorId).html(errorMessage);
        }
      },
      error: function(response) {
        console.log(response);
      }
    });
  }


  //DELETE ANSWER
  function alertModal(ans_id, div_id) {
    var flag = false;
    console.log("entry");
    var deleteConfirm1 = document.getElementById('DeleteConfirm');
    $('#DeleteModal').modal('show');
    console.log("entry", deleteConfirm1);
    flag = true;
    var deleteConfirm = document.getElementById('DeleteConfirm');
    deleteConfirm.setAttribute('onclick', 'deleteAnswer(' + ans_id + ',' + div_id + ')');
    console.log("entry", deleteConfirm);


  }
  var global_count_1 = 0;
  var global_count_2 = 0;
  var global_count_3 = 0;
  const global_count_array = [global_count_1, global_count_2, global_count_3];
  
  function deleteAnswer(ans, div_id) {
    // console.log("deleteentry");
    // console.log("t:", ans);
    // console.log("divid", div_id);

    $.ajax({
      url: '<?php echo base_url('deleteAnswer1'); ?>',
      type: 'post',
      dataType: 'json',
      data: {
        ans
      },
      success: function(response) {
        console.log(response);
        if (response.success) {

          //console.log("deleteEntry1");
          var id = ans + "c" + div_id;
          p_element = document.getElementById(id);
          c_element = p_element.firstElementChild;
          console.log(c_element);
          var checked = false;
          if (c_element.checked) {
            checked = true;
          }
          p_element.remove();
          if (checked) {
            var drpdwn_buttonId = "drpdwn-button-" + div_id;

            global_count_array[div_id - 1] -= 1;
            changedvalue = global_count_array[div_id - 1];
            setValue(drpdwn_buttonId, changedvalue)

          }
        }
      },
      error: function(response) {
        console.log(response);
      }
    });
  };


  //EDIT ANSWER
  function editAnswer(ans, value, id) {
    console.log("editentry");
    console.log("id:", ans);
    console.log("value:", value);
    var class_id = ".dropdown-content-" + id;
    console.log("class_id", class_id);
    const dropdown = document.querySelector(class_id);
    dropdown.style.display = 'none';

    var element_id = "editDiv" + id;
    console.log("element_id", element_id);
    const editbox = document.getElementById(element_id);
    editbox.style.display = 'block';

    var editBox_input1 = "e_id" + id;
    console.log("editBox_input1", editBox_input1);
    document.getElementById(editBox_input1).value = ans;
    var editBox_input2 = "e_answer" + id;
    console.log("editBox_input2", editBox_input2);
    document.getElementById(editBox_input2).value = value;



  };

  function editAnswer1(ans, value, div_id) {
    console.log("editentry1");
    console.log("id:", ans);
    console.log("value:", value);
      $.ajax({
        url: '<?php echo base_url('editAnswer1'); ?>',
        type: 'post',
        dataType: 'json',
        data: {
          answer_id: ans,
          answer_name: value,
          question_Id: div_id + 1
        },
        success: function(response) {
          console.log(response);
          if (response.success) {

            console.log("editsuccess");
            //for (let index = 1; index <= 3; index++) {
            var id = ans + "c" + div_id;

            var ansArrayNameId = div_id + 1;
            //console.log("ansArrayNameId", ansArrayNameId);
            document.getElementById(id).innerHTML = ('<input type="checkbox" name="ans_' + ansArrayNameId + '[]" value="' + ans + '"> ' + value + ' <div class="ed-de-an"><a href="#" id="e' + div_id + '" onclick="editAnswer(' + ans + ',\'' + value + '\',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid"></a><a href="#" onclick="alertModal(' + ans + ',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid"></a></div>');
            //console.log("ans_id:", id);
            // }
            window.alert("Answer edited successfully");
            var element_id = "editDiv" + div_id;
            console.log("element_id", element_id);
            const editbox = document.getElementById(element_id);
            editbox.style.display = 'none';
          } else {
            var errorMessage = response.data;
            console.log("errorMessage", errorMessage);
            var errorId = "editErrorAnswer" + div_id;
            console.log("err", errorId);
            $('#' + errorId).show();
            $('#' + errorId).html(errorMessage);
          }
        },
        error: function(response) {
          console.log(response);
        }

      });
    }



  // NUMBER OF OPTIONS SELECTED SCRIPT
  $(document).on("change", "input[name='ans_2[]']", function() {

    global_count_array[0] += this.checked ? 1 : -1;
    //console.log(global_count_array[0]);
    setValue('drpdwn-button-1', global_count_array[0])
  });
  $(document).on("change", "input[name='ans_3[]']", function() {

    global_count_array[1] += this.checked ? 1 : -1;
    //console.log(global_count_array[1]);
    setValue('drpdwn-button-2', global_count_array[1])
  });
  $(document).on("change", "input[name='ans_4[]']", function() {

    global_count_array[2] += this.checked ? 1 : -1;

    //console.log(global_count_array[2]);
    setValue('drpdwn-button-3', global_count_array[2])

  });

  function setValue(buttonId, value) {
    dpbutton = document.getElementById(buttonId);
    dpbutton.value = value > 0 ? "Total options selected: " + value : 'Please Choose from the list';
  }
</script>

<script>
  //Edit survey map values
  $(document).ready(function() {

    var surveydata = (<?php echo json_encode($surveyData); ?>);
    console.log(surveydata);
    console.log(surveydata.campaign_id);
    var campaign_id = surveydata.campaign_id;
    var campaign_name = surveydata.campaign_name;
    var placeholder_name = surveydata.placeholder_name;
    var answer_id_2 = surveydata.answer_id_2.split(",");
    var answer_id_3 = surveydata.answer_id_3.split(",");
    var answer_id_4 = surveydata.answer_id_4.split(",");
    $('#campaign_name').val(campaign_name);
    $('#placeholder_name').val(placeholder_name);
    console.log("2:", answer_id_2);
    console.log("3:", answer_id_3);
    console.log("4:", answer_id_4);

    var numberOfBoxChecked = 0;
    var buttonId = "drpdwn-button-";

    const ans_array = [answer_id_2, answer_id_3, answer_id_4]
    for (let i = 0; i < ans_array.length; i++) {
      const ans_group = ans_array[i];
      var div_id = i + 1;
      for (let j = 0; j < ans_group.length; j++) {
        const answer = ans_group[j];
        // console.log("answer", answer);
        // console.log("div_id", div_id);
        defaultCheck(answer, div_id);
      }
      setValue(buttonId + div_id, global_count_array[div_id - 1]);
    }

    function defaultCheck(answer_id, div_id) {
      // console.log(answer_id);
      var concate_Id = "c" + div_id;
      var id = answer_id + concate_Id;
      console.log(id)
      var p_element = document.getElementById(id);

      if (p_element != null) {
        //console.log(p_element);
        c_element = p_element.firstElementChild
        //console.log(c_element);
        $(c_element).prop('checked', true);
        global_count_array[div_id - 1] += 1;
      }
    }

  });

  function AddPrevAnswers(div_id) {
    var question_Id = div_id + 1;
    $.ajax({
      url: '<?php echo base_url('uploadPreviousAnswers'); ?>',
      type: 'post',
      dataType: 'json',
      data: {
        question_Id: question_Id
      },
      success: function(response) {
        console.log(response);
        if (response.success) {

          console.log("AddPrevAnswers");
          console.log(response.answerList);
          var className = "c_answer" + question_Id;
          $.each(response.answerList, function(key, value) {
            $('.' + className).append('<label id="' + key + 'c' + div_id + '"class="checkbox-item"><input type="checkbox" name="ans_' + question_Id + '[]" value="' + key + '"> ' + value + ' <div class="ed-de-an"><a href="#"  onclick="editAnswer(' + key + ',\'' + value + '\',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Edit.png" class="img-centered img-fluid"></a><a href="#" onclick="alertModal(' + key + ',' + div_id + ')"><img src="<?php echo base_url(); ?>images/icons/Trash.png" class="img-centered img-fluid"></a> </div></label>');
          });
          var id_name = "AddPrevAnswers" + div_id;
          console.log(id_name);
          //document.getElementById(id_name).style.visibility = 'hidden';
          $('#' + id_name).hide();
        } else {

        }
      },
      error: function(response) {
        console.log(response);
      }

    });
  }
</script>

<script>
  document.getElementById("surveyForm").addEventListener('submit', function(e) {

    var min = <?php echo $optionsCount[0] ?>;
    var max = <?php echo $optionsCount[1] ?>;
    //console.log("optionsCount:", optionsCount);
    var campaign_name = document.getElementById("campaign_name").value;
    //console.log(campaign_name);
    var placeholder_name = document.getElementById("placeholder_name").value;
    var errorMessage = "Please choose 5 to 7 options for this question";
    var ansArray1 = [];
    $("input:checkbox[name='ans_2[]']:checked").each(function() {
      ansArray1.push($(this).val());
    });
    var ansArray2 = [];
    $("input:checkbox[name='ans_3[]']:checked").each(function() {
      ansArray2.push($(this).val());
    });
    var ansArray3 = [];
    $("input:checkbox[name='ans_4[]']:checked").each(function() {
      ansArray3.push($(this).val());
    });
    $("#InvalidCampaign_name").hide();
    if (campaign_name.length < 2 || campaign_name.length > 200) {
      // console.log("campaign_name.length", campaign_name.length)
      $("#InvalidCampaign_name").show();
      $("#InvalidCampaign_name").html("Please give atleast 2 characters");
      e.preventDefault();
    }
    if (campaign_name.length < 2 || campaign_name.length > 200) {
      console.log("placeholder_name.length", placeholder_name.length)
      $("#InvalidPlaceholder_name").show();
      $("#InvalidPlaceholder_name").html("Please give atleast 2 characters");
      e.preventDefault();
    }
    $("#errorQuestion2").hide();
    if (ansArray1.length < min || ansArray1.length > max) {
      $("#errorQuestion2").show();
      $("#errorQuestion2").html(errorMessage);
      e.preventDefault();
    }
    $("#errorQuestion3").hide();

    if (ansArray2.length < min || ansArray2.length > max) {
      $("#errorQuestion3").show();
      $("#errorQuestion3").html(errorMessage);
      e.preventDefault();
    }
    $("#errorQuestion4").hide();

    if (ansArray3.length < min || ansArray3.length > max) {
      $("#errorQuestion4").show();
      $("#errorQuestion4").html(errorMessage);
      e.preventDefault();
    }

  });
</script>
<?= $this->endSection() ?>