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


class Dropdown
{
    private string $name;
    private array $options;
    private ?int $selected;

    /**
     * Dropdown constructor.
     * @param string $name
     * @param array $options
     * @param ?int $selected
     */
    public function __construct(string $name, array $options, ?int $selected = 0)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function __toString(): string
    {
        $select = '<select name="' . $this->name . '">';
        $select .= '<option value="0">&mdash; Please select an option &mdash;</option>';

        foreach ($this->options as $option) {
            $value = $option[0];
            $text = $option[1];
            $isSelected = ($value == $this->selected) ? 'selected' : '';

            $select .= '<option value="' . $value . '" ' . $isSelected . '>' . $text . '</option>';
        }

        $select .= '</select>';

        return $select;
    }
}
