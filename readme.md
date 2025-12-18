# win10explore-UpdateForWP
# WordPress主题更新（win10explore）
* 原主题：https://github.com/ghboke/win10explore/
* 感谢[ghboke](https://github.com/ghboke)提供的WP主题，从20年开始建站就开始使用这款主题，甚是喜欢。
* 但最近有朋友浏览了博客后提出了一些建议，本来这些小问题没啥，但事后想一想，这些意见也确实有助于改善我这博客的整体体验。
* 怎么说呢，都是小改动，后续有更新都会往这提交，更完善点。
* 改进如下：
## 改进部分
### 新增模块：网站上线运行时长计时器（footer.php）
![运行时长计时器](https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/SiteRuntimeTimer.png)
### 禁用WordPress大图片（2560大小）裁剪功能（functions.php）
```php
//禁用WordPress大图片（2560大小）裁剪功能
add_filter( 'big_image_size_threshold', '__return_false' );
```
* 这个好像没怎么起作用。
### 修改分页模块：在“上一页 / 下一页”之间插入自定义分隔文本，并加粗显示；新增页码跳转模块（index.php）
![修改分页模块](https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/PaginationEnhancementAndPageJump.png)
### 新增“就不关”弹窗核心逻辑：原有模块右上角关闭按钮无实际功能（index.php）
![修改分页模块](https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/DisableCloseButtonWithPopupTip.png)
### 新增图片查看功能模块，取消评论模块（single.php）
![新增图片查看功能模块](https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/ImageViewerModule.png)
