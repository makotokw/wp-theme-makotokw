# makotokw theme for WordPress

WordPress theme for [blog.makotokw.com](https://blog.makotokw.com).

![Screenshot](https://raw.githubusercontent.com/makotokw/wp-theme-makotokw/makotokw2021/screenshot.png)

- Created by [_s](http://underscores.me)
- Inspired by [Twenty Fifteen](https://twentyfifteendemo.wordpress.com/), [Ghost](https://blog.ghost.org/), and [Medium](https://medium.com/)
- [Font Awesome](http://fortawesome.github.io/Font-Awesome/) icons
- [Nunito Sans](https://github.com/googlefonts/nunito), self-hosted under the SIL Open Font License 1.1 (`assets/fonts/Nunito-Sans-OFL.txt`)
- [google-code-prettify](https://github.com/google/code-prettify)
- [Notyf](https://github.com/caroso1222/notyf)
- [Tippy.js](https://atomiks.github.io/tippyjs/)

## Works With

- [AmazonJS](https://wordpress.org/plugins/amazonjs/) plugin
- [GitHub Flavored Markdown for WordPress](https://github.com/makotokw/wp-gfm) plugin
- [Twitter Card](https://dev.twitter.com/docs/cards)
- [Facebook Open Graph](https://developers.facebook.com/docs/sharing/opengraph) protocol

## Limitations

- Tested on PHP 7.4 **only** by makotokw for kwLog
- Some styles **depend on** posts on kwLog
- **Uses** `register_taxonomy()` for kwLog
- **No** sidebar, **no** widgets
- **Unsupported** post formats
- **No** implementation for the comment form (I use Jetpack Comment)

Unfortunately, I did **not** design this for use by others.
Please use it as a reference implementation for a WordPress theme.

## Installation

```sh
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/makotokw/wp-theme-makotokw.git makotokw2026
cd makotokw2026
cp -p config.php.sample config.php
```

## Development

### Requirements

- [Node.js](https://nodejs.org)
- [Yarn](https://yarnpkg.com)

### Build

```sh
cd /path/to/wordpress/wp-content/themes/makotokw2026
yarn install
# Development server (optional; for assets only)
yarn dev
# Production build
yarn build
```

## License

- GPL v2
