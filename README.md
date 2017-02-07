#Depot - PHP Command Bus

##Install

`composer require vherus/depot`

##Usage

Out of the box, there are two ways to use Depot. You can either explicitly provide a map of commands `=>` handlers,
or (my favourite) you can use the `NativeNamespaceResolver` to automatically resolve your handlers.

First, we'll look at the automatic resolver.

```php
$bus = new Depot\Bus\NativeCommandBus(new Depot\Resolution\NativeNamespaceResolver);
$bus->dispatch(new My\Command);
```

The `NativeNamespaceResolver` will look in the commands current directory and a subdirectory of `Handler` and `Handlers` to try and resolve
the correct handler for the given command. If it's unable to resolve it, it'll throw a `Depot\Exception\UnresolvableHandlerException`.

So all you need to do is create your command:

```php
namespace My;
    
class Command implements Depot\Command { }
```

And a handler with the same name, suffixed with 'Handler', in either the current namespace or a sub-namespace named 'Handler' or 'Handlers'.

```php
namespace My\Handler;
    
class CommandHandler
{
    public function handle(My\Command $command) { }
}
```

Alternatively, you can use the map resolver to be more explicit about your handler resolutions.

```php
$bus = new NativeCommandBus(new NativeMapResolver([
    My\Command::class => My\Command\Handler\CommandHandler::class
]));
$bus->dispatch(new My\Command);
```

##Decoration

`Depot` does not come with any "decorators" out of the box; at least, not yet. However, since Depot is rather simple, it's very easy to decorate.
You could, for example, create your own implementation of the Depot `CommandBus` interface and pass the provided `NativeCommandBus` into it.

For example:

```php
class QueuedCommand extends Depot\Command {}

class QueuedCommandBus implements Depot\CommandBus
{
    private $innerBus;
    private $queue;

    public function __construct(Depot\CommandBus $innerBus, SomeQueueLibrary $queue)
    {
        $this->innerBus = $innerBus;
        $this->queue = $queue;
    }

    public function dispatch(Command $command)
    {
        if ($command instanceof QueuedCommand) {
            $this->queue->queue($command);
            return;
        }

        $this->innerBus->dispatch($command);
    }
}
```

##Framework Specifics

###Laravel

I'm not in the habit of creating "ServiceProviders" and "Laravel Bridges" - I feel it's important that you be able to
decide exactly how to use any given package. However, I have included an adapter for the Laravel IoC container.

To set up Depot with Laravel, you could simply add something like the below to your `AppServiceProvider`:

```php
$this->app->bind(Depot\Container::class, Depot\Container\Laravel\IlluminateContainer::class);
$this->app->bind(Depot\HandlerResolver::class, Depot\Resolution\NativeNamespaceResolver::class);
$this->app->bind(Depot\CommandBus::class, Depot\Bus\NativeCommandBus::class);
```

This will allow you to go ahead an inject `Depot\CommandBus` as a dependency into your classes as normal.

Note: I have no intention of providing a "facade".