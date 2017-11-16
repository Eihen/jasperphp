<?php

declare(strict_types = 1);

namespace Eihen\JasperPHP;

/**
 * JasperBase
 *
 * Basic interface with the JasperStarter cli tool
 *
 * @package Eihen\JasperPHP
 */
abstract class JasperBase
{
    const JASPER_DIR = __DIR__ . '/../vendor/bin/';

    /** @var string JasperStarter dir realpath */
    protected $jasperDir;

    /** @var bool Is running on windows? */
    protected $isWindows;

    /** @var string JasperStarter executable file name */
    protected $executable = 'jasperstarter';

    /** @var string Output path */
    protected $output = '';

    /** @var string Locale code */
    protected $locale = '';

    /**
     * JasperBase constructor.
     *
     * Checks running OS and existence of JasperStarter
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->jasperDir = realpath(self::JASPER_DIR) . '/';

        if ($this->isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->executable .= '.exe.bat';
        }

        if (!file_exists($this->jasperDir . $this->executable)) {
            throw new \Exception('JasperStarter executable file not found in path: ' . $this->jasperDir . $this->executable);
        }
    }

    /**
     * Set the output directory and file name prefix
     * Format: path/to/output/prefix
     *
     * @param string $output
     * @return $this
     */
    public function output(string $output)
    {
        if (!empty($output))
        {
            $info = pathinfo($output);
            // Checks if the full output is a valid directory
            if (($dir = realpath($output)) && is_dir($dir))
            {
                $output = "-o \"$dir\"";
            }

            // Checks if the dirname of the output is a valid directory
            else if (($dir = realpath($info['dirname'])) && is_dir($dir))
            {
                $output = '-o ' . $dir . '/' . $info['filename'];

                // To avoid .jasper.jasper since JasperStarter always adds the extension
                if (isset($info['extension']) && $info['extension'] != 'jasper')
                {
                    $output .= $info['extension'];
                }
            }
            else
            {
                throw new \InvalidArgumentException('The directory of the output is invalid.');
            }
        }

        $this->output = $output;
        return $this;
    }

    /**
     * Set the locale used to process the report
     * Use ISO-639 two letter code (en) or a combination of ISO-639 and ISO_3166 codes (en_US)
     *
     * @param string $locale Locale code
     *
     * @return $this
     */
    public function locale(string $locale)
    {
        $this->locale = !empty($locale) ? "--locale \"$locale\"" : '';

        return $this;
    }

    /**
     * Validates input file and returns it's real path
     *
     * @param string $input Path to the input file
     * @param array $acceptedFormats Accepted formats
     *
     * @return string
     */
    protected static function validateInput(string $input, array $acceptedFormats)
    {
        if (empty($input)) {
            throw new \InvalidArgumentException('Input file not defined.');
        }

        if (!is_file($input)) {
            throw new \InvalidArgumentException('Input is not a file.');
        }

        if (!in_array(pathinfo($input, PATHINFO_EXTENSION), $acceptedFormats)) {
            throw new \InvalidArgumentException('Invalid input file format.');
        }

        return realpath($input);
    }
}
