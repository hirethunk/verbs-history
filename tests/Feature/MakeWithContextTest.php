<?php

use Composer\EventDispatcher\Event;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\State;
use Thunk\VerbsCommands\Concerns\AttributeInputs;
use Thunk\VerbsCommands\Contracts\Action;

it('can make an event from a combination of context and states', function () {
    //
});

class SomeState extends State
{
}

class SomeEvent extends Event implements Action
{
    use AttributeInputs;

    #[StateId(SomeState::class)]
    public int $some_state_id;

    public static function actionName(): string
    {
        return 'Some Action';
    }

    public static function actionDescription(): string
    {
        return 'Some Action Description';
    }
}
