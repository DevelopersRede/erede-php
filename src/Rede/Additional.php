<?php
/**
 * Created by PhpStorm.
 * User: neto
 * Date: 08/04/19
 * Time: 12:07
 */

namespace Rede;


class Additional implements RedeSerializable
{
    use SerializeTrait;
    use CreateTrait;

    /**
     * @var integer
     */
    private $gateway;

    /**
     * @var integer
     */
    private $module;

    /**
     * @return int
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param int $gateway
     * @return Additional
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return int
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param int $module
     * @return Additional
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }
}