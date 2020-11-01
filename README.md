# shaoran-platform
Shaoran Platform is a web application framework for PHP
Version 5.1 (build 10.2020)

Frameworks & resources for help you.
- Shaoran DbHelper v.3.0
- Shaoran File Manager v.1.0
- BladeOne v.3.47.3
- Bootstrap v.4.5 + Customize Coder Theme
- Font Awesome v.5.0

Hello! Welcome to the first time
1. config AssemblyBaseURL in .\App\WebConfig.php to your access with url address (ex. http://localhost/shaoran-platform)
2. dev time!

Shaoran Platform development from Model-View-Controller (MVC) pattern
.\App\Models -> Model directory
.\App\Controllers -> Controller directory
.\App\Views -> View directory
-- Easy! --

You can create API service in .\App\Controllers\api has get / post / put / delete method request with $_POST or $_GET and response is json syntax.
ex. URL address for call: http://localhost/shaoran-platform/api/get/demo/index
-- responsed --
{"status":403,"msg":"forbidden"}

WTH!
edit Controllers/api/get/DemoController.php remove or comment code

self::$model->userAuth->ApiActive();

because not have session login and refresh again...
-- responsed --
{"status":200,"msg":"success"}

-- WOW! Easy but not security LOL --

This framework is also a prototype. you can join develop it even further!

Thank you.
