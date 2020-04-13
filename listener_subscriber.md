Doctrine events: listeners and subscribers. Both are very similar, but listeners are a bit more straightforward

### Lazy loading for Event Listeners¶
One subtle difference between listeners and subscribers is that Symfony can load entity listeners lazily. This means that your listener class will only be fetched from the service container (and thus be instantiated) once the event it is linked to actually fires.
Lazy loading might give you a slight performance improvement when your listener runs for events that rarely fire. Also, it can help you when you run into circular dependency issues that may occur when your listener service in turn depends on the DBAL connection.

### Priorities for Event Listeners¶
In case you have multiple listeners for the same event you can control the order in which they are invoked using the priority attribute on the tag. Priorities are defined with positive or negative integers (they default to 0). Higher numbers mean that listeners are invoked earlier.


Lifecycle callbacks
Event listener/subscribers
Entity listener
