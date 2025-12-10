<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Sanitizers\Strings;

class ExtendedStringSanitizers extends StringSanitizers
{
    protected ?bool $strip_control = null;
    protected ?bool $strip_extended = null;
    protected ?bool $strip_backtick = null;
    protected ?bool $encode_control = null;
    protected ?bool $encode_extended = null;

    protected function getOptions(): int
    {
        $options = FILTER_FLAG_EMPTY_STRING_NULL;
        if ($this->strip_control === true) {
            $options |= FILTER_FLAG_STRIP_LOW;
        } elseif ($this->encode_control === true) {
            $options |= FILTER_FLAG_ENCODE_LOW;
        }
        if ($this->strip_extended === true) {
            $options |= FILTER_FLAG_STRIP_HIGH;
        } elseif ($this->encode_extended === true) {
            $options |= FILTER_FLAG_ENCODE_HIGH;
        }
        if ($this->strip_backtick === true) {
            $options |= FILTER_FLAG_STRIP_BACKTICK;
        }
        return $options;
    }

    public function setStripBacktick(?bool $backtick = null): static
    {
        $this->strip_backtick = is_bool($backtick) ? $backtick : $this->strip_backtick;
        return $this;
    }

    public function setStripChars(?bool $control = null, ?bool $extended = null): static
    {
        $this->strip_control = is_bool($control) ? $control : $this->strip_control;
        $this->strip_extended = is_bool($extended) ? $extended : $this->strip_extended;
        return $this;
    }

    public function setEncodeChars(?bool $control = null, ?bool $extended = null): static
    {
        $this->encode_control = is_bool($control) ? $control : $this->encode_control;
        $this->encode_extended = is_bool($extended) ? $extended : $this->encode_extended;
        return $this;
    }

    public function unsafe(): static
    {
        return $this->sanitize(FILTER_UNSAFE_RAW, $this->getOptions());
    }

    public function safe(bool $encode_quotes = true): static
    {
        $options = $this->getOptions();
        if (!$encode_quotes) {
            $options |= FILTER_FLAG_NO_ENCODE_QUOTES;
        }
        return $this->sanitize(FILTER_SANITIZE_SPECIAL_CHARS, $options);
    }

    public function urlEncode(): static
    {
        return $this->sanitize(FILTER_SANITIZE_ENCODED, $this->getOptions());
    }

    public function htmlEncode(): static
    {
        return $this->sanitize(FILTER_SANITIZE_SPECIAL_CHARS, $this->getOptions() | FILTER_FLAG_ENCODE_AMP);
    }
}
