feature-flag
============

## Feature-Flag简介

    Feature flag 是一个可以通过配置来控制是否打开页面某一功能，而不用重新发布代码的系统。
    可以做到按照任意的需求、条件决定页面的某一功能是否展现。
    核心思想就是将功能的开发和代码的发布解耦。

## 快速使用

### 安装

    * 下载plugin目录，将里面提供的插件部署到Smarty plugin目录即完成安装

### 使用

#### 定义feature

* smarty config目录添加配置文件 ： common-features.json

        common为features的命名空间，在features调用是会使用

* 配置文件中定义feature ： 格式如下

        ```javascript
        {
            "features" : {
                "featureA" : {
                    "type" : "switch",
                    "value" : "on",
                    "desc" : "test switch feature work or not"
                }
            }
        }

        featureA ： 具体的feature的名字
        type : 该feature的类型，系统提供了几种默认的feature类型
        value ： 该feature的取值，具体格式请参考feature类型描述文档
        desc ： 该feature功能的文字描述，类似于代码的注释，方便以后feature的维护

* [内置feature类型参考这里](./doc/feature-type.md)

#### 调用feature

* 页面中使用feature

        写法一 ：
        {%feature name="common:featureA"%}
            html code for featureA
        {%/feature%}

        写法二 ：
        {%feature name="common:featureA"%}
            html code for featureA
        {%featureelse%}
            html code if featureA not work
        {%/feature%}

## 高级使用

* [如何扩展自定义feature](./doc/feature-extends.md)

## 相关连接

[Feature-flag系统设计](./doc/feature-flags-framework.md)