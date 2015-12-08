<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Records
 *
 * @ORM\Table(name="records", indexes={@ORM\Index(name="fk_technique", columns={"technique_id"}), @ORM\Index(name="fk_station_item", columns={"station_item_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RecordsRepository")
 */
class Records
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="value_00", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value00;

    /**
     * @var string
     *
     * @ORM\Column(name="value_01", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value01;

    /**
     * @var string
     *
     * @ORM\Column(name="value_02", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value02;

    /**
     * @var string
     *
     * @ORM\Column(name="value_03", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value03;

    /**
     * @var string
     *
     * @ORM\Column(name="value_04", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value04;

    /**
     * @var string
     *
     * @ORM\Column(name="value_05", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value05;

    /**
     * @var string
     *
     * @ORM\Column(name="value_06", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value06;

    /**
     * @var string
     *
     * @ORM\Column(name="value_07", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value07;

    /**
     * @var string
     *
     * @ORM\Column(name="value_08", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value08;

    /**
     * @var string
     *
     * @ORM\Column(name="value_09", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value09;

    /**
     * @var string
     *
     * @ORM\Column(name="value_10", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value10;

    /**
     * @var string
     *
     * @ORM\Column(name="value_11", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value11;

    /**
     * @var string
     *
     * @ORM\Column(name="value_12", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value12;

    /**
     * @var string
     *
     * @ORM\Column(name="value_13", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value13;

    /**
     * @var string
     *
     * @ORM\Column(name="value_14", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value14;

    /**
     * @var string
     *
     * @ORM\Column(name="value_15", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value15;

    /**
     * @var string
     *
     * @ORM\Column(name="value_16", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value16;

    /**
     * @var string
     *
     * @ORM\Column(name="value_17", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value17;
    /**
     * @var string
     *
     * @ORM\Column(name="value_18", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value18;

    /**
     * @var string
     *
     * @ORM\Column(name="value_19", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value19;

    /**
     * @var string
     *
     * @ORM\Column(name="value_20", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value20;

    /**
     * @var string
     *
     * @ORM\Column(name="value_21", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value21;

    /**
     * @var string
     *
     * @ORM\Column(name="value_22", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value22;

    /**
     * @var string
     *
     * @ORM\Column(name="value_23", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $value23;

    /**
     * @var \StationItem
     *
     * @ORM\ManyToOne(targetEntity="StationItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="station_item_id", referencedColumnName="id")
     * })
     */
    private $stationItem;

    /**
     * @var \Technique
     *
     * @ORM\ManyToOne(targetEntity="Technique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="technique_id", referencedColumnName="id")
     * })
     */
    private $technique;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Records
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set value00
     *
     * @param string $value00
     *
     * @return Records
     */
    public function setValue00($value00)
    {
        $this->value00 = $value00;

        return $this;
    }

    /**
     * Get value00
     *
     * @return string
     */
    public function getValue00()
    {
        return $this->value00;
    }

    /**
     * Set value01
     *
     * @param string $value01
     *
     * @return Records
     */
    public function setValue01($value01)
    {
        $this->value01 = $value01;

        return $this;
    }

    /**
     * Get value01
     *
     * @return string
     */
    public function getValue01()
    {
        return $this->value01;
    }

    /**
     * Set value02
     *
     * @param string $value02
     *
     * @return Records
     */
    public function setValue02($value02)
    {
        $this->value02 = $value02;

        return $this;
    }

    /**
     * Get value02
     *
     * @return string
     */
    public function getValue02()
    {
        return $this->value02;
    }

    /**
     * Set value03
     *
     * @param string $value03
     *
     * @return Records
     */
    public function setValue03($value03)
    {
        $this->value03 = $value03;

        return $this;
    }

    /**
     * Get value03
     *
     * @return string
     */
    public function getValue03()
    {
        return $this->value03;
    }

    /**
     * Set value04
     *
     * @param string $value04
     *
     * @return Records
     */
    public function setValue04($value04)
    {
        $this->value04 = $value04;

        return $this;
    }

    /**
     * Get value04
     *
     * @return string
     */
    public function getValue04()
    {
        return $this->value04;
    }

    /**
     * Set value05
     *
     * @param string $value05
     *
     * @return Records
     */
    public function setValue05($value05)
    {
        $this->value05 = $value05;

        return $this;
    }

    /**
     * Get value05
     *
     * @return string
     */
    public function getValue05()
    {
        return $this->value05;
    }

    /**
     * Set value06
     *
     * @param string $value06
     *
     * @return Records
     */
    public function setValue06($value06)
    {
        $this->value06 = $value06;

        return $this;
    }

    /**
     * Get value06
     *
     * @return string
     */
    public function getValue06()
    {
        return $this->value06;
    }

    /**
     * Set value07
     *
     * @param string $value07
     *
     * @return Records
     */
    public function setValue07($value07)
    {
        $this->value07 = $value07;

        return $this;
    }

    /**
     * Get value07
     *
     * @return string
     */
    public function getValue07()
    {
        return $this->value07;
    }

    /**
     * Set value08
     *
     * @param string $value08
     *
     * @return Records
     */
    public function setValue08($value08)
    {
        $this->value08 = $value08;

        return $this;
    }

    /**
     * Get value08
     *
     * @return string
     */
    public function getValue08()
    {
        return $this->value08;
    }

    /**
     * Set value09
     *
     * @param string $value09
     *
     * @return Records
     */
    public function setValue09($value09)
    {
        $this->value09 = $value09;

        return $this;
    }

    /**
     * Get value09
     *
     * @return string
     */
    public function getValue09()
    {
        return $this->value09;
    }

    /**
     * Set value10
     *
     * @param string $value10
     *
     * @return Records
     */
    public function setValue10($value10)
    {
        $this->value10 = $value10;

        return $this;
    }

    /**
     * Get value10
     *
     * @return string
     */
    public function getValue10()
    {
        return $this->value10;
    }

    /**
     * Set value11
     *
     * @param string $value11
     *
     * @return Records
     */
    public function setValue11($value11)
    {
        $this->value11 = $value11;

        return $this;
    }

    /**
     * Get value11
     *
     * @return string
     */
    public function getValue11()
    {
        return $this->value11;
    }

    /**
     * Set value12
     *
     * @param string $value12
     *
     * @return Records
     */
    public function setValue12($value12)
    {
        $this->value12 = $value12;

        return $this;
    }

    /**
     * Get value12
     *
     * @return string
     */
    public function getValue12()
    {
        return $this->value12;
    }

    /**
     * Set value13
     *
     * @param string $value13
     *
     * @return Records
     */
    public function setValue13($value13)
    {
        $this->value13 = $value13;

        return $this;
    }

    /**
     * Get value13
     *
     * @return string
     */
    public function getValue13()
    {
        return $this->value13;
    }

    /**
     * Set value14
     *
     * @param string $value14
     *
     * @return Records
     */
    public function setValue14($value14)
    {
        $this->value14 = $value14;

        return $this;
    }

    /**
     * Get value14
     *
     * @return string
     */
    public function getValue14()
    {
        return $this->value14;
    }

    /**
     * Set value15
     *
     * @param string $value15
     *
     * @return Records
     */
    public function setValue15($value15)
    {
        $this->value15 = $value15;

        return $this;
    }

    /**
     * Get value15
     *
     * @return string
     */
    public function getValue15()
    {
        return $this->value15;
    }

    /**
     * Set value16
     *
     * @param string $value16
     *
     * @return Records
     */
    public function setValue16($value16)
    {
        $this->value16 = $value16;

        return $this;
    }

    /**
     * Get value16
     *
     * @return string
     */
    public function getValue16()
    {
        return $this->value16;
    }

    /**
     * Set value17
     *
     * @param string $value17
     *
     * @return Records
     */
    public function setValue17($value17)
    {
        $this->value17 = $value17;

        return $this;
    }

    /**
     * Get value17
     *
     * @return string
     */
    public function getValue17()
    {
        return $this->value17;
    }

    /**
     * Set value18
     *
     * @param string $value18
     *
     * @return Records
     */
    public function setValue18($value18)
    {
        $this->value18 = $value18;

        return $this;
    }

    /**
     * Get value18
     *
     * @return string
     */
    public function getValue18()
    {
        return $this->value18;
    }

    /**
     * Set value19
     *
     * @param string $value19
     *
     * @return Records
     */
    public function setValue19($value19)
    {
        $this->value19 = $value19;

        return $this;
    }

    /**
     * Get value19
     *
     * @return string
     */
    public function getValue19()
    {
        return $this->value19;
    }

    /**
     * Set value20
     *
     * @param string $value20
     *
     * @return Records
     */
    public function setValue20($value20)
    {
        $this->value20 = $value20;

        return $this;
    }

    /**
     * Get value20
     *
     * @return string
     */
    public function getValue20()
    {
        return $this->value20;
    }

    /**
     * Set value21
     *
     * @param string $value21
     *
     * @return Records
     */
    public function setValue21($value21)
    {
        $this->value21 = $value21;

        return $this;
    }

    /**
     * Get value21
     *
     * @return string
     */
    public function getValue21()
    {
        return $this->value21;
    }

    /**
     * Set value22
     *
     * @param string $value22
     *
     * @return Records
     */
    public function setValue22($value22)
    {
        $this->value22 = $value22;

        return $this;
    }

    /**
     * Get value22
     *
     * @return string
     */
    public function getValue22()
    {
        return $this->value22;
    }

    /**
     * Set value23
     *
     * @param string $value23
     *
     * @return Records
     */
    public function setValue23($value23)
    {
        $this->value23 = $value23;

        return $this;
    }

    /**
     * Get value23
     *
     * @return string
     */
    public function getValue23()
    {
        return $this->value23;
    }

    /**
     * Set stationItem
     *
     * @param \AppBundle\Entity\StationItem $stationItem
     *
     * @return Records
     */
    public function setStationItem(\AppBundle\Entity\StationItem $stationItem = null)
    {
        $this->stationItem = $stationItem;

        return $this;
    }

    /**
     * Get stationItem
     *
     * @return \AppBundle\Entity\StationItem
     */
    public function getStationItem()
    {
        return $this->stationItem;
    }

    /**
     * Set technique
     *
     * @param \AppBundle\Entity\Technique $technique
     *
     * @return Records
     */
    public function setTechnique(\AppBundle\Entity\Technique $technique = null)
    {
        $this->technique = $technique;

        return $this;
    }

    /**
     * Get technique
     *
     * @return \AppBundle\Entity\Technique
     */
    public function getTechnique()
    {
        return $this->technique;
    }
}
