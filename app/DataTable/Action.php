<?php


namespace App\DataTable;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Action implements JsonSerializable
{

    public const METHOD_GET = 'GET';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_PUT = 'PUT';

    private string $name = '';

    private string $text = '';

    private string $href = '';

    protected string $method = self::METHOD_GET;

    private string $target = '_self';

    private array $params = [];

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param  string  $text
     * @return Action
     */
    public function setText(string $text): Action
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param  string  $href
     * @return Action
     */
    public function setHref(string $href): Action
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param  string  $target
     * @return Action
     */
    public function setTarget(string $target): Action
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     * @return Action
     */
    public function setName(string $name): Action
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param  string  $method
     * @return Action
     */
    public function setMethod(string $method): Action
    {
        $this->method = $method;
        return $this;
    }

    #[Pure] public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return Action
     */
    public function setParams(array $params): Action
    {
        $this->params = $params;
        return $this;
    }

}
