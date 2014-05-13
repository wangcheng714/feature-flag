
## feature-flag系统内置feature类型

### Switch type

* 通过on/off控制feature是否生效
* value取值 ： on或off

### Percentage type

* 通过百分比控制feature对多少用户开发

        使用baiduid作为百分比取值标准，可以保证feature对同一个用户是否生效是固定的

* value取值 ： 0-100之间，如：80

### Date type

* 通过时间控制，某时间之前feature生效
* value取值 ： 具体的时间字符串，格式如下

        ```javascript
        {
            "features" : {
                "featureA" : {
                    "type" : "beforeDate",
                    "value" : "2013-12-23 15:00:00 | 2013-12-23 15:00:00", //生效时间 | 失效时间
                    "desc" : "test beforeDate feature work or not"
                }
            }
        }

        ```javascript
        {
            "features" : {
                "featureA" : {
                    "type" : "beforeDate",
                    "value" : "* | 2013-12-23 15:00:00", // * 表示无穷小或者无穷大
                    "desc" : "test beforeDate feature work or not"
                }
            }
        }

## 自定义feature扩展

* [如何扩展自定义feature](./doc/feature-design.md)