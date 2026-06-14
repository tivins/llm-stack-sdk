# LLM Stack SDK

PHP wrapper for the LLM Stack CLI.

## Installation

```bash
composer require tivins/llm-stack-sdk
```

## Setup

Point the SDK to your LLM Stack executable:

```bash
export LLM_STACK_PROGRAM=/path/to/llm-stack
```

Or pass the path directly to the constructor.

## Usage

```php
use Tivins\LlmStackSdk\Stack;

$stack = new Stack();

// List models
$stack->list();
$stack->listJson();

// Start and wait until ready (default)
$stack->start('llm_main');
$stack->status('llm_main'); // e.g. "ready"
$stack->stop('llm_main');

// Start without waiting
$stack->start('llm_main', noWait: true);
while ($stack->status('llm_main') !== 'ready') {
    sleep(2);
}

// Switch models (starting one stops the previous one)
$stack->start('llm_main');
$stack->start('llm_flash'); // stops llm_main, starts llm_flash
```

## License

MIT
