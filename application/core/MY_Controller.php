<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
        $this->data['sessionid'] = session_id();
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->makemenu();//$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->data['sessionid'] = session_id();
        $this->parser->parse('_template', $this->data);
    }
     function restrict($roleNeeded = null) {
    $userRole = $this->session->userdata('userRole');
    if ($roleNeeded != null) {
      if (is_array($roleNeeded)) {
        if (!in_array($userRole, $roleNeeded)) {
          redirect("/");
          return;
        }
      } else if ($userRole != $roleNeeded) {
        redirect("/");
        return;
      }
  }
}




function makemenu() {
   
$role = $this->session->userdata('userRole');
$username   =   $this->session->userdata('userName');

if($username == null)
{
   $menu_choices = array(
    'menudata' => array(
	array('name' => "Alpha", 'link' => '/alpha'),
        array('name' => "Login", 'link' => '/auth'),
        )
    );
       
}
else if($role == ROLE_ADMIN)
{
    $menu_choices = array(
    'menudata' => array(
	array('name' => "Alpha", 'link' => '/alpha'),
	array('name' => "Beta", 'link' => '/beta'),
	array('name' => "Gamma", 'link' => '/gamma'),
        array('name' => "Logout", 'link' => '/auth/logout'),
        )
    );
}
else if($role == ROLE_USER)
{
    $menu_choices = array(
    'menudata' => array(
	array('name' => "Alpha", 'link' => '/alpha'),
	array('name' => "Beta", 'link' => '/beta'),
        array('name' => "Logout", 'link' => '/auth/logout'),
        )
    );
}

    return $this->parser->parse('_menubar', $menu_choices, true);
}

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */