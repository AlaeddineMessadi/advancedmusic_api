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
class LabelHistory
{
    use IdTrait;
    use TimestampTrait;


}