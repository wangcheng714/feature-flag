<?php
/**
 * Created by PhpStorm.
 * User: wangcheng
 * Date: 14-5-6
 * Time: 下午1:45
 */


abstract class Module {
    protected $value = "on";
    public function execute(){

    }
}

class ModuleOne extends  Module{
    public function execute(){
        var_dump("ModuleOne execute");
        var_dump($this->value);

    }
}

class ModuleTwo extends Module{
    public function execute(){
        var_dump("ModuleTwo execute");
        var_dump($this->value);
    }
}

class ModuleRun {

    public function run($moduleName){
        $module_class = new ReflectionClass($moduleName);
        $module = $module_class->newInstance();
        $module->execute();
    }
}

$moduleRun = new ModuleRun();
$moduleRun->run("ModuleTwo");

var_dump(strtotime("2021-01-01 11:11:11"));
var_dump(strtotime("2038-01-01 11:11:11") * 10);


