<?php
/**
 * Created by PhpStorm.
 * User: alaeddine
 * Date: 05.03.19
 * Time: 14:07
 *
 * https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/ip_traceable.md
 */

namespace App\Entity\Traits;


trait IpTraceableTrait
{
    /**
     * @var string $createdFromIp
     *
     * @Gedmo\IpTraceable(on="create")
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $createdFromIp;

    /**
     * @var string $updatedFromIp
     *
     * @Gedmo\IpTraceable(on="update")
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $updatedFromIp;


    public function getCreatedFromIp()
    {
        return $this->createdFromIp;
    }

    public function getUpdatedFromIp()
    {
        return $this->updatedFromIp;
    }
}