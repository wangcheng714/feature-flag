
### FeatureService平台

#### 平台形式

* Fis-cloud的一个APP

#### 功能

提供一个UI操作界面，集中管理模块中的所有feature，具有以下几点功能 ：

* 获取所有的feature
* 修改任意一个feature的取值
* Config的校验功能 ：  检验时间、IP等取值是否可以，Config是否有效
* Log功能 ： 记录所有feature的修改who、when
* 保存后能够迅速自动发布到线上生效
* 是否可以删除？(待考虑)
* 权限管理(优先级不高)


### 平台

#### UI界面

#### FeatureController类

Controller类比较简单，这里大概描述需要实现哪些功能

* feature的删、改、查、校验等功能
* feature changelog功能
* config的发布功能(连接CMS)
