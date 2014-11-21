<?php

/**
 * @copyright Copyright (c) 2014 Newerton Vargas de Araujo
 * @link http://newerton.com.br
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yii2-jcrop
 * @version 1.0.0
 */

namespace newerton\jcrop;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Select a cropping area fro an image using the Jcrop jQuery tool and crop
 * it using PHP's GD functions.
 *
 * @author Newerton Vargas de Araujo <contato@newerton.com.br>
 * @since 1.0
 */
class jCrop extends Widget {

    /**
     * @var string URL of the picture to crop.
     */
    public $url;

    /**
     * @var array to set picture options
     */
    public $imageOptions = [];

    /**
     * @var array to set options plugin
     */
    public $jsOptions = [];

    /**
     * @var array to set buttons options
     */
    public $buttons = [];

    /**
     * @var string URL for the AJAX request
     */
    public $ajaxUrl;

    /**
     * @var array Extra parameters to send with the AJAX request.
     */
    public $ajaxParams = [];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();


        if (!isset($this->imageOptions['id'])) {
            $this->imageOptions['id'] = $this->getId();
        }
        $this->id = $this->imageOptions['id'];
    }

    /**
     * @inheritdoc
     */
    public function run() {

        $output = Html::img($this->url, $this->imageOptions);

        if (!empty($this->buttons)) {
            $output .= "<div class='jcrop-buttons' id='{$this->id}_buttons'>";
            $output .= Html::button($this->buttons['start']['label'], $this->getHtmlOptions('start', 'inline'));
            $output .= Html::button($this->buttons['crop']['label'], $this->getHtmlOptions('crop'));
            $output .= Html::button($this->buttons['cancel']['label'], $this->getHtmlOptions('cancel'));
            $output .= '</div>';
        }

        $output .= Html::hiddenInput($this->id . '_x', 0, ['class' => 'coords', 'id' => $this->id . '_x']);
        $output .= Html::hiddenInput($this->id . '_y', 0, ['class' => 'coords', 'id' => $this->id . '_y']);
        $output .= Html::hiddenInput($this->id . '_w', 0, ['class' => 'coords', 'id' => $this->id . '_w']);
        $output .= Html::hiddenInput($this->id . '_h', 0, ['class' => 'coords', 'id' => $this->id . '_h']);
        $output .= Html::hiddenInput($this->id . '_x2', 0, ['class' => 'coords', 'id' => $this->id . '_x2']);
        $output .= Html::hiddenInput($this->id . '_y2', 0, ['class' => 'coords', 'id' => $this->id . '_y2']);

        echo $output;

        $this->registerClientScript();
    }

    /**
     * Registers required script for the plugin to work as DatePicker
     */
    public function registerClientScript($registerJs = true) {
        $view = $this->getView();

        jCropAsset::register($view);

        $this->jsOptions['onChange'] = new JsExpression("function(c) {ejcrop_getCoords(c,'{$this->id}'); ejcrop_showThumb(c,'{$this->id}');}");
        $this->jsOptions['ajaxUrl'] = $this->ajaxUrl;
        $this->jsOptions['ajaxParams'] = $this->ajaxParams;

        $options = !empty($this->jsOptions) ? Json::encode($this->jsOptions) : '';

        if (!empty($this->buttons)) {
            $js = "ejcrop_initWithButtons('{$this->id}', {$options});";
        } else {
            $js = "jQuery('#{$this->id}').Jcrop({$options});";
        }

        if ($registerJs)
            $view->registerJs($js);
    }

    /**
     * Get the HTML options for the buttons.
     * 
     * @param string $name button name
     * @return array HTML options 
     */
    protected function getHtmlOptions($name, $display = 'none') {
        if (isset($this->buttons[$name]['htmlOptions'])) {
            if (isset($this->buttons[$name]['htmlOptions']['id'])) {
                throw new InvalidConfigException("'id' for jcrop '{$name}' button may not be set manually.");
            }
            $options = $this->buttons[$name]['htmlOptions'];

            if (isset($options['class'])) {
                $options['class'] = $options['class'] . " jcrop-{$name}";
            } else {
                $options['class'] = "jcrop-{$name}";
            }

            if (isset($options['style'])) {
                $options['style'] = $options['style'] . " display:{$display};";
            } else {
                $options['style'] = "display:{$display};";
            }
            $options['id'] = $name . '_' . $this->id;
        } else {
            $options = ['id' => $name . '_' . $this->id, 'style' => "display:{$display};", 'class' => "jcrop-{$name}"];
        }
        return $options;
    }

}
