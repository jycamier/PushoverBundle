# PushoverBundle

Provide some tools to use [Pushover](https://pushover.net/) in a symfony 2 project.


## What's Pushover ? ##

Pushover is a simple notification provider for Android, iPhone, iPad, and Desktop.

[Further information](https://pushover.net/).

## Installation ##

- Create an account on [Pushover](https://pushover.net/).
- On the  Pushover website, create an application to get a specific API key for the application
- Download the mobile app and synchronize it with your account
- Then add this bundle in your composer.json

```
$ composer require eheuje/pushover-bundle:last
```
- Enable the bundle in your appKernel.php
- Configure the following parameters in your config.yml with your own values (**user_key**, **api_key** and **user_email** are provided by Pushover once you've create your account and the specific application)
```
eheuje_pushover:
    application:
        user_key: <your_user_key>
        api_key: <your_api_key>
        user_email: <your_user_email>
```

## Services ##

To get the service from a controller that says "Hello World" :

```php
$this->get('eheuje_pushover.pusher')
     ->setMessage("Hello World")
     ->push();
```

### Additional information ###

It's possible to add extra information in your notifications :
- the duration of a task
- the memomy used by the task

```
eheuje_pushover:
    additional_information:
        duration: ~ # true or false
        memory: ~ # true or false
```
However, this feature is not automatic. It works with the StopWatch Component.

[Further information about StopWatch](http://symfony.com/doc/current/components/stopwatch.html)

```php
use Symfony\Component\Stopwatch\Stopwatch;

$stopwatch = new Stopwatch();
$stopwatch->start('eventName');
// ... some code goes here
$event = $stopwatch->stop('eventName');

$this->get('eheuje_pushover.pusher')
     ->setMessage("Hello World")
     ->setStopwatchEvent($event)
     ->push();
```

## PushoverCommand ##

[Further information about the Console Component](http://symfony.com/doc/current/components/console/introduction.html)

When you create huge commands, it takes a lot of time to execute them. If you don't want to wait behind your computer for the commands to terminate, you can create your command as an inheritance of **PushoverCommand**.

```php
use Eheuje\PushoverBundle\Command\PushoverCommand;
use Symfony\Component\Console\Command\Command;

class GreetCommand extends PushoverCommand
{
// ... some code goes here
}
```
Then, call the command with the option **--with-pushover**.
```
$ php app/console foo:bar "Hello World" --with-pushover
```

When the command is terminated, you'll be notified if :
- the command is terminated with a with a awaiting exit code ;
- the command is terminated with an Exception.

## Todolist ##

- Do something with the pushover email function
- Do some tests
- Clean the bundle