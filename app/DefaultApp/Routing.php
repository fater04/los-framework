<?php
use app\DefaultApp\DefaultApp as App;

App::get("/", "default.dashboard", "dashboard");
App::get("dashboard", "default.dashboard", "dashboard");

App::get("login", "default.login", "login");
App::post("login", "default.login", "login");
App::get("logout", "default.logout", "logout");

App::get("users", "utilisateur.lister", "users");
App::post("users", "utilisateur.lister", "users");
