<?php

namespace ChinLeung\Converge;

use ChinLeung\Converge\Concerns\Makeable;

class Customer
{
    use Makeable;

    /**
     * The company name of the customer.
     *
     * @var string
     */
    protected $company;

    /**
     * The email of the customer.
     *
     * @var string
     */
    protected $email;

    /**
     * The first name of the customer.
     *
     * @var string
     */
    protected $firstName;

    /**
     * The id of the customer.
     *
     * @var string
     */
    protected $id;

    /**
     * The last name of the customer.
     *
     * @var string
     */
    protected $lastName;

    /**
     * The phone number of the customer.
     *
     * @var string
     */
    protected $phone;

    /**
     * Set the company name of the customer.
     *
     * @param  string|null  $company
     * @return self
     */
    public function setCompany(?string $company): self
    {
        $this->company = substr($company, 0, 50);

        return $this;
    }

    /**
     * Set the email of the customer.
     *
     * @param  string|null  $email
     * @return self
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the first name of the customer.
     *
     * @param  string|null  $firstName
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = substr($firstName, 0, 20);

        return $this;
    }

    /**
     * Set the id of the customer.
     *
     * @param  string|null  $id
     * @return self
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the last name of the customer.
     *
     * @param  string|null  $lastName
     * @return self
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set the phone of the customer.
     *
     * @param  string|null  $phone
     * @return self
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Retrieve the information of the customer for a payload.
     *
     * @return array
     */
    public function toPayload(): array
    {
        return [
            'ssl_first_name' => $this->firstName,
            'ssl_last_name' => $this->lastName,
            'ssl_email' => $this->email,
            'ssl_phone' => $this->phone,
            'ssl_company' => $this->company,
            'ssl_customer_id' => $this->id,
        ];
    }
}
