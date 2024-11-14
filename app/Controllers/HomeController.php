<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Libraries\TokenManagement\TokenManagement;
use CodeIgniter\HTTP\RequestInterface;

require_once APPPATH . 'Libraries/EnumsAndConstants/Enums.php';
class HomeController extends BaseController
{

    protected $user = null;
    protected $logger;

    public function __construct(RequestInterface $request)
    {


        $tokenManagement = new TokenManagement();
        $this->user = $tokenManagement->verify_token($request);
        // Initialize the Log library
        $this->logger = service('logger');
    }
}
