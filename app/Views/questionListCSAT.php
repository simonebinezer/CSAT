<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<section class="home">
	<div class="container"> <!-- Breadcrumbs-->

		<?php if (session()->getFlashdata('response') !== NULL): ?>
			<p style="color:green; font-size:18px;" align="center"><?php echo session()->getFlashdata('response'); ?>
			</p>
		<?php endif; ?>


		<div class="header">
			<h1>Question List</h1>
			<a class="crt-que-btn" href="<?php echo site_url('csat/addQuestion'); ?>">Create Question</a>
		</div>
		<?php if (!empty($questionList)) { ?>

			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">S.No.</th>
						<th scope="col">Question</th>
						<th scope="col">Type</th>
						<th scope="col">Rating</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;

					foreach ($questionList as $question) {
						$count++; ?>

						<tr>
							<td scope="row">
								<?php echo $count; ?>
							</td>
							<td style="display: none;" scope="row"><?php echo $question['question_id']; ?></td>
							<td><?php echo stripslashes($question['question']); ?></td>
							<td><?php if ($question['type'] == "R") {
								echo "Main question";
							} else {
								echo "Follow up question";
							} ?></td>
							<td><?php if ($question['rating'] == 0) {
								echo "";
							} else {
								echo $question['rating'];
							} ?></td>

							<td class="action-btns"><a class="edit-sur"
									href="<?php echo site_url('csat/editQuestion/' . $question['question_id']); ?>"><img
										src="http://localhost:8000/images/icons/Createnew.svg" class="img-centered img-fluid"
										title="Edit"></a>
								<button type="button" class="del-btn" onclick="showModal(<?= $question['question_id'] ?>)"><img
										src="http://localhost:8000/images/icons/Removenew.svg" title="Delete"></button>
							</td>
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


		<div class="modal fade" id="DeleteQuestionModal">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding:15px 50px;">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h4> Delete Question</h4>
					</div>
					<form action="<?= base_url('csat/deleteQuestion') ?>" method="post">
						<div class="modal-body" style="padding:40px 50px 20px;">
							<p> Are you sure, you want to delete the question?</p>
							<div class="form-group">
								<input type="hidden" class="form-control" id="q_id" name="q_id">
							</div>
							<br />
							<div class="d-grid">
								<button type="submit" class="btn btn-danger confirm pull-right"><span
										class="fa fa-trash"></span>
									Confirm</button>
								<button type="button" class="btn btn-outline-secondary Cancel pull-left"
									data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>

	</div>
</section>
<script>
	function showModal(param) {
		console.log("entry");

		$('#q_id').val(param);

		$("#DeleteQuestionModal").modal('show');
		// getting the value of the input field and assign it to form value.
	};
</script>
<?= $this->endSection() ?>