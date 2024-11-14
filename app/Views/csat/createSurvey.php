<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<?php echo script_tag('js/functions/Script.js'); ?>
<style>
	.checkbox-menu li label {
		display: block;
		padding: 3px 10px;
		clear: both;
		font-weight: normal;
		line-height: 1.42857143;
		color: #333;
		white-space: nowrap;
		margin: 0;
		transition: background-color .4s ease;
		padding: 10px ;
	}

	.checkbox-menu li input {
		margin: 0px 5px;
		top: 2px;
		position: relative;
		accent-color: #000;
	}

	.checkbox-menu li.active label {
    background-color: #ebf3fc;
    font-weight: bold;
    border-radius: 10px;
    padding: 10px;
	margin:10px 0px;
}
	.checkbox-menu li label:hover,
	.checkbox-menu li label:focus {
		background-color: #ebf3fc;
		border-radius: 10px;
		padding: 10px;
		margin:10px 0px;
	}

	.checkbox-menu li.active label:hover,
	.checkbox-menu li.active label:focus {
		background-color: #ebf3fc;
		border-radius: 10px;
		padding: 10px;
		margin:10px 0px;
	}

	.dropdown {
		position: relative;
		display: inline-block;
	}
</style>
<section class="home">

	<div class="container">
		<!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->

		<h2 class="crt-survey-h2 dash mt-5">Create Survey</h2>
		<div class="crt-survey">
			<form id="surveyForm" class="form-horizontal" action="<?= base_url('csat/createSurvey') ?>" method="post">
				<div class="form-group">
					<div class="q-base-1">
						<h3>Survey Name:</h3>

					</div>
					<div class="campaign">
						<label style="">Please enter the Title for the Survey</label>
						<input id="survey_name" name="survey_name" type="text" placeholder="Survey Name" />
						<p style="color:red" class="error" id="survey_name_error" type="hidden"></p>

					</div>
					<div class="q-base-1">
						<h3>Main Question</h3>
						<p>This will ask respondents to rate their satisfaction of your product or service on a scale
							from 1 to 5 .Based on their response, they will be categorized as a
							1 - Very Unsatisfied, 2- Somewhat Dissatisfied, 3 - Neutral, 4 - Satisfied, 5 - Very
							Satisfied
						</p>
					</div>

					<div class="campaign">
						<label style="">Choose the main question</label>
						<select class="custom-select form-select custom-select-sm"
							class="custom-select custom-select-sm" aria-label="Default select example"
							id="main_question" name="main_question">
							<option value="" selected disabled>Please select the main question
							</option>
							<?php foreach ($mainQuestionList as $question) { ?>
								<option value="<?php echo $question['question_id']; ?>">
									<?php echo $question['question']; ?>
								</option>
							<?php } ?>
						</select>
						<p style="color:red" class="error" id="main_question_error" type="hidden"></p>
					</div>
					<div class="campaign">
						<label style="">Choose the answer type</label>
						<select class="custom-select form-select custom-select-sm"
							class="custom-select custom-select-sm" aria-label="Default select example" id="answer_type"
							name="answer_type">
							<option value="" selected disabled>Please choose the answer type
							</option>
							<?php foreach ($answerList as $key => $value) { ?>
								<option value="<?php echo $key; ?>">
									<?php echo $value; ?>
								</option>
							<?php } ?>
						</select>
						<p style="color:red" class="error" id="answer_type_error" type="hidden"></p>

					</div>
				</div>

				<div class="q-base">
					<h3>Follow - Up Question:</h3>
					<p>For the second question, you have the opportunity to gather more detailed feedback. This question
						will vary
						depending on the respondent's score to the first question, allowing you to tailor the follow-up
						based on
						their level of satisfaction.</p>
				</div>

				<div class="q-base">
					<h4>CSAT Score: 1 (Very Dissatisfied) :</h4>
				</div>
				<div class="que-glad">
					<button class="btn btn-default dropdown-toggle drpdwn_bttn" type="button" id="drpdwn_bttn_1"
						data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Choose questions
						<span class="caret"></span>
					</button>
					<p style="color:red" class="error" id="question_1_error" type="hidden"></p>

					<div class="dropdown-menu">
						<ul class="checkbox-menu allow-focus" id="drpdwn_1">

							<?php if (isset($followupQuestionList[1])) {
								foreach ($followupQuestionList[1] as $key => $value) {
									?>
									<li>
										<label>
											<input class="answer" type="checkbox" id="r_<?= $value["question_id"]; ?>"
												name="question_1[]"
												value="<?= $value["question_id"]; ?>"><?= $value["question"]; ?>
										</label>
									</li>

								<?php }
							} ?>
						</ul>
					</div>
					<button type="button" onclick="showModal('F','1')" style="" class="btn btn-primary">Add Your
						+</button>

				</div>
				<div class="q-base-2">
					<h4>CSAT Score: 2 (Dissatisfied) :</h4>
				</div>
				<div class="que-glad">

					<button class="btn btn-default dropdown-toggle drpdwn_bttn" type="button" id="drpdwn_bttn_2"
						data-bs-toggle="dropdown" data-bs-target="empty" aria-haspopup="true" aria-expanded="true">
						Choose questions
						<span class="caret"></span>
					</button>
					<p style="color:red" class="error" id="question_2_error" type="hidden"></p>

					<div class="dropdown-menu">
						<ul class="checkbox-menu allow-focus" id="drpdwn_2">

							<?php if (isset($followupQuestionList[2])) {
								foreach ($followupQuestionList[2] as $key => $value) {
									?>
									<li>
										<label>
											<input class="answer" type="checkbox" id="r_<?= $value["question_id"]; ?>"
												name="question_2[]"
												value="<?= $value["question_id"]; ?>"><?= $value["question"]; ?>
										</label>
									</li>

								<?php }
							} ?>


						</ul>
					</div>
					<button type="button" class="btn btn-primary" onclick="showModal('F','2')" id="showButton2">Add Your
						+</button>


				</div>
				<div class="q-base-3">
					<h4>CSAT Score: 3 (Neutral) :</h4>
				</div>
				<div class="que-glad">
					<button class="btn btn-default dropdown-toggle drpdwn_bttn" type="button" id="drpdwn_bttn_3"
						data-bs-toggle="dropdown" data-bs-target="empty" aria-haspopup="true" aria-expanded="true">
						Choose questions
						<span class="caret"></span>
					</button>
					<p style="color:red" class="error" id="question_3_error" type="hidden"></p>

					<div class="dropdown-menu">
						<ul class="checkbox-menu allow-focus" id="drpdwn_3">

							<?php if (isset($followupQuestionList[3])) {
								foreach ($followupQuestionList[3] as $key => $value) {
									?>
									<li>
										<label>
											<input class="answer" type="checkbox" id="r_<?= $value["question_id"]; ?>"
												name="question_3[]"
												value="<?= $value["question_id"]; ?>"><?= $value["question"]; ?>
										</label>
									</li>

								<?php }
							} ?>

						</ul>
					</div>
					<button type="button" class="btn btn-primary" onclick="showModal('F','3')" id="showButton2">Add Your
						+</button>



				</div>
				<div class="q-base-3">
					<h4>CSAT Score: 4 (Satisfied) :</h4>
				</div>
				<div class="que-glad">
					<button class="btn btn-default dropdown-toggle drpdwn_bttn" type="button" id="drpdwn_bttn_4"
						data-bs-toggle="dropdown" data-bs-target="empty" aria-haspopup="true" aria-expanded="true">
						Choose questions
						<span class="caret"></span>
					</button>
					<p style="color:red" class="error" id="question_4_error" type="hidden"></p>

					<div class="dropdown-menu">
						<ul class="checkbox-menu allow-focus" id="drpdwn_4">

							<?php if (isset($followupQuestionList[4])) {
								foreach ($followupQuestionList[4] as $key => $value) {
									?>
									<li>
										<label>
											<input class="answer" type="checkbox" id="r_<?= $value["question_id"]; ?>"
												name="question_4[]"
												value="<?= $value["question_id"]; ?>"><?= $value["question"]; ?>
										</label>
									</li>

								<?php }
							} ?>


						</ul>
					</div>
					<button type="button" class="btn btn-primary" onclick="showModal('F','4')" id="showButton2">Add Your
						+</button>



				</div>
				<div class="q-base-3">
					<h4>CSAT Score: 5 (Very Satisfied) :</h4>
				</div>
				<div class="que-glad">
					<button class="btn btn-default dropdown-toggle drpdwn_bttn" type="button" id="drpdwn_bttn_5"
						data-bs-toggle="dropdown" data-bs-target="empty" aria-haspopup="true" aria-expanded="true">
						Choose questions
						<span class="caret"></span>
					</button>
					<p style="color:red" class="error" id="question_5_error" type="hidden"></p>

					<div class="dropdown-menu">
						<ul class="checkbox-menu allow-focus" id="drpdwn_5">

							<?php if (isset($followupQuestionList[5])) {
								foreach ($followupQuestionList[5] as $key => $value) {
									?>
									<li>
										<label>
											<input class="answer" type="checkbox" id="r_<?= $value["question_id"]; ?>"
												name="question_5[]"
												value="<?= $value["question_id"]; ?>"><?= $value["question"]; ?>
										</label>
									</li>

								<?php }
							} ?>


						</ul>
					</div>
					<button type="button" class="btn btn-primary" onclick="showModal('F','5')" id="showButton2">Add Your
						+</button>



				</div>

				<div class="form-group" style="border-top: 2px solid #ebf3fc;margin: 50px 0px;">
					<div class=" mt-5 mb-5">
						<input type="submit" name="submit" id="submit" class="btn btn-default btn-block "
							style="" value="Save" />
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
								<input type="hidden" class="form-control" id="Id" name="Id"
									value="<?php echo set_value('E_Id'); ?>" placeholder="Enter Contact">
							</div>
							<br />
							<div class="d-grid">
								<button type="button" id="DeleteConfirm" class="btn btn-danger  pull-right"
									data-bs-dismiss="modal"><span class="fa fa-trash"></span> Confirm</button>
								<button type="button" id="DeleteCancel" class="btn btn-outline-secondary  pull-left"
									data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

	</div>

	<div class="container">

		<div class="modal fade" id="AddQuestionModal">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding:37px 0px 20px;">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h4>Add Question</h4>
					</div>
					<div class="modal-body" style="">
						<form id="AddQuestionForm" action="<?= base_url('csat/addQuestion') ?>" method="post">

							<div class="form-group">
								<input type="hidden" name="isAjax" value="1">
								<label for="question">Enter Question:</label>
								<input type="text" id="question" placeholder="Enter question" name="question">
							</div>
							<div class="form-group">
								<label for="question">Enter Question Info:</label>
								<input type="text" id="q_info" placeholder="Enter question" name="q_info">
								<input type="hidden" id="q_type" placeholder="Enter question" name="q_type" value="">
								<input type="hidden" id="q_rating" placeholder="Enter question" name="q_rating"
									value="">
								
							</div>
							<p style="color:red" class="error" id="question_error"></p>
							<br />
							<div class="d-grid">
								<button type="submit" class="btn btn-primary save"><span
										class="glyphicon glyphicon-plus"></span>
									Save</button>
							</div>
						</form>
					</div>
					<div class="d-grid" style="padding:0px 20px 20px">
						<button type="button" class="btn btn-danger btn-default pull-right close" id="E_close"
							data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(".checkbox-menu").on("change", "input[type='checkbox']", function () {
		$(this).closest("li").toggleClass("active", this.checked);
	});

	$(".allow-focus").on("click", function (e) {
		e.stopPropagation();
	});


	function showModal(q_type, q_rating) {

		$("#AddQuestionModal").modal("show");
		$("#q_type").val(q_type);
		$("#q_rating").val(q_rating);


	}

	$("#surveyForm").submit(function (event) {
		removeError();
		event.preventDefault();
		var form = $(this);
		// ans_arr.forEach(element => {
		// 	console.log("ans_arr",ans_arr);
		// });
		var isError = false;
		var surveyName = $("#survey_name").val();
		var mainQuestion = $("#main_question").val();
		var answerType = $("#answer_type").val();

		console.log("mainQuestion", mainQuestion)
		if (surveyName.length < 5) {
			isError = true;
			$("#survey_name_error").text("Please enter atleast 5 characters.")
		}
		if (!mainQuestion) {
			isError = true;
			$("#main_question_error").text("Please choose a main question.")
		}
		if (!answerType) {
			isError = true;

			$("#answer_type_error").text("Please choose an answer type.")
		}
		for (const key in ans_arr) {
			if (Object.hasOwnProperty.call(ans_arr, key)) {
				const element = ans_arr[key];
				if (element == 0) {
					isError = true;
					console.log("hi", key)
					var id = "question_" + key + "_error";
					$("#" + id).text("Please choose followup questions.");

				}
				else if (element > 5) {
					isError = true;
					console.log("hi", key)
					var id = "question_" + key + "_error";
					$("#" + id).text("Please choose upto 5 followup questions.");
				}
			}
		}
		if (!isError) {
			console.log("method", form.attr("method"));
			console.log("action", form.attr("action"));

			$.ajax({
				type: form.attr("method"),
				url: form.attr("action"),
				data: form.serialize(),
				dataType: "json",
				success: function (response) {

					if (response.success) {

						window.location.href = response.url;
					} else {
						const errorArr = ["survey_name_error", "main_question_error", "answer_type_error", "question_1_error", "question_2_error", "question_3_error", "question_4_error", "question_5_error"];
						const idArr = ["survey_name", "main_question", "answer_type", "question_1", "question_2", "question_3", "question_4", "question_5"];
						errorDisplay(errorArr, idArr, response.error);
					}
				},
				error: function (response) {
					console.log("failure", response)
				}


			})
		}


	});

	$("#AddQuestionForm").submit(function (event) {
		event.preventDefault();
		var form = $(this);
		$.ajax({
			type: "post",
			url: form.attr("action"),
			dataType: "json",
			data: form.serialize(),

			success: function (response) {
				if (response.success) {
					console.log("response", response)
					$("#AddQuestionModal").modal("hide");
					var id_name = "drpdwn_" + response.data["rating"];
					var q_id = response.data["id"];
					var q_name = response.data["question"];
					$("#" + id_name).append('<li><label><input class="answer" type="checkbox" name="question_' + response.data["rating"] + '[]" value="' + q_id + '">' + q_name + '</label></li>')
				} else {

				}
			},
			error: function (response) {
				console.log("failure", response)
			}
		})
	})

	// NUMBER OF OPTIONS SELECTED SCRIPT
	var ans_arr = new Object({
		1: 0,
		2: 0,
		3: 0,
		4: 0,
		5: 0
	});
	// $("input[type='checkbox']").change(function() {
	// 	console.log("called on change")
	// 	var q_div = $(this).closest(".que-glad");
	// 	questionsSelectedCount(q_div);

	// });
	$(document).on("change", "input[type='checkbox']", function () {

		console.log("called on doc change")
		var q_div = $(this).closest(".que-glad");
		questionsSelectedCount(q_div);
	})


	function questionsSelectedCount(q_div) {
		var q_count = q_div.find(".answer:checked").length;
		var group_id = q_div.find("ul").attr("id");
		var ans_id = group_id.split("_")[1];
		console.log("group_id", group_id);
		ans_arr[ans_id] = q_count;
		var drpdwn_bttn = q_div.find(".drpdwn_bttn");
		if (q_count > 0) {
			drpdwn_bttn.text("Total " + q_count + " questions selected.");
		} else {
			drpdwn_bttn.text("Choose questions.");
		}
		console.log("ans_arr", ans_arr);
		console.log("question", q_count);


	}
	//survey details mapping script
	var editSurveyData = <?php if (isset($survey)) {
		echo json_encode($survey);
	} else {
		echo json_encode(array());
	} ?>;
	if (editSurveyData && Object.keys(editSurveyData).length > 0) {

		$("#survey_name").val(editSurveyData.survey_name);

		var options = $("#main_question").find("option");
		options.each(function () {
			if ($(this).val() == editSurveyData.question_id) {
				$(this).prop("selected", true);
			}
			console.log($(this).val());
		});


		var options = $("#answer_type").find("option");
		options.each(function () {
			if ($(this).val() == editSurveyData.answer_list) {
				$(this).prop("selected", true);
			}
			console.log($(this).val());
		});

		var question_id_1 = editSurveyData.question_id_1.split(",");
		var question_id_2 = editSurveyData.question_id_2.split(",");
		var question_id_3 = editSurveyData.question_id_3.split(",");
		var question_id_4 = editSurveyData.question_id_4.split(",");
		var question_id_5 = editSurveyData.question_id_5.split(",");

		var questionArr = [question_id_1, question_id_2, question_id_3, question_id_4, question_id_5]
		for (let index = 0; index < questionArr.length; index++) {
			const que_grp = questionArr[index];
			que_grp.forEach(element => {
				console.log("element", element);
				var id = "r_" + element;
				$("#" + id).prop("checked", true);

			});
		}
		var inputElement = $("<input>").attr({
			type: "hidden",
			name: "survey",
			value: editSurveyData.survey_id
		});

		// Append the input element to the form using jQuery
		$("#surveyForm").append(inputElement);


		//count the checkboxes checked after mapping edit survey data.
		$('.que-glad').each(function () {
			var q_div = $(this);

			questionsSelectedCount(q_div)

		});

	}

	function removeError() {
		var errorElements = document.getElementsByClassName("error");
		for (let j = 0; j < errorElements.length; j++) {
			errorElements[j].innerHTML = "";
		}
	}
</script>


<?= $this->endSection() ?>