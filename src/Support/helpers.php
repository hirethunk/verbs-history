<?php

use Thunk\VerbsCommands\Collections\ActionCollection;

if (! function_exists('actions')) {
    function actions($items): ActionCollection
    {
        return ActionCollection::make($items);
    }
}
