<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 13.07.2015
 * Time: 1:31
 */
class controller
{
    public $tools;
    private $vars;

    public function __construct()
    {
        $this->tools = $this->tools();
    }

    /**
     * @param $model
     * @param string $table
     * @param string $db
     * @param string $user
     * @param string $password
     * @return model
     */

    public function model($model, $table = null, $db = null, $user = null, $password = null)
    {
        $models = registry::get('models');
        if(!$m = $models[$model][$table]) {
            $model_file = ROOT_DIR . 'models' . DS . $model . '_model.php';
            if(file_exists($model_file)) {
                $model_class = $model . '_model';
                $m = new $model_class($table ? $table : $model, $db, $user, $password);
            } else {
                $m = new default_model($model);
            }
            $models[$model][$table] = $m;
            registry::remove('models');
            registry::set('models', $models);
        }
        return $m;
    }

    protected function view($template)
    {
        $this->render('log', registry::get('log'));
        $template_file =  ROOT_DIR . 'templates' . DS . $template . '.php';
        if(!file_exists($template_file)) {
            throw new Exception('cannot find template in ' . $template_file);
        }
        foreach($this->vars as $k => $v) {
            $$k = $v;
        }
        require_once($template_file);
    }

    /**
     * @param string $key
     * @param mixed $value
     */

    protected function render($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
    * @param string $template
    * @return string
    * @throws Exception
    */

    public function fetch($template)
    {
        $template_file = ROOT_DIR . 'templates' . DS . $template . '.php';
        if(!file_exists($template_file)) {
            throw new Exception('cannot find template in ' . $template_file);
        }
        foreach($this->vars as $k => $v) {
            $$k = $v;
        }
        ob_start();
        @require($template_file);
        return ob_get_clean();
    }

    /**
     * @param string $file
     * @param mixed $value
     * @param string $mode
     */

    public function writeLog($file, $value, $mode = 'a+') {
        $f = fopen(ROOT_DIR . 'tmp' . DS . 'logs' . DS . $file . '.log', $mode);
        fwrite($f, date('Y-m-d H:i:s') . ' - ' .print_r($value, true) . "\n");
        fclose($f);
    }

    /**
     * @param string $key
     * @return string
     */

    public function getConfig($key)
    {
        if(!$key) {
            return false;
        }
        if(!$value = registry::get('config')[$key]) {
            $config = registry::get('config');
            $config[$key] = $this->model('system_config')->getByField('config_key', $key)['config_value'];
            registry::remove('config');
            registry::set('config', $key);
            return $config[$key];
        } else {
            return $value;
        }
    }

    public function getLocale($table, $key)
    {
        $row = array(
            'language' => registry::get('language'),
            'locale_key' => $key,
            'locale_table' => $table
        );
        return $this->model('locale')->getByFields($row)['locale_value'];
    }

    public function getAllLocale($table)
    {

    }

    public function callEvent($event, array $data)
    {
        $class_name = $event . '_event';
        return new $class_name($data);
    }

    private function tools()
    {
        return new tools_class();
    }
}