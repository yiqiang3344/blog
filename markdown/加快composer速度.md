#加快composer速度

1、切换国内数据源镜像
执行如下命令：
```bash
composer config -g repo.packagist composer https://packagist.phpcomposer.com 
```

或者直接修改全局composer.json文件，一般为 `~/.composer/composer.json`
修改`repositories`和`config`属性，具体如下：
```json
{
    "repositories": [
        {
          "type": "composer",
          "url": "https://packagist.phpcomposer.com"
        },
        {"packagist": false}
    ],
    "config": {
        "secure-http": false
    }
}
```

2、添加加速扩展`hirak/prestissimo`
此扩展通过使用并行下载的方式大大提升了包的加载速度，可使用国内镜像安装。
```bash
composer global require hirak/prestissimo
```
[官方文档](https://packagist.org/packages/hirak/prestissimo)

3、加载时使用`--prefer-dist`
```bash
composer install --profile --prefer-dist
```
[参考文档](https://www.jianshu.com/p/30e475683629)