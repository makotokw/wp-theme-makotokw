makotokw theme for WordPress
===

WordPress theme for [kwLog](http://blog.makotokw.com).


![Screenshot](https://raw.githubusercontent.com/makotokw/wp-theme-makotokw/makotokw2014/screenshot.png)

 * Created by [_s](http://underscores.me)
 * Inspired [Twenty Thirteen](http://twentythirteendemo.wordpress.com/), [Twenty Eleven](http://wordpress.org/extend/themes/twentyeleven) and [Octopress](http://octopress.org/)
 * Include [Font Awesome](http://fortawesome.github.io/Font-Awesome/) Icons
 * Include [Genericons](http://genericons.com/)
 * Include [google-code-prettify](http://code.google.com/p/google-code-prettify/)

## Work With

* [SyntaxHighlighter Evolved](http://wordpress.org/extend/plugins/syntaxhighlighter/) Plugin
* [AmazonJS](http://wordpress.org/extend/plugins/amazonjs/) Plugin
* [GitHub Flavored Markdown for WordPress](https://github.com/makotokw/wp-gfm) Plugin
* [PukiWiki for WordPress](http://wordpress.org/extend/plugins/pukiwiki-for-wordpress/) Plugin
* [Twitter Card](https://dev.twitter.com/docs/cards)
* [Facebook Open Graph](http://developers.facebook.com/docs/opengraph/) Protocol
* [Facebook Recommendations Bar](https://developers.facebook.com/docs/reference/plugins/recommendationsbar/)
* [Zenback](http://zenback.jp/) Widget

## Limitation

* Tested on PHP 5.5 **ONLY** by makotokw for kwLog
 * Some styles are **depend on** posts on kwLog
 * **No** sidebar, **No** widgets
 * **Unsupported** post formats
 * **Not** implement for Comment Form (I use Jetpack Comment)

Unfortunately, I did **NOT** design for purpose that others use.
So, please use a reference of one implementation for WordPress theme.

## Installation

```
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/makotokw/wp-theme-makotokw.git makotokw2014
cd makotokw2014
git checkout -b makotokw2014 origin/makotokw2014
cp -p config.php.sample config.php
```

## Development

### Requirements

* [Grunt](http://gruntjs.com/)
* [Bower](http://bower.io/)
* [Compass](http://compass-style.org/)

### Setup

```
cd /path/to/wordpress/wp-content/themes/makotokw2014
gem install compass
npm install -g grunt-cli bower
npm install
bower install
grunt bower:install
```

## Build

```
cd /path/to/wordpress/wp-content/themes/makotokw2014
grunt build
```

### phpcs

https://github.com/squizlabs/PHP_CodeSniffer
https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards


```
phpcs --standard=build/phpcs.xml *.php ./**/*.php
```

## License

* GPL v2
