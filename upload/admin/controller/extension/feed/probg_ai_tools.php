<?php
class ControllerExtensionFeedProbgAiTools extends Controller {
  private $error = array();

  public function index() {
    $this->load->language('extension/feed/probg_ai_tools');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('setting/setting');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      $this->model_setting_setting->editSetting('feed_probg_ai_tools', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $this->response->redirect($this->url->link(
        'marketplace/extension',
        'user_token=' . $this->session->data['user_token'] . '&type=feed',
        true
      ));
    }

    $data['heading_title'] = $this->language->get('heading_title');

    $data['text_edit'] = $this->language->get('text_edit');
    $data['text_enabled'] = $this->language->get('text_enabled');
    $data['text_disabled'] = $this->language->get('text_disabled');
    $data['text_yes'] = $this->language->get('text_yes');
    $data['text_no'] = $this->language->get('text_no');

    $data['entry_status'] = $this->language->get('entry_status');
    $data['entry_products'] = $this->language->get('entry_products');
    $data['entry_categories'] = $this->language->get('entry_categories');
    $data['entry_brands'] = $this->language->get('entry_brands');
    $data['entry_product_limit'] = $this->language->get('entry_product_limit');
    $data['entry_ai_sitemap_url'] = $this->language->get('entry_ai_sitemap_url');
    $data['entry_llms_txt'] = $this->language->get('entry_llms_txt');
    $data['entry_llms_json'] = $this->language->get('entry_llms_json');
    $data['entry_llms_full'] = $this->language->get('entry_llms_full');
    $data['entry_products_graph'] = $this->language->get('entry_products_graph');

    $data['help_status'] = $this->language->get('help_status');
    $data['help_products'] = $this->language->get('help_products');
    $data['help_categories'] = $this->language->get('help_categories');
    $data['help_brands'] = $this->language->get('help_brands');
    $data['help_product_limit'] = $this->language->get('help_product_limit');
    $data['help_htaccess'] = $this->language->get('help_htaccess');

    $data['text_htaccess_rule'] = $this->language->get('text_htaccess_rule');

    $data['tab_general'] = $this->language->get('tab_general');
    $data['tab_ai_sitemap'] = $this->language->get('tab_ai_sitemap');
    $data['tab_llms'] = $this->language->get('tab_llms');
    $data['tab_products_graph'] = $this->language->get('tab_products_graph');
    $data['tab_advanced'] = $this->language->get('tab_advanced');

    $data['entry_ai_sitemap'] = $this->language->get('entry_ai_sitemap');
    $data['entry_urls'] = $this->language->get('entry_urls');
    $data['entry_htaccess'] = $this->language->get('entry_htaccess');
    $data['entry_site_description'] = $this->language->get('entry_site_description');

    $data['help_site_description'] = $this->language->get('help_site_description');
    $data['entry_ai_policy'] = $this->language->get('entry_ai_policy');
    $data['help_ai_policy'] = $this->language->get('help_ai_policy');
    $data['entry_ai_sitemap'] = $this->language->get('entry_ai_sitemap');
    $data['help_ai_sitemap'] = $this->language->get('help_ai_sitemap');
    $data['entry_search_index'] = $this->language->get('entry_search_index');
    $data['help_search_index'] = $this->language->get('help_search_index');


    $data['button_save'] = $this->language->get('button_save');
    $data['button_cancel'] = $this->language->get('button_cancel');

    $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link(
        'common/dashboard',
        'user_token=' . $this->session->data['user_token'],
        true
      )
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_extension'),
      'href' => $this->url->link(
        'marketplace/extension',
        'user_token=' . $this->session->data['user_token'] . '&type=feed',
        true
      )
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link(
        'extension/feed/probg_ai_tools',
        'user_token=' . $this->session->data['user_token'],
        true
      )
    );

    $data['action'] = $this->url->link(
      'extension/feed/probg_ai_tools',
      'user_token=' . $this->session->data['user_token'],
      true
    );

    $data['cancel'] = $this->url->link(
      'marketplace/extension',
      'user_token=' . $this->session->data['user_token'] . '&type=feed',
      true
    );

    $settings = array(
      'feed_probg_ai_tools_status',
      'feed_probg_ai_tools_site_description',
      'feed_probg_ai_tools_products',
      'feed_probg_ai_tools_categories',
      'feed_probg_ai_tools_brands',
      'feed_probg_ai_tools_product_limit',
      'feed_probg_ai_tools_llms_txt',
      'feed_probg_ai_tools_llms_json',
      'feed_probg_ai_tools_llms_full',
      'feed_probg_ai_tools_ai_policy',
      'feed_probg_ai_tools_products_graph',
      'feed_probg_ai_tools_ai_catalog',
      'feed_probg_ai_tools_search_index',
      'feed_probg_ai_tools_semantic_graph',
      'feed_probg_ai_tools_ai_sitemap'
    );

    foreach ($settings as $key) {
      if (isset($this->request->post[$key])) {
        $data[$key] = $this->request->post[$key];
      } else {
        $data[$key] = $this->config->get($key);
      }
    }

    if ($data['feed_probg_ai_tools_product_limit'] === null || $data['feed_probg_ai_tools_product_limit'] === '') {
      $data['feed_probg_ai_tools_product_limit'] = 0;
    }

    $data['ai_sitemap_url'] = HTTPS_CATALOG . 'ai-sitemap.xml';
    $data['llms_txt_url'] = HTTPS_CATALOG . 'llms.txt';
    $data['llms_json_url'] = HTTPS_CATALOG . 'llms.json';
    $data['llms_full_url'] = HTTPS_CATALOG . 'llms-full.txt';
    $data['products_graph_url'] = HTTPS_CATALOG . 'products.graph.json';
    $data['ai_catalog_url'] = HTTPS_CATALOG . 'ai-catalog.json';
    $data['search_index_url'] = HTTPS_CATALOG . 'search-index.json';
    $data['semantic_graph_url'] = HTTPS_CATALOG . 'semantic.graph.json';

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput(
      $this->load->view('extension/feed/probg_ai_tools', $data)
    );
  }

  public function install() {
    $this->load->model('setting/setting');

    $this->model_setting_setting->editSetting('feed_probg_ai_tools', array(
      'feed_probg_ai_tools_status' => 1,
      'feed_probg_ai_tools_site_description' => '',
      'feed_probg_ai_tools_ai_policy' => 1,
      'feed_probg_ai_tools_products' => 1,
      'feed_probg_ai_tools_categories' => 1,
      'feed_probg_ai_tools_brands' => 1,
      'feed_probg_ai_tools_product_limit' => 1000,
      'feed_probg_ai_tools_llms_txt' => 1,
      'feed_probg_ai_tools_llms_json' => 1,
      'feed_probg_ai_tools_llms_full' => 1,
      'feed_probg_ai_tools_products_graph' => 1,
      'feed_probg_ai_tools_ai_catalog' => 1,
      'feed_probg_ai_tools_search_index' => 1,
      'feed_probg_ai_tools_semantic_graph' => 1,
      'feed_probg_ai_tools_ai_sitemap' => 1
    ));
  }

  public function uninstall() {
    $this->load->model('setting/setting');

    $this->model_setting_setting->deleteSetting('feed_probg_ai_tools');
  }

  protected function validate() {
    if (!$this->user->hasPermission('modify', 'extension/feed/probg_ai_tools')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    return !$this->error;
  }
}