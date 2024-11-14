<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Include the necessary CSS and JS files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.js"></script>

<style>
  

  .customerlistpg {
    background: #fff;
    padding: 20px 15px 50px;
    border-radius: 20px;
  }

  .table-striped>tbody>tr:nth-of-type(odd)>* {
    --bs-table-color-type: var(--bs-table-striped-color);
    --bs-table-bg-type: #fff;
  }

  .table-bordered>:not(caption)>*>* {
    border-width: 0;
    /* text-align: center; */
    border-bottom: 1px solid #EBF3FC;
  }

  .home .table thead tr th {
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
  }

  .home .table tbody tr td {
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    /* line-height: normal; */
  }

  .home .table tbody tr td .edit {
    padding: 0px;
  }

  .home .table tbody tr td .delete {
    padding: 0px;
  }

  .customerlistpg .add {
    background: #0A2472;
    padding: 5px 20px;
    border-radius: 15px;
  }

  .btn-success,
  .btn-success:hover,
  .btn-success:active,
  .btn-success::after {
    background: #0A2472 !important;
    padding: 5px 20px;
    border-radius: 15px;
  }

  #uploadForm .csv {
    background: none;
    padding: 5px 20px;
    border-radius: 15px;
    color: #000;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    border: 1px solid #0A2472;
  }

  .upload-download {
    display: flex;
    justify-content: space-between;
  }

  .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    border: 1px solid #092C4C;
    height: 30px;
    color: #092C4C;
    font-size: 12px;
    width: 30px;
  }

  .active>.page-link,
  .page-link.active,
  .page-link:hover,
  .page-link:active {
    background: #092C4C;
    color: #fff;
  }

  .page-item:first-child .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    height: 30px;
    width: 30px;
    padding: 5px 12px;
  }

  .page-item:last-child .page-link {
    margin: 0px 5px !important;
    border-radius: 50px;
    height: 30px;
    width: 30px;
    padding: 6px 12px;
  }

  .home .table tbody tr td .send-email {
    padding: 0px;
  }
</style>
<section class="home">
  <div class="container">

    <!-- Breadcrumbs-->
    <!-- <?php include APPPATH . 'Views/layouts/breadcrumb.php'; ?> -->
    <!-- Page Content -->
    <h1 class="dash">Contact Details</h1>
    <!-- <hr> -->

    <div class="customerlistpg">
      <div class="row">
        <div class="col-md-7">
          <div class="download">
            <!-- <div>
            <a href="<?php echo base_url(); ?>uploads/template.csv" class="btn btn-success add pull-left mb-2"  id="output"  download><span class="glyphicon glyphicon-plus">Download</span></a>
            </div> -->
            <div>
              <form id="uploadForm">
                <div class="upload-download pull-left mb-2">
                  <label for="uploadfile" class="btn csv"> Upload csv <img src="<?php echo base_url(); ?>images/icons/upload.png" class="img-centered img-fluid"></label>
                  <input type="file" class="btn btn-success upload" name="formData" style="display: none;" id="uploadfile">
                </div>
              </form>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>uploads/template.csv" class="pull-left mb-3"  id="output"  download><span class="description">(click here to download CSV template)</span></a>
        </div>
        <div class="col-md-5">
          <div class="download-1">
            
            <div>
              <button type="button" class="btn btn-success add pull-right mb-3" data-bs-toggle="modal" data-bs-target="#AddModal" id="AddCustomer"><span class="glyphicon glyphicon-plus">Add
                  Customer</span></button>
            </div>
            

          </div>
          <a href="<?= base_url();?>getSegments" style="font-size: 12px;color:#000" class="pull-right">click here to manage tags and segments</a>
        </div>
      </div>

      <br />
      

      <?php if (!empty($userslist)) { ?>

        <table class="table table-striped table-bordered" id="customer">
          <thead>
            <tr>
              <th scope="col">SNo
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
              </th>
              <th scope="col" style="display:none;"> Id </th>
              <th scope="col">Name
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
              </th>
              <th scope="col">Email Id
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
              </th>
              <th scope="col">Contact No
                <!-- <img src="<?php echo base_url(); ?>images/icons/Alphabetical-Sorting.png"
                  class="img-centered img-fluid"> -->
              </th>
              <th colspan="3" class="pull-centre" scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $count = 0;
            foreach ($userslist as $userdata) {
              $count++; ?>
              <tr id="row">
                <td>
                  <?php echo  $count; ?>
                </td>
                <td scope="row" style="display:none;">
                  <?php echo $userdata['customer_id']; ?>
                </td>
                <td>
                  <?php echo $userdata['name'] ?>
                </td>
                <td>
                  <?php echo $userdata['email']; ?>
                </td>
                <td>
                  <?php echo $userdata['phone_no']; ?>
                </td>
                <td><button type="button" class="btn btn-default edit" data-bs-toggle="modal" data-bs-target="#EditModal" id="EditCustomer"><img src="<?php echo base_url(); ?>images/icons/Create.png" class="img-centered img-fluid"></button></td>

                <td><button type="button" class="btn btn-default delete" data-bs-toggle="modal" data-bs-target="#DeleteModal" id="DeleteCustomer"><img src="<?php echo base_url(); ?>images/icons/Remove.png" class="img-centered img-fluid"></button></td>

                <td>
                  <form action="<?= base_url('sendEmail') ?>" method="post">
                    <input type="hidden" name="email_id" value="<?php echo $userdata['email']; ?>">
                    <button type="submit" class="btn btn-default send-email" action="" id="send-email"><img src="<?php echo base_url(); ?>images/icons/Send-Email.png" class="img-centered img-fluid"></button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>

        </table>

        <!-- <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled">
              <a class="page-link">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav> -->
      <?php } else { ?>
        <div class="text-center">
          <p class="fs-3"> <span class="text-danger">Oops!</span>No records found.</p>
        </div>
      <?php } ?>

    </div>
  </div>
</section>


<!-- Modal -->
<!-- <style>
  .modal-header,
  h4,
  .modal-header .close {
    background-color: #0a2472;
    color: white !important;
    text-align: center;
    font-size: 35px;
    border: 0px;
  }

  .modal-footer {
    background-color: #f9f9f9;
  }

  .btn-danger {
    width: 100%;
    margin: 0px auto 15px;
  }
</style> -->
<!-- #region --><!-- ADD MODAL -->
<div class="container">


  <div class="modal fade" id="AddModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:37px 0px 20px">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Add Customer</h4>
        </div>
        <div class="modal-body gap-3" style="">
          <form role="form" action="<?= base_url('AddCustomer') ?>" method="post" id="Add_form">

            <div class="form-group">
              <div class="form-field">
                <label for="first_name"><span class="glyphicon glyphicon fa fa-user"></span> First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="V1">
                  <?= $validation->showError('first_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="last_name"><span class="glyphicon glyphicon fa fa-user"></span> Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="V2">
                  <?= $validation->showError('last_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="email"><span class="glyphicon glyphicon fa fa-envelope"></span> Email Id</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="V3">
                  <?= $validation->showError('email') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="contact"><span class="glyphicon glyphicon fa fa-phone"></span> Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="V4">
                  <?= $validation->showError('contact') ?>
                </div>
              <?php endif; ?>
            </div>
            <br />
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-block save"><span class="glyphicon glyphicon fa fa-plus"></span> Add</button>
            </div>
          </form>
        </div>
        <div class="d-grid" style="padding:0px 20px 20px">
          <button type="submit" class="btn btn-danger btn-default pull-right" id="close" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- #endregion -->

<!-- #region --><!-- EDIT MODAL -->
<div class="container">


  <div class="modal fade" id="EditModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:37px 0px 20px;">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Edit Customer</h4>
        </div>
        <div class="modal-body" style="">
          <form action="<?= base_url('EditCustomer') ?>" method="post">

            <div class="form-group">
              <div class="form-field">
                <label for="E_first_name"><span class="glyphicon glyphicon fa fa-user"></span> First Name</label>
                <input type="text" class="form-control" id="E_first_name" name="first_name" value="<?php echo set_value('E_first_name'); ?>" placeholder="Enter First name">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="E1">
                  <?= $validation->showError('first_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="E_last_name"><span class="glyphicon glyphicon fa fa-user"></span> Last Name</label>
                <input type="text" class="form-control" id="E_last_name" name="last_name" value="<?php echo set_value('E_last_name'); ?>" placeholder="Enter Last name">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="E2">
                  <?= $validation->showError('last_name') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="E_email"><span class="glyphicon glyphicon fa fa-envelope"></span> Email Id</label>
                <input type="text" class="form-control" id="E_email" name="email" value="<?php echo set_value('E_email'); ?>" placeholder="Enter Email">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="E3">
                  <?= $validation->showError('email') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <label for="E_contact"><span class="glyphicon glyphicon fa fa-phone"></span> Contact</label>
                <input type="text" class="form-control" id="E_contact" name="contact" value="<?php echo set_value('E_contact'); ?>" placeholder="Enter Contact">
              </div>
              <?php if (isset($validation)) : ?>
                <div style="color:red; text-align:left;margin:0px 20px" id="E4">
                  <?= $validation->showError('contact') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <div class="form-field">
                <input type="hidden" class="form-control" id="E_Id" name="E_Id">
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
          <button type="submit" class="btn btn-danger btn-default pull-right" id="E_close" data-bs-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- #endregion -->


<!-- #region --><!-- DELETE MODAL -->
<div class="container">


  <div class="modal fade" id="DeleteModal">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:15px 50px;">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4> Delete Customer</h4>
        </div>
        <form action="<?= base_url('DeleteCustomer') ?>" method="post">
          <div class="modal-body" style="padding:40px 50px 20px;">
            <p> Are you sure you want to remove the customer from the customer list?</p>
            <div class="form-group">
              <input type="hidden" class="form-control" id="Id" name="Id" placeholder="Enter Contact">
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


<div class="modal fade" id="dropdownModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:15px 50px;">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        <h4> Tag as:</h4>
      </div>
      <form action="<?= base_url('mapTag') ?>" method="post">
        <div class="modal-body" style="padding:40px 50px 20px;">
          <input type="hidden" id="tagCustomerId" name="customerId">
          <?php if (!empty($tagList)) {
            foreach ($tagList as $tag) { ?>
              <div>
                <input type="checkbox" id="tag<?= $tag['tag_id']; ?>" name="tagList[]" value="<?= $tag['tag_id']; ?>" />
                <label for="tag<?= $tag['tag_id']; ?>"><?= $tag['tag_name']; ?></label>
              </div>

            <?php } ?>
          <?php } ?>
          <br />
          <div class="d-grid">
            <button type="submit" class="btn btn-danger confirm pull-right"><span class="fa fa-add"></span>
              Confirm</button>
            <button type="button" class="btn btn-outline-secondary Cancel pull-left" data-bs-dismiss="modal"><span class="fa fa-remove"></span> Cancel</button>
          </div>
        </div>
      </form>


    </div>
  </div>
</div>

<?php if (isset($Function)) : ?>
  <?php if ($Function == "ADD") : ?>
    <!-- #region --><!-- ADD MODAL Script -->
    <script>
      $(document).ready(function() {
        $('#AddModal').modal('show')
        var a = <?php echo ($Data); ?>;
        //console.log(a.E_Id);
        $('#first_name').val(a.first_name);
        $('#last_name').val(a.last_name);
        $('#email').val(a.email);
        $('#contact').val(a.contact);
      });
    </script>
  <?php elseif ($Function == "EDIT") : ?>
    <script>
      $(document).ready(function() {
        $('#EditModal').modal('show')
        var a = <?php echo ($Data); ?>;
        $('#E_Id').val(a.E_Id);
        $('#E_first_name').val(a.first_name);
        $('#E_last_name').val(a.last_name);
        $('#E_email').val(a.email);
        $('#E_contact').val(a.contact);

      });
    </script>
  <?php endif; ?>
<?php endif; ?>


<script>
  $(document).ready(function() {
    //remove validation messages
    $("#close").on('click', function() {
      $('#Add_form').trigger("reset");
      removeValidation("V");
      removeValidation("E");
    });

    $("#E_close").on('click', function() {
      removeValidation("E");
      removeValidation("V");
    });

    function removeValidation(param) {
      var id = param;
      for (let index = 1; index <= 4; index++) {
        console.log(index);
        var final_Id = id + index;
        console.log(final_Id);
        var element = document.getElementById(final_Id);
        console.log(element);
        element.parentNode.removeChild(element);
      }
    }

    window.onload = function() {
      history.replaceState("", "", "/getCustomerData");
    }
    $(document).on('change', 'input[type="file"]', function() {
      // console.log(file1);
      var file = null;
      var file = $('#uploadfile').prop('files')[0];
      console.log(file);

      var formData = new FormData();
      formData.append('formData', file);
      console.log(formData);
      $.ajax({
        url: '<?php echo base_url('UploadFileCustomer'); ?>',
        type: 'post',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          console.log(response);
          if (response.success) {
            console.log(response);
            if (response.count > 0) {
              if (!alert(response.count + " customer's details uploaded successfully!")) {
                window.location.reload();
              }
            } else {
              alert(" File contains no data or the customer's email is already present.")
            }

          } else {
            console.log(response);
            alert("ERROR: " + response.validation['formData'])
            $('#uploadForm').trigger("reset");
          }
        },
        error: function(response) {
          console.log(response);
        }
      });
    });
  });
</script>
<script>
  function editCustomer(data) {
    $("#EditModal").modal('show');
    //getting data of selected row using id.
    console.log(data.name);
    //splitting the name
    var nameArray = data.name.trim().split(" ");
    // getting the value of the input fields and assign it to form values.
    $('#E_Id').val(data.customer_id);
    $('#E_first_name').val(nameArray[0]);
    $('#E_last_name').val(nameArray[1]);
    $('#E_email').val(data.email);
    $('#E_contact').val(data.phone_no);
  }

  function deleteCustomer(data) {
    $("#DeleteModal").modal('show');
    console.log(data);
    // getting the value of the input field and assign it to form value.
    $('#Id').val(data.customer_id);
  }

  

  function mapTagandCustomer(customerId, tagList) {
    if (tagList) {

      var tagArray = tagList.split(",");
    }
    console.log(tagArray);
    $("#dropdownModal").modal('show');
    $('input:checkbox').prop('checked', false);
    if (tagArray) {
      tagArray.forEach(element => {
        // console.log("element",tagArray.length);
        // console.log("element",element);
        document.getElementById("tag" + element).checked = true;;
      });
    }
    $('#tagCustomerId').val(customerId);
  }

  //tag filter logic
  var tags = [];
  <?php
  $tagsArray = [];
  $encoded = '';
  foreach ($tagList as $tag => $tagName) {
    array_push($tagsArray, $tagName['tag_name']);
  }
  $encoded = json_encode($tagsArray);
  ?>
  tags = (<?= $encoded ?>);
  tags.unshift("");
</script>
<script>
  $(function() {
    // Initializing the JSGrid
    $("#customer").jsGrid({
      width: "100%",
      autoload: true,
      filtering: true,
      //pageloading:true,
      paging: true,
      pageSize: 15,
      pageButtonCount: 10,
      fields: [{
          name: "name",
          type: "text",
          title: "Name",
          width: 50,

        },
        {
          name: "email",
          type: "text",
          title: "Email",
          width: 100
        },
        {
          name: "phone_no",
          type: "text",
          title: "Phone Number",
          filtering: false,
          width: 50
        },
        {
          name: "tag_names",
          title: "Tags",
          type: "select",
          items: tags,
          valueField: "value",
          itemTemplate: function(value, item) {
            return value.split(",").join(", ");
          },
          filtering: true,
          width: 50
        },
        {
          title: "Actions",
          align: "center",
          sorting: false,
          itemTemplate: function(value, item) {
            var $editButton = $("<button>")
              .attr("type", "button")
              .html('<img src="<?php echo base_url(); ?>images/icons/edit-1.png"  alt="edit" class="img-centered js-grid-icons img-fluid" title="Edit Customer"></button>')
              .on("click", function() {
                // Implement your edit logic here
                editCustomer(item);
              });

            var $deleteButton = $("<button>")
              .attr("type", "button")
              .addClass("button")
              .html('<img src="<?php echo base_url(); ?>images/icons/remove-1.png" class="img-centered js-grid-icons img-fluid" title="Delete Customer">')
              
              .on("click", function() {
                // Implement your delete logic here
                deleteCustomer(item);
              });
            var $tagButton = $("<button>")
              .attr("type", "button")
              .attr("id", "show-form-btn")
              .addClass("button")
              .html('<img src="<?php echo base_url(); ?>images/icons/plus.png" class="img-centered js-grid-icons img-fluid" title="Add Tag">')
              // .addClass("jsgrid-button jsgrid-insert-button")
              .on("click", function() {
                // Implement your edit logic here
                console.log("item", item);
                mapTagandCustomer(item.customer_id, item.tag_id_list);
              });

            var $emailButton = $("<button>").addClass("mail-btn")
              // .text("mail")
              .html('<img src="<?php echo base_url(); ?>images/icons/gmail.png" class="img-centered js-grid-icons img-fluid" title="Send Mail">')
            var input = $("<input>").attr("type", "hidden").attr("name", "email_id").attr("value", item.email).addClass("jsgrid-edit-hidden");
            var $form = $("<form>")
              .attr("action", "<?= base_url('sendEmail') ?>")
              .attr("method", "post")
              .append(input)
              .append($emailButton);
            var $actionsContainer = $("<div>").append(
              $editButton, // Edit button
              $deleteButton,
              $tagButton,
              $form // Delete button
            );

            return $actionsContainer;
          }
        }
      ],
      sorting: true,
      controller: {
        data: <?php echo json_encode($userslist); ?>,
        loadData: function(filter) {
          return $.grep(this.data, function(item) {
            return ((!filter.name || item.name.indexOf(filter.name) >= 0) && (!filter.email || item.email.indexOf(filter.email) >= 0) && (!filter.tag_names || item.tag_names.indexOf(filter.tag_names) >= 0));
          });
        }
      }



    });
  });
</script>


<?= $this->endSection() ?>