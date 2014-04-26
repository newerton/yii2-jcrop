<?php
/**
 * @copyright Copyright (c) 2014 Newerton Vargas de Araújo
 * @link http://newerton.com.br
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace newerton\jcrop;

use yii\web\AssetBundle;

class jCropAsset extends AssetBundle
{
    public $sourcePath = '@vendor/newerton/yii2-jcrop/assets';

    public $js = [
        'js/jquery.color.js',
        'js/ejcrop.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    
     public function registerAssetFiles($view) {
        $this->css[] = 'css/jquery.Jcrop' . (!YII_DEBUG ? '.min' : '') . '.css';
        $this->js[] = 'js/jquery.Jcrop' . (!YII_DEBUG ? '.min' : '') . '.js';
        parent::registerAssetFiles($view);
    }
} 
