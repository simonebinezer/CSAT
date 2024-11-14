<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'UserController::login');

$routes->match(['get', 'post'], 'login', 'UserController::login', ["filter" => "noauth"]);
$routes->match(['get', 'post'], 'signup', 'TenantController::createtenant', ["filter" => "noauth"]);
$routes->match(['get', 'post'], 'forget', 'UserController::forget', ["filter" => "noauth"]);

$routes->get('verificationpage', 'UserController::generateOtp');
$routes->match(['get', 'post'], 'verificationpage', 'UserController::generateOtp', ["filter" => "noauth"]);

$routes->match(['get', 'post'], 'updateprofile', 'UserController::updateprofile', ["filter" => "auth"]);

$routes->match(['get', 'post'], 'tenant_data', 'TenantController::createtenantOld', ["filter" => "auth"]);

$routes->match(['get', 'post'], 'paswordupdate', 'UserController::updatepassword', ["filter" => "auth"]);

// Admin routes
$routes->group("admin", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "AdminController::index");
});
// Editor routes
$routes->group("user", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "SubuserController::index");
});
$routes->get('signup', 'TenantController::createtenant');

$routes->get('userprofile', 'UserController::getprofile', ["filter" => "auth"]);
$routes->get('changepassword', 'UserController::changepassword', ["filter" => "auth"]);
$routes->get('userpermission', 'TenantController::getUserDetails', ["filter" => "auth"]);
$routes->get('createtenant', 'TenantController::index', ["filter" => "auth"]);
$routes->get('createquestion', 'QandAController::index', ["filter" => "auth"]);
$routes->get('questionList', 'QandAController::questionList', ["filter" => "auth"]);
$routes->get('editquestion/(:num)', 'QandAController::editquestion/$1', ["filter" => "auth"]);
$routes->get('deletequestion/(:num)', 'QandAController::deletequestion/$1', ["filter" => "auth"]);

//csat 
$routes->group("csat", ["filter" => "auth"], function ($routes) {

    //Question and answers
    $routes->get('questionList', 'CSATQandAController::CSATQuestionList', ["filter" => "auth"]);
    $routes->match(["get", "post"], 'addQuestion', 'CSATQandAController::CreateCSATQuestion', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'editQuestion/(:num)', 'CSATQandAController::EditCSATQuestion/$1', ["filter" => "auth"]);
    $routes->post('deleteQuestion', 'CSATQandAController::DeleteCSATQuestion', ["filter" => "auth"]);
    $routes->get('answerList', 'CSATQandAController::AnswerList', ["filter" => "auth"]);
    $routes->post('updateEmoji', 'CSATQandAController::UpdateEmojiAnswer', ["filter" => "auth"]);
    $routes->post('updateText', 'CSATQandAController::UpdateTextAnswer', ["filter" => "auth"]);

    $routes->match(['get', 'post'], 'sendSurvey', 'CSATSurveyController::SendSurvey', ["filter" => "auth"]);

   
   
   //survey
    $routes->get('surveyList', 'CSATSurveyController::SurveyList', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'createSurvey', 'CSATSurveyController::AddOrUpdateSurvey', ["filter" => "auth"]);
    $routes->match(['get', 'post'], 'editSurvey', 'CSATSurveyController::AddOrUpdateSurvey', ["filter" => "auth"]);
    $routes->post('deleteSurvey', 'CSATSurveyController::DeleteSurvey', ["filter" => "auth"]);

    //survey response

$routes->match(['get', 'post'], 'surveyResponse', 'CSATSurveyResponseController::SurveyResponse', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'downloadCsv', 'CSATSurveyResponseController::DownloadCsv', ["filter" => "auth"]);

});

$routes->get('csat/getSurveyQuestion/(:any)/(:any)/(:any)/(:any)', 'CSATSurveyController::GetSurveyQuestion/$1/$2/$3/$4');
$routes->post('csat/getNextQuestion', 'CSATSurveyController::GetNextQuestion');
$routes->match(['get', 'post'], 'csat/saveResponse', 'CSATSurveyController::SaveResponse');





$routes->get('emailtemplate', 'EmailTemplateController::index', ["filter" => "auth"]);
$routes->get('SurveyResponse', 'SurveyResponseController::index', ["filter" => "auth"]);
$routes->get('getCustomerData', 'CustomerController::GetCustomerList', ["filter" => "auth"]);
$routes->get('settingpage', 'TenantController::settingpage', ["filter" => "auth"]);

//Customer Details
$routes->match(['get', 'post'], 'EditCustomer', 'CustomerController::UpdateCustomerDetails', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'AddCustomer', 'CustomerController::InsertCustomerDetails', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'DeleteCustomer', 'CustomerController::DeleteCustomer', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'UploadFileCustomer', 'CustomerController::UploadFileCustomer', ["filter" => "auth"]);
$routes->get('searchMails', 'EmailTemplateController::SearchMails', ["filter" => "auth"]);

//Tag Details
$routes->post('mapTag', 'CustomerController::MapTag', ["filter" => "auth"]);
$routes->post('createTag', 'CustomerController::CreateTag', ["filter" => "auth"]);
$routes->post('editTag', 'CustomerController::EditTag', ["filter" => "auth"]);
$routes->post('deleteTag', 'CustomerController::DeleteTag', ["filter" => "auth"]);

//Segment Details
$routes->get('getSegments', 'CustomerController::GetSegmentsAndTags', ["filter" => "auth"]);
$routes->post('addTag', 'CustomerController::AddTagWithSegment', ["filter" => "auth"]);
$routes->post('createSegment', 'CustomerController::CreateSegment', ["filter" => "auth"]);
$routes->post('editSegment', 'CustomerController::EditSegment', ["filter" => "auth"]);
$routes->post('deleteSegment', 'CustomerController::DeleteSegment', ["filter" => "auth"]);

// Answer details
$routes->get('createAnswer', 'AnswerlistController::createAnswer', ["filter" => "auth"]);
$routes->get('answerList', 'AnswerlistController::index', ["filter" => "auth"]);
$routes->get('editAnswer/(:num)', 'AnswerlistController::editAnswer/$1', ["filter" => "auth"]);
$routes->get('deleteAnswer/(:num)', 'AnswerlistController::deleteAnswer/$1', ["filter" => "auth"]);


$routes->match(['get', 'post'], 'changerole', 'AdminController::updateRole', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'editquestion/(:num)', 'QandAController::editquestion/$1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'deletequestion/(:num)', 'QandAController::deletequestion/$1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'uploadFile', 'EmailTemplateController::uploadFile', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'sendEmail', 'EmailTemplateController::sendEmail', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'create_question', 'QandAController::createQuestion', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'createsurveyanswer', 'EmailTemplateController::createsurveyanswer');

$routes->match(['get', 'post'], 'getquestionnext', 'EmailTemplateController::getquestionnext');
$routes->match(['get', 'post'], 'settingupdate', 'TenantController::settingupdate', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'logoupload', 'TenantController::logoupload', ["filter" => "auth"]);
//new survey
$routes->get('createSurvey', 'SurveyController::index', ["filter" => "auth"]);
$routes->get('surveyList', 'SurveyController::surveyList', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'create_survey', 'SurveyController::createSurvey', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'deletesurvey/(:num)', 'SurveyController::deletesurvey/$1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'editsurvey/(:num)', 'SurveyController::editsurvey/$1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'uploadPreviousAnswers', 'AnswerlistController::GetPreviousAnswers', ["filter" => "auth"]);

//surveyResponse

$routes->match(['get', 'post'], 'SurveyResponse', 'SurveyResponseController::index', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'DownloadCsv', 'SurveyResponseController::DownloadCsv', ["filter" => "auth"]);

// Answer List
$routes->match(['get', 'post'], 'createAnswer', 'AnswerlistController::createAnswer', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'editAnswer/(:num)', 'AnswerlistController::editAnswer/$1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'deleteAnswer/(:num)', 'AnswerlistController::deleteAnswer/$1', ["filter" => "auth"]);
//new Answer List
$routes->match(['get', 'post'], 'createAnswer1', 'AnswerlistController::createAnswer1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'deleteAnswer1', 'AnswerlistController::deleteAnswer1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'editAnswer1', 'AnswerlistController::editAnswer1', ["filter" => "auth"]);
$routes->match(['get', 'post'], 'deleteTempRecords', 'AnswerlistController::DeleteTempRecords', ["filter" => "auth"]);



$routes->get('Migrate', 'Migrate::index');

$routes->get('/ajax-request', 'AdminController::ajaxrequest');


$routes->get('validatepage/(:num)', 'UserController::validatepage/$1');
$routes->get('activateOption/(:num)', 'UserController::activateOption/$1');
$routes->get('logout', 'UserController::logout');
$routes->get('forget', 'UserController::forget');
$routes->match(['get', 'post'], 'getSurveyAnwser/(:any)/(:any)/(:any)/(:any)', 'EmailTemplateController::getSurveyAnwser/$1/$2/$3/$4');
$routes->get('getSurveyAnwser/(:any)/(:any)/(:any)/(:any)', 'EmailTemplateController::getSurveyAnwser/$1/$2/$3/$4');

$routes->get('resetpwd', 'UserController::resetpwd');
$routes->match(['get', 'post'], 'resetpwd', 'UserController::resetpwd');


$routes->get('overallreport', 'OverallReportController::index', ["filter" => "auth"]);
$routes->get('support', 'OverallReportController::comingSoon', ["filter" => "auth"]);
$routes->get('geomatrix', 'OverallReportController::comingSoon', ["filter" => "auth"]);
$routes->get('reports', 'OverallReportController::comingSoon', ["filter" => "auth"]);
$routes->get('pdfGenerateCurrentYr/(:any?)/(:any?)', 'OverallReportController::pdfGenerateCurrentYr/$1/$2', ["filter" => "auth"]);
$routes->get('excelGenerateCurrentYr', 'OverallReportController::excelGenerateCurrentYr', ["filter" => "auth"]);


$routes->get('createAccount/(:any)', 'TenantController::CreateAccount/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
