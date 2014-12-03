
# feature自定义扩展

## 什么情况下需要扩展？

如果页面的某块功能需要按需展示，而系统内置的几种feature([参考这里](./feature-type.md))无法满足你的场景需求时，可以考虑自定义feature类型

## 如何扩展？

下面以开发City type为例说明如何开发一个feature扩展，City type判断如果用户来自value指定的城市则feature生效，否则feature失效。

### 创建CityFeature类

* 新建CityFeature.class.php文件
* CityFeature需要继承Feature抽象类

```php
class CityFeature extends Feature{

}
```

* 实现getFlag方法 : 方法利用配置文件中的value计算、判断返回feature是否生效，生效返回ture，否则返回false

```php
class CityFeature extends Feature{
    public function getFlag(){
        $client_ip = $_SERVER["REMOTE_ADDR"]; //获取用户IP
        //调用百度哥伦布IP库获得用户城市
        $city = convertToCity($client_ip);
        if($city = $this->value){
            return ture;
        }else{
            return false;
        }
    }
}
```

### 配置feature扩展类部署位置

* 可以将CityFeature.class.php和内置Feature放到一起，无需任何配置
* 如果需要部署到指定的目录，有一下两种方法指定部署的目录：

        方法一：配置文件中和features并列增加feature_dir属性
        "feature_dir" : [
            "../templates/features/" //该目录是相对于smarty的config目录
        ]

        方法二： 调用系统提供的接口设定目录
        require DoorKeeper.class.php
        调用addFeatureDir($dir) 设定目录

### 使用

通过上述两个简单的步骤就可以在项目中调用CityFeature了

```javascript
{
    "features" : {
        "city-beijing" : {
            "type" : "city",
            "value" : "北京",
            "desc" : "some feature for 北京"
        }
    }
}

{%feature name="common:city-beijing"%}
    html code for 北京
{%featureelse%}
    html code for other city
{%/feature%}
```

## 场景

下面简单罗列一些可能需要自定义feature的应用场景：

* 某一新功能只在特定的城市上线，其他城市依然使用老版页面
* 某一功能希望给登录用户或者付费用户展示