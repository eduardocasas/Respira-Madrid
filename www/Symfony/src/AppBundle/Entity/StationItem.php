<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StationItem.
 *
 * @ORM\Table(name="station_item", uniqueConstraints={@ORM\UniqueConstraint(name="rel", columns={"station_id", "item_id"})}, indexes={@ORM\Index(name="fk_rel_item", columns={"item_id"}), @ORM\Index(name="IDX_F128022321BDB235", columns={"station_id"})})
 * @ORM\Entity
 */
class StationItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     */
    private $item;

    /**
     * @var \Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="station_id", referencedColumnName="id")
     * })
     */
    private $station;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set item.
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return StationItem
     */
    public function setItem(\AppBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set station.
     *
     * @param \AppBundle\Entity\Station $station
     *
     * @return StationItem
     */
    public function setStation(\AppBundle\Entity\Station $station = null)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station.
     *
     * @return \AppBundle\Entity\Station
     */
    public function getStation()
    {
        return $this->station;
    }
}
