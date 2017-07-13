## FreshMail REST API client library

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

#### Functions ####
The library provides methods of communicating with the API to:
* Test connection 
* Send transactional emails
* Send SMS messages
* Create a new campaign
* Edit, delete, test and send an existing campaign
* Create, delete, get data about and edit a subscriber
* Register a new account
* Spam-test an email