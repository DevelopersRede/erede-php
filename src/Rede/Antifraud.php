<?php

namespace Rede;

class Antifraud
{
    use CreateTrait;

    /**
     * @var string
     */
    private $recommendation;

    /**
     * @var string
     */
    private $riskLevel;

    /**
     * @var int
     */
    private $score;

    /**
     * @var bool
     */
    private $success = false;

    /**
     * @return string
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }

    /**
     * @param string $recommendation
     *
     * @return Antifraud
     */
    public function setRecommendation($recommendation)
    {
        $this->recommendation = $recommendation;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRiskLevel()
    {
        return $this->riskLevel;
    }

    /**
     * @param string $riskLevel
     *
     * @return Antifraud
     */
    public function setRiskLevel($riskLevel)
    {
        $this->riskLevel = $riskLevel;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     *
     * @return Antifraud
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return Antifraud
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }
}