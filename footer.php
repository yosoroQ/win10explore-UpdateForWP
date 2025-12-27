<footer>
    <p>Copyright © 2020~2026 <a href=""> <?php echo bloginfo('name')?> </a>.
       Theme  made by <a href="http://www.lovestu.com/Win10explorer">Win10explorer</a></p>
    <a href="https://beian.miit.gov.cn">粤ICP备20047854号</a>
    <br>
    <span id="runtime_span"></span>
    <?php
    /* 修复并优化访问量统计代码 */
    // 定义计数器文件和访问记录记录文件路径（服务器根目录）
    $counterFile = $_SERVER['DOCUMENT_ROOT'] . "/counter.txt";
    $visitLogFile = $_SERVER['DOCUMENT_ROOT'] . "/visit_loglog.csv"; // 改为CSV文件
    
    // 安全获取IP地址
    $ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "未知IP";
    
    // 记录访问日志（CSV格式，日期和IP分列）
    $visitTime = date("Y-m-d H:i:s");
    // CSV格式处理：使用逗号分隔列，为防止包含特殊字符，用双引号包裹字段
    $logEntry = "\"{$visitTime}\",\"{$ip}\"" . PHP_EOL;
    
    // 写入访问日志（追加模式）
    $logFp = fopen($visitLogFile, "a+");
    if ($logFp) {
        flock($logFp, LOCK_EX);
        // 首次写入时添加CSV表头
        if (filesize($visitLogFile) == 0) {
            fwrite($logFp, "访问时间,IP地址" . PHP_EOL);
        }
        fwrite($logFp, $logEntry);
        flock($logFp, LOCK_UN);
        fclose($logFp);
    }

    // 统计总访问量
    $fp = fopen($counterFile, "a+");
    if ($fp) {
        flock($fp, LOCK_EX);
        fseek($fp, 0);
        $num = trim(fgets($fp, 10));
        $num = $num ? intval($num) : 0;
        $num += 1;
        
        // IP地址添加超链接到Bing搜索，使用样式消除链接突显效果
        $ipLink = '<a href="https://www.bing.com/search?q=' . htmlspecialchars($ip) . '" style="text-decoration: none; color: inherit;">' . htmlspecialchars($ip) . '</a>';
        echo '<br><span style="font-size: 0.9em;">您是第 ' . $num . ' 位访客（Post-27 Dec 2025），您的IP是：[' . $ipLink . ']</span>';
        
        ftruncate($fp, 0);
        fwrite($fp, $num);
        flock($fp, LOCK_UN);
        fclose($fp);
    } else {
        echo '<br><span style="color: red;">访问量统计文件创建失败</span>';
    }
    ?>
<script type="text/javascript">
function show_runtime(){
    window.setTimeout("show_runtime()",1000);
    var startDate = new Date("5/25/2020 15:00:00");
    var nowDate = new Date();
    var timeDiff = nowDate.getTime() - startDate.getTime();

    var yearMs = 365 * 24 * 60 * 60 * 1000;
    var dayMs = 24 * 60 * 60 * 1000;
    var hourMs = 60 * 60 * 1000;
    var minuteMs = 60 * 1000;

    var X = Math.floor(timeDiff / yearMs);
    var remainingMsAfterYear = timeDiff % yearMs;
    
    var A = Math.floor(remainingMsAfterYear / dayMs);
    var remainingMsAfterDay = remainingMsAfterYear % dayMs;
    
    var B = Math.floor(remainingMsAfterDay / hourMs);
    var remainingMsAfterHour = remainingMsAfterDay % hourMs;
    
    var C = Math.floor(remainingMsAfterHour / minuteMs);
    var D = Math.floor((remainingMsAfterHour % minuteMs) / 1000);

    document.getElementById("runtime_span").innerHTML = 
        "本站勉强运行: " + X + "年" + A + "天" + B + "小时" + C + "分" + D + "秒";
}
show_runtime();
</script>
</footer>
<?php