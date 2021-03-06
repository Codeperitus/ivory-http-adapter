<?php

/*
 * This file is part of the Ivory Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\HttpAdapter;

use Ivory\HttpAdapter\CakeHttpAdapter;
use Ivory\Tests\HttpAdapter\Utility\CakeUtility;

/**
 * Cake http adapter test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class CakeHttpAdapterTest extends AbstractHttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        CakeUtility::setUp();

        parent::setUpBeforeClass();
    }

    public function testGetName()
    {
        $this->assertSame('cake', $this->httpAdapter->getName());
    }

    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter()
    {
        return new CakeHttpAdapter();
    }
}
