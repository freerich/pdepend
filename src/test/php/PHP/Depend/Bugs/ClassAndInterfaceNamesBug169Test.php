<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2013, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

namespace PHP\Depend\Bugs;

/**
 * Test case for ticket #169.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @covers \stdClass
 * @group pdepend
 * @group pdepend::bugs
 * @group regressiontest
 */
class ClassAndInterfaceNamesBug169Test extends AbstractRegressionTest
{
    /**
     * testParserAcceptsNullAsClassName
     *
     * @return void
     */
    public function testParserAcceptsNullAsClassName()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * testParserAcceptsNullAsInterfaceName
     *
     * @return void
     */
    public function testParserAcceptsNullAsInterfaceName()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * testParserAcceptsTrueAsClassName
     *
     * @return void
     */
    public function testParserAcceptsTrueAsClassName()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * testParserAcceptsTrueAsInterfaceName
     *
     * @return void
     */
    public function testParserAcceptsTrueAsInterfaceName()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * testParserAcceptsFalseAsClassName
     *
     * @return void
     */
    public function testParserAcceptsFalseAsClassName()
    {
        self::parseCodeResourceForTest();
    }

    /**
     * testParserAcceptsFalseAsInterfaceName
     *
     * @return void
     */
    public function testParserAcceptsFalseAsInterfaceName()
    {
        self::parseCodeResourceForTest();
    }
}
