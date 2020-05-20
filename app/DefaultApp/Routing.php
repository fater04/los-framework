<?php
use app\DefaultApp\DefaultApp as App;
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");


App::get("/test", "default.test", "test");