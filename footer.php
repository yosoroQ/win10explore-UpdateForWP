<footer>
    <p>Copyright © 2020~2026 <a href=""> <?php echo bloginfo('name')?> </a>.
       Theme  made by <a href="http://www.lovestu.com/Win10explorer">Win10explorer</a></p>
    <a href="https://beian.miit.gov.cn">粤ICP备20047854号</a>
    <br>
    <span id="runtime_span"></span>
    <?php
    /* 修复并优化访问量统计代码 */
    // 定义计数器文件路径
    $counterFile = "counter.txt";
    
       // 安全打开文件（添加文件锁防止并发问题）
       $fp = fopen($counterFile, "a+");
       if ($fp) {
           // 获取排他锁，确保数据写入安全
           flock($fp, LOCK_EX);
           
           // 将文件指针移到开头，确保能读取到完整数据
           fseek($fp, 0);
           
           // 获取IP地址（增加安全过滤）
           $address = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "未知IP"; 
           
           // 读取访问量（处理空文件情况）
           $num = trim(fgets($fp, 10)); // 增加读取长度，去除空白字符
           $num = $num ? intval($num) : 0; // 处理空文件或非数字内容
           $num += 1; // 访问量+1
           
           // 输出访客信息（整合到footer中）
   
           // 输出访客信息（整合到footer中）
           echo '<br><span style="font-size: 0.9em;">您是第 ' . $num . ' 位访客（Post-27 Dec 2025），您的IP是:[' . $address . ']</span>';
           
           // 清空文件并写入新数值
           ftruncate($fp, 0); // 清空文件内容
           fwrite($fp, $num); // 写入新的访问量
           flock($fp, LOCK_UN); // 释放锁
           fclose($fp); // 关闭文件
       } else {
           echo '<br><span style="color: red;">访问量统计文件创建失败</span>';
       }
       ?>
<script type="text/javascript">
function show_runtime(){
    window.setTimeout("show_runtime()",1000); // 每秒刷新一次
    // 网站启动时间（保持原时间：2020年5月25日15:00:00）
    var startDate = new Date("5/25/2020 15:00:00");
    var nowDate = new Date(); // 当前时间
    var timeDiff = nowDate.getTime() - startDate.getTime(); // 时间差（毫秒）

    // 计算时间单位（1年按365天计算，1天=24小时，1小时=60分，1分=60秒）
    var yearMs = 365 * 24 * 60 * 60 * 1000; // 1年的毫秒数
    var dayMs = 24 * 60 * 60 * 1000; // 1天的毫秒数
    var hourMs = 60 * 60 * 1000; // 1小时的毫秒数
    var minuteMs = 60 * 1000; // 1分钟的毫秒数

    // 计算年、天、小时、分、秒（X+年：取整数年并加“+”，其他单位取整数）
    var X = Math.floor(timeDiff / yearMs); // 年数（整数）
    var remainingMsAfterYear = timeDiff % yearMs; // 扣除年后剩余的毫秒数
    
    var A = Math.floor(remainingMsAfterYear / dayMs); // 天数（整数）
    var remainingMsAfterDay = remainingMsAfterYear % dayMs; // 扣除天后剩余的毫秒数
    
    var B = Math.floor(remainingMsAfterDay / hourMs); // 小时数（整数）
    var remainingMsAfterHour = remainingMsAfterDay % hourMs; // 扣除小时后剩余的毫秒数
    
    var C = Math.floor(remainingMsAfterHour / minuteMs); // 分钟数（整数）
    var D = Math.floor((remainingMsAfterHour % minuteMs) / 1000); // 秒数（整数）

    // 拼接成目标格式：本站勉强运行: X+年A天B小时C分D秒
    document.getElementById("runtime_span").innerHTML = 
        "本站勉强运行: " + X + "年" + A + "天" + B + "小时" + C + "分" + D + "秒";
}
// 页面加载时启动计时
show_runtime();
</script>
</footer>
<?php