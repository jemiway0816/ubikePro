#!/bin/bash

while true; do
    # 取得目前的時間 (小時和分鐘)
    current_time=$(date +"%H:%M")

    # 檢查是否在 18:00 到 21:00 之間
    if [[ "$current_time" > "18:00" && "$current_time" < "21:00" ]]; then

        rm /share/Web/ubike/carData.json
        # 執行你的程式
        /mnt/ext/opt/PHP7.4/bin/php7.4 /share/Web/ubike/readCarByTDX.php
    fi

    # 等待 5 分鐘
    sleep 300
done
