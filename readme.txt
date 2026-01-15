=== Minimum order for WooCommerce ===
Contributors: marketingparadise
Tags: woocommerce, minimum order, cart, checkout, e-commerce
Requires at least: 5.8
Tested up to: 6.9
Stable tag: 1.0.6.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Set a minimum order amount in your WooCommerce store to be able to check out. Simple, lightweight, and effective.

== Description ==

Do you want to ensure your customers reach a minimum amount before completing an order? **Minimum order for WooCommerce** is the ideal tool for you.

This plugin allows you to set a minimum value that the cart subtotal must reach for the customer to proceed to checkout. If this requirement is not met, a clear notice will be displayed on the cart page, and the checkout process will be prevented.

**Main Features:**

* **Simple Configuration:** Adds three single options to define the minimum amount.
* **Clear Notices:** Messages on the cart and checkout pages to inform the user when they have not reached the minimum.
* **Full Compatibility:** Native integration with WooCommerce and compatible with most themes.
* **Optimal Performance:** Clean, lightweight code that aligns with WordPress development best practices.

== Installation ==

**Automatic Installation (Recommended):**

1.  From your WordPress dashboard, navigate to `Plugins > Add New`.
2.  Search for "minimum order".
3.  Click "Install Now" and then "Activate".
4.  Go to `WooCommerce > Minimum order` to set the minimum amount in the corresponding section.

**Manual Installation:**

1.  Download the plugin's `.zip` file from the WordPress.org repository.
2.  Unzip the file. You will upload the `pedido-minimo-for-woocommerce` folder to the `/wp-content/plugins/` directory of your WordPress installation.
3.  Activate the plugin from the `Plugins` menu in your dashboard.
4.  Configure the amount in `WooCommerce > Minimum Order`.

== Frequently Asked Questions ==

= Does the minimum amount include shipping costs? =

No, the plugin validates the amount against the **cart subtotal**. You have the option to do this before or after applying a coupon discount.

= Can I customize the message shown to the user? =

Yes, the plugin has a field to customize the message.

= Is it compatible with my theme? =

The plugin uses standard WooCommerce hooks to display notices, so it should be compatible with any theme that follows WooCommerce standards.

= Does it affect my site's performance? =

No. The plugin is extremely lightweight, and its code only runs on the cart and checkout pages, so the impact on performance is negligible.

== Screenshots ==

1.  The settings page where the minimum amount is configured.
2.  Notice on the cart page when the minimum is not met.
3.  Notice on the checkout page if the minimum is not met.

== Changelog ==

= 1.0.6.1 - 2026-01-15 =
* Fix: Corrected blueprint for repository live preview.

= 1.0.6 - 2026-01-15 =
* Fix: Corrected some texts.

= 1.0.5 - 2025-12-05 =
* New: Added option to customize the message shown to the user.

= 1.0.4 - 2025-10-07 =
* New: Added option to take coupon discounts into account.
* Fix: Corrected the English texts.

= 1.0.3 - 2025-09-15 =
* Tweak: Minor changes to class and function names.

= 1.0.2 - 2025-09-09 =
* Tweak: Rename and change the description of the plugin.

= 1.0.1 - 2025-09-03 =
* Fix: Corrected internationalization strings.
* Fix: Corrected escaping for some variables.

= 1.0.0 - 2025-09-01 =
* Initial release of the plugin.
* Basic functionality to set a minimum amount in the cart.
* Visible notice on the cart page when the minimum amount is not reached.