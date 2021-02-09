<?php

return [
    /**
     * Database config properties
     *
     * implementation: Switch between Redis/Eloquent to handle data
     * ttl: "time to live", number of days the data can remain idle in the database before getting deleted.
     */
    "database" => [
        "implementation" => \juniorE\ShoppingCart\Data\Repositories\EloquentCartDatabase::class,
        "ttl" => 30,

    ],
    "login" => [
        "userIdColumn" => "id"
    ]
];
