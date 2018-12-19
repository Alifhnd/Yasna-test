<?php

namespace Modules\Yasna\Schedules;

use Modules\Filemanager\Services\Tools\Doc;
use Modules\Yasna\Services\YasnaSchedule;
use Illuminate\Support\Facades\File;

class RepositionFavIconSchedule extends YasnaSchedule
{
    /**
     * Schedule Job
     */
    protected function job()
    {
        $file = $this->getFile();

        if (is_null($file)) {
            File::copy('Modules/Yasna/Assets/images/_favicon.ico','public/favicon.ico');
            return;
        }


        $new_file_pathname = $this->newFilePathname($file);

        File::copy($file->getPathName(), $new_file_pathname);
    }



    /**
     * Return the pathname of the new file
     *
     * @param Doc $file
     *
     * @return string
     */
    protected function newFilePathname($file)
    {
        return 'public/favicon.' . $file->getExtension();
    }



    /**
     * Return the file from settings
     *
     * @return null|Doc
     */
    protected function getFile()
    {
        $hash = setting('favicon')->gain();

        if (!$hash) {
            return null;
        }

        $file = fileManager()->file($hash)->resolve();

        return $file->getUrl() ? $file : null;
    }



    /**
     * Return the frequency of the job
     *
     * @return string
     */
    protected function frequency()
    {
        return 'dailyAt:00:00';
    }
}
