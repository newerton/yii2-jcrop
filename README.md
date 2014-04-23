jQuery jCrop
============
Jcrop is the quick and easy way to add image cropping functionality to your web application.
It combines the ease-of-use of a typical jQuery plugin with a powerful cross-platform 
DHTML cropping engine that is faithful to familiar desktop graphics applications.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist newerton/yii2-jcrop "dev-master"
```

or add

```
"newerton/yii2-jcrop": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php
echo \newerton\jcrop\jCrop::widget([
    // Image URL
    'url' => '/path/to/full/image.jpg',
    // options for the IMG element
    'imageOptions' => [
        'id' => 'imageId',
        'width' => 600,
        'alt' => 'Crop this image'
    ],
    // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
    'jsOptions' => array(
        'minSize' => [50, 50],
        'aspectRatio' => 1,
        'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
        //customization
        'bgColor' => '#FF0000',
        'bgOpacity' => 0.4,
        'selection' => true,
        'theme' => 'light',
    ),
    // if this array is empty, buttons will not be added
    'buttons' => array(
        'start' => array(
            'label' => 'Adjust thumbnail cropping',
            'htmlOptions' => array(
                'class' => 'myClass',
                'style' => 'color:red;'
            )
        ),
        'crop' => array(
            'label' => 'Apply cropping',
        ),
        'cancel' => array(
            'label' => 'Cancel cropping'
        )
    ),
    // URL to send request to (unused if no buttons)
    'ajaxUrl' => 'controller/ajaxcrop',
    // Additional parameters to send to the AJAX call (unused if no buttons)
    'ajaxParams' => ['someParam' => 'someValue'],
]);
?>
```