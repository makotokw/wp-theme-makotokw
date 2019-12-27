makotokw theme for WordPress
===

WordPress theme for [blog.makotokw.com](https://blog.makotokw.com).

![Screenshot](https://raw.githubusercontent.com/makotokw/wp-theme-makotokw/makotokw2018/screenshot.png)

 * Created by [_s](http://underscores.me)
 * Inspired [Twenty Fifteen](https://twentyfifteendemo.wordpress.com/), [ghost](https://blog.ghost.org/) and [medium](https://medium.com/)
 * Include [Font Awesome](http://fortawesome.github.io/Font-Awesome/) Icons
 * Include [google-code-prettify](https://github.com/google/code-prettify)

## Work With

* [AmazonJS](https://wordpress.org/plugins/amazonjs/) Plugin
* [GitHub Flavored Markdown for WordPress](https://github.com/makotokw/wp-gfm) Plugin
* [Twitter Card](https://dev.twitter.com/docs/cards)
* [Facebook Open Graph](https://developers.facebook.com/docs/sharing/opengraph) Protocol

## Limitation

* Tested on PHP 7.3 **ONLY** by makotokw for kwLog
 * Some styles are **depend on** posts on kwLog
 * **Used** ``register_taxonomy()`` for kwLog
 * **No** sidebar, **No** widgets
 * **Unsupported** post formats
 * **Not** implement for Comment Form (I use Jetpack Comment)

Unfortunately, I did **NOT** design for purpose that others use.
So, please use a reference of one implementation for WordPress theme.

## Installation

```
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/makotokw/wp-theme-makotokw.git makotokw2018
cd makotokw2018
cp -p config.php.sample config.php
```

## Development

### Requirements

* [Node.js](https://nodejs.org)
* [Yarn](https://yarnpkg.com)

### Build

```
cd /path/to/wordpress/wp-content/themes/makotokw2020
yarn install
yarn run build
```

## License

* GPL v2
