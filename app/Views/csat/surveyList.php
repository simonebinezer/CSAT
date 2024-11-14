<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<?php echo script_tag('js/jquery.min.js'); ?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

	.edit-sur {
		background: none !important;
		border: 0px solid #092c4c;
	}

	.edit-sur:hover {
		background: #00000017 !important;
		border: 0px solid #092c4c;
	}

	.del-sur {
    background: none !important;
    border: 0px solid #092c4c;
    padding: 0px 10px;
	float: right;
}
.action-btns form{
	float: left;
}
	.del-sur:hover {
		background: #00000017 !important;
		border: 0px solid #092c4c;
		padding: 0px 10px;
	}

	.table-striped>tbody>tr:nth-of-type(odd)>* {
		--bs-table-color-type: none;
		--bs-table-bg-type: none;
	}

	.sur-lis-bd {
		border-width: 0px !important;
	}

	.sur-lis-bd td {
		border-width: 0px 0px 1px 0px !important;
		padding: 20px 30px;
		border-bottom: 0px solid #cae3ff !important;
		background: none;
	}

	.sur-lis-bd th {
		border-width: 0px 0px 1px 0px !important;
		padding: 20px 30px;
		border-bottom: 1px solid #cae3ff;
		background: none;
	}

	.table-bordered {
		padding: 20px;
		background: #fff;
		border-radius: 20px;
	}

	.crt-sur {
		border-radius: 8px;
		background: #130A72;
		border: 0px;
		font-family: "Inter", sans-serif;
	}

	.crt-sur:hover {
		border-radius: 8px;
		background: #092C4C;
		/* border: 1px solid #092C4C; */
		box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
	}


</style>
<section class="home"  style="">
	<div class="container">
		<!-- Breadcrumbs-->
		<!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
		<!-- Page Content -->
		<!-- <h1>Survey List</h1>
    <hr> -->

		<?php if (session()->getFlashdata('response') !== NULL) : ?>
			<p style="color:green; font-size:18px;" align="center">
				<?php echo session()->getFlashdata('response'); ?>
			</p>
		<?php endif; ?>
		<div class="row header">
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="">
					<h1>Survey Management</h1>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="text-center "><a class="btn btn-primary crt-sur float-end" href="<?php echo site_url('csat/createSurvey'); ?>">Create Survey</a>
				</div>
			</div>
		</div>

		<?php if (!empty($surveyList)) { ?>
			<table class="table mt-6 table-striped table-bordered">
				<thead>
					<tr class="sur-lis-bd">
						<!-- <th scope="col">S.No</th> -->
						<th scope="col">Survey Name</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;
					foreach ($surveyList as $surveyData) {
						$count++; ?>
						<tr class="sur-lis-bd">
							<!-- <td scope="row">
                //<?php echo $count; ?>//
              </td> -->
							<td class="name-sur">
								<div class="">
									<?php echo stripslashes($surveyData['survey_name']); ?>
									<?php if ($surveyData['sent_status'] == 0) { ?>
										<p style="color: red;font-size: 12px;">* This survey is already in progress you cannot edit.</p><?php } ?>
								</div>
							</td>
							<td class="action-btns">
								<form method="get" action="<?= base_url("csat/editSurvey")?>">
								<input type="hidden" name="surveyId" value="<?= $surveyData['survey_id']?>">
								<button class="btn btn-primary edit-sur" type="submit" <?php if ($surveyData['sent_status'] == 0) { ?>style="pointer-events: none;" <?php } ?>> <img src="<?php echo base_url(); ?>images/icons/Createnew.svg" class="img-centered img-fluid"></button>
								</form>
								<!-- <a class="btn btn-primary del-sur" id="<?= $surveyData['survey_id']; ?>" href="<?php echo site_url('deletesurvey/' . $surveyData['survey_id']); ?>" > <img src="<?php echo base_url(); ?>images/icons/Remove.png" class="img-centered img-fluid"></a> -->
								<button class="btn btn-primary del-sur" type="button" onclick="showModal(<?= $surveyData['survey_id']; ?>)"><img src="<?php echo base_url(); ?>images/icons/Removenew.svg"></button>
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


	<!-- #region --><!-- DELETE MODAL -->
	<div class="container">


		<div class="modal fade" id="DeleteModal">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header" style="padding:15px 50px;">
						<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
						<h4> Delete Survey</h4>
					</div>
					<form id="deleteForm" action="<?= base_url("csat/deleteSurvey") ?>" method="post">
						<div class="modal-body" style="padding:40px 50px 20px;">
							<p> Are you sure you want to delete the survey ?</p>
							<div class="form-group">
								<input type="hidden" class="form-control" id="surveyId" name="surveyId" value="">
							</div>
							<br />
							<div class="d-grid">
								<button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-trash"></span>
									Confirm</button>
								<button type="button" class="btn btn-outline-secondary Cancel pull-left" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>
	</div>
	<!-- #endregion -->
</section>
<script>
	//delete modal 
	function showModal(param) {
		console.log("entry");

		$('#surveyId').val(param);
		$("#DeleteModal").modal('show');

	};


	$('.editOrder').on('click', function () {
            //getting data of selected row using id.

            console.log("ENtry");
            // $id = document.getElementById('orderRow');
            // console.log($id);
            $tr = $(this).closest('tr');
            var data = $tr.children().map(function () {
              return $(this).text();
            }).get();
            console.log(data[1].trim());
            var orderId = data[1].trim();
            var url = "<?= base_url('csat/editSurvey/') ?>" + orderId;
            window.location.href = url;

          });
</script>
<?= $this->endSection() ?>