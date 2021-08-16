<?php

class TextArea
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
        $input = '<textarea';
        $input .= ' name="' . $this->name . '">';
        $input .= $this->value;
        $input .= '</textarea>';

        return $input;
    }
}

