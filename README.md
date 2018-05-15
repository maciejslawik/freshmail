[![Build Status](https://scrutinizer-ci.com/g/maciejslawik/freshmail/badges/build.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/freshmail/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maciejslawik/freshmail/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/freshmail/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/maciejslawik/freshmail/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/freshmail/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/mslwk/freshmail/v/stable)](https://packagist.org/packages/mslwk/freshmail)
[![License](https://poser.pugx.org/mslwk/freshmail/license)](https://packagist.org/packages/mslwk/freshmail)

# FreshMail REST API client library #

The library was designed to provide simple interface for using FreshMail API.
It is a standalone and requires no outside libraries to work.


#### Usage ####
A simple interface is provided to communicate with the API. To call the Ping service:

Use the library:   

![Alt text](docs/use_library.png?raw=true "Use the library")

Call the API:   

![Alt text](docs/ping_example.png?raw=true "Call the API")

#### Installation ####

Use composer to include the library in your project.

```
composer require mslwk/freshmail
```

#### Features ####
The library provides methods of communicating with the API to:
* Test connection 
* Send transactional emails
* Send SMS messages
* Create a new campaign
* Edit, delete, test and send an existing campaign
* Create, delete, get data about and edit a subscriber
* Create, delete and edit a subscription list
* Get subscription lists
* Register a new account
* Spam-test an email