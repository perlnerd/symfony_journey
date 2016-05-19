<?php

namespace AppBundle\Model;

use \SplFileObject;

class CsvFileModel extends SplFileObject
{
    protected $file;

    /**
     * Create a new SplFileObject and set the flags to process the file as a csv
     * @param string $fileName full system path to the file to be read.
     */
    public function __construct($fileName)
    {
        parent::__construct($fileName);

        
    }

    /**
     * Check file is a file and is readable
     * @return boolean true on success false on failure
     */
    public function fileIsValid()
    {
        if ($this->isReadable() && $this->isFile()) {
            return true;
        }

        return false;
    }

    /**
     *
     * @return boolean true
     */
    public function configureFlags()
    {
        $this->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_CSV);

        return true;
    }
}
