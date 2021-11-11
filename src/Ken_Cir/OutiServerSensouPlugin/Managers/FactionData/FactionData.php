<?php

declare(strict_types=1);

namespace Ken_Cir\OutiServerSensouPlugin\Managers\FactionData;

use function strtolower;

class FactionData
{
    /**
     * @var int
     * 派閥ID
     */
    private int $id;

    /**
     * @var string
     * 派閥名
     */
    private string $name;

    /**
     * @var string
     * 派閥主Player名
     */
    private string $owner;

    /**
     * @var int
     * 派閥チャットカラー
     */
    private int $color;

    /**
     * @param int $id
     * @param string $name
     * @param string $owner
     * @param int $color
     */
    public function __construct(int $id, string $name, string $owner, int $color)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = strtolower($owner);
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = strtolower($name);
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner(string $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @param int $color
     */
    public function setColor(int $color): void
    {
        $this->color = $color;
    }
}