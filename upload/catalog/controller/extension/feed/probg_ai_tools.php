<?php
class ControllerExtensionFeedProbgAiTools extends Controller {

  public function index() {
    if ((int)$this->config->get('feed_probg_ai_tools_status') !== 1) {
      $this->disabled();
      return;
    }
    $this->load->language('extension/feed/probg_ai_tools');

    $this->response->addHeader('Content-Type: application/json; charset=utf-8');

    $data = array(
      'site' => array(
        'name' => $this->cleanText($this->config->get('config_name')),
        'url'  => $this->config->get('config_url')
      ),
      'generated_at' => date('Y-m-d H:i:s')
    );

    if ($this->config->get('feed_probg_ai_tools_products')) {
      $data['products'] = $this->getProducts();
    }

    if ($this->config->get('feed_probg_ai_tools_categories')) {
      $data['categories'] = $this->getCategories();
    }

    if ($this->config->get('feed_probg_ai_tools_brands')) {
      $data['brands'] = $this->getBrands();
    }

    $this->response->setOutput(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
  }
  public function llms() {

    if ((int)$this->config->get('feed_probg_ai_tools_llms_txt') !== 1) {
      $this->disabled();
      return;
    }

    $this->load->language('extension/feed/probg_ai_tools');

    $this->response->addHeader('Content-Type: text/plain; charset=utf-8');

    $output = '';

    // Header

    $output .= '# ' . $this->cleanText(
        $this->config->get('config_name')
      ) . "\n\n";

    // Description

    $description = $this->cleanText(
      $this->config->get('feed_probg_ai_tools_site_description')
    );

    if (empty($description)) {

      $description = $this->cleanText(
        $this->config->get('config_meta_description')
      );
    }

    if (!empty($description)) {

      $output .= '> ' . $description . "\n\n";
    }

    // Website

    $output .= $this->language->get('text_website')
      . ': '
      . $this->getStoreUrl()
      . "\n\n";

    /*
     * Categories
     */

    if ($this->config->get('feed_probg_ai_tools_categories')) {

      $output .= '## '
        . $this->language->get('text_categories')
        . "\n\n";

      foreach ($this->getCategories() as $category) {

        $output .= '- [' . $category['name'] . '](' . $category['url'] . ')';

        if (!empty($category['description'])) {

          $output .= ': ' . $category['description'];
        }

        $output .= "\n";
      }

      $output .= "\n";
    }

    /*
     * Products
     */

    if ($this->config->get('feed_probg_ai_tools_products')) {

      $output .= '## '
        . $this->language->get('text_products')
        . "\n\n";

      foreach ($this->getProducts() as $product) {

        $output .= '- [' . $product['name'] . '](' . $product['url'] . ')';

        if (!empty($product['description'])) {

          $output .= ': ' . $product['description'];
        }

        $output .= "\n";
      }

      $output .= "\n";
    }

    /*
     * Brands
     */

    if ($this->config->get('feed_probg_ai_tools_brands')) {

      $output .= '## '
        . $this->language->get('text_brands')
        . "\n\n";

      foreach ($this->getBrands() as $brand) {

        $output .= '- [' . $brand['name'] . '](' . $brand['url'] . ')' . "\n";
      }

      $output .= "\n";
    }

    /*
     * AI Resources
     */

    $output .= '## '
      . $this->language->get('text_ai_resources')
      . "\n\n";

    if ($this->config->get('feed_probg_ai_tools_llms_json')) {

      $output .= '- ['
        . $this->language->get('text_llms_json')
        . ']('
        . $this->getStoreUrl()
        . 'llms.json)'
        . "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_ai_catalog')) {

      $output .= '- ['
        . $this->language->get('text_ai_catalog')
        . ']('
        . $this->getStoreUrl()
        . 'ai-catalog.json)'
        . "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_search_index')) {
      $output .= '- ['
        . $this->language->get('text_search_index')
        . ']('
        . $this->getStoreUrl()
        . 'search-index.json)'
        . "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_semantic_graph')) {

      $output .= '- [Semantic Graph]('
        . $this->getStoreUrl()
        . 'semantic.graph.json)'
        . "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_llms_full')) {

      $output .= '- ['
        . $this->language->get('text_llms_full')
        . ']('
        . $this->getStoreUrl()
        . 'llms-full.txt)'
        . "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_products_graph')) {

      $output .= '- ['
        . $this->language->get('text_products_graph')
        . ']('
        . $this->getStoreUrl()
        . 'products.graph.json)'
        . ': '
        . $this->language->get('text_graph_description')
        . "\n";
    }

    /*
     * Footer
     */

    if ($this->config->get('feed_probg_ai_tools_ai_policy')) {

      $output .= '- [AI Access Policy]('
        . $this->getStoreUrl()
        . 'ai-policy.txt)'
        . "\n";
    }

    $output .= "\n---\n";

    $output .= $this->language->get('text_generated')
      . ': '
      . date('Y-m-d H:i:s');

    $this->response->setOutput($output);
  }

  public function json() {
    if ((int)$this->config->get('feed_probg_ai_tools_llms_json') !== 1) {
      $this->disabled();
      return;
    }

    $this->load->language('extension/feed/probg_ai_tools');
    $this->index();
  }

  public function full() {

    if ((int)$this->config->get('feed_probg_ai_tools_llms_full') !== 1) {
      $this->disabled();
      return;
    }

    $this->load->language('extension/feed/probg_ai_tools');

    $this->response->addHeader('Content-Type: text/plain; charset=utf-8');

    $output = '# ' . $this->language->get('text_full_ai_dataset') . "\n\n";

    $output .= $this->language->get('text_website')
      . ': '
      . $this->getStoreUrl()
      . "\n\n";

    /*
     * Categories
     */
    if ($this->config->get('feed_probg_ai_tools_categories')) {

      $output .= '## '
        . $this->language->get('text_categories')
        . "\n\n";

      foreach ($this->getCategories() as $category) {

        $output .= '### ' . $category['name'] . "\n";

        $output .= '- '
          . $this->language->get('text_url')
          . ': '
          . $category['url']
          . "\n";

        if (!empty($category['description'])) {
          $output .= '- '
            . $this->language->get('text_description_label')
            . ': '
            . $category['description']
            . "\n";
        }

        $output .= "\n";
      }
    }

    /*
     * Brands
     */
    if ($this->config->get('feed_probg_ai_tools_brands')) {

      $output .= '## '
        . $this->language->get('text_brands')
        . "\n\n";

      foreach ($this->getBrands() as $brand) {

        $output .= '### ' . $brand['name'] . "\n";

        $output .= '- '
          . $this->language->get('text_url')
          . ': '
          . $brand['url']
          . "\n\n";
      }
    }

    /*
     * Products
     */
    if ($this->config->get('feed_probg_ai_tools_products')) {

      $output .= '## '
        . $this->language->get('text_products')
        . "\n\n";

      foreach ($this->getProducts(false) as $product) {

        $output .= '### ' . $product['name'] . "\n";

        $output .= '- '
          . $this->language->get('text_url')
          . ': '
          . $product['url']
          . "\n";

        if (!empty($product['brand'])) {
          $output .= '- '
            . $this->language->get('text_brand')
            . ': '
            . $product['brand']
            . "\n";
        }

        if (!empty($product['price'])) {
          $output .= '- '
            . $this->language->get('text_price')
            . ': '
            . $product['price']
            . "\n";
        }

        if (!empty($product['model'])) {
          $output .= '- '
            . $this->language->get('text_model')
            . ': '
            . $product['model']
            . "\n";
        }

        if (!empty($product['description'])) {
          $output .= '- '
            . $this->language->get('text_description_label')
            . ': '
            . $product['description']
            . "\n";
        }

        $output .= "\n";
      }
    }

    $output .= "---\n";
    $output .= $this->language->get('text_generated')
      . ': '
      . date('Y-m-d H:i:s');

    $this->response->setOutput($output);
  }

  public function catalog() {

    if ((int)$this->config->get('feed_probg_ai_tools_ai_catalog') !== 1) {
      $this->disabled();
      return;
    }

    $this->response->addHeader('Content-Type: application/json; charset=utf-8');

    $data = array(
      'store' => array(
        'name' => $this->cleanText($this->config->get('config_name')),
        'url' => $this->getStoreUrl(),
        'description' => $this->cleanText($this->config->get('config_meta_description'))
      ),
      'generated_at' => date('Y-m-d H:i:s'),
      'catalog' => array()
    );

    if ($this->config->get('feed_probg_ai_tools_categories')) {
      $data['catalog']['categories'] = $this->getCategories();
    }

    if ($this->config->get('feed_probg_ai_tools_brands')) {
      $data['catalog']['brands'] = $this->getBrands();
    }

    if ($this->config->get('feed_probg_ai_tools_products')) {
      $data['catalog']['products'] = $this->getProducts();
    }

    $this->response->setOutput(
      json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
  }

  public function semantic() {

    if ((int)$this->config->get('feed_probg_ai_tools_semantic_graph') !== 1) {
      $this->disabled();
      return;
    }

    $this->response->addHeader('Content-Type: application/json; charset=utf-8');

    $graph = array();

    $products = $this->getProducts(false);

    foreach ($products as $product) {

      /*
       * Product -> Category
       */
      if (!empty($product['categories'])) {

        foreach ($product['categories'] as $category) {

          $graph[] = array(
            'from' => array(
              'type' => 'product',
              'id'   => (int)$product['id'],
              'name' => $product['name'],
              'url'  => $product['url']
            ),
            'to' => array(
              'type' => 'category',
              'id'   => (int)$category['id'],
              'name' => $category['name'],
              'url'  => $category['url']
            ),
            'relation' => 'belongs_to'
          );
        }
      }

      /*
       * Product -> Brand
       */
      if (!empty($product['brand'])) {

        $graph[] = array(
          'from' => array(
            'type' => 'product',
            'id'   => (int)$product['id'],
            'name' => $product['name'],
            'url'  => $product['url']
          ),
          'to' => array(
            'type' => 'brand',
            'name' => $product['brand']
          ),
          'relation' => 'made_by'
        );
      }

      /*
       * Brand -> Product
       */
      if (!empty($product['brand'])) {

        $graph[] = array(
          'from' => array(
            'type' => 'brand',
            'name' => $product['brand']
          ),
          'to' => array(
            'type' => 'product',
            'id'   => (int)$product['id'],
            'name' => $product['name'],
            'url'  => $product['url']
          ),
          'relation' => 'has_product'
        );
      }
    }

    /*
     * Category -> Parent Category
     */
    $this->load->model('catalog/category');

    $category_query = $this->db->query("
    SELECT c.category_id, c.parent_id, cd.name
    FROM `" . DB_PREFIX . "category` c
    LEFT JOIN `" . DB_PREFIX . "category_description` cd
      ON (c.category_id = cd.category_id)
    WHERE c.status = '1'
      AND c.parent_id > 0
      AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
    ORDER BY c.sort_order ASC, cd.name ASC
  ");

    foreach ($category_query->rows as $category) {

      $parent_info = $this->model_catalog_category->getCategory($category['parent_id']);

      if (!$parent_info) {
        continue;
      }

      $graph[] = array(
        'from' => array(
          'type' => 'category',
          'id'   => (int)$category['category_id'],
          'name' => $this->cleanText($category['name']),
          'url'  => $this->url->link(
            'product/category',
            'path=' . (int)$category['category_id']
          )
        ),
        'to' => array(
          'type' => 'category',
          'id'   => (int)$category['parent_id'],
          'name' => $this->cleanText($parent_info['name']),
          'url'  => $this->url->link(
            'product/category',
            'path=' . (int)$category['parent_id']
          )
        ),
        'relation' => 'child_of'
      );
    }

    $output = array(
      'meta' => array(
        'generated_at' => date('Y-m-d H:i:s'),
        'total_relations' => count($graph)
      ),
      'relations' => $graph
    );

    $this->response->setOutput(
      json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
  }

  public function search() {

    if ((int)$this->config->get('feed_probg_ai_tools_search_index') !== 1) {
      $this->disabled();
      return;
    }

    $this->response->addHeader('Content-Type: application/json; charset=utf-8');

    $data = array();

    foreach ($this->getProducts() as $product) {

      $keywords = array();
      $search_terms = array();

      $name  = isset($product['name']) ? $this->cleanText($product['name']) : '';
      $brand = isset($product['brand']) ? $this->cleanText($product['brand']) : '';
      $model = isset($product['model']) ? $this->cleanText($product['model']) : '';

      if ($name) {
        $keywords[] = $name;

        $words = preg_split('/[\s\-\_,\.\/]+/u', mb_strtolower($name, 'UTF-8'));

        foreach ($words as $word) {
          $word = trim($word);

          if (mb_strlen($word, 'UTF-8') > 2) {
            $keywords[] = $word;
          }
        }
      }

      if ($brand) {
        $keywords[] = $brand;
        $search_terms[] = $brand;

        if ($name) {
          $search_terms[] = $brand . ' ' . $name;
        }
      }

      if ($model) {
        $keywords[] = $model;
        $search_terms[] = $model;

        if ($brand) {
          $search_terms[] = $brand . ' ' . $model;
        }

        if ($name) {
          $search_terms[] = $name . ' ' . $model;
        }
      }

      if ($name) {
        $search_terms[] = $name;
      }

      if ($brand && $name) {
        $search_terms[] = $brand . ' ' . $name;
      }

      $keywords = array_values(array_unique(array_filter(array_map(function($value) {
        return mb_strtolower(trim($value), 'UTF-8');
      }, $keywords))));

      $search_terms = array_values(array_unique(array_filter(array_map(function($value) {
        return mb_strtolower(trim($value), 'UTF-8');
      }, $search_terms))));

      $data[] = array(
        'id' => (int)$product['id'],
        'type' => 'product',
        'name' => $name,
        'brand' => $brand,
        'model' => $model,
        'url' => $product['url'],
        'keywords' => $keywords,
        'search_terms' => $search_terms
      );
    }

    $this->response->setOutput(
      json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
  }

  public function policy() {

    if ((int)$this->config->get('feed_probg_ai_tools_ai_policy') !== 1) {
      $this->disabled();
      return;
    }

    $this->response->addHeader('Content-Type: text/plain; charset=utf-8');

    $host = parse_url($this->getStoreUrl(), PHP_URL_HOST);

    $output = '';

    $output .= '# AI Access Policy for: ' . $host . "\n";
    $output .= '# This file declares our content access policy for LLMs (Large Language Models)' . "\n\n";

    $output .= "User-agent: *\n";
    $output .= "Allow: /\n\n";

    $output .= "Purpose: Content on this website is publicly available for analysis and processing by LLMs.\n";
    $output .= "License: Website content may be analyzed by AI systems. Republishing, redistribution and commercial reuse require explicit permission from the website owner.\n";

    $this->response->setOutput($output);
  }

  public function graph() {
    if ((int)$this->config->get('feed_probg_ai_tools_products_graph') !== 1) {
      $this->disabled();
      return;
    }
    $this->load->language('extension/feed/probg_ai_tools');

    $this->response->addHeader('Content-Type: application/json; charset=utf-8');

    $nodes = array();
    $edges = array();

    foreach ($this->getCategories() as $category) {
      $nodes[] = array(
        'id' => 'category_' . $category['id'],
        'type' => 'category',
        'name' => $category['name'],
        'url' => $category['url']
      );
    }

    foreach ($this->getBrands() as $brand) {
      $nodes[] = array(
        'id' => 'brand_' . $brand['id'],
        'type' => 'brand',
        'name' => $brand['name'],
        'url' => $brand['url']
      );
    }

    foreach ($this->getProducts(false) as $product) {
      $product_node_id = 'product_' . $product['id'];

      $nodes[] = array(
        'id' => $product_node_id,
        'type' => 'product',
        'name' => $product['name'],
        'url' => $product['url'],
        'price' => $product['price']
      );

      if (!empty($product['manufacturer_id'])) {
        $edges[] = array(
          'from' => $product_node_id,
          'to' => 'brand_' . $product['manufacturer_id'],
          'relation' => 'manufactured_by'
        );
      }
    }

    $output = array(
      'meta' => array(
        'generated_at' => date('Y-m-d H:i:s'),
        'total_nodes' => count($nodes),
        'total_edges' => count($edges)
      ),
      'nodes' => $nodes,
      'edges' => $edges
    );

    $this->response->setOutput(json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
  }

  private function getProducts($use_limit = true) {
    $this->load->model('catalog/product');
    $this->load->model('catalog/category');

    $limit = (int)$this->config->get('feed_probg_ai_tools_product_limit');

    if (!$use_limit || $limit <= 0) {
      $limit = 1000000;
    }

    $products = $this->model_catalog_product->getProducts(array(
      'start' => 0,
      'limit' => $limit
    ));

    $data = array();

    foreach ($products as $product) {

      $info = $this->model_catalog_product->getProduct($product['product_id']);

      $description = '';

      if (!empty($info['meta_description'])) {
        $description = $info['meta_description'];
      } elseif (!empty($info['description'])) {
        $description = $info['description'];
      }

      $manufacturer_name = '';

      if (!empty($product['manufacturer'])) {
        $manufacturer_name = $this->cleanText($product['manufacturer']);
      } elseif (!empty($info['manufacturer'])) {
        $manufacturer_name = $this->cleanText($info['manufacturer']);
      }

      $categories = array();

      $category_query = $this->db->query("
      SELECT c.category_id, cd.name
      FROM `" . DB_PREFIX . "product_to_category` p2c
      LEFT JOIN `" . DB_PREFIX . "category` c
        ON (p2c.category_id = c.category_id)
      LEFT JOIN `" . DB_PREFIX . "category_description` cd
        ON (c.category_id = cd.category_id)
      WHERE p2c.product_id = '" . (int)$product['product_id'] . "'
        AND c.status = '1'
        AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
      ORDER BY c.sort_order ASC, cd.name ASC
    ");

      foreach ($category_query->rows as $category) {
        $categories[] = array(
          'id' => (int)$category['category_id'],
          'name' => $this->cleanText($category['name']),
          'url' => $this->url->link(
            'product/category',
            'path=' . (int)$category['category_id']
          )
        );
      }

      $item = array(
        'id' => (int)$product['product_id'],
        'type' => 'product',
        'name' => $this->cleanText($product['name']),
        'url' => $this->url->link(
          'product/product',
          'product_id=' . (int)$product['product_id']
        ),
        'description' => mb_substr(
          $this->cleanText($description),
          0,
          300,
          'UTF-8'
        ),
        'price' => isset($product['price']) ? $product['price'] : '',
        'model' => isset($product['model']) ? $product['model'] : ''
      );

      if (!empty($manufacturer_name)) {
        $item['brand'] = $manufacturer_name;
      }

      if (!empty($categories)) {
        $item['categories'] = $categories;
      }

      $data[] = $item;
    }

    return $data;
  }

  private function getCategories() {
    $this->load->model('catalog/category');

    $categories = $this->model_catalog_category->getCategories(0);

    $data = array();

    foreach ($categories as $category) {
      $info = $this->model_catalog_category->getCategory($category['category_id']);

      $data[] = array(
        'id' => (int)$category['category_id'],
        'type' => 'category',
        'name' => $this->cleanText($category['name']),
        'url' => $this->url->link('product/category', 'path=' . (int)$category['category_id']),
        'description' => !empty($info['description']) ? mb_substr($this->cleanText($info['description']), 0, 300) : ''
      );
    }

    return $data;
  }

  private function getBrands() {
    $this->load->model('catalog/manufacturer');

    $manufacturers = $this->model_catalog_manufacturer->getManufacturers();

    $data = array();

    foreach ($manufacturers as $manufacturer) {
      $data[] = array(
        'id' => (int)$manufacturer['manufacturer_id'],
        'type' => 'brand',
        'name' => $this->cleanText($manufacturer['name']),
        'url' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . (int)$manufacturer['manufacturer_id'])
      );
    }

    return $data;
  }

  private function cleanText($text) {
    $text = html_entity_decode((string)$text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('#<script(.*?)>(.*?)</script>#is', ' ', $text);
    $text = preg_replace('#<style(.*?)>(.*?)</style>#is', ' ', $text);
    $text = strip_tags($text);
    $text = preg_replace('/\s+/', ' ', $text);

    return trim($text);
  }
  private function getStoreUrl() {
    if ($this->request->server['HTTPS']) {
      return $this->config->get('config_ssl');
    }

    return $this->config->get('config_url');
  }
  private function disabled() {

    $this->load->language('extension/feed/probg_ai_tools');
    $this->response->addHeader('HTTP/1.1 410 Gone');
    $this->response->setOutput(
      $this->language->get('text_feed_disabled')
    );
  }
}