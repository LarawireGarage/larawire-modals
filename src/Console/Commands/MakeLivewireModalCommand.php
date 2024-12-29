<?php


namespace LarawireGarage\LarawireModals\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class MakeLivewireModalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modal {name : The name of the modal component class.}  {--t|theme= : theme of the modal} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Livewire Modal';

    private $theme;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    private $baseClassPath;
    private $baseViewPath;
    private $componentClass;
    private $directories;
    private $component;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // config('livewire.class_namespace'),
        // config('livewire.view_path'),
        // $this->argument('name'),
        // $this->option('stub')

        $directories = preg_split('/[.\/(\\\\)]+/', $this->argument('name'));

        $camelCase = str(array_pop($directories))->camel();
        $kebabCase = str($camelCase)->kebab();

        $this->component = $kebabCase;
        $this->componentClass = str($this->component)->studly();
        $this->directories = array_map([Str::class, 'studly'], $directories);
        // $classPath = app('path') . DIRECTORY_SEPARATOR . str_replace(
        $classPath = base_path() . DIRECTORY_SEPARATOR . str_replace(
            [DIRECTORY_SEPARATOR, '/'],
            DIRECTORY_SEPARATOR,
            str(config('larawire-modals.class_namespace'))
                ->replace('App', 'app')
                ->replace(['/', '\\'], DIRECTORY_SEPARATOR)
                ->finish(DIRECTORY_SEPARATOR)
                ->replaceFirst(app()->getNamespace(), '')
        );

        $this->baseClassPath = rtrim($classPath, DIRECTORY_SEPARATOR);
        $this->baseViewPath = rtrim(config('larawire-modals.view_path'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $this->theme = $this->option('theme') ?? config('larawire-modals.theme', 'bootstrap');

        $this->createModalComponent();

        return 0;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    public function createModalComponent()
    {
        $class = $this->createClass();

        // create blade  
        $view = $this->createView($this->option('force'));

        if ($class && $view) {
            $this->line("<options=bold,reverse;fg=green>MODAL COMPONENT CREATED </> 🤙\n");
            $this->line("<options=bold;fg=green>CLASS:</> {$this->relativeClassPath()}");
            $this->line("<options=bold;fg=green>VIEW:</>  {$this->relativeViewPath()}");
        }
    }

    protected function createClass($force = false)
    {
        $classPath = $this->generatePathFromQualifiedClass();

        $this->makeDirectory($classPath);

        $this->files->put($classPath, $this->prepareClass());

        return $classPath;
    }



    protected function createView($force = false)
    {

        $viewPath = $this->viewPath($this->baseViewPath);

        if (File::exists($viewPath) && !$force) {
            $this->line("<fg=red;options=bold>Modal View already exists: </> {$this->relativeViewPath()}");
            return false;
        }

        $this->ensureDirectoryExists($viewPath);

        File::put($viewPath, $this->viewContents());

        return $viewPath;
    }

    protected function ensureDirectoryExists($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0777, $recursive = true, $force = true);
        }
    }

    public function viewPath($path = '')
    {
        return (!empty($path) ? $path : $this->baseViewPath) . collect()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($this->viewFile())
            ->implode(DIRECTORY_SEPARATOR);
    }

    public function relativeViewPath(): string
    {
        return str($this->viewPath())
            ->replaceFirst(base_path() . DIRECTORY_SEPARATOR, '')
            ->replace(['/', '\\'], DIRECTORY_SEPARATOR);
    }

    public function classPath()
    {
        return $this->baseClassPath . DIRECTORY_SEPARATOR . collect()
            ->concat($this->directories)
            ->push($this->classFile())
            ->implode(DIRECTORY_SEPARATOR);
    }

    public function relativeClassPath(): string
    {
        return str($this->classPath())
            ->replaceFirst(base_path() . DIRECTORY_SEPARATOR, '')
            ->replace(['/', '\\'], DIRECTORY_SEPARATOR)
            ->toString();
    }

    public function classFile()
    {
        return $this->componentClass . '.php';
    }

    public function viewFile()
    {
        return $this->component . '.blade.php';
    }

    public function viewFileName()
    {
        return collect(str($this->viewName())->explode('.'))->last();
    }
    public function viewName()
    {
        return collect()
            ->when(config('larawire-modals.view_path') !== resource_path(), function ($collection) {
                return $collection->concat(explode(
                    DIRECTORY_SEPARATOR,
                    str($this->baseViewPath)
                        ->after(resource_path('views'))
                        ->replace(['/', '\\'], DIRECTORY_SEPARATOR)
                        ->toString()
                ));
            })
            ->filter()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($this->component)
            ->implode('.');
    }

    public function viewContents()
    {
        return file_get_contents($this->getViewStub());
    }

    public function prepareClass()
    {
        return $this->sortImports($this->buildClass($this->qualifyClass($this->getNameInput())));
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', DIRECTORY_SEPARATOR, $name);

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . $name
        );
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Alphabetically sorts the imports for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function sortImports($stub)
    {
        if (preg_match('/(?P<imports>(?:^use [^;{]+;$\n?)+)/m', $stub, $match)) {
            $imports = explode("\n", trim($match['imports']));

            sort($imports);

            return str_replace(trim($match['imports']), implode("\n", $imports), $stub);
        }

        return $stub;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace'],
            ['{{ namespace }}', '{{ rootNamespace }}'],
            ['{{namespace}}', '{{rootNamespace}}',],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getNamespace($name), $this->rootNamespace()],
                $stub
            );
        }

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . DIRECTORY_SEPARATOR, '', $name);
        $classContent = str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class, $stub);
        $classContent = str_replace(['{{ view }}', '{{view}}'], $this->viewName(), $classContent);
        $classContent = str_replace(['{{ viewID }}', '{{viewID}}'], $this->viewFileName(), $classContent);
        $classContent = str_replace(['{{ theme }}', '{{theme}}'], $this->theme, $classContent);

        return $classContent;
    }

    public function getNameInput()
    {
        return Str::of($this->argument('name'))
            ->replace(['/', '\\'], DIRECTORY_SEPARATOR)
            ->replace('.', '/')
            ->explode('/')
            ->map(fn($dir) => Str::studly($dir))
            ->implode('/');
        // return Str::of($this->argument('name'))->camel()->studly() . '';
    }

    public function getNamespace($qualifiedClass)
    {
        return Str::of($this->qualifyClass($this->getNameInput()))
            ->explode(DIRECTORY_SEPARATOR)
            ->map(fn($dirname) => Str::ucfirst($dirname))
            ->slice(0, -1)
            ->implode(DIRECTORY_SEPARATOR);
    }
    /**
     * Get the destination class path.
     *
     * @param  string  $qualifiedClass
     * @return string
     */
    public function generatePathFromQualifiedClass()
    {
        $name = Str::of(Str::of($this->qualifyClass($this->getNameInput()))
            ->explode(DIRECTORY_SEPARATOR)
            ->map(fn(string $dirname) => Str::ucfirst($dirname))
            ->implode(DIRECTORY_SEPARATOR))
            ->replaceFirst(app()->getNamespace(), '')
            ->replace(['/', '\\'], DIRECTORY_SEPARATOR)
            ->finish('.php')
            ->toString();

        return app_path(str_replace('/', DIRECTORY_SEPARATOR, $name));
    }
    public function generateDirFromNamespace($qualifiedClass)
    {
        $name = Str::of($qualifiedClass)
            ->replaceFirst(app()->getNamespace(), '');
        return app_path(str_replace('/', DIRECTORY_SEPARATOR, $name));
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getViewStub(): string
    {
        return __DIR__ . '/stubs/modal-component-view.stub';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/modal-component-class.stub';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return config('larawire-modals.class_namespace', 'App\\Http\\Livewire');
    }

}