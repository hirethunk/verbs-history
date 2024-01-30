<?php

use Thunk\VerbsCommands\Examples\Tasks\Events\TaskArchived;
use Thunk\VerbsCommands\Examples\Tasks\Events\TaskAssigned;
use Thunk\VerbsCommands\Examples\Tasks\States\TaskState;
use Thunk\VerbsCommands\Exceptions\MissingInputException;

beforeEach(function () {
    $this->task = TaskState::factory()->create([
        'status' => 'brand spanking new',
    ]);
});

it('A test with no required arguments is "available" when none are provided', function () {
    expect($this->task->availableActions(['task_id' => $this->task->id]))
        ->toContain(TaskArchived::class);
});

it('A test with required arguments is "unavailable" unless those arguments are provided', function () {
    expect($this->task->availableActions())
        ->not->toContain(TaskArchived::class);
});

it('A test with required arguments is "available" when those arguments are provided', function () {
    expect($this->task->availableActions(['task_id' => $this->task->id]))
        ->toContain(TaskAssigned::class);
});

it('can fire an event with context data', function () {
    $this->task->fireAction(
        'archive',
        ['task_id' => $this->task->id]
    );

    expect($this->task)->status->toEqual('archived');
});

it('throws MissingInputException if we do not provide all the required input when firing an event', function () {
    expect(function () {
        $this->task->fireAction(
            'assign',
            ['task_id' => $this->task->id]
        );
    })->toThrow(MissingInputException::class);
});

it('does not throw if we pass all the required data', function () {
    expect(function () {
        $this->task->fireAction(
            'assign',
            ['task_id' => $this->task->id, 'assignee_id' => 1]
        );
    })->not->toThrow(MissingInputException::class);

    expect($this->task)->assignee->toEqual(1);
});
