<?
namespace app\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Menu widget
 *
 * @version 1.0.0
 * @author Melnikov R.S. <mrs2000@inbox.ru>
 * @copyright 2015 Melnikov R.S.
 * @license MIT
 *
 * echo Menu::widget([
 *     'options' => ['class' => 'my-menu']
 *     'items' => [
 *         ['label' => 'Login', 'url' => '/user/login'],
 *         ['label' => 'Logout', 'url' => ['user/logout'], 'data-method' => 'post'],
 *      ]
 * ]);
 *
 */
class Menu extends Widget
{
    /**
     * @var array Menu items
     */
    public $items;

    /**
     * @var array HTML menu options
     */
    public $options = [];

    /**
     * @var string Type the definition of the active menu item
     * controller (comparing only the controller) or route (a comparison of the controller and action)
     */
    public $activeMatch = 'controller';

    private $controllerID;
    private $route;
    private $actionParams;

    public function init()
    {
        $this->controllerID = Yii::$app->controller->id;
        $this->route = Yii::$app->controller->route;
        $this->actionParams = Yii::$app->controller->actionParams;

        if ($this->route == Yii::$app->defaultRoute) {
            $this->controllerID = '';
        }
    }

    public function run()
    {
        echo Html::beginTag('ul', $this->options);

        foreach ($this->items as $item) {

            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException('The "label" element is required for each link.');
            }

            if (array_key_exists('url', $item)) {
                $options = [];
                if (count($item) > 2) {
                    $options = array_splice($item, 2);
                }
                $a = Html::a($item['label'], $item['url'], $options);
            } else {
                $a = $item['label'];
            }

            $options = [];
            if ($this->isActive($item)) {
                $options = ['class' => 'active'];
            }

            echo Html::tag('li', $a, $options);
        }

        echo Html::endTag('ul');
    }

    /**
     * @param $item
     * @return bool
     */
    private function isActive($item)
    {
        if (!array_key_exists('url', $item)) {
            return false;
        }

        if ($this->activeMatch === 'controller') {
            if ($this->controllerID != explode('/', $item['url'][0])[0]) {
                return false;
            }
        } else if ($this->activeMatch === 'route' && ($this->route != $item['url'][0])) {
            return false;
        }

        if (count($item['url']) > 1) {
            foreach ($item['url'] as $key => $value) {
                if (!is_numeric($key) && Yii::$app->controller->actionParams[$key] !== $value) {
                    return false;
                }
            }
        }

        return true;
    }
}