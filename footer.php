<footer>
    <p>Copyright © 2020~<?php echo date('Y'); ?> 
       <a href=""><?php echo bloginfo('name'); ?></a>.
       Theme made by <a href="http://www.lovestu.com/Win10explorer">Win10explorer</a>
    </p>
    <a href="https://beian.miit.gov.cn">粤ICP备20047854号</a>
    <br>
    <span id="runtime_span"></span>
    <?php
    /* 修复并优化访问量统计代码 */
    // 定义计数器文件和访问记录记录文件路径（服务器根目录）
    $counterFile = $_SERVER['DOCUMENT_ROOT'] . "/counter.txt";
    $visitLogFile = $_SERVER['DOCUMENT_ROOT'] . "/visit_loglog.csv"; // 改为CSV文件
    $ipRecordFile = $_SERVER['DOCUMENT_ROOT'] . "/ip_record.txt"; // IP访问记录
    
    // 获取客户端IP
    $ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "未知IP";
    
    // 当前时间 UTC+8
    $now = gmdate("Y-m-d H:i:s", time() + 8 * 3600);
    
    // 读取已有的IP记录
    $ipRecords = array();
    if (file_exists($ipRecordFile)) {
        $fp = fopen($ipRecordFile, "r");
        if ($fp) {
            flock($fp, LOCK_SH);
            while (($line = fgets($fp)) !== false) {
                $line = trim($line);
                if (!empty($line)) {
                    list($recordIp, $recordTime) = explode(",", $line);
                    $ipRecords[$recordIp] = $recordTime;
                }
            }
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    
    // 判断是否超过30分钟
    $isNewVisit = false;
    if (!isset($ipRecords[$ip]) || (strtotime($now) - strtotime($ipRecords[$ip]) > 1800)) {
        $isNewVisit = true;
        $ipRecords[$ip] = $now;
    }
    
    // 写入更新后的IP记录
    $fp = fopen($ipRecordFile, "w");
    if ($fp) {
        flock($fp, LOCK_EX);
        foreach ($ipRecords as $recordIp => $recordTime) {
            fwrite($fp, $recordIp . "," . $recordTime . "\n");
        }
        flock($fp, LOCK_UN);
        fclose($fp);
    }
    
    // 增加总访问量
    if ($isNewVisit) {
        $fp = fopen($counterFile, "a+");
        if ($fp) {
            flock($fp, LOCK_EX);
            fseek($fp, 0);
            $num = trim(fgets($fp, 10));
            $num = $num ? intval($num) : 0;
            $num += 1;
            ftruncate($fp, 0);
            fwrite($fp, $num);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    
    // 写入访问日志
    if ($isNewVisit) {
        $logEntry = "\"{$now}\",\"{$ip}\"" . PHP_EOL;
        $logFp = fopen($visitLogFile, "a+");
        if ($logFp) {
            flock($logFp, LOCK_EX);
            if (filesize($visitLogFile) == 0) {
                fwrite($logFp, "访问时间,IP地址" . PHP_EOL);
            }
            fwrite($logFp, $logEntry);
            flock($logFp, LOCK_UN);
            fclose($logFp);
        }
    }
    
    // 输出信息
    $fp = fopen($counterFile, "r");
    if ($fp) {
        flock($fp, LOCK_SH);
        $num = trim(fgets($fp, 10));
        $num = $num ? intval($num) : 0;
        flock($fp, LOCK_UN);
        fclose($fp);
    } else {
        $num = 0;
    }
    
    $ipLink = '<a href="https://www.bing.com/search?q=' . htmlspecialchars($ip) . '" style="text-decoration: none; color: inherit;">' . htmlspecialchars($ip) . '</a>';
    echo '<br><span style="font-size: 0.9em;">您是第 ' . $num . ' 位访客（Post-27 Dec 2025），您的IP是：[' . $ipLink . ']</span>';
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