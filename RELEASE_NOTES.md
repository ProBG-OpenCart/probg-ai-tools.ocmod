# ProBG AI Tools 1.3.0

## Български

Версия 1.3.0 включва пълна ревизия на модула с фокус върху коректност, производителност, SEO URL интеграция и по-добра съвместимост с OpenCart 3.

### Основни промени

- `ai-sitemap.xml` вече е реален XML sitemap;
- публичните AI файлове се регистрират автоматично в `oc_seo_url` / `<DB_PREFIX>seo_url`;
- отпада нуждата от отделни `.htaccess` RewriteRule правила за всеки AI ресурс;
- SEO URL записите се синхронизират при инсталация и при запис на настройките за default store, допълнителните магазини и активните езици;
- добавена е защита от конфликт със съществуващ SEO keyword;
- при деинсталация се премахват само SEO URL записите на ProBG AI Tools;
- глобалният статус вече контролира всички публични endpoints;
- поправени са `products.graph.json` и `semantic.graph.json` връзките продукт → категория и продукт → марка;
- премахнат е N+1 моделът при зареждане на продукти и категории чрез оптимизирани SQL заявки и пакетно зареждане;
- добавени са SKU, количество, stock status, промоционална цена и валута;
- Search Index вече включва категории и SKU;
- лимитът на продуктите се прилага последователно към всички генерирани ресурси;
- подобрена е multi-store и language филтрацията;
- timestamps са в ISO-8601 формат;
- добавени са Cache-Control, X-Content-Type-Options и `Link: </llms.txt>; rel="describedby"` headers;
- подобрено е HTTPS разпознаването при reverse proxy;
- `ai-policy.txt` е обозначен като информационен, като crawler контролът остава в `robots.txt`;
- поправени са административният интерфейс, записът на настройките и валидацията;
- коригирани и синхронизирани са българските и английските езикови файлове.

## English

Version 1.3.0 is a full module revision focused on correctness, performance, SEO URL integration and improved OpenCart 3 compatibility.

### Highlights

- `ai-sitemap.xml` is now a real XML sitemap;
- public AI resource filenames are registered automatically in `oc_seo_url` / `<DB_PREFIX>seo_url`;
- separate `.htaccess` RewriteRule entries are no longer required for each AI resource;
- SEO URL records are synchronized on install and settings save for the default store, additional stores and active languages;
- existing SEO keyword conflicts are detected and are never overwritten silently;
- uninstall removes only SEO URL records owned by ProBG AI Tools;
- the global module status now controls all public endpoints;
- product → category and product → brand relations in `products.graph.json` and `semantic.graph.json` are fixed;
- the N+1 product/category loading pattern has been replaced with optimized SQL and batched category loading;
- SKU, quantity, stock status, special price and currency data have been added;
- Search Index now includes categories and SKU;
- the configured product limit is applied consistently across generated resources;
- multi-store and language filtering has been improved;
- generated timestamps use ISO-8601;
- Cache-Control, X-Content-Type-Options and `Link: </llms.txt>; rel="describedby"` headers have been added;
- HTTPS detection behind reverse proxies has been improved;
- `ai-policy.txt` is explicitly informational while crawler access remains controlled by `robots.txt`;
- administration UI, settings save behavior and validation have been corrected;
- Bulgarian and English language files have been corrected and synchronized.
