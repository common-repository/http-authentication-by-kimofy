=== HTTP Authentication By KIMoFy ===
Contributors: kimofy
Tags: auth, http auth, authentication, http authentication, restrict pages, restrict site, login, admin, crawler, crawl, locked, .htaccess password, .htpasswd, .htaccess authentication, kimofy, kimofy youtube, kimofy.com
Donate link: https://paypal.com/KIMoFy
Requires at least: 3.5
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

HTTP Authentication lets you make a site without letting anyone view it without valid credentials. This can protect the full site or only admin pages.

== Description ==
The HTTP Authentication plugin allows you to use existing means of authenticating people to WordPress. This includes Apache's basic HTTP authentication module, which most servers use.

This plugin works the same way web servers would handle password protection, but in this case, WordPress handles everything.

Ordered list:

1. **Password protect a website currently in development.**
2. **Secure all admin pages.**
3. **Deny access to unauthorized visitors.**

== Installation ==
1. Upload "http-authentication-by-kimofy.php" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Edit Plugin settings from the "HTTP Auth Settings" menu in your WordPress dashboard.

== Frequently Asked Questions ==
= Does this work on multi-site installations of WordPress? =
Yes, this plugin is compatible with all WordPress installations above WordPress 3.5

= What happens if I forget my password? =
If you forget your password, I will not be able to help you recover it. Please choose your password carefully.

= How does this plugin work? =
This plugin uses the same method any web server's configuration file would use to protect a website. All passwords are encrypted on your web server.

== Screenshots ==
1. Activating The Plugin.
2. Password Request.
3. Unauthorized (401) Error Page.

== Changelog ==
= 5.1 =
Added support for WordPress version 4.8.

= 5.0 =
Added a more user friendly Unauthorized (401) Error page to better fit all themes. All known bugs are patched.

= 4.0 =
Minor security flaw detected and fixed. Update recommended.

= 3.0 =
Fixed a security issue allowing users tto bypass the password screen. Update immediately.

= 2.0 =
Added a more User Friendly experience.

= 1.0 =
This is the initial release of the plugin. There may be bugs or glitches with this release.

== Upgrade Notice ==
Please update this plugin as often as possible. Since this plugin enables a password on your site, a security flaw would be a major concern. Stay on top of that by keeping the latest version installed!