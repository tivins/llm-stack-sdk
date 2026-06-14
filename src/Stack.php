<?php
declare(strict_types=1);

namespace Tivins\LlmStackSdk;

use Exception;

class Stack
{
    private string $executablePath;

    /**
     * @throws Exception
     */
    public function __construct(
        ?string $executablePath = null,
    )
    {
        if (is_null($executablePath)) {
            $executablePath = getenv('LLM_STACK_PROGRAM');
        }
        if (empty($executablePath)) {
            throw new Exception("Executable path can't be empty");
        }
        if (!is_file($executablePath)) {
            throw new Exception("Executable path '$executablePath' does not exist");
        }
        $this->executablePath = $executablePath;
    }

    /**
     * @throws Exception
     */
    private function run(string $command): array
    {
        $finalCommand = $this->executablePath . ' ' . $command;
        exec($finalCommand, $output, $exitCode);
        if ($exitCode !== 0) {
            throw new Exception("Exit code $exitCode");
        }
        return $output;
    }

    /**
     * @throws Exception
     */
    public function list(): array
    {
        return $this->run('list');
    }

    /**
     * @throws Exception
     */
    public function listJson(): array
    {
        $lines = $this->run('list-json');
        return json_decode(implode("\n", $lines), true);
    }

    /**
     * @throws Exception
     */
    public function start(string $model, bool $noWait = false): array
    {
        return $this->run('start ' . escapeshellarg($model) . ($noWait ? ' --no-wait' : ''));
    }

    /**
     * @throws Exception
     */
    public function stop(string $model): array
    {
        return $this->run('stop ' . escapeshellarg($model));
    }

    /**
     * @throws Exception
     */
    public function status(string $model): string
    {
        return $this->run('status ' . escapeshellarg($model))[0];
    }
}