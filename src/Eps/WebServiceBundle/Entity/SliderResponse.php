<?php

namespace Eps\WebServiceBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\MaxDepth;


/**
 * SliderResponse
 *
 *
 * @ExclusionPolicy("all")
 */
class SliderResponse
{

    /**
     * @Expose
     * @Groups({"list"})
     */
    private $sliders;

    /**
     * Set sliders
     *
     * @param array $sliders
     */
    public function setSliders($sliders)
    {
        $this->sliders = $sliders;
    }
    /**
     * Get sliders
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSliders()
    {
        return $this->sliders;
    }
}