# ProBG AI Tools за OpenCart 3

Модул за AI ориентирани feed-ове и машинно четими ресурси за магазини с OpenCart 3.

English documentation: [README.md](README.md)

## Версия

Текуща публикувана версия: **1.2.0**

## Възможности

- конфигурируеми ресурси `llms.txt` и `llms.json`;
- разширен набор от данни `llms-full.txt`;
- стандартен XML `ai-sitemap.xml`;
- данни за продукти, категории, производители, наличности, цени и промоционални цени;
- граф от връзки продукт/категория/марка;
- AI каталог, индекс за търсене и семантичен граф;
- информационна политика за AI достъп;
- лимит на продуктите и отделно включване на всеки публичен ресурс;
- филтриране според текущия магазин и език при multi-store инсталации;
- български и английски езикови файлове за администрацията и каталога.

## Публични ресурси

При включени съответни настройки и добавени препоръчаните rewrite правила модулът предоставя:

- `ai-sitemap.xml`
- `llms.txt`
- `llms.json`
- `llms-full.txt`
- `ai-catalog.json`
- `products.graph.json`
- `semantic.graph.json`
- `search-index.json`
- `ai-policy.txt`

В настройките на модула са показани необходимите `.htaccess` rewrite правила.

## Инсталационен пакет

Качете `dist/probg-ai-tools-1.2.0.ocmod.zip` през **Extensions → Installer**, обновете **Extensions → Modifications**, след което инсталирайте и настройте **ProBG AI Tools** от разширенията тип Feed.

Пакетът в `dist/` е за текущата публикувана версия. Промените в source кода след Release се пакетират при следващата версия.

## Подкрепете разработката

Ако модулът ви е полезен, можете да подкрепите неговата разработка чрез Revolut:

[![Buy me a coffee](https://img.shields.io/badge/Buy%20me%20a%20coffee-Revolut-0075EB?style=for-the-badge&logo=revolut&logoColor=white)](https://revolut.me/vtotev)
