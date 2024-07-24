<?php
namespace LarawireGarage\LarawireModals;

class LarawireModalBladeDirectives
{
    public static function larawireModalScripts()
    {
        if (file_exists(public_path('vendor\larawire\modals\larawireModalScripts.js'))) {
            return <<<HTML
                        <script src="{{ asset('vendor/larawire/modals/larawireModalScripts.js') }}"></script>
                    HTML;
        }
        $scripts = file_get_contents(__DIR__ . '/../resources/js/build/larawireModalScripts.js');
        $scripts = static::minify($scripts);
        return <<<HTML
                    <script>
                        {$scripts}
                    </script>
                HTML;
    }

    protected static function minify($content)
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $content);
    }
}