# UmanIT - Trace User Actions

This bundle allows you to trace your user actions in a log file. By default, login and logout are trace, but you can
easily add your own actions through the dispatch of en event.

For example, login and logout will be logged as follows:

```
[2022-07-13T09:19:23.886319+02:00] umanit_trace_user_actions.INFO: User login {"user":"vdebona@umanit.fr"} []
[2022-07-13T09:19:41.715806+02:00] umanit_trace_user_actions.INFO: User logout {"user":"vdebona@umanit.fr"} []
```

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the extension.

```bash
composer require umanit/trace-user-actions
```

Load the bundle into your Symfony project.

```php
<?php

# config/bundles.php
return [
    // ...
    Umanit\TraceUserActions\UmanitTraceUserActionsBundle::class => ['all' => true],
];
```

## Usage

All actions will be logged into rotating files (one per day). The filename mask is
`umanit-trace-user-actions-%kernel.environment%-YYYY-MM-DD.log`.

If you want to log your own actions, you have to dispatch a new `UserActionEvent`, for example:

```php
function deleteProductAction(Product $product, EventDispatcherInterface $eventDispatcher): Response
{
    // [...]
    $eventDispatcher->dispatch(new UserActionEvent(sprintf('Delete product "%s"', $product->getName()), $this->getUser()));
    // [...]
}
```

This action will be logged as follows:

```
[2022-07-13T10:15:27.962118+02:00] umanit_trace_user_actions.INFO: Delete product "Example product" {"user":"vdebona@umanit.fr"} []
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
