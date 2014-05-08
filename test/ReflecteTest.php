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

var_dump(strtotime("now"));
var_dump(strtotime("2014-5-7 20:21:10"));

$baiduid = "F3564929D88C591024AD44FA3E7CF565:FG=1";
var_dump(hexdec(substr(str_ireplace(':FG=1', '', $baiduid), -6)) % 100);

