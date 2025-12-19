
# win10explore-UpdateForWP

> 🧩 基于 **win10explore** 的个人使用向改进版本  
> 一些不影响主题整体风格的小优化，主要用于提升博客的浏览与交互体验。

---

## 📌 项目说明

- **原主题地址**：  
  https://github.com/ghboke/win10explore/
- **致谢**：感谢 [ghboke](https://github.com/ghboke) 提供的 WordPress 主题  
- 自 2020 年建站起一直使用该主题，整体风格非常喜欢  
- 近期根据朋友反馈，对部分细节与交互进行了小幅改进  
- 后续若有更新，将持续提交至本仓库

> 说明：均为小改动，偏向体验优化与细节完善。

---

## ✨ 改进内容

---

### ⏱ 新增：网站上线运行时长计时器（`footer.php`）

* 用于展示网站自上线以来的运行时间。

<p align="center">
  <img src="https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/SiteRuntimeTimer.png" width="50%">
</p>

---

### 🖼 禁用 WordPress 大图片（2560px）自动裁剪功能（`functions.php`）

```php
// 禁用 WordPress 大图片（2560px）裁剪功能
add_filter( 'big_image_size_threshold', '__return_false' );
```

> ⚠️ 备注：该方法在部分环境下效果不明显，可能与 WordPress 版本或主题机制有关，目前仍在观察中。

---

### 📄 分页模块优化（`index.php`）

* 在「上一页 / 下一页」之间插入自定义分隔文本，并加粗显示。
* 新增页码跳转模块，方便在文章较多时快速定位页面。

<p align="center">
  <img src="https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/PaginationEnhancementAndPageJump.png" width="50%">
</p>

---

### 🚫 新增“就不关”弹窗核心逻辑（`index.php`）

* 原模块点击关闭按钮时而能关闭，时而无反应。
* 避免用户误操作。

<p align="center">
  <img src="https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/DisableCloseButtonWithPopupTip.png" width="30%">
</p>

---

### 🔍 新增图片查看功能模块 & 取消评论模块（`single.php`）

* 新增文章内图片查看功能，点击即可滑动阅览图片。
* 移除评论模块（一开始是为了备案审查隐藏了评论模块，后来想着恢复下吧，反而看着不习惯了，关了也挺好的）。

<p align="center">
  <img src="https://github.com/yosoroQ/win10explore-UpdateForWP/blob/main/imgUpdate/ImageViewerModule.png" width="50%">
</p>

---

