# ProBG AI Tools for OpenCart 3

AI-oriented feeds and machine-readable resources for OpenCart 3 stores.

Bulgarian documentation: [README_BG.md](README_BG.md)

## Version

Current released version: **1.2.0**

## Features

- configurable `llms.txt` and `llms.json` resources;
- extended `llms-full.txt` dataset;
- standards-based XML `ai-sitemap.xml`;
- product, category, manufacturer, stock, price and special-price data;
- product/category/brand graph output;
- AI catalogue, search index and semantic graph resources;
- informational AI access policy output;
- configurable product limit and individual resource switches;
- multi-store and active-language filtering;
- automatic registration of public AI addresses in OpenCart `seo_url`;
- Bulgarian and English administration/catalog language files.

## Public resources

When enabled, the module exposes:

- `ai-sitemap.xml`
- `llms.txt`
- `llms.json`
- `llms-full.txt`
- `ai-catalog.json`
- `products.graph.json`
- `semantic.graph.json`
- `search-index.json`
- `ai-policy.txt`

On installation and every settings save, the module automatically synchronizes these addresses in `oc_seo_url` (or `<DB_PREFIX>seo_url`) for the default store, all additional stores and all active languages. Separate `.htaccess` rules for each AI resource are no longer required.

The standard OpenCart SEO URL mechanism and the standard OpenCart rewrite rule must remain enabled. If a keyword such as `llms.txt` is already owned by another route, the module does not overwrite it and reports the conflict in administration.

On uninstall, only `seo_url` records whose query values belong to ProBG AI Tools are removed.

## Installation package

Upload `dist/probg-ai-tools-1.2.0.ocmod.zip` through **Extensions → Installer**, refresh **Extensions → Modifications**, then install and configure **ProBG AI Tools** from the feed extensions.

The package in `dist/` represents the current released version. Source changes made after a release are packaged with the next version.

## Support development

If this module is useful to you, you can support its development through Revolut:

[![Buy me a coffee](https://img.shields.io/badge/Buy%20me%20a%20coffee-Revolut-0075EB?style=for-the-badge&logo=revolut&logoColor=white)](https://revolut.me/vtotev)
