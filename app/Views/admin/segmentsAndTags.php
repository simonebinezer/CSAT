<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Include the necessary CSS and JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>

.mapTagSegment{
    /* padding: 20px; */
    /* background: url(http://hctools.in/images/icons/plus.png) no-repeat top center; */
    width: 57px !important;
}
.editSegment{
  width: 57px !important;
}
.deleteSegment{
  width: 57px !important;
}
.deleteTag{
  width: 57px !important;
}
</style>

<section class="home">
  <div class="container">

    <!-- Breadcrumbs-->
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
    <!-- Page Content -->

    <br />


    <!-- <hr> -->
    <div>
      <div class="modal-btn-add">

        <h2 class="dash">Segments Management</h2>
        <button type="button" class=" btn-success-tag add mb-3" data-bs-toggle="modal" data-bs-target="#SegmentModal" id="AddSegement"><span class="glyphicon glyphicon-plus">Add
            Segment</span></button>
      </div>
      <div>

      </div>
      <div class="content">
        <?php if (!empty($segmentList)) { ?>
          <table class="table table-striped table-bordered add-segments-tab-hd" id="tags">
            <thead>
              <tr>

                <th scope="col" style="display:none;"> Id </th>
                <th scope="col">Name</th>
                <th scope="col">Tag list</th>
                <th colspan="3" class="pull-centre" scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($segmentList as $segment) { ?>
                <tr id="segmentRow">
                  <td scope="row" style="display:none;">
                    <?php echo $segment['segment_id']; ?>
                  </td>
                  <td>
                    <?php echo $segment['segment_name'] ?>
                  </td>
                  <td>
                    <?php echo $segment['tag_names'] ?>
                  </td>
                  <td><button type="button" class="btn btn-default mapTagSegment" data-bs-toggle="modal" onclick="mapTagandSegment(<?php echo $segment['segment_id']; ?>,'<?php echo $segment['tag_id_list'] ?>')" data-bs-target="#dropdownModal"><img src="<?php echo base_url(); ?>images/icons/plus.png" class="img-centered img-fluid" title="Add tags"></button></td>
                  <td><button type="button" class="btn btn-default editSegment" data-bs-toggle="modal" data-bs-target="#segmentEditModal"><img src="<?php echo base_url(); ?>images/icons/edit-1.png" class="img-centered img-fluid" title="Edit segment"> </button></td>
                  <td><button type="button" class="btn btn-default deleteSegment" data-bs-toggle="modal" data-bs-target="#segmentDeleteModal"><img src="<?php echo base_url(); ?>images/icons/remove-1.png" class="img-centered img-fluid" title="Delete segment"> </button></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else{  ?>
          

<div style="max-width: 794px;
        margin: 20px auto 90px;
        background-color: #fff;
        padding: 60px 50px;
        border: 0px solid #000;
        border-radius: 20px;">
  <div style="text-align: center;margin: auto;">
    <h2 style="color: #000;
                text-align: center; font-family: 'Trebuchet MS', sans-serif;
                font-size: 44px;
                font-style: normal;
                font-weight: 500;">No data Found!</h2>
  </div>
 
</div>
          <?php }   ?>
      </div>
      <div class="modal-btn-add mt-5">
        <h2 class="dash">Tags Management</h1>
          <button type="button" class=" btn-success-tag add mb-3" data-bs-toggle="modal" data-bs-target="#TagModal" id="AddTag"><span class="glyphicon glyphicon-plus">Add
              Tag</span></button>
      </div>
      <div class="content">
        <?php if (!empty($tagList)) { ?>
          <table class="table table-striped table-bordered add-tab-hd" id="tags">
            <thead>
              <tr>
                <th scope="col" style="display:none;"> Id </th>
                <th scope="col">Name</th>
                <th colspan="2" class="pull-centre" scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 0;
              foreach ($tagList as $tag) { ?>
                <tr id="tagRow">
                  <td scope="row" style="display:none;">
                    <?php echo $tag['tag_id']; ?>
                  </td>
                  <td>
                    <?php echo $tag['tag_name'] ?>
                  </td>

                  <td><button type="button" class="btn btn-default editTag" data-bs-toggle="modal" data-bs-target="#tagEditModal"><img src="<?php echo base_url(); ?>images/icons/edit-1.png" class="img-centered img-fluid" title="Edit tag"></button></td>
                  <td><button type="button" class="btn btn-default deleteTag" data-bs-toggle="modal" data-bs-target="#tagDeleteModal"><img src="<?php echo base_url(); ?>images/icons/remove-1.png" class="img-centered img-fluid" title="Delete tag"> </button></td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else{  ?>
          

          <div style="max-width: 794px;
                  margin: 20px auto 90px;
                  background-color: #fff;
                  padding: 60px 50px;
                  border: 0px solid #000;
                  border-radius: 20px;">
            <div style="text-align: center;margin: auto;">
              <h2 style="color: #000;
                          text-align: center; font-family: 'Trebuchet MS', sans-serif;
                          font-size: 44px;
                          font-style: normal;
                          font-weight: 500;">No data Found!</h2>
            </div>
           
          </div>
                    <?php }   ?>
      </div>
    </div>
    <!-- ADD TAG MODAL -->
    <div class="container">
      <div class="modal fade" id="TagModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header  ctr-segment" style="padding:15px 50px;">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Create Tag </h4>
            </div>
            <form action="<?= base_url('createTag') ?>" id="AddTagForm" class="form" name="AddTag" method="post">
              <div class="modal-body ctr-segment-body" style="padding:20px;">

                <div class="form-group">
                  <label for="tag_name"> please enter a new Tag name:</label><br/>
                  <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Tag name">
                  <p style="color:red" class="error" id="tagName_error"></p>
                </div>
                <div class="modal-footer-btn">
                  <button type="button" class="btn btn-outline-secondary Cancel close" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                  <button type="submit" class="btn btn-primary confirm "><span class="fa fa-add"></span>
                    Add</button>
                </div>
                </br>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- EDIT TAG MODAL -->
    <div class="container">


      <div class="modal fade" id="tagEditModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header  ctr-segment" style="">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Edit tag</h4>
            </div>
            <div class="modal-body ctr-segment-body" style="">
              <form action="<?= base_url('editTag') ?>" class="form" id="EditTagForm" name="EditTag" method="post">
                <div class="form-group">
                  <div class="form-field">
                    <input type="hidden" class="form-control" id="E_tag_id" name="E_tag_id">
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-field  ctr-segment-form-field">
                    <label for="E_tag_name">Tag name:</label><br/>
                    <input type="text" class="form-control" id="E_tag_name" name="E_tag_name" placeholder="tag name">
                    <p style="color:red" class="error" id="E_tagName_error"></p>
                  </div>
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



    <!-- DELETE TAG MODAL -->
    <div class="container">
      <div class="modal fade" id="tagDeleteModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header  ctr-segment" style="">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Delete tag</h4>
            </div>
            <form action="<?= base_url('deleteTag') ?>" class="form" id="DeleteTagForm" name="DeleteTag" method="post">
              <div class="modal-body ctr-segment-body" style="">
                <p> Are you sure you want to delete the tag?</p>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="tag_id" name="tag_id">
                </div>
                <br />
                <div class="d-grid">
                  <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-trash"></span>
                    Confirm</button>
                  <button type="button" class="btn btn-outline-secondary Cancel pull-left close" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                </div>
              </div>
            </form>


          </div>
        </div>
      </div>
    </div>


    <!-- ADD SEGMENT MODAL -->
    <div class="container">
      <div class="modal fade" id="SegmentModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">

            <div class="modal-header ctr-segment" style="">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Create Segment </h4>
            </div>
            <form action="<?= base_url('createSegment') ?>" class="form" id="AddSegmentForm" name="AddSegment" method="post">
              <div class="modal-body ctr-segment-body" style="padding:20px;">

                <div class="form-group">
                  <div class="form-field ctr-segment-form-field">
                    <input type="hidden" class="form-control" name="Edit" value="false">
                  </div>
                </div>
                <div class="form-group">
                  <label for="tag_name"> Please enter a new segment name:</label><br/>
                  <input type="text" class="form-control" id="segment_name" name="segment_name" placeholder="Segment name">
                  <p style="color:red" class="error" id="segmentName_error"></p>
                </div>

                <div class="modal-footer-btn">
                  
                  <button type="button" class="btn btn-outline-secondary Cancel close" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                  <button type="submit" class="btn btn-primary confirm"><span class="fa fa-add"></span>
                    Add</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <br />

    </div>

    <!-- EDIT SEGMENT MODAL -->
    <div class="container">
      <div class="modal fade" id="segmentEditModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header  ctr-segment" style="">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Edit segment</h4>
            </div>
            <div class="modal-body ctr-segment-body" style="">
              <form action="<?= base_url('editSegment') ?>" class="form" id="EditSegmentForm" name="EditSegment" method="post">
                <div class="form-group">
                  <div class="form-field ctr-segment-form-field">
                    <input type="hidden" class="form-control" id="E_segment_id" name="E_segment_id">
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-field ctr-segment-form-field">
                    <input type="hidden" class="form-control" name="Edit" value="true">
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-field ctr-segment-form-field">
                    <label for="E_tag_name">Segment name:</label><br/>
                    <input type="text" class="form-control" id="E_segment_name" name="E_segment_name" placeholder="Segment name">
                    <p style="color:red" class="error" id="E_segmentName_error"></p>
                  </div>
                </div>
                <br />
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary save"><span class="glyphicon glyphicon-plus"></span>
                    Save</button>
                </div>
              </form>
            </div>
            <div class="d-grid" style="padding:0px 20px 20px">
              <button type="submit" class="btn btn-danger btn-default pull-right close" id="E_close" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- DELETE SEGMENT MODAL -->
    <div class="container">
      <div class="modal fade" id="segmentDeleteModal">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header  ctr-segment" style="padding:15px 50px;">
              <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              <h4> Delete segment</h4>
            </div>
            <form action="<?= base_url('deleteSegment') ?>" class="form" id="DeleteSegmentForm" name="DeleteSegment" method="post">
              <div class="modal-body ctr-segment-body" style="padding:20px;">
                <p> Are you sure you want to delete the segment?</p>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="segment_id" name="segment_id">
                </div>
                <br />
                <div class="d-grid">
                  <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-trash"></span>
                    Confirm</button>
                  <button type="button" class="btn btn-outline-secondary Cancel pull-left close" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
                </div>
              </div>
            </form>


          </div>
        </div>
      </div>

    </div>
    <div class="modal fade" id="dropdownModal">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header  ctr-segment" style="">
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            <h4> select tags</h4>
          </div>
          <form action="<?= base_url('addTag') ?>" id="MapTagForm" name="MapTag" method="post">
            <div class="modal-body ctr-segment-body" style="padding:40px 50px 20px;">
              <input type="hidden" id="tagSegmentId" name="segmentId">
              <?php if (!empty($tagList)) {
                foreach ($tagList as $tag) { ?>
                  <div>
                    <input type="checkbox" id="tag<?= $tag['tag_id']; ?>" name="tagList[]" value="<?= $tag['tag_id']; ?>" />
                    <label for="tag<?= $tag['tag_id']; ?>"><?= $tag['tag_name']; ?></label>
                  </div>

                <?php } ?>
              <?php } ?>
              <p style="color:red" class="error" id="tag_list_error"></p>
              <br />
              <div class="d-grid">
                <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-add"></span>
                  Confirm</button>
                <button type="button" class="btn btn-outline-secondary Cancel pull-left close" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
              </div>
            </div>
          </form>


        </div>
      </div>
    </div>
    <div id='loader' style='display: none;'>
      <img src="<?php echo base_url(); ?>images/Circles-menu-3.gif" />
    </div>
  </div>


</section>

<script>
  $('.editTag').on('click', function() {
    $("#tagEditModal").modal('show');
    //getting data of selected row using id.
    $id = document.getElementById('tagRow');
    console.log($id);

    $tr = $(this).closest('tr');
    var data = $tr.children().map(function() {
      return $(this).text();
    }).get();
    // getting the value of the input fields and assign it to form values.
    $('#E_tag_id').val(data[0].trim());
    $('#E_tag_name').val(data[1].trim());

  });

  $('.deleteTag').on('click', function() {
    $("#tagDeleteModal").modal('show');
    //getting data of selected row using id.
    $id = document.getElementById('tagRow');
    console.log($id);

    $tr = $(this).closest('tr');
    var data = $tr.children().map(function() {
      return $(this).text();
    }).get();
    // getting the value of the input fields and assign it to form values.
    $('#tag_id').val(data[0].trim());
  });


  $('.editSegment').on('click', function() {
    $("#segmentEditModal").modal('show');
    //getting data of selected row using id.
    $id = document.getElementById('segmentRow');
    console.log($id);

    $tr = $(this).closest('tr');
    var data = $tr.children().map(function() {
      return $(this).text();
    }).get();
    // getting the value of the input fields and assign it to form values.
    $('#E_segment_id').val(data[0].trim());
    $('#E_segment_name').val(data[1].trim());

  });

  $('.deleteSegment').on('click', function() {
    $("#segmentDeleteModal").modal('show');
    //getting data of selected row using id.
    $id = document.getElementById('segmentRow');
    console.log($id);

    $tr = $(this).closest('tr');
    var data = $tr.children().map(function() {
      return $(this).text();
    }).get();
    // getting the value of the input fields and assign it to form values.
    $('#segment_id').val(data[0].trim());
  });

  $(".close").click(function() {
    var modalId = $(this).closest(".modal").attr("id");
    console.log("Modal ID:", modalId);
    $("#" + modalId).modal('hide');
    var modal = document.getElementById(modalId);
    var errorElements = modal.getElementsByClassName("error");
    console.log("errorElements", errorElements);
    for (let j = 0; j < errorElements.length; j++) {
      errorElements[j].style.display = "none";
    }
    console.log("this", $(this).closest("form"));
    var formId = modal.getElementsByTagName("form")[0].id;
    console.log("formId", formId)
    document.getElementById(formId).reset();

  });

  function mapTagandSegment(segmentId, tagList) {
    console.log(tagList);
    if (tagList) {

      var tagArray = tagList.split(",");
    }
    console.log(tagArray);
    $("#dropdownModal").modal('show');
    $('input:checkbox').prop('checked', false);
    if (tagArray) {
      tagArray.forEach(element => {
        console.log("element", tagArray.length);
        // console.log("element",element);
        document.getElementById("tag" + element).checked = true;;
      });
    }
    $('#tagSegmentId').val(segmentId);
  }


  $("form").submit(function(event) {
    $('#loader').show();

    console.log("hello");
    event.preventDefault();
    var form = $(this);
    console.log(form.attr("id"));
    console.log(form.serialize());
    console.log(form.attr("action"));
    console.log(form.attr("method"));
    ajaxCall(form)

  })

  const ErrArr = {
    AddSegment: [{
      idArray: ["segment_name"],
      errorArray: ["segmentName_error"]
    }],
    EditSegment: [{
      idArray: ["E_segment_name"],
      errorArray: ["E_segmentName_error"]
    }],
    AddTag: [{
      idArray: ["tag_name"],
      errorArray: ["tagName_error"]
    }],
    EditTag: [{
      idArray: ["E_tag_name"],
      errorArray: ["E_tagName_error"]
    }],
    MapTag: [{
      idArray: ["tagList"],
      errorArray: ["tag_list_error"]
    }]
  };

  function ajaxCall(form) {
    var action = form.attr("name");
    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      dataType: 'json',
      data: form.serialize(),
      success: function(response) {
        console.log(response);
        if (response.success) {
          $('#loader').hide();
          console.log("successentry");
          window.location.href = "<?= base_url('getSegments') ?>";

        } else {
          $('#loader').hide();
          console.log(response.error);
          const idArray = ErrArr[action][0]["idArray"];
          const errorArray = ErrArr[action][0]["errorArray"];
          errorDisplay(errorArray, idArray, response.error);

        }
      },
      error: function(response) {
        console.log(response);
      }

    });
  }


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
</script>

<?= $this->endSection() ?>