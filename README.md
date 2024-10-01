[![Verbs](art/verbs-animated.gif)](https://verbs.thunk.dev/)

# Verbs

Verbs is an event sourcing package for PHP artisans. It aims to take all the good
things about event sourcing, and remove as much of the boilerplate and jargon as
possible. Think in Verbs… not nouns.

[Read the Docs](https://verbs.thunk.dev/)

# Verbs History

Verbs History is a package to be used with Verbs for easily displaying a history of events that have taken place.

## Installation

Ensure you already have Verbs installed as per [the docs](https://verbs.thunk.dev/docs/getting-started/quickstart).

Install Verbs History using composer:

```bash
composer require hirethunk/verbs-history
```

## Usage

Verbs History has three main components:
- States - what the history gets applied to
- Events - exposes history for the states
- Feeds - how history gets displayed to users

### States

To add history to any of your states, you need to use the `Thunk\VerbsHistory\States\Traits\HasHistory` on your state.

```php
namespace App\States;

use Thunk\Verbs\State;
use Thunk\VerbsHistory\States\Traits\HasHistory;

class ExampleState extends State
{
    use HasHistory;

    // It ain't my birthday but I got my name on the cake - Lil Wayne
}
```

### Events

Any Event which should add it's history to the States, needs to implement the `Thunk\VerbsHistory\States\Interfaces\ExposesHistory` interface.

```php
namespace App\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsHistory\States\Interfaces\ExposesHistory;

class ExampleEvent extends Event implements ExposesHistory
{
    public function handle()
    {
        // The best things in life are free, not cheap. - Lil Wayne
    }
}
```

To ensure the Event adheres to the `ExposesHistory` interface, we need to add an `asHistory()` method with the correct return types `array|string|HistoryComponentDto`.

```php
namespace App\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;
use Thunk\VerbsHistory\States\Interfaces\ExposesHistory;

class ExampleEvent extends Event implements
{
    public function handle()
    {
        // The best things in life are free, not cheap. - Lil Wayne
    }

    public function asHistory(): array|string|HistoryComponentDto
    {
        // Return history data here
    }
}
```

The `asHistory()` method can return history data in a few different works.

**string**

In it's most basic form, we can just return a string form the `asHistory()` method, which will be what is displayed in the [history feed](#feeds).

```php
public function asHistory(): array|string|HistoryComponentDto
{
    return 'My ExampleEvent was fired!';
}
```

**array**

Verbs History also supports having multiple named feeds.

For example you may want basic history data for an event displayed to all users, but you want more detailed information to be shown for admins.

To achieve this we can return an associative array from the `asHistory()` method, with the keys being the names of the different feeds you want to support.

```php
public function asHistory(): array|string|HistoryComponentDto
{
    return [
        'users' => 'My ExampleEvent was fired!',
        'admin' => 'My ExampleEvent was fired with more information for admins!'
    ];
}
```

**HistoryComponentDto**

Verbs History has default styling for the history feed (see [history feed](#feeds)), but sometime you want a custom blade component to display your history data for an event.

To achieve this we can return a `HistoryComponentDto` which defines the component name and props that it needs.

```php
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;

public function asHistory(): array|string|HistoryComponentDto
{
    return new HistoryComponentDto(
        component: 'my-custom-component',
        props: [
            'someProp' => 'prop data',
        ],
    )
}
```

The above will render a `<x-my-custom-component />` and pass in a prop called `someProp` with the data `prop data`.

The `HistoryComponentDto` can also be used with multiple feeds, by returning an associative array from the `asHistory()` method with the values being `HistoryComponentDto` objects.

This allows us to completely customise the look of each history item depending on which feed it should go to.

```php
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;

public function asHistory(): array|string|HistoryComponentDto
{
    return [
        'users' => new HistoryComponentDto(
                component: 'my-custom-component',
                props: [
                    'someProp' => 'prop data',
                ],
            ),
        'admin' => new HistoryComponentDto(
                component: 'my-custom-admin-component',
                props: [
                    'someProp' => 'prop data for admins',
                ],
            ),
    ];
}
```

For `users` the above will render a `<x-my-custom-component />` and pass in a prop called `someProp` with the data `prop data`.

But for `admin` it will render a `<x-my-custom-admin-component />` and pass in a prop called `someProp` with the data `prop data for admins`.

### Feeds

A feed is how the history of events get displayed to a user.

**Feed component**

Verbs History has a `feed` blade component that is already styled ready for you to use it in your app.

To use it, you need add the `feed` blade component to your view and pass a state, which uses `HasHistory` trait, into the `state` prop.

```blade
@php
$exampleState = ExampleState::load($example_state_id);
@endphp

<x-verbs::feed :state="$exampleState" />
```

If you have multiple feeds and want to display a specific feed in a particular view, you can also pass the name of the feed into the `subHistory` prop.

```blade
<x-verbs::feed :state="$exampleState" subHistory="admin" />
```

The above will render the `admin` history feed.

**Custom feed**

You can always create your own custom feed component instead of using the supplied `feed` component.

To do this, you can get the history of events from a state, which uses `HasHistory` trait, by calling `getHistory()` on the state and looping through the results.

```blade
@php
$exampleState = ExampleState::load($example_state_id);
@endphp

@foreach ($state->getHistory() as $history_item)
    {{-- Add custom display here --}}
@endforeach
```

If you have multiple feeds and want to get the history of events for a specific feed, you can also pass the name of the feed into the `getHistory()` method.

```blade
@foreach ($state->getHistory('admin') as $history_item)
    {{-- Add custom admin display here --}}
@endforeach
```
