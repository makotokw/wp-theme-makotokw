makotokw theme for WordPress
===

WordPress theme for [kwLog](http://blog.makotokw.com).

 * Created by [_s](http://underscores.me)
 * Inspired [Twenty Thirteen](http://twentythirteendemo.wordpress.com/), [Twenty Eleven](http://wordpress.org/extend/themes/twentyeleven) and [Octopress](http://octopress.org/)
 * Developed CSS by using [Compass](http://compass-style.org/)
 * Include [Font Awesome](http://fortawesome.github.io/Font-Awesome/) Icons
 * Include [Genericons](http://genericons.com/)
 * Include [google-code-prettify](http://code.google.com/p/google-code-prettify/)

## Work With 

* [SyntaxHighlighter Evolved](http://wordpress.org/extend/plugins/syntaxhighlighter/) Plugin
* [AmazonJS](http://wordpress.org/extend/plugins/amazonjs/) Plugin
* [GitHub Flavored Markdown for WordPress](https://github.com/makotokw/wp-gfm) Plugin
* [PukiWiki for WordPress](http://wordpress.org/extend/plugins/pukiwiki-for-wordpress/) Plugin
* [Facebook Open Graph](http://developers.facebook.com/docs/opengraph/) Protocol
* [Facebook Recommendations Bar](https://developers.facebook.com/docs/reference/plugins/recommendationsbar/)
* [Zenback](http://zenback.jp/) Widget

## Limitation

* Tested on PHP 5.4 **ONLY** by makoto\_kw for kwLog
 * Some styles are **depend on** posts on kwLog
 * **No** sidebar, **No** widgets
 * **Unsuppoted** post formats
 * **Not** implement for Comment Form (I use Jetpack Comment)

Unfortunately, I did **NOT** design for purpose that others use.
So, please use a reference of one implemention for WordPress theme.

## Instration

```
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/makotokw/wp-theme-makotokw.git makotokw2013
cd makotokw2013
cp -p config.php.sample config.php
```

## Build

```
cd /path/to/wordpress/wp-content/themes/makotokw2013
compass compile
```

## License

* GPL v2
