<?php

namespace Controllers;

use App\Controller;

// DEFINE CLASS NAME = FILE NAME = CONTROLLER NAME
class NameController extends Controller
{

    /**
     * Default path to the view
     * @var string
     */
    // THIS VARIABLE IS USED IN RENDER TO DEFINE THE DEFAULT VIEW PATH OF THE CONTROLLER 
    private string $default_path = "users/profil"; 

    // CONTROLLER CONSTRUCTOR THAT VERIFIES IF THE USER IS LOGGED IN, OTHERWISE REDIRECTS TO THE HOME PAGE
    // IT IS NOT POSSIBLE TO USE BOTH TYPES OF CONSTRUCTORS AT THE SAME TIME 
    // IT IS POSSIBLE TO CHANGE THE HOME PAGE PATH BY MODIFYING THE PARAMETER OF THE redirect() FUNCTION
    public function __construct()
    {
        if ($this->isLogged() === false) {
            $this->redirect('../home');
            exit();
        }
    }

    // OTHER CONSTRUCTOR TYPE THAT VERIFIES IF USER IS LOGGED IN AND IS ADMIN, OTHERWISE REDIRECTS TO HOME PAGE
    // IT IS NOT POSSIBLE TO USE BOTH TYPES OF CONSTRUCTORS AT THE SAME TIME 
    // IT IS POSSIBLE TO CHANGE THE HOME PAGE PATH BY MODIFYING THE PARAMETER OF THE redirect() FUNCTION
    public function __construct()
    {

        if ($this->isLogged() === false) {
            $this->redirect('../home');
            exit();
        }

        if ($this->isAdmin($this->getUserId()) === false) {
            $this->redirect('../home');
            exit();
        }

        if($this->isRh($this->getUserId()) === false){
            $this->redirect('../home');
            exit();
        }

        if ($this->isProvider($this->getUserId()) === false) {
            $this->redirect('../home');
            exit();
        }
    }

    /**
     * Display the user profil page
     *
     * @return void
     */
    // METHOD = FUNCTION = CORRESPONDS TO A PAGE OR AN ACTION 
    public function profil(): void
    {

        // GET URL PARAMETERS AFTER CONTROLLER NAME AND METHOD 
        // EXAMPLE : http://localhost/NameController/profil/1/2/3
        // HERE THE PARAMETERS ARE 1, 2, AND 3
        // PARAMETERS ARE STORED IN AN ARRAY
        // EXAMPLE : HERE THE ARRAY $params CONTAINS THE PARAMETERS 1, 2, AND 3
        // WE CHECK IF THE $params ARRAY CONTAINS PARAMETERS AND IF THE FIRST PARAMETER IS A NUMBER
        // IF THE $params ARRAY IS EMPTY OR IF THE FIRST PARAMETER IS NOT A NUMBER, WE REDIRECT THE USER TO THE HOME PAGE
        $params = $_GET['params'];
        if (count($params) === 0 || is_numeric($params[0]) === false) {
            $this->redirect('../home');
            exit();
        }
        // GET THE FIRST PARAMETER OF THE $params ARRAY AND CONVERT IT TO AN INTEGER
        $id_event = (int) $params[0];

        // LOADS A MODEL TO BE ABLE TO USE ITS FUNCTIONS IN THE CONTROLLER (DATA RETRIEVAL FUNCTIONS ONLY)
        $this->loadModel('User');

        // EXAMPLE OF MODEL FUNCTION USAGE
        $user = $this->_model->getUserInfo($_SESSION['user']['id_users']);

        // PAGE NAME IS AN ARRAY TO DEFINE THE PAGE NAME AND SUB-PAGES IN THE NAVIGATION MENU 
        // THE PAGE NAME IS THE LAST ELEMENT OF THE ARRAY 
        // SUB-PAGES ARE DEFINED BY ARRAY KEYS AND VALUES ARE PATHS TO SUB-PAGES
        // EXAMPLE: HERE PAGE NAME IS "Profil" AND SUB-PAGE IS "users/profil" (DEFAULT VIEW PATH OF THE CONTROLLER)
        $page_name = array("Profil" => $this->default_path);

        // DEFINES CSS FILES TO USE FOR THE PAGE
        // PATH TO CSS FILES STARTS IN THE "assets" DIRECTORY
        // EXAMPLE : HERE CSS PATH IS "assets/css/home/styles.css"
        $this->setCssFile(['css/home/styles.css']);

        // DEFINES JS FILES TO USE FOR THE PAGE
        // PATH TO JS FILES STARTS IN THE "assets/pages" DIRECTORY
        // EXAMPLE : HERE JS PATH IS "assets/pages/script.js"
        $this->setJsFile(['script.js']);

        // DISPLAY AN ERROR TO THE USER UPON REDIRECTION TO A PAGE
        // FIRST PARAMETER IS THE ERROR NAME
        // SECOND PARAMETER IS THE MESSAGE TO DISPLAY
        // THIRD PARAMETER IS THE ERROR TYPE (SUCCESS_ALERT / ERROR_ALERT / WARNING_ALERT / INFO_ALERT)
        $this->setError('File too heavy', "the file size must not exceed 5 MB", ERROR_ALERT);

        // REDIRECT THE USER TO A PAGE
        // PARAMETER IS THE PATH TO THE PAGE (controller name / method name)
        $this->redirect('../home');
        // IT IS POSSIBLE TO REDIRECT THE USER TO A PAGE WITH PARAMETERS
        // PARAMETER IS THE PATH TO THE PAGE (controller name / method name)
        // SECOND PARAMETER IS AN ARRAY CONTAINING PARAMETERS
        // EXAMPLE : HERE PATH IS "../home" AND PARAMETERS ARE "id" AND "name"
        $this->redirect('../home', array('id' => 1, 'name' => 'test'));

        // CONVERT SQL DATE TO ENGLISH DATE (or French format as helper, keeping helper description)
        // PARAMETER IS THE SQL DATE
        // EXAMPLE : HERE SQL DATE IS "2021-05-05 00:00:00" AND CONVERTED DATE IS "05/05/2021"
        $this->convertDateFrench('2021-05-05 00:00:00');

        // GET LOGGED USER ID
        $this->getUserId();

        // GET RANDOM IMAGE IN A FOLDER
        // PARAMETER IS THE PATH TO THE FOLDER
        // EXAMPLE : HERE PATH IS "assets/images/avatar/head/"
        $this->randomImg('assets/images/avatar/head/');

        // DOES THE SAME THING AS var_dump() BUT MORE READABLE 
        dump($data);


        // ==================== SECURITY FUNCTIONS ==================== //

        // PERFORM A SECURITY CHECK 
        // THE activeSecurity() FUNCTION IS CALLED IN A CONTROLLER BEFORE A REDIRECTION TO A PAGE WITH PARAMETERS 
        // IT CAN TAKE AN OPTIONAL PARAMETER WHICH IS THE PATH TO THE REDIRECTION PAGE 
        // IT WILL THEN RETURN IN THE 'url' INDEX OF THE ARRAY THE PATH TO THE REDIRECTION PAGE WITH THE NECESSARY PARAMETERS
        $this->activeSecurity();
        // HERE THE REDIRECTION PATH IS "UserSubscription/Success" (controller name / method name)
        $this->activeSecurity('UserSubscription/Success'); 

        // IN THE CONTROLLER PROTECTED BY activeSecurity(), YOU MUST RETRIEVE PARAMETERS USING checkSecurity()
        // THE FUNCTION RETURNS TRUE IF SECURITY IS VALID, OTHERWISE FALSE
        $this->checkSecurity();



        // ==================== VIEW RENDERING FUNCTIONS ==================== //


        // RENDER DEFAULT VIEW OF THE CONTROLLER
        // VIEW PATH STARTS IN THE "views" DIRECTORY
        // COMPACT FUNCTION CONVERTS ARRAY KEYS TO VARIABLES
        // EXAMPLE : HERE THE VARIABLE $page_name IS CREATED AND CONTAINS THE $page_name ARRAY
        // THE DASHBOARD CONSTANT DEFINES THE TYPE OF PAGE TO DISPLAY (DASHBOARD / OTHERS / NO_LAYOUT)
        // DASHBOARD = PAGE WITH NAVIGATION MENU AND SIDEBAR
        // OTHERS = PAGE WITHOUT NAVIGATION MENU AND SIDEBAR
        // NO_LAYOUT = PAGE WITHOUT ANY LAYOUT (YOU NEED TO CREATE A VIEW WITH ALL HTML CODE)
        $this->render($this->default_path, compact('user', 'subscription', 'page_name'), DASHBOARD);
        
        // THE LAST PARAMETER IS OPTIONAL AND ALLOWS MANUALLY DEFINING THE $path_prefix VARIABLE IN CASE OF ISSUES
        $this->render($this->default_path, compact('user', 'subscription', 'page_name'), DASHBOARD, '../');

    }

}
