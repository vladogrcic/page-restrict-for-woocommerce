=== Page Restrict for WooCommerce ===
Contributors: vladogrcic
Tags: restrict, pages, woocommerce, pay, product, sell pages, sell posts
Author URI: https://vladogrcic.com
Author: Vlado Grčić
Requires at least: 4.8.12
Tested up to: 6.2
Requires PHP: 7.0.25
Stable tag: trunk
Version: 1.6.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Restrict access to your WordPress pages using WooCommerce products. 

== Description ==
Page Restrict for WooCommerce is a plugin that sells access to pages, posts and custom post types through WooCommerce. It's been built with Gutenberg in mind as well as the classic editor. You can restrict pages in two ways. Restrict an entire page or restrict sections on the page. In case you want to restrict sections on the page you can use blocks for the Gutenberg editor and using shortcodes for the classic or similar editors. If you want to restrict entire pages you can use enable the sidebar in the More tools & options in the Gutenberg editor or use the page metabox in the classic editor. You can also restrict all of your pages in one place in the Pages plugin menu. 

= Requirements =

* WooCommerce to be installed and active
* Guest checkout needs to be disabled
* PHP 7.0.25+. 

= Features =

* Restrict content from pages, posts and custom post types based on if they have purchased a specific WooCommerce product
* Restrict entire page or just sections of it
* Use one or multiple products to restrict it and choose whether you want to require the user to buy all of them to access or at least one of the products that restrict. 
* Restrict by time - Set a time limit for the user after which they won't be able to see the content.
* Restrict by views - Set a view count for the user after which they won't be able to see the content ( currently only if you want to restrict entire pages ).
* Use other pages or posts for specific pages as Restricted Messages
* Use default pages or posts for all restricted pages as Restricted Messages
* Redirect to the chosen page instead of just showing the other pages content
* Built for use with the latest Gutenberg editor as well as the classic one
* Use either Gutenberg blocks or shortcodes to restrict sections on a page or post
* Plugin menu page to handle all pages you need to restrict in one place called Pages
* Plugin menu page to get an overview of all users that bought a product required to access an restricted page which either is still valid or already expired called User Overview.
* Similar feature to User Overview for the frontend for each user to have an overview of their pages where they bought products in order to access them.
* A Quick Start menu page to get you started on using this plugin

= Blocks =

__page-restrict-wc/restrict-section__
Section Restrict for WooCommerce - Restricts a section on the page using this grouping element.

__page-restrict-wc/restricted-pages-list__
Restricted Pages List - Shows a table of restricted pages for the current user which have had bought products for.

= Shortcodes =

[prwc_is_purchased products="1,2" days="25" hours="2" minutes="45" seconds="15" inverse="false" defRestrictMessage="Restrict Message" notAllProductsRequired="false" defaultPageNotBoughtSections="4" defaultPageNotLoggedSections="5"]

* Restricts the content using the chosen options. 
* products - choose which products to restrict with. Add product IDs separated by a comma.
* Timeout options for this are days, hours, minutes, seconds.
* inverse - using the inverse option you can choose inverse="false" to hide the content in order for the user to not see it. Choose inverse="true" for the user to see it in order to show them instructions on what to do to access the desired content you chose using inverse="false"
* defRestrictMessage - is the message you want to show if the user didn't buy the product.
* notAllProductsRequired - set to true if the user doesn't need to buy all products.
* defaultPageNotBoughtSections - you can choose a page to show instead of a message like in defRestrictMessage.
* defaultPageNotLoggedSections - you can choose a page to show if the user isn't logged in.

[prwc_restricted_pages_list table="time" disable_table_class="false"]

* Shows a table of restricted pages for the current user which have had bought products for.
* Using the table attribute you can choose which table of restricted page you will show. It can show pages that are restricted either by time or view count.
* Using disable_table_class attribute you can choose whether to kepp or not to keep the default plugin style for the tables.
* You can show restricted pages that timeout either by time or view. 

= Coming soon =

* Restrict categories
* Restrict authors

== Screenshots ==

1. Plugin pages menu page
1. Plugin user overview menu page
1. My account user overview page
1. Plugin quick start menu page
1. Gutenberg sidebar - Products - Restrict with
1. Gutenberg sidebar - Page to Show - Restrict message pages
1. Gutenberg sidebar - Timeout - Time until restriction expires
1. Gutenberg block
1. Gutenberg block - General block settings
1. Gutenberg block - Products - Restrict with
1. Gutenberg block - Timeout - Time until restriction expires
1. Classic metabox
1. Plugin settings

== Installation ==

1. Upload the plugin files to the "/wp-content/plugins/page-restrict-for-woocommerce" directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the "Plugins" screen in WordPress
1. Use the Settings --> Page Restrict screen to configure the plugin
1. You can go to Settings --> Page Restrict --> Quick Start to get a head start on how to use this plugin

== Frequently Asked Questions ==
= Do you have a premium version of the plugin? =
No, there isn't any. 

== Changelog ==

= 1.6.5 =

* Fixed count error for view restriction.

= 1.6.4 =

* Fixed some warnings.

= 1.6.3 =

* Added notice for custom post types where the feature "Custom Fields" is missing.

= 1.6.2 =

* Fixed "PHP Fatal error:  Uncaught TypeError: in_array(): Argument #2 ($haystack) must be of type array..." error.

= 1.6.1 =

* Fixed undefined array key 0 that happened.

= 1.6.0 =

* Added prwc_restricted_pages_products shortcode.
* Minor fixes

= 1.4.13 =

* Fixed "Lock by Products" not able to accept more than 1 product on "Pages" page.

= 1.4.12 =

* Fixed Time Table not showing pages with bought products with no expiration.

= 1.4.11 =

* Fixed issue with $all_pages.

= 1.4.10 =

* Fixed issue with not bought and not logged in restrict message options not showing any pages on the classic editor.
* Added further warnings for redirecting to private pages.
* Removed unused code (future feature).
* Refactored "Quick Start" page.

= 1.4.9 =

* Fixed issue where the list of pages isn't the same in the Pages page and the Settings page.

= 1.4.8 =

* Performance fixes. It should be considerably faster now.
* Fixed various PHP warnings.

= 1.4.7 =

* Fixed bool passed to count error.

= 1.4.6 =

* Fixed custom post types not showing in "User Overview" and "Page Restrict" page on My Account.

= 1.4.5 =

* Added features to view ant time table on My Account page.
* Fixed issue with loading a limited number of pages for views.
* Rephrased the "Not all products required" option description in the Quick Start page.
* Fixed shortcode issue on Quick Start page.
* Translation fixes.

= 1.4.4 =

* Fixed showing pages when product wasn't bought.
* Fixed "ModuleNotFoundError: Module not found: Error: Can't resolve 'react' in" which seems to happen in the admin/assets/src/scss/admin.scss file.
* Changed Quick Start text.

= 1.4.3 =

* Fixed translation issues.

= 1.4.2 =

* Fixed issue with User Overview page not showing pages restricted by products.

= 1.4.1 =

* Fixed problems with Views tab in User Overview that prevents from showing users that bought product unless they viewed the page at least once.
* Smaller design issues (horizontal bar in User Overview).
* My Account fixes.

= 1.4.0 =

* Design changes.
* Showing order, product ids on User Overview page.
* Refactored variables
* Fixed issues with my-account Page Restrict tab.
* Design changes to "User Overview" page.

= 1.3.5 =

* Fixed issue with "User Overview" not showing users correctly, restricting also didn't work.
* Some minor refactoring
* Design changes to "User Overview" page.
* Language files update.

= 1.3.4 =

* Fixed issue with reverse block where it doesn't show for guests.

= 1.3.3 =

* Fixed "My Account" pages restricted pages list page not showing active restricted pages at all.

= 1.3.2 =

* Fixed issue where the "User Overview" page would be empty if timeout would not be set. It should be able to show if you only need to show if product purchased.
* Fixed issue with incorrect expiration time.

= 1.3.1 =

* Updated Javascript dependencies.
* Removed unnecessary code.

= 1.3.0 =

* Updated the React JS code to be in JSX.
* Some smaller changes.

= 1.2.0 =

* Adding "Not all products required" feature.
* Fixed bugs
    * Fixed problems with existing products bought checking. It counted only the first full set of products if users needed to buy multiple products.
    * Incorrect order list.

= 1.1.1 =

* Fixed Quick Start text.
* Fixing bugs.
  * Fixed incorrect namespace used.
  * Fixed guest users executing table list code.
  * Fixed $_POST not having nonce.

= 1.1.0 =

* Admins now can see which users have bought products needed to access pages. It shows users who recently bought it and are valid as a blue color and the users who have expired pages have those in red.
* Regular users can see their bought (expired or still valid) pages for their account as well. They can see it in their WooCommerce My Account page, or on a separate page using a Gutenberg block or shortcode.
* Added animation for pagination.
* Fixed not removing everything on uninstall.
* Fixed adding data that is not needed.

= 1.0.0 =

* Initial commit. == Upgrade Notice ==

= 1.6.5 =

* Fixed count error for view restriction.

= 1.6.4 =

* Fixed some warnings.

= 1.6.3 =

* Added notice for custom post types where the feature "Custom Fields" is missing.

= 1.6.2 =

* Fixed "PHP Fatal error:  Uncaught TypeError: in_array(): Argument #2 ($haystack) must be of type array..." error.

= 1.6.1 =

* Fixed undefined array key 0 that happened.

= 1.6.0 =

* Added prwc_restricted_pages_products shortcode.
* Minor fixes

= 1.4.13 =

* Fixed "Lock by Products" not able to accept more than 1 product on "Pages" page.

= 1.4.12 =

* Fixed Time Table not showing pages with bought products with no expiration.

= 1.4.11 =

* Fixed issue with $all_pages.

= 1.4.10 =

* Fixed issue with not bought and not logged in restrict message options not showing any pages on the classic editor.
* Added further warnings for redirecting to private pages.
* Removed unused code (future feature).
* Refactored "Quick Start" page.

= 1.4.9 =

* Fixed issue where the list of pages isn't the same in the Pages page and the Settings page.

= 1.4.8 =

* Performance fixes. It should be considerably faster now.
* Fixed various PHP warnings.

= 1.4.7 =

* Fixed bool passed to count error.

= 1.4.6 =

* Fixed custom post types not showing in "User Overview" and "Page Restrict" page on My Account.

= 1.4.5 =

* Added features to view ant time table on My Account page.
* Fixed issue with loading a limited number of pages for views.
* Rephrased the "Not all products required" option description in the Quick Start page.
* Fixed shortcode issue on Quick Start page.
* Translation fixes.

= 1.4.4 =

* Fixed showing pages when product wasn't bought.
* Fixed "ModuleNotFoundError: Module not found: Error: Can't resolve 'react' in" which seems to happen in the admin/assets/src/scss/admin.scss file.
* Changed Quick Start text.

= 1.4.3 =

* Fixed translation issues.

= 1.4.2 =

* Fixed issue with User Overview page not showing pages restricted by products.

= 1.4.1 =

* Fixed problems with Views tab in User Overview that prevents from showing users that bought product unless they viewed the page at least once.
* Smaller design issues (horizontal bar in User Overview).
* My Account fixes.

= 1.4.0 =

* Design changes.
* Showing order, product ids on User Overview page.
* Refactored variables
* Fixed issues with my-account Page Restrict tab.
* Design changes to "User Overview" page.

= 1.3.5 =

* Fixed issue with "User Overview" not showing users correctly, restricting also didn't work.
* Some minor refactoring
* Design changes to "User Overview" page.
* Language files update.

= 1.3.4 =

* Fixed issue with reverse block where it doesn't show for guests.

= 1.3.3 =

* Fixed "My Account" pages restricted pages list page not showing active restricted pages at all.

= 1.3.2 =

* Fixed issue where the "User Overview" page would be empty if timeout would not be set. It should be able to show if you only need to show if product purchased.
* Fixed issue with incorrect expiration time.

= 1.3.1 =

* Updated Javascript dependencies.
* Removed unnecessary code.

= 1.3.0 =

* Updated the React JS code to be in JSX.
* Some smaller changes.

= 1.2.0 =

* Adding "Not all products required" feature.
* Fixed bugs
    * Fixed problems with existing products bought checking. It counted only the first full set of products if users needed to buy multiple products.
    * Incorrect order list.

= 1.1.1 =

* Fixed Quick Start text.
* Fixing bugs.
  * Fixed incorrect namespace used.
  * Fixed guest users executing table list code.
  * Fixed $_POST not having nonce.

= 1.1.0 =

* Admins now can see which users have bought products needed to access pages. It shows users who recently bought it and are valid as a blue color and the users who have expired pages have those in red.
* Regular users can see their bought (expired or still valid) pages for their account as well. They can see it in their WooCommerce My Account page, or on a separate page using a Gutenberg block or shortcode.
* Added animation for pagination.
* Fixed not removing everything on uninstall.
* Fixed adding data that is not needed.

= 1.0.0 =

* Initial commit. 
