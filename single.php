<!--没有评论区的single-->
<?php
get_header();
the_post();
$cat = get_the_category();
$catid = $cat[0]->cat_ID;
?>

<!-- 图片查看器样式 -->
<style>
/* 放大弹窗容器 */
.img-viewer-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
}

/* 放大后的图片 */
.img-viewer-modal .viewer-img {
    max-width: 90%;
    max-height: 80vh;
    object-fit: contain;
    transition: transform 0.3s ease;
}

/* 关闭按钮 */
.img-viewer-modal .close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    color: #fff;
    font-size: 30px;
    cursor: pointer;
    z-index: 10;
}

/* 左右切换按钮 */
.img-viewer-modal .nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 40px;
    cursor: pointer;
    padding: 20px;
    user-select: none;
}

.img-viewer-modal .prev-btn {
    left: 20px;
}

.img-viewer-modal .next-btn {
    right: 20px;
}

/* 图片计数 */
.img-viewer-modal .counter {
    position: absolute;
    bottom: 20px;
    color: #fff;
    font-size: 16px;
}
</style>

<div class="layui-container" id="main">
    <div class="blog-title"><?php obj_title_icon();
        bloginfo('name'); ?>
        <div class="post-title"> - <?php the_title(); ?></div>
        <div class="close"><i class="layui-icon layui-icon-close"></i>
        </div>
    </div>
    <div class="toolbar">
        <div class="layui-row">
            <div class="obj_menu_header">
                <?php get_nav_menu_obj(); ?>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md1 <?php get_self_adaption_css()?>">
                <div class="toobar-col"><i class="fa fa-arrow-left" aria-hidden="true"
                                           onclick="javascript :history.back(-1)"></i>
                    <i class="fa fa-arrow-right" aria-hidden="true" onclick="javascript :history.forward()"></i><i
                            class="fa fa-arrow-up" aria-hidden="true"></i></div>
            </div>
            <div class="layui-col-md9 layui-col-xs-12 layui-col-sm-12">
                <div class="toolbar-url"><img class="toobar-icon" src="<?php echo getImgDir('folder.ico') ?>"
                                              alt=""><span><a
                                href="//<?php echo $_SERVER['SERVER_NAME']; ?>">本网站</a></span>><span><a
                                href="<?php echo get_category_link($catid) ?>"><?php echo get_cat_name($catid) ?></a></span>><span><?php the_title(); ?></span>
                </div>
            </div>
            <div class="layui-col-md2 <?php get_self_adaption_css()?>">
                <?php get_search_obj(); ?>
            </div>
        </div>
    </div>
    <div class="layui-row content">
        <div class="layui-col-md2 sidebar <?php get_self_adaption_css() ?>">
            <?php get_sidebar(); ?>
        </div>
        <div class="layui-col-md10 post-content">
            <div class="post-content-content">
                <?php the_content(); ?> <!-- 文章内容（包含图片） -->
            </div>
        </div>
    </div>
</div>

<!-- 图片查看器弹窗（动态显示） -->
<div class="img-viewer-modal">
    <span class="close-btn">&times;</span>
    <span class="nav-btn prev-btn">&#10094;</span>
    <img class="viewer-img" src="" alt="大图预览">
    <span class="nav-btn next-btn">&#10095;</span>
    <div class="counter">1/0</div>
</div>

<!-- 图片查看功能脚本 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 获取页面中所有图片
    const images = document.querySelectorAll('.post-content-content img');
    const imageUrls = Array.from(images).map(img => img.src); // 收集所有图片地址
    const modal = document.querySelector('.img-viewer-modal');
    const viewerImg = document.querySelector('.viewer-img');
    const closeBtn = document.querySelector('.close-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const counter = document.querySelector('.counter');
    let currentIndex = 0;

    // 给所有图片添加点击事件（点击放大）
    images.forEach((img, index) => {
        img.style.cursor = 'zoom-in'; // 鼠标悬停显示放大图标
        img.addEventListener('click', () => {
            currentIndex = index;
            viewerImg.src = imageUrls[index];
            updateCounter();
            modal.style.display = 'flex'; // 显示弹窗
            document.body.style.overflow = 'hidden'; // 禁止背景滚动
        });
    });

    // 关闭弹窗
    closeBtn.addEventListener('click', closeModal);
    // 点击弹窗背景关闭
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    // ESC键关闭
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });

    // 上一张（左箭头）
    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + imageUrls.length) % imageUrls.length;
        viewerImg.src = imageUrls[currentIndex];
        updateCounter();
    });

    // 下一张（右箭头）
    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % imageUrls.length;
        viewerImg.src = imageUrls[currentIndex];
        updateCounter();
    });

    // 左右方向键切换图片
    document.addEventListener('keydown', (e) => {
        if (modal.style.display !== 'flex') return;
        if (e.key === 'ArrowLeft') {
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            nextBtn.click();
        }
    });

    // 更新图片计数（如 2/5）
    function updateCounter() {
        counter.textContent = `${currentIndex + 1}/${imageUrls.length}`;
    }

    // 关闭弹窗并恢复背景滚动
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
});
</script>

<?php get_footer() ?>
<?php wp_footer(); ?>
</body>
</html>