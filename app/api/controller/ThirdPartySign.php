<?php
declare (strict_types=1);

namespace app\api\controller;

use app\api\library\AutoSign;
use app\common\controller\Api;

class ThirdPartySign extends Api
{
    public function index(){
        echo "欢迎使用~";
    }

    /**
     * 百货杂铺自动签到
     * @link http://localhost:8000/index.php/api/thirdPartySign/hangSign
     * @return void
     */
    public function hangSign(){
        $hangIndex = new \app\api\library\hangSign\Index();
        $hangIndex->sign();
    }

    /**
     * 掘金自动签到、抽奖、抽幸运值
     * @link http://localhost:8000/index.php/api/thirdPartySign/jjAuto
     * @return void
     */
    public function jjAuto(){
        $jjIndex = new \app\api\library\jjSign\Index();
        /* 签到 */
        $res['sign'] = $jjIndex->sign();

        /* 沾福气 */
        $res['lucky'] = $jjIndex->lucky();
        /* 抽奖 */
        $res['lottery'] = $jjIndex->lottery();
        exit(json_encode($res, JSON_UNESCAPED_UNICODE));
    }
}