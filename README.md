makotokw theme for WordPress
===

WordPress theme for [kwLog](http://blog.makotokw.com).


![Screenshot](https://raw.githubusercontent.com/makotokw/wp-theme-makotokw/makotokw2014/screenshot.png)

 * Created by [_s](http://underscores.me)
 * Inspired [Twenty Fifteen](https://twentyfifteendemo.wordpress.com/), [ghost](http://blog.ghost.org/) and [medium](https://medium.com/)
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
git clone https://github.com/makotokw/wp-theme-makotokw.git makotokw2015
cd makotokw2015
git checkout makotokw2015
cp -p config.php.sample config.php
```

## Development

### Requirements

* Node.JS, [Gulp](http://gruntjs.com/) and [Bower](http://bower.io/)
* Ruby and [Sass](http://sass-lang.com/)
* gettext, [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards)

### Setup

```
cd /path/to/wordpress/wp-content/themes/makotokw2015
gem install sass
npm install -g gulp bower
npm install
```

## Build

```
cd /path/to/wordpress/wp-content/themes/makotokw2015
gulp bower:install
gulp build
```

## License

* GPL v2
