<?php

// Vars
$config["base_dir"] = 'assets/';
$config["manifest"] = 'core/manifest.json'; // Default : null

// Autoload
$config["autoload"] = [];
$config["autoload"]["script_js"] = [];
$config["autoload"]["script_css"] = [];

// Orderby
$config["orderdy"] = [];
$config["orderby"]["script"] = []; // Default : 'manifest', 'autoload'
$config["orderby"]["manifest"] =
[
	"script_js" => ['manifest.js', 'vendor.js', 'app.js'],
	"script_css" => []
]; // Default : ordre dans le manifest (tableau des clefs comptenu dans le manifest)