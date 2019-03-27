<?php

namespace App\Entity;

//LabelHistoryRepository

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
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
    use BlameableEntity;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $distributionLabel;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $contactReceived;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $transferSheetReceived;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $approvalRequested;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $logoApproved;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $informationAccepted;


    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $labelApproved;

    /**
     * @return mixed
     */
    public function getDistributionLabel()
    {
        return $this->distributionLabel;
    }

    /**
     * @param $distributionLabel
     * @return LabelHistory
     */
    public function setDistributionLabel(bool $distributionLabel): self
    {
        $this->distributionLabel = $distributionLabel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactReceived()
    {
        return $this->contactReceived;
    }

    /**
     * @param bool $contactReceived
     * @return LabelHistory
     */
    public function setContactReceived(bool $contactReceived): self
    {
        $this->contactReceived = $contactReceived;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransferSheetReceived()
    {
        return $this->transferSheetReceived;
    }

    /**
     * @param bool $transferSheetReceived
     * @return LabelHistory
     */
    public function setTransferSheetReceived(bool $transferSheetReceived): self
    {
        $this->transferSheetReceived = $transferSheetReceived;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApprovalRequested()
    {
        return $this->approvalRequested;
    }

    /**
     * @param bool $approvalRequested
     * @return LabelHistory
     */
    public function setApprovalRequested(bool $approvalRequested): self
    {
        $this->approvalRequested = $approvalRequested;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogoApproved()
    {
        return $this->logoApproved;
    }

    /**
     * @param bool $logoApproved
     * @return LabelHistory
     */
    public function setLogoApproved(bool $logoApproved): self
    {
        $this->logoApproved = $logoApproved;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInformationAccepted()
    {
        return $this->informationAccepted;
    }

    /**
     * @param bool $informationAccepted
     * @return LabelHistory
     */
    public function setInformationAccepted(bool $informationAccepted): self
    {
        $this->informationAccepted = $informationAccepted;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelApproved()
    {
        return $this->labelApproved;
    }

    /**
     * @param bool $labelApproved
     * @return LabelHistory
     */
    public function setLabelApproved(bool $labelApproved): self
    {
        $this->labelApproved = $labelApproved;

        return $this;
    }



}