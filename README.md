<p align="center">
<a href="https://wordpress.org/plugins/page-restrict-for-woocommerce">
  
![Page Restrict for WooCommerce](https://user-images.githubusercontent.com/25887644/78312806-3e882080-7555-11ea-8689-e30501aa59fb.png)

</a>
</p>
Restrict access to your WordPress pages using WooCommerce products.

# Description
Page Restrict for WooCommerce is a plugin that sells access to pages, posts and custom post types through WooCommerce. It's been built with Gutenberg in mind as well as the classic editor. You can restrict pages in two ways. Restrict an entire page or restrict sections on the page. In case you want to restrict sections on the page you can use blocks for the Gutenberg editor and using shortcodes for the classic or similar editors. If you want to restrict entire pages you can use enable the sidebar in the More tools & options in the Gutenberg editor or use the page metabox in the classic editor. You can also restrict all of your pages in one place in the Pages plugin menu.

# Requirements
* WooCommerce to be installed and active
* Guest checkout needs to be disabled
* PHP 7.0.25+.

## Features
* Restrict content from pages, posts and custom post types based on if they have purchased a specific WooCommerce product
* Restrict entire page or just sections of it
* Use one or multiple products to restrict it
* Restrict by time - Set a time limit for the user after which they won't be able to see the content.
* Restrict by views - Set a view count for the user after which they won't be able to see the content ( currently only if you want to restrict entire pages ).
* Use other pages or posts for specific pages as Restricted Messages
* Use default pages or posts for all restricted pages as Restricted Messages
* Redirect to the chosen page instead of just showing the other pages content
* Built for use with the latest Gutenberg editor as well as the classic one
* Use either Gutenberg blocks or shortcodes to restrict sections on a page or post
* Plugin menu page to handle all pages you need to restrict in one place called Pages
* A Quick Start menu page to get you started on using this plugin

## Blocks
__page-restrict-wc/restrict-section__
Page Restrict for WooCommerce - Restricts a section on the page using this grouping element.

## Shortcodes
`[prwc_is_purchased products='1,2' days='25' hours='2' minutes='45' seconds='15 inverse='false']`

* This restricts the content using the chosen options. 
* Using the inverse option you can choose inverse='false' to hide the content in order for the user to not see it. Choose inverse='true' for the user to see it in order to show them instructions on what to do to access the desired content you chose using inverse='false'.
* Timeout options for this are days, hours, minutes, seconds.

# Coming soon
* Restrict categories
* Restrict authors
