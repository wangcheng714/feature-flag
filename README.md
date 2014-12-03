feature-flag
============

## Feature-Flag简介

    Feature flag 是一个可以通过配置来控制是否打开页面某一功能，而不用重新发布代码的系统。
    可以做到按照任意的需求、条件决定页面的某一功能是否展现。

如果你还不了解Feature-flag，参考[这里](https://secure.phabricator.com/book/phabflavor/article/recommendations_on_branching/)facebook的branching系统。
整个系统分为框架和平台两部分:
框架主要负责利用配置文件运行时决定页面的某一功能是否展现。框架采用Smarty插件开发，仅支持Smarty模板。
平台主要负责通过可视化的配置界面控制feature配置文件，并自动发布上线。

### 使用场景

Feature-flag可以很轻松的满足以下场景需求：

* 页面功能小流量发布控制
* 专题页面定时上下线
* 不同城市展现不同的页面内容
* 新功能快速回滚
* 页面功能按照IP展现
* 主干开发模式，控制为开发完成功能

### feature-flag解决的问题

#### 功能快速发布

对于传统的分支开发模式，当我们需要上线或者下线页面某一功能时，通常是建立新的分支，添加或者注释掉多余的代码，然后提测、合并分支，最后上线。
即使我们只需要修改注释一两行代码也是如此的麻烦，对于上线较多的产品线，可以说上线流程就占据了很大一部分工作时间。
使用feature-flag系统只需要在平台简单的配置true、false就可以了。

#### 主干开发的利器

诸如facebook、google等很多国外的公司都在利用类似的技术达到主干开发的效果。
关于主干开发和分支开发可以看[这里](https://github.com/wangcheng714/feature-flag/blob/master/doc/feature-flags-framework.md#featurebranch-%E7%BC%BA%E7%82%B9),业界也有很多这方面的讨论，这里就不详细描述了，可以参考[这里](http://martinfowler.com/bliki/FeatureToggle.html)。

## 框架使用

### 安装

* 执行命令 lights install feature-plugin  没有使用过lights的童鞋，[参考这里](http://lightjs.duapp.com/)
* 将feature-plugin中的插件部署到Smarty plugin目录

### 使用

框架的使用首先需要针对需求定义feature类型(按时间、按地点等控制)，然后在页面功能需求调用配置文件中定义的feature。

#### 定义feature

* smarty config目录添加配置文件 ： common-features.json

        common为features的命名空间，在features调用是会使用，如果使用Fis(http://fis.baidu.com/)建议同模块名相同

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
```

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

## 系统设计

[Feature-flag系统设计](./doc/feature-flags-framework.md)
