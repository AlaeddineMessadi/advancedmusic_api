<?php

namespace App\Entity;

//LabelHistoryRepository

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LabelHistory
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\LabelHistoryRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Gedmo\Loggable()
 */
class Logos
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @var Files
     */
    private $logoBig;

    /**
     * @var Files
     */
    private $logoMedium;

    /**
     * @var Files
     */
    private $logoSmall;




    /*********** Relations ***********/

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Label", mappedBy="logos")
     * @Groups({"read"})
     */
    private $label;

    /*** ************************* **/


    /**
     * @return Files
     */
    public function getLogoBig(): Files
    {
        return $this->logoBig;
    }

    /**
     * @param Files $logoBig
     */
    public function setLogoBig(Files $logoBig): void
    {
        $this->logoBig = $logoBig;
    }

    /**
     * @return Files
     */
    public function getLogoMedium(): Files
    {
        return $this->logoMedium;
    }

    /**
     * @param Files $logoMedium
     */
    public function setLogoMedium(Files $logoMedium): void
    {
        $this->logoMedium = $logoMedium;
    }

    /**
     * @return Files
     */
    public function getLogoSmall(): Files
    {
        return $this->logoSmall;
    }

    /**
     * @param Files $logoSmall
     */
    public function setLogoSmall(Files $logoSmall): void
    {
        $this->logoSmall = $logoSmall;
    }



}