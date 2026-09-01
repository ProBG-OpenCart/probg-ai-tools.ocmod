<?php
class ControllerExtensionFeedProbgAiTools extends Controller {
  public function index() {
    if (!$this->isEnabled()) {
      $this->disabled();
      return;
    }

    $this->outputJson($this->buildDataset());
  }

  public function sitemap() {
    if (!$this->isEnabled('feed_probg_ai_tools_ai_sitemap')) {
      $this->disabled();
      return;
    }

    $this->setResponseHeaders('application/xml; charset=utf-8');

    $urls = array();
    $urls[$this->getStoreUrl()] = '';

    if ($this->config->get('feed_probg_ai_tools_categories')) {
      foreach ($this->getCategories() as $category) {
        $urls[$category['url']] = isset($category['date_modified']) ? $category['date_modified'] : '';
      }
    }

    if ($this->config->get('feed_probg_ai_tools_brands')) {
      foreach ($this->getBrands() as $brand) {
        $urls[$brand['url']] = '';
      }
    }

    if ($this->config->get('feed_probg_ai_tools_products')) {
      foreach ($this->getProducts() as $product) {
        $urls[$product['url']] = isset($product['date_modified']) ? $product['date_modified'] : '';
      }
    }

    foreach ($this->getEnabledResourceUrls() as $resource_url) {
      $urls[$resource_url] = '';
    }

    $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($urls as $url => $lastmod) {
      $output .= "  <url>\n";
      $output .= '    <loc>' . $this->xmlEscape($url) . "</loc>\n";

      if ($lastmod) {
        $timestamp = strtotime($lastmod);
        if ($timestamp) {
          $output .= '    <lastmod>' . gmdate('c', $timestamp) . "</lastmod>\n";
        }
      }

      $output .= "  </url>\n";
    }

    $output .= '</urlset>';

    $this->response->setOutput($output);
  }

  public function llms() {
    if (!$this->isEnabled('feed_probg_ai_tools_llms_txt')) {
      $this->disabled();
      return;
    }

    $this->load->language('extension/feed/probg_ai_tools');
    $this->setResponseHeaders('text/plain; charset=utf-8');

    $output = '# ' . $this->escapeMarkdownText($this->cleanText($this->config->get('config_name'))) . "\n\n";

    $description = $this->getSiteDescription();
    if ($description) {
      $output .= '> ' . $this->escapeMarkdownText($description) . "\n\n";
    }

    $output .= $this->language->get('text_website') . ': ' . $this->getStoreUrl() . "\n\n";

    if ($this->config->get('feed_probg_ai_tools_categories')) {
      $output .= '## ' . $this->language->get('text_categories') . "\n\n";
      foreach ($this->getCategories() as $category) {
        $output .= '- [' . $this->escapeMarkdownText($category['name']) . '](' . $category['url'] . ')';
        if (!empty($category['description'])) {
          $output .= ': ' . $this->escapeMarkdownText($category['description']);
        }
        $output .= "\n";
      }
      $output .= "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_products')) {
      $output .= '## ' . $this->language->get('text_products') . "\n\n";
      foreach ($this->getProducts() as $product) {
        $output .= '- [' . $this->escapeMarkdownText($product['name']) . '](' . $product['url'] . ')';
        if (!empty($product['description'])) {
          $output .= ': ' . $this->escapeMarkdownText($product['description']);
        }
        $output .= "\n";
      }
      $output .= "\n";
    }

    if ($this->config->get('feed_probg_ai_tools_brands')) {
      $output .= '## ' . $this->language->get('text_brands') . "\n\n";
      foreach ($this->getBrands() as $brand) {
        $output .= '- [' . $this->escapeMarkdownText($brand['name']) . '](' . $brand['url'] . ')' . "\n";
      }
      $output .= "\n";
    }

    $output .= '## ' . $this->language->get('text_ai_resources') . "\n\n";

    $resources = array(
      'feed_probg_ai_tools_llms_json' => array($this->language->get('text_llms_json'), 'llms.json', ''),
      'feed_probg_ai_tools_ai_catalog' => array($this->language->get('text_ai_catalog'), 'ai-catalog.json', ''),
      'feed_probg_ai_tools_search_index' => array($this->language->get('text_search_index'), 'search-index.json', ''),
      'feed_probg_ai_tools_semantic_graph' => array($this->language->get('text_semantic_graph'), 'semantic.graph.json', ''),
      'feed_probg_ai_tools_llms_full' => array($this->language->get('text_llms_full'), 'llms-full.txt', ''),
      'feed_probg_ai_tools_products_graph' => array($this->language->get('text_products_graph'), 'products.graph.json', $this->language->get('text_graph_description')),
      'feed_probg_ai_tools_ai_policy' => array($this->language->get('text_ai_policy'), 'ai-policy.txt', '')
    );

    foreach ($resources as $setting => $resource) {
      if ($this->config->get($setting)) {
        $output .= '- [' . $this->escapeMarkdownText($resource[0]) . '](' . $this->getStoreUrl() . $resource[1] . ')';
        if ($resource[2]) {
          $output .= ': ' . $this->escapeMarkdownText($resource[2]);
        }
        $output .= "\n";
      }
    }

    $output .= "\n---\n";
    $output .= $this->language->get('text_generated') . ': ' . gmdate('c');

    $this->response->setOutput($output);
  }

  public function json() {
    if (!$this->isEnabled('feed_probg_ai_tools_llms_json')) {
      $this->disabled();
      return;
    }

    $this->outputJson($this->buildDataset());
  }

  public function full() {
    if (!$this->isEnabled('feed_probg_ai_tools_llms_full')) {
      $this->disabled();
      return;
    }

    $this->load->language('extension/feed/probg_ai_tools');
    $this->setResponseHeaders('text/plain; charset=utf-8');

    $output = '# ' . $this->language->get('text_full_ai_dataset') . "\n\n";
    $output .= $this->language->get('text_website') . ': ' . $this->getStoreUrl() . "\n\n";

    if ($this->config->get('feed_probg_ai_tools_categories')) {
      $output .= '## ' . $this->language->get('text_categories') . "\n\n";
      foreach ($this->getCategories() as $category) {
        $output .= '### ' . $this->escapeMarkdownText($category['name']) . "\n";
        $output .= '- ' . $this->language->get('text_url') . ': ' . $category['url'] . "\n";
        if (!empty($category['description'])) {
          $output .= '- ' . $this->language->get('text_description_label') . ': ' . $this->escapeMarkdownText($category['description']) . "\n";
        }
        $output .= "\n";
      }
    }

    if ($this->config->get('feed_probg_ai_tools_brands')) {
      $output .= '## ' . $this->language->get('text_brands') . "\n\n";
      foreach ($this->getBrands() as $brand) {
        $output .= '### ' . $this->escapeMarkdownText($brand['name']) . "\n";
        $output .= '- ' . $this->language->get('text_url') . ': ' . $brand['url'] . "\n\n";
      }
    }

    if ($this->config->get('feed_probg_ai_tools_products')) {
      $output .= '## ' . $this->language->get('text_products') . "\n\n";
      foreach ($this->getProducts() as $product) {
        $output .= '### ' . $this->escapeMarkdownText($product['name']) . "\n";
        $output .= '- ' . $this->language->get('text_url') . ': ' . $product['url'] . "\n";

        if (!empty($product['brand'])) {
          $output .= '- ' . $this->language->get('text_brand') . ': ' . $this->escapeMarkdownText($product['brand']) . "\n";
        }

        if ($product['price'] !== '') {
          $output .= '- ' . $this->language->get('text_price') . ': ' . $product['price'] . ' ' . $product['currency'] . "\n";
        }

        if ($product['special_price'] !== '') {
          $output .= '- ' . $this->language->get('text_special_price') . ': ' . $product['special_price'] . ' ' . $product['currency'] . "\n";
        }

        if (!empty($product['model'])) {
          $output .= '- ' . $this->language->get('text_model') . ': ' . $this->escapeMarkdownText($product['model']) . "\n";
        }

        if (!empty($product['sku'])) {
          $output .= '- SKU: ' . $this->escapeMarkdownText($product['sku']) . "\n";
        }

        if (!empty($product['description'])) {
          $output .= '- ' . $this->language->get('text_description_label') . ': ' . $this->escapeMarkdownText($product['description']) . "\n";
        }

        $output .= "\n";
      }
    }

    $output .= "---\n";
    $output .= $this->language->get('text_generated') . ': ' . gmdate('c');

    $this->response->setOutput($output);
  }

  public function catalog() {
    if (!$this->isEnabled('feed_probg_ai_tools_ai_catalog')) {
      $this->disabled();
      return;
    }

    $data = array(
      'store' => array(
        'name' => $this->cleanText($this->config->get('config_name')),
        'url' => $this->getStoreUrl(),
        'description' => $this->getSiteDescription()
      ),
      'generated_at' => gmdate('c'),
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

    $this->outputJson($data);
  }

  public function semantic() {
    if (!$this->isEnabled('feed_probg_ai_tools_semantic_graph')) {
      $this->disabled();
      return;
    }

    $graph = array();
    $products = $this->getProducts();

    foreach ($products as $product) {
      if (!empty($product['categories'])) {
        foreach ($product['categories'] as $category) {
          $graph[] = array(
            'from' => array('type' => 'product', 'id' => (int)$product['id'], 'name' => $product['name'], 'url' => $product['url']),
            'to' => array('type' => 'category', 'id' => (int)$category['id'], 'name' => $category['name'], 'url' => $category['url']),
            'relation' => 'belongs_to'
          );
        }
      }

      if (!empty($product['manufacturer_id']) && !empty($product['brand'])) {
        $brand = array(
          'type' => 'brand',
          'id' => (int)$product['manufacturer_id'],
          'name' => $product['brand'],
          'url' => $this->buildPublicUrl('product/manufacturer/info', 'manufacturer_id=' . (int)$product['manufacturer_id'])
        );

        $product_node = array(
          'type' => 'product',
          'id' => (int)$product['id'],
          'name' => $product['name'],
          'url' => $product['url']
        );

        $graph[] = array('from' => $product_node, 'to' => $brand, 'relation' => 'made_by');
        $graph[] = array('from' => $brand, 'to' => $product_node, 'relation' => 'has_product');
      }
    }

    $categories = $this->getCategories();
    $category_map = array();
    foreach ($categories as $category) {
      $category_map[(int)$category['id']] = $category;
    }

    foreach ($categories as $category) {
      $parent_id = isset($category['parent_id']) ? (int)$category['parent_id'] : 0;
      if (!$parent_id || !isset($category_map[$parent_id])) {
        continue;
      }

      $parent = $category_map[$parent_id];
      $graph[] = array(
        'from' => array('type' => 'category', 'id' => (int)$category['id'], 'name' => $category['name'], 'url' => $category['url']),
        'to' => array('type' => 'category', 'id' => (int)$parent['id'], 'name' => $parent['name'], 'url' => $parent['url']),
        'relation' => 'child_of'
      );
    }

    $this->outputJson(array(
      'meta' => array(
        'generated_at' => gmdate('c'),
        'total_relations' => count($graph)
      ),
      'relations' => $graph
    ));
  }

  public function search() {
    if (!$this->isEnabled('feed_probg_ai_tools_search_index')) {
      $this->disabled();
      return;
    }

    $data = array();

    foreach ($this->getProducts() as $product) {
      $keywords = array();
      $search_terms = array();

      $name = isset($product['name']) ? $this->cleanText($product['name']) : '';
      $brand = isset($product['brand']) ? $this->cleanText($product['brand']) : '';
      $model = isset($product['model']) ? $this->cleanText($product['model']) : '';
      $sku = isset($product['sku']) ? $this->cleanText($product['sku']) : '';

      $this->appendSearchValue($keywords, $name, true);
      $this->appendSearchValue($keywords, $brand, false);
      $this->appendSearchValue($keywords, $model, false);
      $this->appendSearchValue($keywords, $sku, false);

      if (!empty($product['categories'])) {
        foreach ($product['categories'] as $category) {
          $this->appendSearchValue($keywords, $category['name'], true);
        }
      }

      foreach (array($name, $brand, $model, $sku) as $value) {
        if ($value) {
          $search_terms[] = $value;
        }
      }

      if ($brand && $name) {
        $search_terms[] = $brand . ' ' . $name;
      }
      if ($brand && $model) {
        $search_terms[] = $brand . ' ' . $model;
      }
      if ($name && $model) {
        $search_terms[] = $name . ' ' . $model;
      }

      $data[] = array(
        'id' => (int)$product['id'],
        'type' => 'product',
        'name' => $name,
        'brand' => $brand,
        'model' => $model,
        'sku' => $sku,
        'url' => $product['url'],
        'keywords' => $this->normalizeSearchValues($keywords),
        'search_terms' => $this->normalizeSearchValues($search_terms)
      );
    }

    $this->outputJson($data);
  }

  public function policy() {
    if (!$this->isEnabled('feed_probg_ai_tools_ai_policy')) {
      $this->disabled();
      return;
    }

    $this->setResponseHeaders('text/plain; charset=utf-8');

    $host = parse_url($this->getStoreUrl(), PHP_URL_HOST);
    $output = '# AI Access Policy for: ' . $host . "\n";
    $output .= '# Informational policy file. Automated crawler access is controlled by robots.txt.\n\n';
    $output .= 'Website: ' . $this->getStoreUrl() . "\n";
    $output .= 'Robots: ' . $this->getStoreUrl() . "robots.txt\n";
    $output .= 'LLMS: ' . $this->getStoreUrl() . "llms.txt\n\n";
    $output .= "Policy:\n";
    $output .= "- Public website content may be analyzed by AI systems when crawler access is allowed by robots.txt.\n";
    $output .= "- Republishing, redistribution, and commercial reuse require permission from the website owner unless another license explicitly applies.\n";

    $this->response->setOutput($output);
  }

  public function graph() {
    if (!$this->isEnabled('feed_probg_ai_tools_products_graph')) {
      $this->disabled();
      return;
    }

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

    foreach ($this->getProducts() as $product) {
      $product_node_id = 'product_' . $product['id'];

      $nodes[] = array(
        'id' => $product_node_id,
        'type' => 'product',
        'name' => $product['name'],
        'url' => $product['url'],
        'price' => $product['price'],
        'special_price' => $product['special_price'],
        'currency' => $product['currency']
      );

      if (!empty($product['manufacturer_id'])) {
        $edges[] = array(
          'from' => $product_node_id,
          'to' => 'brand_' . (int)$product['manufacturer_id'],
          'relation' => 'manufactured_by'
        );
      }

      if (!empty($product['categories'])) {
        foreach ($product['categories'] as $category) {
          $edges[] = array(
            'from' => $product_node_id,
            'to' => 'category_' . (int)$category['id'],
            'relation' => 'belongs_to'
          );
        }
      }
    }

    $this->outputJson(array(
      'meta' => array(
        'generated_at' => gmdate('c'),
        'total_nodes' => count($nodes),
        'total_edges' => count($edges)
      ),
      'nodes' => $nodes,
      'edges' => $edges
    ));
  }

  private function buildDataset() {
    $data = array(
      'site' => array(
        'name' => $this->cleanText($this->config->get('config_name')),
        'url' => $this->getStoreUrl(),
        'description' => $this->getSiteDescription()
      ),
      'generated_at' => gmdate('c')
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

    return $data;
  }

  private function getProducts() {
    $language_id = (int)$this->config->get('config_language_id');
    $store_id = (int)$this->config->get('config_store_id');
    $customer_group_id = (int)$this->config->get('config_customer_group_id');
    $limit = (int)$this->config->get('feed_probg_ai_tools_product_limit');

    $sql = "SELECT p.product_id, p.model, p.sku, p.quantity, p.manufacturer_id, p.price AS base_price, p.date_modified, "
      . "pd.name, pd.description, pd.meta_description, m.name AS manufacturer, "
      . "(SELECT price FROM `" . DB_PREFIX . "product_discount` pd2 "
      . "WHERE pd2.product_id = p.product_id "
      . "AND pd2.customer_group_id = '" . $customer_group_id . "' "
      . "AND pd2.quantity = '1' "
      . "AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) "
      . "AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) "
      . "ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, "
      . "(SELECT price FROM `" . DB_PREFIX . "product_special` ps "
      . "WHERE ps.product_id = p.product_id "
      . "AND ps.customer_group_id = '" . $customer_group_id . "' "
      . "AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) "
      . "AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) "
      . "ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, "
      . "(SELECT ss.name FROM `" . DB_PREFIX . "stock_status` ss "
      . "WHERE ss.stock_status_id = p.stock_status_id "
      . "AND ss.language_id = '" . $language_id . "') AS stock_status "
      . "FROM `" . DB_PREFIX . "product` p "
      . "INNER JOIN `" . DB_PREFIX . "product_description` pd ON (p.product_id = pd.product_id) "
      . "INNER JOIN `" . DB_PREFIX . "product_to_store` p2s ON (p.product_id = p2s.product_id) "
      . "LEFT JOIN `" . DB_PREFIX . "manufacturer` m ON (p.manufacturer_id = m.manufacturer_id) "
      . "WHERE pd.language_id = '" . $language_id . "' "
      . "AND p.status = '1' "
      . "AND p.date_available <= NOW() "
      . "AND p2s.store_id = '" . $store_id . "' "
      . "ORDER BY p.sort_order ASC, LCASE(pd.name) ASC";

    if ($limit > 0) {
      $sql .= " LIMIT " . $limit;
    }

    $products = $this->db->query($sql)->rows;
    $product_ids = array();

    foreach ($products as $product) {
      $product_ids[] = (int)$product['product_id'];
    }

    $category_map = $this->getProductCategoriesMap($product_ids);
    $data = array();

    foreach ($products as $product) {
      $product_id = (int)$product['product_id'];
      $description = '';

      if (!empty($product['meta_description'])) {
        $description = $product['meta_description'];
      } elseif (!empty($product['description'])) {
        $description = $product['description'];
      }

      $manufacturer_name = !empty($product['manufacturer']) ? $this->cleanText($product['manufacturer']) : '';
      $price_source = ($product['discount'] !== null && $product['discount'] !== '') ? $product['discount'] : $product['base_price'];
      $price = ($price_source !== null && $price_source !== '') ? (float)$price_source : '';
      $special_price = ($product['special'] !== null && $product['special'] !== '' && (float)$product['special'] > 0) ? (float)$product['special'] : '';

      $item = array(
        'id' => $product_id,
        'type' => 'product',
        'name' => $this->cleanText($product['name']),
        'url' => $this->buildPublicUrl('product/product', 'product_id=' . $product_id),
        'description' => $this->truncateText($this->cleanText($description), 300),
        'price' => $price,
        'special_price' => $special_price,
        'currency' => (string)$this->config->get('config_currency'),
        'model' => isset($product['model']) ? $this->cleanText($product['model']) : '',
        'sku' => isset($product['sku']) ? $this->cleanText($product['sku']) : '',
        'quantity' => isset($product['quantity']) ? (int)$product['quantity'] : null,
        'stock_status' => isset($product['stock_status']) ? $this->cleanText($product['stock_status']) : '',
        'manufacturer_id' => isset($product['manufacturer_id']) ? (int)$product['manufacturer_id'] : 0,
        'date_modified' => isset($product['date_modified']) ? $product['date_modified'] : ''
      );

      if ($manufacturer_name) {
        $item['brand'] = $manufacturer_name;
      }

      if (!empty($category_map[$product_id])) {
        $item['categories'] = $category_map[$product_id];
      }

      $data[] = $item;
    }

    return $data;
  }

  private function getProductCategoriesMap($product_ids) {
    $map = array();

    if (!$product_ids) {
      return $map;
    }

    $language_id = (int)$this->config->get('config_language_id');
    $store_id = (int)$this->config->get('config_store_id');

    foreach (array_chunk($product_ids, 500) as $chunk) {
      $ids = implode(',', array_map('intval', $chunk));

      $query = $this->db->query("SELECT p2c.product_id, c.category_id, cd.name\n"
        . "FROM `" . DB_PREFIX . "product_to_category` p2c\n"
        . "INNER JOIN `" . DB_PREFIX . "category` c ON (p2c.category_id = c.category_id)\n"
        . "INNER JOIN `" . DB_PREFIX . "category_description` cd ON (c.category_id = cd.category_id)\n"
        . "INNER JOIN `" . DB_PREFIX . "category_to_store` c2s ON (c.category_id = c2s.category_id)\n"
        . "WHERE p2c.product_id IN (" . $ids . ")\n"
        . "AND c.status = '1'\n"
        . "AND cd.language_id = '" . $language_id . "'\n"
        . "AND c2s.store_id = '" . $store_id . "'\n"
        . "ORDER BY p2c.product_id ASC, c.sort_order ASC, cd.name ASC");

      foreach ($query->rows as $category) {
        $product_id = (int)$category['product_id'];
        if (!isset($map[$product_id])) {
          $map[$product_id] = array();
        }

        $map[$product_id][] = array(
          'id' => (int)$category['category_id'],
          'name' => $this->cleanText($category['name']),
          'url' => $this->buildPublicUrl('product/category', 'path=' . (int)$category['category_id'])
        );
      }
    }

    return $map;
  }

  private function getCategories() {
    $language_id = (int)$this->config->get('config_language_id');
    $store_id = (int)$this->config->get('config_store_id');

    $query = $this->db->query("SELECT c.category_id, c.parent_id, c.date_modified, cd.name, cd.description\n"
      . "FROM `" . DB_PREFIX . "category` c\n"
      . "INNER JOIN `" . DB_PREFIX . "category_description` cd ON (c.category_id = cd.category_id)\n"
      . "INNER JOIN `" . DB_PREFIX . "category_to_store` c2s ON (c.category_id = c2s.category_id)\n"
      . "WHERE c.status = '1'\n"
      . "AND cd.language_id = '" . $language_id . "'\n"
      . "AND c2s.store_id = '" . $store_id . "'\n"
      . "ORDER BY c.sort_order ASC, cd.name ASC");

    $data = array();

    foreach ($query->rows as $category) {
      $data[] = array(
        'id' => (int)$category['category_id'],
        'parent_id' => (int)$category['parent_id'],
        'type' => 'category',
        'name' => $this->cleanText($category['name']),
        'url' => $this->buildPublicUrl('product/category', 'path=' . (int)$category['category_id']),
        'description' => $this->truncateText($this->cleanText($category['description']), 300),
        'date_modified' => $category['date_modified']
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
        'url' => $this->buildPublicUrl('product/manufacturer/info', 'manufacturer_id=' . (int)$manufacturer['manufacturer_id'])
      );
    }

    return $data;
  }

  private function getEnabledResourceUrls() {
    $resources = array(
      'feed_probg_ai_tools_llms_txt' => 'llms.txt',
      'feed_probg_ai_tools_llms_json' => 'llms.json',
      'feed_probg_ai_tools_llms_full' => 'llms-full.txt',
      'feed_probg_ai_tools_products_graph' => 'products.graph.json',
      'feed_probg_ai_tools_ai_catalog' => 'ai-catalog.json',
      'feed_probg_ai_tools_ai_policy' => 'ai-policy.txt',
      'feed_probg_ai_tools_search_index' => 'search-index.json',
      'feed_probg_ai_tools_semantic_graph' => 'semantic.graph.json'
    );

    $urls = array();
    foreach ($resources as $setting => $path) {
      if ($this->config->get($setting)) {
        $urls[] = $this->getStoreUrl() . $path;
      }
    }

    return $urls;
  }

  private function appendSearchValue(&$values, $value, $split_words) {
    $value = $this->cleanText($value);
    if (!$value) {
      return;
    }

    $values[] = $value;

    if (!$split_words) {
      return;
    }

    $words = preg_split('/[\s\-\_,\.\/]+/u', $this->toLower($value));
    foreach ($words as $word) {
      $word = trim($word);
      if ($this->textLength($word) > 2) {
        $values[] = $word;
      }
    }
  }

  private function normalizeSearchValues($values) {
    $normalized = array();

    foreach ($values as $value) {
      $value = $this->toLower(trim($value));
      if ($value !== '') {
        $normalized[] = $value;
      }
    }

    return array_values(array_unique($normalized));
  }

  private function getSiteDescription() {
    $description = $this->cleanText($this->config->get('feed_probg_ai_tools_site_description'));
    if (!$description) {
      $description = $this->cleanText($this->config->get('config_meta_description'));
    }
    return $description;
  }

  private function isEnabled($feature = '') {
    if ((int)$this->config->get('feed_probg_ai_tools_status') !== 1) {
      return false;
    }

    if ($feature && (int)$this->config->get($feature) !== 1) {
      return false;
    }

    return true;
  }

  private function outputJson($data) {
    $this->setResponseHeaders('application/json; charset=utf-8');
    $output = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    if ($output === false) {
      $this->response->addHeader('HTTP/1.1 500 Internal Server Error');
      $output = json_encode(array('error' => 'Unable to encode AI feed data.'));
    }

    $this->response->setOutput($output);
  }

  private function setResponseHeaders($content_type) {
    $this->response->addHeader('Content-Type: ' . $content_type);
    $this->response->addHeader('Cache-Control: public, max-age=300');
    $this->response->addHeader('X-Content-Type-Options: nosniff');
    $this->response->addHeader('Link: </llms.txt>; rel="describedby"');
  }

  private function cleanText($text) {
    $text = html_entity_decode((string)$text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('#<script(.*?)>(.*?)</script>#is', ' ', $text);
    $text = preg_replace('#<style(.*?)>(.*?)</style>#is', ' ', $text);
    $text = strip_tags($text);
    $text = preg_replace('/\s+/u', ' ', $text);

    return trim($text);
  }

  private function escapeMarkdownText($text) {
    return str_replace(array('\\', '[', ']'), array('\\\\', '\\[', '\\]'), (string)$text);
  }

  private function xmlEscape($text) {
    return htmlspecialchars((string)$text, ENT_QUOTES | ENT_XML1, 'UTF-8');
  }

  private function truncateText($text, $length) {
    if (function_exists('utf8_substr')) {
      return utf8_substr($text, 0, $length);
    }
    if (function_exists('mb_substr')) {
      return mb_substr($text, 0, $length, 'UTF-8');
    }
    return substr($text, 0, $length);
  }

  private function toLower($text) {
    if (function_exists('utf8_strtolower')) {
      return utf8_strtolower($text);
    }
    if (function_exists('mb_strtolower')) {
      return mb_strtolower($text, 'UTF-8');
    }
    return strtolower($text);
  }

  private function textLength($text) {
    if (function_exists('utf8_strlen')) {
      return utf8_strlen($text);
    }
    if (function_exists('mb_strlen')) {
      return mb_strlen($text, 'UTF-8');
    }
    return strlen($text);
  }

  private function buildPublicUrl($route, $args = '') {
    return $this->url->link($route, $args, $this->isHttps());
  }

  private function isHttps() {
    if (!empty($this->request->server['HTTPS']) && strtolower((string)$this->request->server['HTTPS']) !== 'off') {
      return true;
    }

    if (!empty($this->request->server['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$this->request->server['HTTP_X_FORWARDED_PROTO']) === 'https') {
      return true;
    }

    return !empty($this->request->server['SERVER_PORT']) && (int)$this->request->server['SERVER_PORT'] === 443;
  }

  private function getStoreUrl() {
    $url = $this->isHttps() ? $this->config->get('config_ssl') : $this->config->get('config_url');

    if (!$url) {
      $url = $this->config->get('config_url');
    }

    return rtrim($url, '/') . '/';
  }

  private function disabled() {
    $this->load->language('extension/feed/probg_ai_tools');
    $this->response->addHeader('HTTP/1.1 404 Not Found');
    $this->response->addHeader('Content-Type: text/plain; charset=utf-8');
    $this->response->addHeader('X-Content-Type-Options: nosniff');
    $this->response->setOutput($this->language->get('text_feed_disabled'));
  }
}
