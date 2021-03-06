# Twig Awesome Bundle

[![Build Status](https://travis-ci.org/derrabus/twig-awesome-bundle.svg?branch=master)](https://travis-ci.org/derrabus/twig-awesome-bundle)

This bundle integrates the icon font [Font Awesome 5](http://fontawesome.io/) into Twig. But instead of using CSS to
render icons on the frontend, the icons are rendered as SVG images directly into the compiled Twig template.

## Example

This example renders a flag icon. Please note that you should wrap the icon in a div or similar element in order to
adjust its size.

```html
<div style="height: 10em;">{% fa regular flag %}</div>
```
