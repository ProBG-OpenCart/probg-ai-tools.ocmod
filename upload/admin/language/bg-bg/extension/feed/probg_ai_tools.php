<?php
$_['heading_title'] = 'ProBG AI Tools';

$_['text_extension'] = 'Разширения';
$_['text_success'] = 'Настройките на ProBG AI Tools са записани успешно!';
$_['text_edit'] = 'Настройки на ProBG AI Tools';
$_['text_enabled'] = 'Включено';
$_['text_disabled'] = 'Изключено';
$_['text_yes'] = 'Да';
$_['text_no'] = 'Не';
$_['text_ai_catalog_url'] = 'AI Catalog';
$_['text_seo_url_managed'] = 'Публичните имена на AI ресурсите се управляват автоматично чрез OpenCart SEO URL (oc_seo_url). Не са необходими допълнителни .htaccess правила.';
$_['text_seo_url_disabled'] = 'SEO URL е изключен в настройките на OpenCart. Записите в oc_seo_url са създадени, но публичните адреси като llms.txt ще работят само при включен SEO URL и стандартното OpenCart rewrite правило.';

$_['tab_general'] = 'Основни';
$_['tab_ai_sitemap'] = 'AI Sitemap';
$_['tab_ai_catalog'] = 'AI Catalog';
$_['tab_llms'] = 'LLMS';
$_['tab_products_graph'] = 'Products Graph';
$_['tab_advanced'] = 'Разширени';

$_['entry_status'] = 'Статус';
$_['entry_product_limit'] = 'Лимит на продуктите';
$_['entry_site_description'] = 'AI описание за llms.txt';
$_['entry_products'] = 'Продукти';
$_['entry_categories'] = 'Категории';
$_['entry_brands'] = 'Марки';
$_['entry_ai_sitemap'] = 'AI Sitemap';
$_['entry_ai_sitemap_url'] = 'AI Sitemap URL';
$_['entry_llms_txt'] = 'llms.txt';
$_['entry_llms_json'] = 'llms.json';
$_['entry_llms_full'] = 'llms-full.txt';
$_['entry_ai_catalog'] = 'AI Catalog';
$_['entry_ai_policy'] = 'AI Access Policy';
$_['entry_products_graph'] = 'Products Graph';
$_['entry_search_index'] = 'Search Index';
$_['entry_semantic_graph'] = 'Semantic Graph';

$_['help_status'] = 'Включва или изключва всички публични ресурси на ProBG AI Tools.';
$_['help_product_limit'] = '0 = всички продукти. Положително число ограничава броя продукти във всички генерирани ресурси.';
$_['help_site_description'] = 'Кратко описание на магазина за AI модели. Ако е празно, се използва Meta Description на магазина.';
$_['help_products'] = 'Включва продуктите в генерираните AI ресурси.';
$_['help_categories'] = 'Включва категориите в генерираните AI ресурси.';
$_['help_brands'] = 'Включва марките в генерираните AI ресурси.';
$_['help_ai_sitemap'] = 'Включва или изключва стандартния XML файл ai-sitemap.xml.';
$_['help_llms_txt'] = 'Включва или изключва публичния llms.txt файл.';
$_['help_llms_json'] = 'Включва или изключва публичния llms.json файл.';
$_['help_llms_full'] = 'Включва или изключва разширения llms-full.txt файл.';
$_['help_ai_catalog'] = 'Генерира ai-catalog.json със структурирани данни за магазина.';
$_['help_ai_policy'] = 'Генерира информационен ai-policy.txt. Реалният достъп на crawler-и се управлява от robots.txt.';
$_['help_products_graph'] = 'Генерира products.graph.json с връзки продукт → категория и продукт → марка.';
$_['help_search_index'] = 'Генерира search-index.json с нормализирани ключови думи и комбинации за търсене.';
$_['help_semantic_graph'] = 'Генерира semantic.graph.json със семантични връзки между продукти, категории и марки.';

$_['button_save'] = 'Запази';
$_['button_cancel'] = 'Отказ';

$_['error_permission'] = 'Нямате права за промяна на ProBG AI Tools!';
$_['error_product_limit'] = 'Лимитът на продуктите трябва да бъде цяло неотрицателно число.';
$_['error_seo_keyword_conflict'] = 'SEO URL конфликт: "%s" вече се използва от "%s" за store_id %d. ProBG AI Tools няма да презапише съществуващия адрес.';
