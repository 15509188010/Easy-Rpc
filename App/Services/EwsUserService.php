<?php
namespace App\Services;

use App\Utility\ServiceWrapper;
use EasySwoole\EasySwoole\Logger;
use EasySwoole\EasySwoole\Trigger;
use EasySwoole\Mysqli\Exception\Exception;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\ORM\Utility\Schema\Table;

/**
 * Description: 用户服务层接口
 * Class EwsUserService
 * @package App\Services
 */
class EwsUserService extends AbstractModel
{
    /**
     * @var string
     */
    protected $tableName = 'ews_user';

    // 都是非必选的，默认值看文档下面说明
    protected $autoTimeStamp = 'datetime';

    /**
     * @var string
     */
    protected $createTime = 'create_time';

    /**
     * @var string
     */
    protected $updateTime = 'update_time';

    /**
     * Doc: (des="表结构")
     * User: XMing
     * Date: 2020/9/27
     * Time: 6:08 下午
     * @param bool $isCache
     * @return Table
     */
    public function schemaInfo(bool $isCache = true): Table
    {
        $table = new Table($this->tableName);
        $table->colInt('id')->setIsPrimaryKey(true);
        $table->colVarChar('user_name', 50);
        $table->colVarChar('password',255);
        $table->colVarChar('avatar',255);
        $table->colDateTime('create_time');
        $table->colDateTime('update_time');
        return $table;
    }

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/27
     * Time: 6:44 下午
     * @param string $username
     * @return ServiceWrapper
     */
    public function getUserByUserName(string $username): ServiceWrapper
    {
        try {
            $user = $this->field('id,user_name,password,create_time')->get(['user_name' => $username]);
            $user = is_null($user) ? [] : $user->toArray();
            return ServiceWrapper::success($user);
        } catch (Exception $e) {
            Logger::getInstance()->error($e->getMessage());
            return ServiceWrapper::fail($e->getMessage(),500);
        } catch (\EasySwoole\ORM\Exception\Exception $e) {
            Logger::getInstance()->error($e->getMessage());
            return ServiceWrapper::fail($e->getMessage(),500);
        } catch (\Throwable $e) {
            Logger::getInstance()->error($e->getMessage());
            return ServiceWrapper::fail($e->getMessage(),500);
        }
    }
}