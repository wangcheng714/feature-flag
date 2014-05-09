<?php

/**
 * todo : 
 *   1. 整理各种错误应该如何处理
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Feature.class.php");

class DoorKeeper {

	private static $featureMap = array();
	private static $featureDirs = array();
	private static $configDir = null;
	private static $defaultDir = null;

	private static function triggerError($msg){
		trigger_error(date('Y-m-d H:i:s') . ' ' . $msg, E_USER_ERROR);
	}
	
	/**
	 * todo ： 描述namespace的数据结构
	 */
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
		if(isset(self::$featureMap[$strNamespace]) || self::registerFeatureMap($strNamespace, $smarty)) {
			$arrMap = &self::$featureMap[$strNamespace];
			$featureInfo = &$arrMap[$featureName];
			if (isset($featureInfo)) {
				$featureInfo["name"] = $featureName;
				$featureInfo["namespace"] = $strNamespace;
				return $featureInfo;
			}
		}
		return null;
	}

	private static function registerFeatureMap($nameSpace, $smarty){

		$strMapName = $nameSpace . '-features';

		$arrConfigDir = $smarty->getConfigDir();
		foreach ($arrConfigDir as $strDir) {
			$strPath = preg_replace('/[\\/\\\\]+/', '/', $strDir . '/' . $strMapName);
			if (is_file($strPath . '.json')) {
				$featureResult = json_decode(file_get_contents($strPath . '.json'), true);
				self::$featureMap[$nameSpace] = $featureResult["features"];
				if(isset($featureResult["feature_dir"])){
					self::$featureDirs[$nameSpace] =  $featureResult["feature_dir"];
				}
				self::$configDir = $strDir;
				return true;
			}
		}
		return false;
	}

	/**
	 * 		
	 *    feature 扩展既支持单独模块独立目录， 也可以feature插件共享目录
	 */	
	private static function getFeatureFile($featureConfig){
		$featureType = ucfirst($featureConfig["type"]);
		$nameSpace = $featureConfig["namespace"];
		
		if(isset(self::$featureDirs[$nameSpace])){
			foreach(self::$featureDirs[$nameSpace] as $dir){
				$featureFile = realpath(self::$configDir . $dir .  DIRECTORY_SEPARATOR . $featureType . "Feature.class.php");
				if(is_file($featureFile)){
					return $featureFile;
				}
			}
		}

		if(isset(self::$defaultDir)){
			$userDefaultFile = realpath(self::$defaultDir . DIRECTORY_SEPARATOR . $featureType . "Feature.class.php");
			if(is_file($userDefaultFile)){
				return $userDefaultFile;
			}
		}

		$systemDefaultFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $featureType . "Feature.class.php";
		if(is_file($systemDefaultFile)){
			return $systemDefaultFile;
		}else{
			self::triggerError("Not find " . $featureType);
		}

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
		$classFile = self::getFeatureFile($featureConfig);
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
			self::triggerError("Not find " . $className);
		}
		return null;
	}

	public static function addFeatureDir($dir){
		if(is_dir($dir)){
			self::$defaultDir = $dir;
		}else{
			self::triggerError($dir . " is not a dir!");
		}
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