<?php


namespace App;


trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        static::created(function ($thread) {
            $thread->recordActivity('created');
        });
    }

    protected function recordActivity($event)
    {
        Activity::create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
        ]);
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}