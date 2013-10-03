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
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @since     0.9.10
 */

namespace PDepend\Metrics;

/**
 * Locator that searches for PDepend analyzers that follow the PDepend
 * convention and are present the PDepend source tree.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @since     0.9.10
 */
class AnalyzerClassFileSystemLocator implements AnalyzerClassLocator
{
    /**
     * The root search directory.
     *
     * @var string
     */
    private $classPath = null;

    /**
     * Array containing reflection classes for all found analyzer implementations.
     *
     * @var array(ReflectionClass)
     */
    private $analyzers = null;

    /**
     * Constructs a new locator instance.
     *
     * @param string $classPath The root search directory.
     */
    public function __construct($classPath = null)
    {
        if ($classPath === null) {
            $classPath = dirname(__FILE__) . '/../../../';
        }
        $this->classPath = realpath($classPath) . DIRECTORY_SEPARATOR;
    }

    /**
     * Returns an array with reflection instances for all analyzer classes.
     *
     * @return \ReflectionClass[]
     */
    public function findAll()
    {
        if ($this->analyzers === null) {
            $this->analyzers = $this->find();
        }
        return $this->analyzers;
    }

    /**
     * Performs a recursive search for analyzers in the configured class path
     * directory.
     *
     * @return \ReflectionClass[]
     */
    private function find()
    {
        $result = array();

        if (0 === stripos(PHP_OS, 'win')) {
            $paths = explode(PATH_SEPARATOR, get_include_path());
        } else {
            preg_match_all('(:?(([a-z]+://)?[^:]+):?)i', get_include_path(), $match);
            $paths = $match[1];
        }

        foreach ($paths as $path) {
            $dir = $path.'/PDepend/Metrics/';

            if (!is_dir($dir)) {
                continue;
            }

            $this->classPath = $dir;

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir)
            );

            foreach ($iterator as $file) {

                $pathName = strtr($file->getPathname(), '\\', '/');
                if (0 === preg_match('(/Metrics/[^/]+/Analyzer\.php$)', $pathName)) {
                    continue;
                }

                $className = $this->createClassNameFromPath(
                    $dir, $file->getPathname()
                );
                if (!class_exists($className)) {
                    include_once $file->getPathname();
                }

                if ($this->isAnalyzerClass($className)) {
                    $result[$className] = new \ReflectionClass($className);
                }
            }
        }

        ksort($result);
        return array_values($result);
    }

    /**
     * Creates a possible analyzer class name from a given absolute file path
     * name.
     *
     * @param string $classPath The currently processed class path.
     * @param string $path      Path of a possible analyzer class.
     * @return string
     */
    private function createClassNameFromPath($classPath, $path)
    {
        $localPath = substr($path, strlen($classPath), -4);
        return 'PDepend\\Metrics\\' . strtr($localPath, DIRECTORY_SEPARATOR, '\\');
    }

    /**
     * Checks if the given class name represents a valid analyzer implementation.
     *
     * @param string $className Class name of a possible analyzer implementation.
     * @return boolean
     */
    private function isAnalyzerClass($className)
    {
        return class_exists($className) && $this->implementsInterface($className);
    }

    /**
     * Checks if the given class implements the analyzer interface.
     *
     * @param string $className Class name of a possible analyzer implementation.
     * @return boolean
     */
    private function implementsInterface($className)
    {
        $expectedType = 'PDepend\\Metrics\\Analyzer';
        return in_array($expectedType, class_implements($className));
    }
}