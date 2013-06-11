<?php

class Site
{
    private $link = NULL;
    private $p1, $p2, $p3;
    private $config = array();
    private $bypassRender;
    private $content, $title;
    private $pageTitle, $contentTitle;
    private $headerTitle, $headerSubtext;
    private $menuCapture, $contentCapture;
    private $username, $email, $userid, $admin;
    private $PATH, $FULL_PATH, $PUBLIC_PATH, $IMG_PATH ;

    function __construct()
    {
        $this->config = include('config.php.local');
        $this->authenticate();
        $this->frontController();
    }

    public function makePath($page)
    {
        if (!is_array($page)) return $this->PATH . $page;
        $path = $this->PATH;
        foreach ($page as &$p) $path .= $p."/";
        return rtrim ($path, "/ ");
    }

    public function mySqlConnect()
    {
        if (!isset($this->link))
        {
            $user = $this->config['mysql']['user'];
            $pass = $this->config['mysql']['password'];
            $db =   $this->config['mysql']['db'];
            $this->link = mysqli_connect("localhost",$user, $pass, $db);
            if (!$this->link) die('Could not connect: ' . mysqli_error($this->link));
            mysqli_set_charset($this->link, "utf8");
        }
    }

    private function authenticate()
    {
        session_start();

        /** LOGED_OUT -> LOGIN ( ATTEMT TO LOGIN ) */
        if ( !isset($_SESSION['username']) && isset($_POST['username'])) {
            $this->mySqlConnect();
            $query = 'SELECT * from users where username = "'.$_POST['username'].'";';
            $res = mysqli_query($this->link, $query);
            if ($res && ($row = mysqli_fetch_array($res))) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['userid'] = $row['user_id'];
                $_SESSION['admin'] = $row['admin'];
            }
        }

        /** LOGED_IN -> LOGED_OUT ( REQUEST TO LOGOUT ) */
        else if (isset($_POST['logout']) && $_POST['logout']=="true" && !isset($_POST['username'])) {
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['admin']);
            session_destroy();
        }

        /** Set auth fields */
        if (isset($_SESSION['userid'])) {
            $this->username = $_SESSION['username'];
            $this->email = $_SESSION['email'];
            $this->userid = $_SESSION['userid'];
            $this->admin = $_SESSION['admin'];
        }

    }

    public function frontController ()
    {
        $this->PATH = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        $this->PUBLIC_PATH   = $this->PATH . $this->config['paths']['public'];
        $this->IMAGE_PATH    = $this->PATH . $this->config['paths']['image'];
        $this->FULL_PATH     = $this->PATH;

        /* Extract the case parameter from url */
        $this->p1 = isset($_GET["p1"])? $_GET["p1"] : "home";
        $this->p2 = isset($_GET["p2"])? $_GET["p2"] : "";
        $this->p3 = isset($_GET["p3"])? rtrim($_GET["p3"],"/ ") : "";
        $this->contentScript = "pages/pages_$this->p1.php";

        /* Fall back to default page */
        if (!file_exists($this->contentScript)) {
            header ("Location: " . $this->makePath($this->config['default_path']));
        }

        /* Construct path variables */
        if (strlen($this->p1)) $this->FULL_PATH = $this->FULL_PATH . $this->p1 . '/';
        if (strlen($this->p2)) $this->FULL_PATH = $this->FULL_PATH . $this->p2 . '/';
        if (strlen($this->p3)) $this->FULL_PATH = $this->FULL_PATH . $this->p3 . '/';

        $this->pageTitle = "Kryptolexa";
        $this->bypassRender = false;
        $this->menuItems = $this->config['menu_items'];
        foreach ($this->menuItems as $pg=>$text ) {
            $this->menuCapture .= "<div class='topNavigationLink'><a href='" . $this->makePath($pg) ."'>$text</a></div>\n";
        }

        ob_start();
        include($this->contentScript);
        $this->contentCapture = ob_get_contents();
        ob_end_clean();
    }

    public function render()
    {
        if ($this->bypassRender )
            echo $this->contentCapture;
        else
            include('pages/layout.html');

    }

}
