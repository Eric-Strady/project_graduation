<?php

namespace App\Security;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ResetPasswordForm 
{
    /**
     * @SecurityAssert\UserPassword)
     */
    private $old_password;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})/")
     */
    private $new_password;

    /**
     * @Assert\NotBlank
     */
    private $new_confirm_password;

    public function getOldPassword(): ?string
    {
        return $this->old_password;
    }

    public function setOldPassword(string $old_password): self
    {
        $this->old_password = $old_password;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->new_password;
    }

    public function setNewPassword(string $new_password): self
    {
        $this->new_password = $new_password;

        return $this;
    }

    public function getNewConfirmPassword(): ?string
    {
        return $this->new_confirm_password;
    }

    public function setNewConfirmPassword(string $new_confirm_password): self
    {
        $this->new_confirm_password = $new_confirm_password;

        return $this;
    }
}