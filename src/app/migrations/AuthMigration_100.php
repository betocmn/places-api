<?php

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index as Index;
use Phalcon\Db\Reference as Reference;

class AuthMigration_100 extends \Phalcon\Mvc\Model\Migration
{
    public function up()
    {
        $this->morphTable(
            "auth",
            array(
                "columns" => array(
                    new Column(
                        "id",
                        array(
                            "type"          => Column::TYPE_INTEGER,
                            "size"          => 10,
                            "unsigned"      => true,
                            "notNull"       => true,
                            "autoIncrement" => true,
                            "first"         => true
                        )
                    ),
                    new Column(
                        "name",
                        array(
                            "type"    => Column::TYPE_VARCHAR,
                            "size"    => 70,
                            "notNull" => true,
                            "after"   => "id"
                        )
                    ),
                    new Column(
                        "username",
                        array(
                            "type"    => Column::TYPE_VARCHAR,
                            "size"    => 70,
                            "notNull" => true,
                            "after"   => "name"
                        )
                    ),
                    new Column(
                        "email",
                        array(
                            "type"    => Column::TYPE_VARCHAR,
                            "size"    => 255,
                            "notNull" => true,
                            "after"   => "username"
                        )
                    ),
                    new Column(
                        "password",
                        array(
                            "type"    => Column::TYPE_VARCHAR,
                            "size"    => 100,
                            "notNull" => true,
                            "after"   => "email"
                        )
                    ),
                    new Column(
                        "is_active",
                        array(
                            "type"    => Column::TYPE_BOOLEAN,
                            "notNull" => true,
                            "default"   => true,
                            "after"   => "password"
                        )
                    ),
                ),
                "indexes" => array(
                    new Index(
                        "PRIMARY",
                        array("id")
                    )
                )
            )
        );
    }
}