<?php

namespace App\controller;

class ActorsCrudController extends CrudController
{
    protected string $table = "actor";
    public const ACCEPTED_GENDER = ["Male", "Female", "Other"];
}
