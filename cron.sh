#clear api cache at moring & 603 update at 20
0 20 * * * weget -O - https://api.bce2.yongbuzhixi.com/lyapi/cc >/dev/null 2>&1
0 1 * * * wget -O - https://api.bce2.yongbuzhixi.com/lyapi/cc  >/dev/null 2>&1
0 5 * * * wget -O - https://api.bce2.yongbuzhixi.com/lyapi/cc  >/dev/null 2>&1