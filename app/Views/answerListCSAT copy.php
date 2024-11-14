<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<?php echo script_tag('js/functions/Script.js'); ?>

<section class="home">
	<div class="container"> <!-- Breadcrumbs-->

		<!-- Breadcrumbs-->
		<!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
		<!-- Page Content -->
		<h1>Answer List</h1>
		<hr>
		<?php if (session()->getFlashdata('response') !== NULL) : ?>
			<p style="color:green; font-size:18px;" align="center"><?php echo session()->getFlashdata('response'); ?></p>
		<?php endif; ?>
		<div class="row">
			<div class="col-xl-11 col-lg-11 col-md-11">
				<button type="button" class="btn btn-success float-end" data-bs-target="#UpdateModal" data-bs-toggle="modal">UPdate Emoji</button>
				
				<button type="button" class="btn btn-success float-end" data-bs-target="#UpdateTextModal" data-bs-toggle="modal">UPdate Text</button>
			</div>
		</div>
		<?php if (!empty($answerList)) { ?>

			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">S.No.</th>
						<th scope="col">Emoji</th>
						<th scope="col">Text</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($answerList as $answer) { ?>

						<tr>

							<td scope="row"><?php echo $answer['answer_id']; ?></td>
							<td><img src="<?= base_url() . "/images/answers/" . ($answer['emoji']); ?>" alt=""></td>
							<td><?php echo stripslashes($answer['text']); ?></td>
							<!-- <td class="action-btns"><a class="btn btn-primary edit-sur" href="<?php echo site_url('csat/editanswer/' . $answer['answer_id']); ?>"><img src="http://localhost:8000/images/icons/Createnew.svg" class="img-centered img-fluid" title="Edit"></a>
								<button type="button" class="btn btn-primary" onclick="showModal(<?= $answer['answer_id'] ?>)"><img src="http://localhost:8000/images/icons/Removenew.svg" title="Delete"></button>
							</td> -->
						</tr>
					<?php  } ?>
				</tbody>

			</table>
		<?php  } else { ?>
			<div class="text-center">
				<p class="fs-3"> <span class="text-danger">Oops!</span>No records found.</p>
			</div>
		<?php } ?>
	</div>
	<div class="container">

		<div class="modal fade" id="UpdateModal">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding:37px 0px 20px;">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h4> Update Emoji</h4>
					</div>
					<div class="modal-body" style="">
						<form id="updateEmojiForm" action="<?= base_url('csat/updateEmoji') ?>" method="post">

							<div class="form-group">
								<div class="form-field">
									<label for="emoji_1"> 1 </label>
									<input type="file" class="form-control" id="emoji_1" name="emoji_1">
								</div>
								<p style="color:red" class="error" id="emoji_1_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 2 </label>
									<input type="file" class="form-control" id="emoji_2" name="emoji_2">
								</div>
								<p style="color:red" class="error" id="emoji_2_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 3 </label>
									<input type="file" class="form-control" id="emoji_3" name="emoji_3">
								</div>
								<p style="color:red" class="error" id="emoji_3_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 4 </label>
									<input type="file" class="form-control" id="emoji_4" name="emoji_4">
								</div>
								<p style="color:red" class="error" id="emoji_4_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 5 </label>
									<input type="file" class="form-control" id="emoji_5" name="emoji_5">
								</div>
								<p style="color:red" class="error" id="emoji_5_error"></p>
								<p style="color:red" class="error" id="emoji_error"></p>
							</div>

							<br />
							<div class="d-grid">
								<button type="submit" class="btn btn-primary save"><span class="glyphicon glyphicon-plus"></span>
									Save</button>
							</div>
						</form>
					</div>
					<div class="d-grid" style="padding:0px 20px 20px">
						<button type="button" class="btn btn-danger btn-default pull-right close" id="E_close" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">

		<div class="modal fade" id="UpdateTextModal">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding:37px 0px 20px;">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h4> Update Text</h4>
					</div>
					<div class="modal-body" style="">
						<form id="updateTextForm" action="<?= base_url('csat/updateText') ?>" method="post">

							<div class="form-group">
								<div class="form-field">
									<label for="emoji_1"> 1 </label>
									<input type="text" class="form-control" id="text_1" name="text">
								</div>
								<p style="color:red" class="error" id="emoji_1_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 2 </label>
									<input type="text" class="form-control" id="text_2" name="text">
								</div>
								<p style="color:red" class="error" id="emoji_2_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 3 </label>
									<input type="text" class="form-control" id="text_3" name="text">
								</div>
								<p style="color:red" class="error" id="emoji_3_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 4 </label>
									<input type="text" class="form-control" id="text_4" name="text">
								</div>
								<p style="color:red" class="error" id="emoji_4_error"></p>

								<div class="form-field">
									<label for="emoji_1"> 5 </label>
									<input type="text" class="form-control" id="text_5" name="text">
								</div>
								<p style="color:red" class="error" id="text_error"></p>
							</div>

							<br />
							<div class="d-grid">
								<button type="submit" class="btn btn-primary save"><span class="glyphicon glyphicon-plus"></span>
									Save</button>
							</div>
						</form>
					</div>
					<div class="d-grid" style="padding:0px 20px 20px">
						<button type="button" class="btn btn-danger btn-default pull-right close" id="E_close" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$("#updateEmojiForm").submit(function(event) {
		var form = $(this);
		event.preventDefault();
		var emoji = new FormData();

		var elements = document.querySelectorAll("input[type=file]");
		elements.forEach(element => {

			var file = element.files[0];
			if (file != undefined) {
				console.log("file", file);
				console.log((element.id).split("_")[1]);
				emoji.append("emoji[" + (element.id).split("_")[1] + "]", file);
			}
			//emoji.append(element.name, file);
		})

		// var file = $('#emoji_1').prop('files')[0];
		// //  console.log(file);


		//   console.log("emoji",emoji);
		//emoji_1.append('emoji', file);
		$.ajax({
			url: form.attr("action"),
			data: emoji,
			dataType: "json",
			type: "post",
			contentType: false,
			processData: false,
			success: function(response) {

				if (response.success) {

					window.location.href = response.url;
				} else {
					//const idArray = ["emoji_error", "emoji_2", "emoji_3", "emoji_4", "emoji_5"];
					//const errorArray = ["emoji_1_error", "emoji_2_error", "emoji_3_error", "emoji_4_error", "emoji_5_error"];

					//errorDisplay(errorArray, idArray, response.error);
					console.log(response.error["emoji.*"]);
					$("#emoji_error").text(response.error["emoji.*"]);
				}
			},
			failure: function(response) {
				console.log("failure", response.error);
			}
		})
	})

	$("#updateTextForm").submit(function(event) {
		var form = $(this);
		event.preventDefault();
		var elements = document.querySelectorAll("input[name=text]");
		const text = new Object();

		elements.forEach(element => {

			var name = element.value;
			console.log("text")
			if (name != "") {

				text[((element.id).split("_")[1])]=name;
				console.log(text);
			}
			//emoji.append(element.name, file);
		})

		$.ajax({
			url: form.attr("action"),
			data: {text:text},
			dataType: "json",
			type: "post",
			success: function(response) {

				if (response.success) {

					window.location.href = response.url;
				} else {

					console.log(response.error["text.*"]);
					$("#text_error").text(response.error["text.*"]);
				}
			},
			failure: function(response) {
				console.log("failure", response.error);
			}
		})
	})


	$(".close").on("click", function() {

		removeError();
	})

	function showModal(param) {
		console.log("entry");

		$('#q_id').val(param);

		$("#DeleteanswerModal").modal('show');
		// getting the value of the input field and assign it to form value.
	};
</script>
<?= $this->endSection() ?>