<?php

/**
 * todo : 
 *   1. 整理各种错误应该如何处理
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Feature.class.php");

class DoorKeeper {

	private static $featureMap = array();

	private static function triggerError($msg){
		trigger_error(date('Y-m-d H:i:s') . ' ' . $msg, E_USER_ERROR);
	}
	
	private static function _getFeature($featureName, $smarty){
		/**
		 * 1.  处理featureName : 有模块名前缀
		 * 2.  load、查找config
		 */
		$featureToken = explode(":", $featureName);
        if(count($featureToken) > 1){
            $strNamespace = $featureToken[0];
            $featureName = $featureToken[1];
        } else {
            self::triggerError("Feature name is illegal");
        }
        if(isset(self::$featureMap[$strNamespace]) || self::registerFeatures($strNamespace, $smarty)) {
            $arrMap = &self::$featureMap[$strNamespace];
            $featureInfo = &$arrMap[$featureName];
            if (isset($featureInfo)) {
            	$featureInfo["name"] = $featureName;
                return $featureInfo;
            }
        }
        return null;
	}

	private static function registerFeatures($nameSpace, $smarty){

        $strMapName = $nameSpace . '-features';

        $arrConfigDir = $smarty->getConfigDir();
        foreach ($arrConfigDir as $strDir) {
            $strPath = preg_replace('/[\\/\\\\]+/', '/', $strDir . '/' . $strMapName);
            if (is_file($strPath . '.json')) {
            	$featureResult = json_decode(file_get_contents($strPath . '.json'), true);
                self::$featureMap[$nameSpace] = $featureResult["features"];
                return true;
            }
        }
        return false;
	}

	private static function initFeature($featureConfig){
		/**
		 * 1. require对应的class文件 ： 判断文件是否存在
		 * 2. 反射对应的class实例 ： 验证是否是Feature子类
		 * 3. 返回初始化的对象
		 */
		$fatherClazz = new ReflectionClass("Feature");
		$featureType = ucfirst($featureConfig["type"]);
		$featureValue = $featureConfig["value"];
		$featureName = $featureConfig["name"];
		//todo : 思考如何扩展，使得可以查找外部的Feature
		$classFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $featureType . "Feature.class.php";
		$className = $featureType . "Feature";
		if(is_file($classFile)){
			require_once($classFile);
			$featureClazz = new ReflectionClass($className);
			if($featureClazz->isSubclassOf($fatherClazz)){
				$featureClass = $featureClazz->newInstance($featureName, $featureValue);
				return 	$featureClass;
			}else{
				self::triggerError($className . " must extends class Feature!");
			}
		}else{
			self::triggerError("Not find " . $classNames);
		}
		return null;
	}

	public static function getFeature($featureName, $smarty){
		/**
		 * 1. 调用_getFeature
		 * 2. 调用initFeature
		 * 3. 调用子类的getFlag获得最终结果
		 */
		$featureInfo = self::_getFeature($featureName, $smarty);
		$featureClass = self::initFeature($featureInfo);
		$featureResult = $featureClass->getFlag();
		return $featureResult;
	}

} 
?>