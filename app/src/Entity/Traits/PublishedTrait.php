<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait PublishedTrait
 * @package App\Entity\Traits
 *
 *
 * Use title field in the entity that is going to use this trait
 */

trait PublishedTrait
{
    /**
     * @var \DateTime $published
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field="type.title", value="Published")
     *
     * or for example
     * @Gedmo\Timestampable(on="change", field="type.title", value={"Published", "Closed"})
     */
    private $published;
}