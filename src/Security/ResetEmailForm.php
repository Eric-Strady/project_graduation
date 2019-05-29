<?php

namespace App\Security;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ResetEmailForm 
{
    /**
     * @SecurityAssert\UserPassword)
     */
    private $old_password;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $new_email;



    public function getOldPassword(): ?string
    {
        return $this->old_password;
    }

    public function setOldPassword(string $old_password): self
    {
        $this->old_password = $old_password;

        return $this;
    }

    public function getNewEmail(): ?string
    {
        return $this->new_email;
    }

    public function setNewEmail(string $new_email): self
    {
        $this->new_email = $new_email;

        return $this;
    }
}