<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class TinyEditor extends Field
{
    protected string $view = 'filament.forms.components.tiny-editor';

    protected int $maxContentWidth = 12;

    protected array $toolbarButtons = [
        'undo',
        'redo',
        '|',
        'bold',
        'italic',
        'underline',
        'strikethrough',
        'subscript',
        'superscript',
        '|',
        'bullist',
        'numlist',
        '|',
        'alignleft',
        'aligncenter',
        'alignright',
        'alignjustify',
        '|',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        '|',
        'link',
        'image',
        'media',
        'table',
        'hr',
        'blockquote',
        'code',
        'removeformat',
        '|',
        'forecolor',
        'backcolor',
        '|',
        'fullscreen',
        'preview'
    ];

    protected array $tinymceOptions = [];

    protected string $plugins = 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount';

    public function getMaxContentWidth(): int
    {
        return $this->maxContentWidth;
    }

    public function getToolbarButtons(): array
    {
        return $this->toolbarButtons;
    }

    public function getToolbarButtonsString(): string
    {
        return implode(' ', $this->toolbarButtons);
    }

    public function getPlugins(): string
    {
        return $this->plugins;
    }

    public function maxContentWidth(int $width): static
    {
        $this->maxContentWidth = $width;

        return $this;
    }

    public function toolbar(array $buttons): static
    {
        $this->toolbarButtons = $buttons;

        return $this;
    }

    public function plugins(string $plugins): static
    {
        $this->plugins = $plugins;

        return $this;
    }

    public function options(array $options): static
    {
        $this->tinymceOptions = $options;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->tinymceOptions;
    }

    public function getOptionsString(): string
    {
        $options = $this->getOptions();
        $optionsJson = json_encode($options);
        return $optionsJson ?: '{}';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TinyEditor $component, $state) {
            $component->state(is_string($state) ? $state : '');
        });
    }
}
