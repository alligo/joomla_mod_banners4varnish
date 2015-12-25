# Banners for Joomla CMS sites that bypass with full page cache, like Varnish
Version 1.0.0beta - Do not use in production yet

Free Joomla CMS Module extension, similar to native mod_banners, but load async to bypass Varnish Cache. Also add Google Analytics Event Tracking.

**Ideal for high traffic sites that full page cache is really need, but still need rotate banners.**

Other links to see
- [Joomla CMS system plugin for Joomla + Varnish](https://github.com/alligo/plg_system_alligovarnish)
- [Joomla CMS content plugin for Google Analytics Event Tracking to show Article visualizations](https://github.com/alligo/plg_content_google-analytics-event-tracking)
- [Google Analytics Event Tracking - Alligo Helper, JS library](https://github.com/alligo/google-analytics-event-tracking)

Follow [@fititnt](https://twitter.com/fititnt) on Twitter or
[@fititnt](https://github.com/fititnt) on Github for updates

## How to enable rotate banners, show impressions and clicks, even with full page cache
In this case on module options, go to Advanced tab, and change "Alternative Layout" from "default" to Ajax.

For now, you still need allow exception on your full page cache `GET /component/banners/click/*`. If this
still a problem for you, open a Issue and we improve this module.

<img src="https://raw.githubusercontent.com/alligo/mod_banners4varnish/master/documentation/banners4varnish-ajax-parameter.png" alt="AJAX parameters"/>

## How to enable Google Analytics Tracking Events
Even if you do not need bypass full page cache, and using Joomla with cache disabled, you can still
use this module as one simple improved version of native Joomla mod_banners to track impressions
and banners clicks with your Google Analytics account.

<img src="https://raw.githubusercontent.com/alligo/mod_banners4varnish/master/documentation/gaet-parameters.png" alt="AJAX parameters"/>

Also, see (Google Analytics Event Tracking)[https://developers.google.com/analytics/devguides/collection/analyticsjs/events] and adicional
information about [Google Analytics Event Tracking - Alligo Helper, JS library](https://github.com/alligo/google-analytics-event-tracking)

### Requirements for Tracking
- **Requires Google analytics.js (ga). Old one (_gaq) will NOT work**
- (**Only for debug**) install Google Analytics Debugger