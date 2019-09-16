##创建gitlab库

代码放在src目录下，定义composer.json，如：
```json
{
  "name": "xyf/lib",
  "description": "信用飞公共php库",
  "license": "MIT",
  "authors": [
    {
      "name": "junqiang.yi",
      "email": "junqiang.yi@xinyongfei.cn"
    }
  ],
  "autoload": {
    "psr-4": {
      "xyf\\lib\\": "src/"
    }
  },
  "minimum-stability": "dev",
  "require":{},
  "extra":{}
}
```
`autoload`中要定义命名空间，此处通过`psr-4`规范定义`src`目录的命名空间为`xyf\lib`：
```json
  "autoload": {
    "psr-4": {
      "xyf\\lib\\": "src/"
    }
  }
```

稳定版`minimum-stability`为`stable`；
开发版`minimum-stability`为`dev`；

可以通过`extra`来定义开发版本：
```json
  "extra":{
      "branch-alias":{
          "dev-master":"1.0.x-dev" 
      } 
  }
```

src下命名空间以`xyf\lib`开头，以`src/helper/config/Config.php`举例：
```php
<?php
namespace xyf\lib\helper\config;

use yii\base\Model;

class Config extends Model
{
}
```

##项目中引入gitlab库
修改项目根目录下的composer.json文件
1、修改`repositories`，列最上方加入gitlab库源，因为是按顺序从源查询库的。
```json
  "repositories": [
    {
      "type": "git",
      "url": "git@gitlab.xinyongfei.cn:php/xyf-php-lib.git"
    },
    {
      "type": "composer",
      "url": "https://packagist.phpcomposer.com"
    },
    {
      "packagist": false
    }
  ]
```
如果是公开库，可以使用http协议地址，如果是私库需要使用ssh秘钥自动访问，则必须使用git协议。

第二个源为国内的composer源；
`packagist`建议改为false，可以避免2次从全局设置的源中搜索。

2、一般开发版修改`require-dev`，稳定版修改`require`。
```json
  "require-dev": {
    "xyf/lib": "dev-master"
  }
```
如果是加载分支，分支前需要加上`dev`,比如，要加载master分支的，用`dev-master`；
如果是加载tag，则直接写tag名，比如：`1.0.0`，也可以使用`~1.0.0`来加载1.0.x的版本，其他参见：[composer版本约束规则详情](https://overtrue.me/articles/2017/08/about-composer-version-constraint.html)
```json
  "require": {
    "xyf/lib": "~1.1.0"
  }
```

3、修改`config`，关闭https安全检查。
```json
  "config": {
    "secure-http": false
  }
```

##常见问题处理
1、依赖`bower-asset/jquery`，但包解析不了 `yiisoft/yii2 2.0.9 requires bower-asset/jquery 2.2.*@stable`
composer需要安装扩展包：`composer global require "fxp/composer-asset-plugin:~1.4"`


