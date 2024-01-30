<?php

use Thunk\VerbsCommands\Examples\Tasks\Events\TaskArchived;
use Thunk\VerbsCommands\Examples\Tasks\Events\TaskAssigned;
use Thunk\VerbsCommands\Examples\Tasks\States\TaskState;

beforeEach(function () {
    $this->task = TaskState::factory()->create([]);
});

it('A test with no required arguments is "available" when none are provided', function () {
    expect($this->task->availableActions())
        ->toContain(TaskArchived::class);
});

it('A test with required arguments is "unavailable" unless those arguments are provided', function () {
    expect($this->task->availableActions())
        ->not->toContain(TaskAssigned::class);
});

it('A test with required arguments is "available" when those arguments are provided', function () {
    expect($this->task->availableActions(['task_id' => $this->task->id]))
        ->toContain(TaskAssigned::class);
});
