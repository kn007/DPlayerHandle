## Description
Easy handle DPlayer Lite or DPlayer on WordPress. A shortcode for WordPress to using DPlayer.

Support `[video]` tag, compatible with AMP.

<a href="https://github.com/kn007/DPlayerHandle/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-green.svg?style=flat"></a>

## Requirement

* WordPress
* [DPlayer Lite](https://github.com/kn007/DPlayer-Lite)(full support) or [DPlayer](https://github.com/MoePlayer/DPlayer)(partial support)

## How To Using

Put `class.dplayer.php` into your theme folder, then put this following code to your theme `functions.php`:
```
class_exists('DPlayerHandle') or require(get_template_directory() . '/class.dplayer.php');
$dplayer = new DPlayerHandle;
$dplayer->init();
```

Shortcode example:
```
[dplayer autoplay="false" theme="#b7daff" loop="false" preload="auto" src="http://devtest.qiniudn.com/若能绽放光芒.mp4" poster="http://devtest.qiniudn.com/若能绽放光芒.png" type="auto" mutex="true" iconsColor="#ffffff"]
```

Video tag shortcode example:
```
[video dplayer="true" src="http://devtest.qiniudn.com/若能绽放光芒.mp4" poster="http://devtest.qiniudn.com/若能绽放光芒.png"]
```

More information: [https://kn007.net/topics/wordpress-blog-use-new-html5-video-player-dplayer-lite/](https://kn007.net/topics/wordpress-blog-use-new-html5-video-player-dplayer-lite/) 

## Thank you list

DIYgod, the author of DPlayer. [Github repo](https://github.com/MoePlayer/DPlayer)

## About

[kn007's blog](https://kn007.net) 

***

## 中文说明
轻松的在WordPress使用上DPlayer和DPlayer Lite，短代码形式调用。

支持原生`[video]`标签，不影响AMP模式。

<a href="https://github.com/kn007/DPlayerHandle/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-green.svg?style=flat"></a>

## 依赖组件

* WordPress
* [DPlayer Lite](https://github.com/kn007/DPlayer-Lite)(完整支持) 或者 [DPlayer](https://github.com/MoePlayer/DPlayer)(有限功能支持)

## 如何使用

将`class.dplayer.php`放在你主题的根目录下，然后将下面代码放在`functions.php`里即可。
```
class_exists('DPlayerHandle') or require(get_template_directory() . '/class.dplayer.php');
$dplayer = new DPlayerHandle;
$dplayer->init();
```

短代码调用方式举例：
```
[dplayer autoplay="false" theme="#b7daff" loop="false" preload="auto" src="http://devtest.qiniudn.com/若能绽放光芒.mp4" poster="http://devtest.qiniudn.com/若能绽放光芒.png" type="auto" mutex="true" iconsColor="#ffffff"]
```

Video短代码调用方式举例：
```
[video dplayer="true" src="http://devtest.qiniudn.com/若能绽放光芒.mp4" poster="http://devtest.qiniudn.com/若能绽放光芒.png"]
```

详细说明见：[https://kn007.net/topics/wordpress-blog-use-new-html5-video-player-dplayer-lite/](https://kn007.net/topics/wordpress-blog-use-new-html5-video-player-dplayer-lite/)

## 特别鸣谢

感谢DIYgod写的DPlayer，[Github项目地址](https://github.com/MoePlayer/DPlayer)

## 关于作者

[kn007的个人博客](https://kn007.net) 
