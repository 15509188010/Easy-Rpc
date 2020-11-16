<?php
namespace App\HttpController;

use App\Services\EwsUserService;
use EasySwoole\FastCache\Cache;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Spider\SpiderClient;

/**
 * Description:
 * Class UserController
 * @package App\HttpController
 */
class UserController extends Controller
{
    /**
     * @var EwsUserService
     */
    private $objEwsUserService;

    public function __construct()
    {
        parent::__construct();
        $this->objEwsUserService = new EwsUserService();
    }

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/28
     * Time: 11:23 上午
     */
    public function login()
    {
        $params = $this->json();
        $data = [
            'user_name' => isset($params['user_name']) ? $params['user_name'] : null,
            'password'  => isset($params['password']) ? $params['password'] : null,
        ];
        foreach ($data as $key => $val){
            if (empty($val)){
               return parent::writeJson(ResponseCode::$noParams,'',$key.'参数错误');
            }
        }
    }
}