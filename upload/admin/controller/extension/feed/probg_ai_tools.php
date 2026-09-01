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
        'extension/feed/probg_ai_tools',
        'user_token=' . $this->session->data['user_token'],
        true
      ));
    }

    $language_keys = array(
      'heading_title',
      'text_edit',
      'text_enabled',
      'text_disabled',
      'text_yes',
      'text_no',
      'text_ai_catalog_url',
      'entry_status',
      'entry_products',
      'entry_categories',
      'entry_brands',
      'entry_product_limit',
      'entry_ai_sitemap_url',
      'entry_llms_txt',
      'entry_llms_json',
      'entry_llms_full',
      'entry_products_graph',
      'entry_ai_catalog',
      'entry_ai_policy',
      'entry_search_index',
      'entry_semantic_graph',
      'entry_htaccess',
      'entry_site_description',
      'help_status',
      'help_products',
      'help_categories',
      'help_brands',
      'help_product_limit',
      'help_htaccess',
      'help_site_description',
      'help_ai_policy',
      'help_ai_sitemap',
      'help_ai_catalog',
      'help_search_index',
      'help_semantic_graph',
      'help_products_graph',
      'help_llms_txt',
      'help_llms_json',
      'help_llms_full',
      'text_htaccess_rule',
      'tab_general',
      'tab_ai_sitemap',
      'tab_ai_catalog',
      'tab_llms',
      'tab_products_graph',
      'tab_advanced',
      'button_save',
      'button_cancel'
    );

    foreach ($language_keys as $key) {
      $data[$key] = $this->language->get($key);
    }

    $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
    $data['error_product_limit'] = isset($this->error['product_limit']) ? $this->error['product_limit'] : '';

    $data['success'] = '';
    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    }

    $data['breadcrumbs'] = array();
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_extension'),
      'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=feed', true)
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('extension/feed/probg_ai_tools', 'user_token=' . $this->session->data['user_token'], true)
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

    $catalog_url = rtrim(HTTPS_CATALOG, '/') . '/';
    $data['ai_sitemap_url'] = $catalog_url . 'ai-sitemap.xml';
    $data['llms_txt_url'] = $catalog_url . 'llms.txt';
    $data['llms_json_url'] = $catalog_url . 'llms.json';
    $data['llms_full_url'] = $catalog_url . 'llms-full.txt';
    $data['products_graph_url'] = $catalog_url . 'products.graph.json';
    $data['ai_catalog_url'] = $catalog_url . 'ai-catalog.json';
    $data['ai_policy_url'] = $catalog_url . 'ai-policy.txt';
    $data['search_index_url'] = $catalog_url . 'search-index.json';
    $data['semantic_graph_url'] = $catalog_url . 'semantic.graph.json';

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/feed/probg_ai_tools', $data));
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

    if (isset($this->request->post['feed_probg_ai_tools_product_limit'])) {
      $limit = trim((string)$this->request->post['feed_probg_ai_tools_product_limit']);

      if ($limit === '' || !ctype_digit($limit)) {
        $this->error['product_limit'] = $this->language->get('error_product_limit');
      }
    }

    return !$this->error;
  }
}
