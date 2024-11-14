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
        padding: 10px;
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
        margin: 10px 0px;
    }

    .checkbox-menu li label:hover,
    .checkbox-menu li label:focus {
        background-color: #ebf3fc;
        border-radius: 10px;
        padding: 10px;
        margin: 10px 0px;
    }

    .checkbox-menu li.active label:hover,
    .checkbox-menu li.active label:focus {
        background-color: #ebf3fc;
        border-radius: 10px;
        padding: 10px;
        margin: 10px 0px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }
</style>
<section class="home">
    <div class="container">
        <h2 class="crt-survey-h2 dash mt-3">Create Survey</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="crt-survey">
                    <form id="surveyForm" class="form-horizontal" action="<?= base_url('csat/createSurvey') ?>"
                        method="post">
                        <?= csrf_field() ?> <!-- Ensures CSRF protection -->
                        <!-- Survey Name -->
                        <div class="form-group">
                            <div class="q-base-1">
                                <h3>Brand Name</h3>
                            </div>
                            <div class="campaign">
                                <input id="survey_name" name="survey_name" type="text" placeholder="Survey Name"
                                    oninput="updatePreview()" />
                                <p style="color:red" class="error" id="survey_name_error"></p>
                            </div>
                        </div>
                        <!-- Survey Question -->
                        <div class="form-group">
                            <div class="q-base-1">
                                <h3>Survey Question</h3>
                            </div>
                            <div class="campaign satisfaction">
                                <label>How satisfied were you with</label><br>
                                <input id="company_service" name="company_service" type="text"
                                    placeholder="Company/ Product/ Services" oninput="updatePreview()" />
                                <p style="color:red" class="error" id="company_service_error"></p>
                            </div>
                        </div>
                        <!-- Rating Style Selection -->
                        <div class="form-group">
                            <div class="q-base-1">
                                <h3>Rating styles</h3>
                            </div>
                            <select class="custom-select form-select custom-select-sm" id="main_question"
                            name="main_question" onchange="updatePreview()">
                                <option value="" selected disabled>Please select the main question</option>
                                <option value="Satisfy">Satisfied</option>
                                <option value="Star">Star</option>
                                <option value="Number">Number</option>
                                <option value="Emoji">Emoji</option>
                            </select>
                            <p style="color:red" class="error" id="main_question_error"></p>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="mt-5 mb-5">
                                <input type="submit" name="submit" id="submit" class="btn btn-default btn-block"
                                    value="Save" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview mode toggle buttons -->
            <div class="col-md-8">
                <div class="preview-toggle">
                    <button id="desktop-view" onclick="togglePreview('desktop')">Desktop View</button>
                    <button id="mobile-view" onclick="togglePreview('mobile')">Mobile View</button>
                </div>
                <!-- Display the real-time preview of Brand Name, Survey Question, and Rating Style -->
                <div id="previewContainer" class="preview-desktop">
                    <hr>
                    <div class="content-view">
                        <div class="brnd-name-display">
                            <p id="brandPreview">Brand
                                Name</p>
                        </div>
                        <div class="content-view-survey">
                            <div class="survey-que-display">
                                <p>How Satisfied were you with <span id="surveyPreview">Company / Product /
                                        Service</span></p>
                            </div>
                            <div class="rating-style-display">
                                <p id="ratingPreview"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Function to update the preview text as the user types and selects a rating style
            function updatePreview() {
                const brandName = document.getElementById("survey_name").value;
                const surveyQuestion = document.getElementById("company_service").value;
                const ratingStyle = document.getElementById("main_question").value;

                document.getElementById("brandPreview").textContent = brandName || "Brand Name";
                document.getElementById("surveyPreview").textContent = surveyQuestion || "How Satisfied were you with Company / Product / Service";

                const ratingPreview = document.getElementById("ratingPreview");

                // Update rating style preview based on selected option
                switch (ratingStyle) {
                    case 'Satisfy':
                        ratingPreview.innerHTML = `
                    <button type="button" class="btn btn-outline-primary">Very Unsatisfied</button>
                    <button type="button" class="btn btn-outline-primary">Unsatisfied</button>
                    <button type="button" class="btn btn-outline-primary">Neutral</button>
                    <button type="button" class="btn btn-outline-primary">Satisfied</button>
                    <button type="button" class="btn btn-outline-primary">Very Satisfied</button>
                `;
                        break;
                    case 'Star':
                        ratingPreview.innerHTML = `
                    <button type="button" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg></button>
                    <button type="button" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg></button>
                    <button type="button" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg></button>
                    <button type="button" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg></button>
                    <button type="button" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg>&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <g clip-path="url(#clip0_3401_2327)">
    <path d="M9.44071 14.5436C9.16931 14.3792 8.829 14.3792 8.55761 14.5437L4.39532 17.0665C3.75017 17.4575 2.95263 16.8789 3.12406 16.1443L4.22755 11.4153C4.29924 11.1081 4.19529 10.7864 3.95739 10.5792L0.293637 7.38862C-0.273874 6.8944 0.031211 5.96092 0.781053 5.89724L5.60934 5.48723C5.92375 5.46053 6.19766 5.26223 6.3212 4.97188L8.21605 0.518403C8.51015 -0.172801 9.48985 -0.172801 9.78395 0.518404L11.6788 4.97188C11.8023 5.26224 12.0762 5.46053 12.3907 5.48723L17.2189 5.89724C17.9688 5.96092 18.2739 6.8944 17.7064 7.38862L14.0426 10.5792C13.8047 10.7864 13.7008 11.1081 13.7725 11.4153L14.876 16.1446C15.0474 16.8792 14.25 17.4578 13.6048 17.0668L9.44071 14.5436Z" fill="#FFC500"/>
  </g>
  <defs>
    <clipPath id="clip0_3401_2327">
      <rect width="18" height="17.25" fill="white"/>
    </clipPath>
  </defs>
</svg></button>
                `;
                        break;
                    case 'Number':
                        ratingPreview.innerHTML = `
                    <button type="button" class="btn btn-outline-primary">1</button>
                    <button type="button" class="btn btn-outline-primary">2</button>
                    <button type="button" class="btn btn-outline-primary">3</button>
                    <button type="button" class="btn btn-outline-primary">4</button>
                    <button type="button" class="btn btn-outline-primary">5</button>
                `; break;
                    case 'Emoji':
                        ratingPreview.innerHTML = `
                    <button type="button" class="btn btn-outline-primary">😡</button>
                    <button type="button" class="btn btn-outline-primary">😟</button>
                    <button type="button" class="btn btn-outline-primary">😐</button>
                    <button type="button" class="btn btn-outline-primary">🙂</button>
                    <button type="button" class="btn btn-outline-primary">😍</button>
                `; break;
                    default:
                        ratingPreview.innerHTML = "";
                }
            }
            // Function to toggle preview between desktop and mobile view
            function togglePreview(view) {
                const previewContainer = document.getElementById("previewContainer");
                if (view === "desktop") {
                    previewContainer.classList.remove("preview-mobile");
                    previewContainer.classList.add("preview-desktop");
                    document.getElementById("desktop-view").classList.add("active");
                    document.getElementById("mobile-view").classList.remove("active");
                } else {
                    previewContainer.classList.remove("preview-desktop");
                    previewContainer.classList.add("preview-mobile");
                    document.getElementById("mobile-view").classList.add("active");
                    document.getElementById("desktop-view").classList.remove("active");
                }
            }
        </script>

        <!-- CSS for desktop and mobile preview styles -->




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
        var isError = false;
        var surveyName = $("#survey_name").val();
        var mainQuestion = $("#main_question").val();
        // var answerType = $("#answer_type").val();
        var companyService = $("#company_service").val();

        if (surveyName.length < 5) {
            isError = true;
            $("#survey_name_error").text("Please enter at least 5 characters.");
        }
        if (!mainQuestion) {
            isError = true;
            $("#main_question_error").text("lease choose a rating style.");
        }
        if (!companyService) {
            isError = true;
            $("#company_service_error").text("Please enter a service question.");
        }
        // if (!answerType) {
        //     isError = true;
        //     $("#answer_type_error").text("Please choose an answer type.");
        // }

        if (!isError) {
            $.ajax({
                type: form.attr("method"),
                url: form.attr("action"),
                data: form.serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.url;
                    } else {
                        const errorArr = ["survey_name_error", "main_question_error", "company_service_error", "answer_type_error", "question_1_error", "question_2_error", "question_3_error", "question_4_error", "question_5_error"];
                        const idArr = ["survey_name", "main_question", "company_service", "answer_type", "question_1", "question_2", "question_3", "question_4", "question_5"];
                        errorDisplay(errorArr, idArr, response.error);
                    }
                },
                error: function (response) {
                    console.log("failure", response);
                }
            });
        }
    });

    function errorDisplay(errorArr, idArr, errorMessages) {
        errorArr.forEach((errorField, index) => {
            const errorMsg = errorMessages[errorField];
            if (errorMsg) {
                $("#" + errorField).text(errorMsg);
            } else {
                $("#" + errorField).text("");
            }
        });
    }


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