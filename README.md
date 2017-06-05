#Solution

## Markup

![markup](markup.jpg)

## Running Simulation

### Technical requirements
* CLI php 7.0 
* composer
* xdebug
* php-mbstring

### Installation

```sh 
git clone $url $your_folder
``` 
```sh 
cd $your_folder
```
```sh 
git checkout develop
```
```sh 
composer install
```

### Basic Usage
* Run Listener to proceed queue
```sh 
php listener.php
```
* In separate terminal run publisher to send messages to Queue, argument - amount of message
```sh
php publisher.php 20
```
* Check detail logs by consumers
```sh
tail -f var/consumer.log 
```
* You can run publisher anytime, listener will pick up new messages for execution by LoadBalancer

### Automated tests
* run via
```sh
/vendor/bin/phpunit
```
* check report in tests/reports/coverage/index.html