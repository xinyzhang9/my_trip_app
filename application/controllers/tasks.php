<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class tasks extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model("task");
    $this->output->enable_profiler();
  }
  public function index_json()
  {
    $data["tasks"] = $this->task->all();
    echo json_encode($data);
  }

  public function index_html()
  {
    $data["tasks"] = $this->task->all();
    $this->load->view('/partials/tasks',$data);
  }

  public function create(){
    $form_info = $this->input->post();
    $this->task->create_task($form_info);
    $data["tasks"] = $this->task->all();
    $this->load->view('/partials/tasks',$data);
  }

  public function delete(){
    $form_info = $this->input->post();
    $this->task->delete_task($form_info);
    $data["tasks"] = $this->task->all();
    $this->load->view('/partials/tasks',$data);
  }

  public function edit(){
    $form_info = $this->input->post();
    $this->task->edit_task($form_info);
    $data["tasks"] = $this->task->all();
    $this->load->view('/partials/tasks',$data);
  }

  public function index()
  {
    $this->load->view('index');
  }
}

?>
