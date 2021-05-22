<?php
/**
 *
 */
class ControllerExtensionModuleTwitterModule extends Controller
{

  public function index($argument)
  {
    $this->load->language("extension/module/TwitterModule");
    return $this->load->view("extension/module/TwitterModule",$argument);
  }
}

 ?>
