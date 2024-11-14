<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<?php echo script_tag('js/functions/Script.js'); ?>

<section class="home" style="height:-webkit-fill-available">
	<div class="container"> <!-- Breadcrumbs-->
		<!-- Breadcrumbs-->
		<!-- Page Content -->

		<?php if (session()->getFlashdata('response') !== NULL): ?>
			<p style="color:green; font-size:18px;" align="center"><?php echo session()->getFlashdata('response'); ?></p>
		<?php endif; ?>
		<div class="header">
			<h1>Answer List</h1>
			<div class="">
				<button type="button" class="btn update-emoji " data-bs-target="#UpdateModal"
					data-bs-toggle="modal">Update Emoji</button>

				<button type="button" class="btn update-text " data-bs-target="#UpdateTextModal"
					data-bs-toggle="modal">Update Text</button>
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
					<?php } ?>
				</tbody>

			</table>
		<?php } else { ?>
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
								<?php $count = 0;
								foreach ($answerList as $answer) {
									$count++;
									?>
									<div class="form-field">
										<label for="emoji_<?= $count ?>"> <?= $count ?> </label>
										<div><img src="<?= base_url() . "/images/answers/" . ($answer['emoji']); ?>" alt="">
										</div>
										<input type="file" class="form-control" id="emoji_<?= $count ?>"
											name="emoji_<?= $count ?>">
									</div>
								<?php } ?>

								<p style="color:red" class="error" id="emoji_error"></p>
							</div>

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
								<?php $count = 0;
								foreach ($answerList as $answer) {
									$count++;
									?>
									<div class="form-field">
										<label for="text_<?= $count ?>"> <?= $count ?> </label>
										<div><?= $answer['text'] ?></div>

										<input type="text" class="form-control" id="text_<?= $count ?>"
											name="text_<?= $count ?>">
									</div>
								<?php } ?>

								<p style="color:red" class="error" id="text_error"></p>
							</div>

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
	$("#updateEmojiForm").submit(function (event) {
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
			success: function (response) {

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
			failure: function (response) {
				console.log("failure", response.error);
			}
		})
	})

	$("#updateTextForm").submit(function (event) {
		console.log("here");

		var form = $(this);
		event.preventDefault();
		var elements = document.querySelectorAll("input[type=text]");
		const text = new Object();

		elements.forEach(element => {
			console.log("here2");

			var name = element.value;
			console.log("text")
			if (name != "") {

				text[((element.id).split("_")[1])] = name;
				console.log(text);
			}
			//emoji.append(element.name, file);
		})

		$.ajax({
			url: form.attr("action"),
			data: {
				text: text
			},
			dataType: "json",
			type: "post",
			success: function (response) {

				if (response.success) {

					window.location.href = response.url;
				} else {

					console.log(response.error["text.*"]);
					$("#text_error").text(response.error["text.*"]);
				}
			},
			failure: function (response) {
				console.log("failure", response.error);
			}
		})
	})


	$(".close").on("click", function () {

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