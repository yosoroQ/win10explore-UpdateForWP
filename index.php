<?php
include_once 'inc/obj.php';
get_header();
?>

<div class="layui-container" id="main">

    <div class="blog-title"><?php obj_title_icon();
        bloginfo('name'); ?>
        <div class="close"><a href="javascript:window.opener=null;window.open('','_self');window.close();"><i
                        class="layui-icon layui-icon-close"></i></a>
        </div>
    </div>

    <div class="toolbar">
        <div class="layui-row">
            <div class="obj_menu_header">
                <?php get_nav_menu_obj(); ?>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="layui-row">
            <div class="layui-col-md1 <?php get_self_adaption_css() ?>">
                <div class="toobar-col"><i class="fa fa-arrow-left" aria-hidden="true"
                                           onclick="javascript :history.back(-1)"></i>
                    <i class="fa fa-arrow-right" aria-hidden="true" onclick="javascript :history.forward()"></i><i
                            class="fa fa-arrow-up" aria-hidden="true" onclick="window.scrollTo(0,0)"></i></div>
            </div>
            <div class="layui-col-md9 layui-col-xs-12 layui-col-sm-12">
                <div class="toolbar-url"><img class="toobar-icon" src="<?php echo getImgDir('folder.ico') ?>"
                                              alt=""><span><a
                                href="https://mxzfun.com">本网站</a></span>><span>最新文章</span>
                </div>
            </div>
            <div class="layui-col-md2 <?php get_self_adaption_css() ?>">
                <?php get_search_obj(); ?>
            </div>
        </div>

    </div>
    <div class="layui-row content">
        <div class="layui-col-md2 sidebar <?php get_self_adaption_css() ?>">
            <?php get_sidebar(); ?>
        </div>
        <div class="layui-col-md10 postlist">
            <?php default_post(); ?>

            <!-- 优化后的分页区域，下拉框只显示页码数字 -->
            <div class="posts-nav" style="margin-top:10px; text-align:center; padding:5px 0;">
                <?php 
                // 获取当前页码
                $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
                // 获取总页数
                global $wp_query;
                $total_pages = $wp_query->max_num_pages;
                ?>
            
                <?php posts_nav_link(' <b>繚乱！ビクトリーロード</b> '); ?>

                <!-- 下拉框只显示页码数字 -->
                <div style="display:inline-flex; align-items:center; gap:5px; margin-left:10px;">
                    <span>跳转至：</span>
                    <select id="pageSelect" 
                            style="width:60px; padding:3px; border:1px solid #ddd; border-radius:3px; font-size:14px;"
                            onchange="jumpToPage()">
                        <?php 
                        // 生成页码选项，只显示页码数字
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $selected = ($i == $current_page) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <!-- 缩小元素间间距 -->
                <!-- <div style="display:inline-flex; align-items:center; gap:5px; margin-left:10px;">
                    <span>跳转至：</span>
                    <input type="number" id="targetPage" min="1" placeholder="页码" 
                           style="width:50px; padding:3px; border:1px solid #ddd; border-radius:3px; font-size:14px;">
                    <button onclick="jumpToPage()" 
                            style="padding:3px 8px; border:none; background:#009688; color:#fff; border-radius:3px; cursor:pointer; font-size:14px;">
                        确认
                    </button>
                </div> -->
            </div>
        </div>
    </div>

</div>

<script>
// 原有跳转页面函数（保留不变）
// 跳转页面函数
function jumpToPage() {
    const selectElement = document.getElementById('pageSelect');
    const targetPage = parseInt(selectElement.value);
    const currentUrl = window.location.href;
    let baseUrl = currentUrl;

    if (currentUrl.includes('?paged=')) {
        baseUrl = currentUrl.replace(/\?paged=\d+/, '');
    } else if (currentUrl.includes('&paged=')) {
        baseUrl = currentUrl.replace(/&paged=\d+/, '');
    }

    if (isNaN(targetPage) || targetPage < 1 || targetPage > <?php echo $total_pages; ?>) {
        alert('请选择有效的页码！');
        return;
    }

    const jumpUrl = baseUrl.includes('?') ? `${baseUrl}&paged=${targetPage}` : `${baseUrl}?paged=${targetPage}`;
    window.location.href = jumpUrl;
}

// 新增：“就不关”弹窗核心逻辑（无需改原有HTML）
document.addEventListener('DOMContentLoaded', function() {
    // 1. 获取关闭按钮（匹配原有.close类下的a标签）
    const closeBtn = document.querySelector('.close a');
    if (!closeBtn) return; // 若按钮不存在，避免报错

    // 2. 移除原关闭页面功能（阻止点击关闭窗口）
    closeBtn.addEventListener('click', function(e) {
        e.preventDefault(); // 取消原链接跳转/关闭行为
        e.stopPropagation(); // 防止事件冒泡
        console.log('就不关，哼　(。-`ω´-) 　');

        // 3. 动态创建“就不关”弹窗（首次点击时创建，避免初始冗余）
        let tipBox = document.getElementById('close-tip-box');
        if (!tipBox) {
            tipBox = document.createElement('div');
            tipBox.id = 'close-tip-box';
            tipBox.innerText = '就不关，哼　(。-`ω´-) 　';

            // 弹窗样式：固定在按钮下方，不影响原有布局
            Object.assign(tipBox.style, {
                position: 'absolute',
                top: '100%',
                right: '0',
                marginTop: '5px',
                padding: '4px 12px',
                background: '#333',
                color: '#fff',
                fontSize: '12px',
                borderRadius: '4px',
                whiteSpace: 'nowrap',
                opacity: '0',
                visibility: 'hidden',
                transition: 'opacity 0.3s ease, visibility 0.3s ease',
                zIndex: '9999'
            });
            // 给按钮父容器加相对定位，确保弹窗定位正确
            closeBtn.parentElement.style.position = 'relative';
            // 将弹窗插入按钮父容器（紧跟按钮后）
            closeBtn.parentElement.appendChild(tipBox);
        }

        // 4. 切换弹窗显示/隐藏
        const isShow = tipBox.style.visibility === 'visible';
        tipBox.style.opacity = isShow ? '0' : '1';
        tipBox.style.visibility = isShow ? 'hidden' : 'visible';
    });

    // 5. 点击页面其他区域，隐藏弹窗
    document.addEventListener('click', function() {
        const tipBox = document.getElementById('close-tip-box');
        if (tipBox) {
            tipBox.style.opacity = '0';
            tipBox.style.visibility = 'hidden';
        }
    });

    // 6. 鼠标移开按钮，延迟隐藏弹窗（优化体验）
    const closeBtnParent = document.querySelector('.close');
    if (closeBtnParent) {
        closeBtnParent.addEventListener('mouseleave', function() {
            const tipBox = document.getElementById('close-tip-box');
            if (tipBox) {
                setTimeout(() => {
                    tipBox.style.opacity = '0';
                    tipBox.style.visibility = 'hidden';
                }, 300);
            }
        });
    }
});
</script>



<?php get_footer() ?>
<?php wp_footer(); ?>


</body>
</html>