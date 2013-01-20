# Service APIs for Kohana

The following services are supported:

- twitter
- blogger
- tumblr
- *Want to add one? Fork and send a pull request!*

To enable an individual API, add it to your `Kohana::modules` call:

    Kohana::modules(array(
        'twitter' => MODPATH.'apis/twitter',
        'blogger' => MODPATH.'apis/blogger',
        'tumblr' => MODPATH.'apis/tumblr',
    ));

Some services also have live demos and debuggers. To use them, check out the `demos` branch:

    > git checkout demos

Enable the `demo` API module:

    Kohana::modules(array(
        'api/demos' => MODPATH.'apis/demo',
        'twitter'   => MODPATH.'apis/twitter',
        // ...
    ));

Now the Twitter demo should be available at `http://example.com/twitter_demo`, if the base URL to your Kohana installation is `http://example.com/`.
