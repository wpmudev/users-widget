# Users Widget

**INACTIVE NOTICE: This plugin is unsupported by WPMUDEV, we've published it here for those technical types who might want to fork and maintain it for their needs.**

## Users Widget displays a simple list, or a mosaic list, of random users complete with avatars in any widget area.

### Simple and Effective

Activate and a new 'Users' widget will automatically be added to your 'Available Widgets'. From drag-and-drop setup to simple configuration, each element was designed to act and feel native to WordPress core.

### Configure to Fit Any Sidebar

Users Widget is easy to setup and can be configured to fit any widget area available on your network. Extends Multisite, engage users and strength community participation across your Multisite network with Users Widget.

### To Get Started

Start by reading [Installing plugins](https://premium.wpmudev.org/project/wpmu-manual/installing-regular-plugins-on-wpmu/) section in our comprehensive [WordPress and WordPress Multisite Manual](https://premium.wpmudev.org/manuals/) if you are new to WordPress.

Once installed go to **Plugins** in the network admin dashboard and Network Activate the Users Widget plugin.

### To Use:

Once activated, just go to _Appearance > Widgets_ in the admin area of your main site, where you'll now see the Users Widget.  Simply drag the widget to an available sidebar and you'll be presented with several settings.  You can optionally enter a _Title_ for the widget. Select a _Display_ option from the following:

*   Avatar + Display Name
*   Avatar Only
*   Display Name Only

Specify a limit for the _Display Name Characters_, this will display only the specified number of characters for the name. Select an _Order_ option from either of the following:

*   Most Recent
*   Random

Specify the number of users to display in the widget using the _Number_ option. Select a size for the avatars using the _Avatar Size_ selector, you'll see the following options:

*   16px
*   32px
*   48px
*   96px
*   128px

Press the _Save_ button to save your changes. When you view your main site you will now see the widget displayed in your sidebar. Here's an example of how it could look using Twenty Twelve theme.

### Enabling Users Widget for all sites

By default the Users widget is only enabled for use on the main site. Here's how you can enable it for all sites on your network:

1\. Locate the following file within the plugin folder (/wp-content/plugins/users-widget/):

<pre>widget-users.php</pre>

2\. Locate the following line in that file:

<pre>$users_widget_main_blog_only = 'yes';</pre>

3\. Change the 'yes' to 'no'. Here's how the code will look when edited: Save your amended _widget-users.php_ and use this file when you upload the _users-widget_ folderto _/wp-content/plugins/_. It's also possible to edit the plugin code directly in your Network Admin area at _Plugins > Editor_, where you can select Users Widget from the _Select plugin to edit_ drop-down selector.
