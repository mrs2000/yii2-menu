yii2-menu
===========================

Yii2 menu widget

Install
-------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mrssoft/yii2-menu "dev-master"
```

or add

```
"mrssoft/yii2-menu": "dev-master"
```

to the require section of your composer.json


Usage
-----

```php
 echo Menu::widget([
      'options' => ['class' => 'my-menu']
      'items' => [
          ['label' => 'Login', 'url' => '/user/login'],
          [
          	'label' => 'Logout', 
            'url' => ['user/logout'], 
            'data-method' => 'post'
          ],
       ]
 ]);
 ```

