<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *      fields = {"username"},
 *      message="Ce nom d'utilisateur est déjà existant, veuillez en saisir un nouveau !",
 *      groups={"registration"}
 * )
 * @UniqueEntity(
 *      fields = {"email"},
 *      message="Cet email est déjà existant, veuillez en saisir un nouveau !",
 *      groups={"registration"}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min="2",
     *      minMessage="Votre mon d'utilisateur doit contenir minimum 2 caratères"
     * )
     * @Assert\NotBlank(message="Veuillez renseigner un nom d'utilisateur")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner un Email")
     * @Assert\Email(message="Veuillez saisir une adresse Email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(
     *      propertyPath="confirm_password",
     *      message="Les mots de passe ne correspondent pas",
     *      groups={"registration"}
     * )
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *      propertyPath="password",
     *      message="Les mots de passe ne correspondent pas",
     *      groups={"registration"}
     * )
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials() // Nettoie les mdp stockés éventuellement
    {
    }

    public function getSalt() // Envoi la chaine de caractère non coder utiliser pour encoder
    {
    }
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
