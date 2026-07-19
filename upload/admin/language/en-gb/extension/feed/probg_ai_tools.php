<?php

// Heading
$_['heading_title'] = 'ProBG AI Tools';

// Text
$_['text_extension'] = 'Разширения';
$_['text_success'] = 'Настройките на ProBG AI Tools са записани успешно!';
$_['text_edit'] = 'Настройки на ProBG AI Tools';
$_['text_enabled'] = 'Включено';
$_['text_disabled'] = 'Изключено';
$_['text_yes'] = 'Да';
$_['text_no'] = 'Не';
$_['text_copied'] = 'Правилата бяха копирани.';

// Tabs
$_['tab_general'] = 'Основни';
$_['tab_ai_sitemap'] = 'AI Sitemap';
$_['tab_llms'] = 'LLMS';
$_['tab_products_graph'] = 'Products Graph';
$_['tab_advanced'] = 'Разширени';

// Entry
$_['entry_status'] = 'Статус';
$_['entry_product_limit'] = 'Лимит на продуктите';
$_['entry_site_description'] = 'AI описание за LLMS.txt';

$_['entry_products'] = 'Продукти';
$_['entry_categories'] = 'Категории';
$_['entry_brands'] = 'Марки';

$_['entry_ai_sitemap'] = 'AI Sitemap';
$_['entry_ai_sitemap_url'] = 'AI Sitemap URL';

$_['entry_llms_txt'] = 'LLMS.txt';
$_['entry_llms_json'] = 'LLMS.json';
$_['entry_llms_full'] = 'LLMS Full';
$_['entry_ai_catalog'] = 'AI Catalog';
$_['entry_ai_policy'] = 'AI Access Policy';

$_['entry_products_graph'] = 'Products Graph';
$_['entry_search_index'] = 'Search Index';

$_['entry_urls'] = 'Публични URL адреси';
$_['entry_htaccess'] = '.htaccess правила';

$_['entry_semantic_graph'] = 'Semantic Graph';

// Help
$_['help_status'] = 'Включва или изключва целия пакет ProBG AI Tools.';
$_['help_product_limit'] = '0 = всички продукти. Ако зададете число, ще се включат само толкова продукта.';
$_['help_site_description'] = 'Кратко описание на магазина за AI модели. Ако е празно, ще се използва Meta Description на магазина.';

$_['help_products'] = 'Включва продуктите във всички AI фийдове.';
$_['help_categories'] = 'Включва категориите във всички AI фийдове.';
$_['help_brands'] = 'Включва марките във всички AI фийдове.';

$_['help_ai_sitemap'] = 'Включва или изключва публичния файл ai-sitemap.xml.';
$_['help_llms_txt'] = 'Включва или изключва публичния файл llms.txt.';
$_['help_llms_json'] = 'Включва или изключва публичния файл llms.json.';
$_['help_llms_full'] = 'Включва или изключва публичния файл llms-full.txt.';
$_['help_ai_catalog'] = 'Генерира ai-catalog.json с цялата структура на магазина.';
$_['help_ai_policy'] = 'Генерира отделен файл ai-policy.txt с политика за достъп на AI системи.';
$_['help_products_graph'] = 'Генерира products.graph.json със семантични връзки между продукти, категории и марки.';
$_['help_search_index'] = 'Генерира search-index.json с оптимизирани ключови думи и термини за AI търсене.';
$_['help_semantic_graph'] = 'Генерира semantic.graph.json със семантичните връзки в магазина.';

$_['help_htaccess'] = 'Добавете тези правила в .htaccess файла преди основното OpenCart SEO правило.';

// URL labels
$_['text_ai_sitemap_url'] = 'AI Sitemap URL';
$_['text_llms_txt_url'] = 'LLMS.txt URL';
$_['text_llms_json_url'] = 'LLMS.json URL';
$_['text_llms_full_url'] = 'LLMS Full URL';
$_['text_ai_catalog_url'] = 'AI Catalog URL';
$_['text_ai_policy_url'] = 'AI Policy URL';
$_['text_products_graph_url'] = 'Products Graph URL';
$_['text_search_index_url'] = 'Search Index URL';

// Buttons
$_['button_save'] = 'Запази';
$_['button_cancel'] = 'Отказ';
$_['button_copy'] = 'Копирай';

// .htaccess
$_['text_htaccess_rule'] = 'RewriteRule ^ai-sitemap\.xml$ index.php?route=extension/feed/probg_ai_tools [L,QSA]

RewriteRule ^llms\.txt$ index.php?route=extension/feed/probg_ai_tools/llms [L,QSA]

RewriteRule ^llms\.json$ index.php?route=extension/feed/probg_ai_tools/json [L,QSA]

RewriteRule ^llms-full\.txt$ index.php?route=extension/feed/probg_ai_tools/full [L,QSA]

RewriteRule ^products\.graph\.json$ index.php?route=extension/feed/probg_ai_tools/graph [L,QSA]

RewriteRule ^ai-catalog\.json$ index.php?route=extension/feed/probg_ai_tools/catalog [L,QSA]

RewriteRule ^ai-policy\.txt$ index.php?route=extension/feed/probg_ai_tools/policy [L,QSA]

RewriteRule ^search-index\.json$ index.php?route=extension/feed/probg_ai_tools/search [L,QSA]';

// Error
$_['error_permission'] = 'Нямате права за промяна на ProBG AI Tools!';