# Dispute Suite Plugin for Wordpress
I've created this plugin for a customer who required a sign up procedure for their website's visitors and an integration with Dispute Suite, a CRM for U.S. credit repair businesses. It's still WIP, as this is a reinterpreted version meant to be a bit more generic than the solution made for this particular client.

This plugin for Wordpress lets you create an automatic sign up procedure for your website's visitors.

Visitors will be required to enter their personal details, accept an Electronic Agreement, and authorize their credit card through an integration with Authorize.net. At the end of the process, your visitors will be customers in your Dispute Suite CRM. They will also find their U.S. electronic agreement in PDF format in their personal portal in Dispute Suite, along with their payment method which was pre-authorized during the sign up process and will be charged automatically after X days.

# Running locally
Clone this repository, then:

* `$ composer install`
* `$ npm install`
* `$ grunt dev|production`

And activate the plugin in Wordpress. Default content will be created automatically (e.g. example services to purchase, signup steps with basic information, ...).

# Links
* [Dispute Suite - http://www.disputesuite.com/](http://www.disputesuite.com/)
* [Authorize.net - http://www.authorize.net/](http://www.authorize.net/)

# Copyright
Copyright (c) 2016 Giacomo Persichini