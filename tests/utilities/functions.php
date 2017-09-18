<?php

function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function make()
{
    return factory($class)->make($attributes);
}