<?php

/**
 *
 */
class ControllerExtensionModuleTwitterModule extends Controller
{
  private $error = array();

  public function index() {
    $this->load->language('extension/module/TwitterModule');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('setting/module');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      if (!isset($this->request->get['module_id'])) {
        $this->model_setting_module->addModule('TwitterModule', $this->request->post);
      } else {
        $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
      }

      $this->cache->delete('product');

      $this->session->data['success'] = $this->language->get('text_success');

      $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
    }

    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    if (isset($this->error['name'])) {
      $data['error_name'] = $this->error['name'];
    } else {
      $data['error_name'] = '';
    }




    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_extension'),
      'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
    );

    if (!isset($this->request->get['module_id'])) {
      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('extension/module/TwitterModule', 'user_token=' . $this->session->data['user_token'], true)
      );
    } else {
      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('extension/module/TwitterModule', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
      );
    }

    if (!isset($this->request->get['module_id'])) {
      $data['action'] = $this->url->link('extension/module/TwitterModule', 'user_token=' . $this->session->data['user_token'], true);
    } else {
      $data['action'] = $this->url->link('extension/module/TwitterModule', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
    }

    $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

    if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
    }

    if (isset($this->request->post['name'])) {
      $data['name'] = $this->request->post['name'];
    } elseif (!empty($module_info)) {
      $data['name'] = $module_info['name'];
    } else {
      $data['name'] = '';
    }


    if (isset($this->request->post['twitter_name'])) {
			$data['twitter_name'] = $this->request->post['twitter_name'];
		} elseif (!empty($module_info)) {
			$data['twitter_name'] = $module_info['twitter_name'];
		} else {
			$data['twitter_name'] = '';
		}

    if (isset($this->request->post['twitter_name'])) {
      $data['twitter_genislik'] = $this->request->post['twitter_genislik'];
    } elseif (!empty($module_info)) {
      $data['twitter_genislik'] = $module_info['twitter_genislik'];
    } else {
      $data['twitter_genislik'] = 300;
    }

    if (isset($this->request->post['twitter_name'])) {
      $data['twitter_yukseklik'] = $this->request->post['twitter_yukseklik'];
    } elseif (!empty($module_info)) {
      $data['twitter_yukseklik'] = $module_info['twitter_yukseklik'];
    } else {
      $data['twitter_yukseklik'] = 300;
    }

    if (isset($this->request->post['twitter_name'])) {
      $data['twitter_tema'] = $this->request->post['twitter_tema'];
    } elseif (!empty($module_info)) {
      $data['twitter_tema'] = $module_info['twitter_tema'];
    } else {
      $data['twitter_tema'] = '';
    }

    if (isset($this->request->post['status'])) {
      $data['status'] = $this->request->post['status'];
    } elseif (!empty($module_info)) {
      $data['status'] = $module_info['status'];
    } else {
      $data['status'] = '';
    }

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/TwitterModule', $data));
  }

  protected function validate() {
    if (!$this->user->hasPermission('modify', 'extension/module/TwitterModule')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
      $this->error['name'] = $this->language->get('error_name');
    }



    if (!$this->request->post['twitter_name']) {
			$this->error['twitter_name'] = $this->language->get('error_width');
		}


    return !$this->error;
  }
}


 ?>
