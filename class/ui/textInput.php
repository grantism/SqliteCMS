<?php

class TextInput
{
    private string $name;
    private ?string $value;
    private string $type;

    public function __construct($name, $value, $type = 'text')
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
    }

    public function __toString(): string
    {
        $input = '<input type="' . $this->type . '"';
        $input .= ' name="' . $this->name . '"';
        $input .= ' value="' . $this->value . '"';
        $input .= '>';
        return $input;
    }
}