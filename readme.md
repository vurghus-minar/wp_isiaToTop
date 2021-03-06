# isiaToTop 

[![Build Status](https://travis-ci.org/vurghus-minar/wp_isiaToTop.svg?branch=master)](https://travis-ci.org/vurghus-minar/wp_isiaToTop)

A versatile and mobile friendly 'scroll to top' plugin based on isiaToTop.


## Description 

isiaToTop plugin is based on the isiaToTop js plugin available at:
[https://github.com/vurghus-minar/isiaToTop](https://github.com/vurghus-minar/isiaToTop)

You can check out the Codepen demo here:
[https://codepen.io/vurghusm/pen/NZqGxb](https://codepen.io/vurghusm/pen/NZqGxb)

It is mobile friendly and fully customizable.

Contribution, feedback, issue reporting, and comments are welcomed via the github.


## Installation 

1. Install and activate via Plugin manager.
   Alternatively, download, unzip and upload `isiatotop` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


## Overriding defaults css and js 

1. To override the `css` and `js` files, create a `config-isiatotop` folder in your theme or child theme.
2. Copy the `css` and `js` folders located in the `isiatotop/assets/public` directory to the `config-isiatotop` and override files there.
   
   The directory structure should look like this.
   --themes
   ---->your_theme or child_theme
   ------>config-isiatotop
   -------->css
   ---------->custom.css
   -------->js
   ---------->init.js