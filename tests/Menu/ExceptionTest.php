<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ExceptionTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testAfterTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->afterTag('')->afterContent('tests')->items([['label' => 'Item 1']])->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testBeforeTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->beforeTag('')->beforeContent('tests')->items([['label' => 'Item 1']])->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testDropdownContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()
            ->dropdownContainerTag('')
            ->items([
                [
                    'label' => 'Dropdown',
                    'link' => '#',
                    'items' => [
                        ['label' => 'Action', 'link' => '#'],
                        ['label' => 'Another action', 'link' => '#'],
                        ['label' => 'Something else here', 'link' => '#'],
                        '-',
                        ['label' => 'Separated link', 'link' => '#'],
                    ],
                ],
            ])
            ->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->itemsTag('')->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testLabelExceptionEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Menu::widget()->items([['link' => '/home']])->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testLabelExceptionEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" cannot be an empty string.');
        Menu::widget()->items([['label' => '']])->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testLabelExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option must be a string.');
        Menu::widget()->items([['label' => 1]])->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testLinkTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->linkTag('')->render();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testTagName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->tagName('')->render();
    }
}
