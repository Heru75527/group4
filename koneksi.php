<?php
$conn = mysqli_connect("localhost", "root", "", "group4");
if (!$conn) {
    die("<div style='color:white; background:#ff4757; padding:20px; border-radius:10px;'>
            <strong>System Error:</strong> Database 'group4' tidak terdeteksi.
         </div>");
}
?>