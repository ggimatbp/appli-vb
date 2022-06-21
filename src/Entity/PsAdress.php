<?php

namespace App\Entity;

use App\Repository\PsAdressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PsAdressRepository::class)
 */
class PsAdress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_state;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_customer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_manufacturer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_supplier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_warehouse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255 )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $other;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone_mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vat_number;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $dni;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_upd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address1;

    /**
    * @ORM\Column(type="float", nullable=true)
    */
    private $latitude;

    // /**
    // * @ORM\Column(type="float", nullable=true)
    // */
    // private $longitude;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCountry(): ?int
    {
        return $this->id_country;
    }

    public function setIdCountry(?int $id_country): self
    {
        $this->id_country = $id_country;

        return $this;
    }

    public function getIdState(): ?int
    {
        return $this->id_state;
    }

    public function setIdState(?int $id_state): self
    {
        $this->id_state = $id_state;

        return $this;
    }

    public function getIdCustomer(): ?int
    {
        return $this->id_customer;
    }

    public function setIdCustomer(?int $id_customer): self
    {
        $this->id_customer = $id_customer;

        return $this;
    }

    public function getIdManufacturer(): ?int
    {
        return $this->id_manufacturer;
    }

    public function setIdManufacturer(?int $id_manufacturer): self
    {
        $this->id_manufacturer = $id_manufacturer;

        return $this;
    }

    public function getIdSupplier(): ?int
    {
        return $this->id_supplier;
    }

    public function setIdSupplier(?int $id_supplier): self
    {
        $this->id_supplier = $id_supplier;

        return $this;
    }

    public function getIdWarehouse(): ?int
    {
        return $this->id_warehouse;
    }

    public function setIdWarehouse(?int $id_warehouse): self
    {
        $this->id_warehouse = $id_warehouse;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(?string $other): self
    {
        $this->other = $other;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoneMobile(): ?string
    {
        return $this->phone_mobile;
    }

    public function setPhoneMobile(?string $phone_mobile): self
    {
        $this->phone_mobile = $phone_mobile;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vat_number;
    }

    public function setVatNumber(?string $vat_number): self
    {
        $this->vat_number = $vat_number;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(?\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->date_upd;
    }

    public function setDateUpd(?\DateTimeInterface $date_upd): self
    {
        $this->date_upd = $date_upd;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdAddress(): ?int
    {
        return $this->id_address;
    }

    public function setIdAddress(int $id_address): self
    {
        $this->id_address = $id_address;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
