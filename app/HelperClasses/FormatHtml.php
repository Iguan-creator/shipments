<?php


namespace App\HelperClasses;


use Illuminate\Contracts\Support\Htmlable;

class FormatHtml implements Htmlable
{
    /**
     * Text for formatting
     *
     * @var string
     */
    protected $text;

    protected $href;

    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * return html format
     *
     * @return string
     */
    public function toHtml()
    {
        if ($this->href) {
            return "<a target=\"_blank\" href=\"{$this->href}\">{$this->text}</a>";
        } else {
            return $this->text;
        }
    }

    /**
     * Make text a link
     *
     * @param string $href
     */
    public function toA(string $href)
    {
        $this->href = $href;
    }
}
